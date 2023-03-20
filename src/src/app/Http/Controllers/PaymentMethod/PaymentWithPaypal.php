<?php

namespace App\Http\Controllers\PaymentMethod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\PaymentLog;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use App\Http\Utility\PaymentInsert;
use App\Http\Controllers\PaymentMethod\PaymentController;

class PaymentWithPaypal extends Controller
{
    private $_api_context;
    
    public function __construct()
    {
        $paypal_configuration = Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_configuration['client_id'], $paypal_configuration['secret']));
        $this->_api_context->setConfig($paypal_configuration['settings']);
    }

    public function postPaymentWithpaypal(Request $request)
    {
    	$paymentMethod = PaymentMethod::where('unique_code','PAYPAL102')->first();
        if(!$paymentMethod){
            $notify[] = ['error', 'Invalid Payment gateway'];
            return back()->withNotify($notify);
        }
        $paymentTrackNumber = session()->get('payment_track');
        $paymentLog = PaymentLog::where('trx_number', $paymentTrackNumber)->first();

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $itemsarray = [];

    	$item = new Item();
        $item->setName('Products')
            ->setCurrency($paymentLog->paymentGateway->currency->name)
            ->setQuantity(1)
            ->setPrice($paymentLog->final_amount);
        array_push($itemsarray, $item);

        $item_list = new ItemList();
        $item_list->setItems($itemsarray);

        $amount = new Amount();
        $amount->setCurrency($paymentLog->paymentGateway->currency->name)
            ->setTotal($paymentLog->final_amount);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('transaction ref number', $paymentLog->trx_number);

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('user.payment.paypal.status'))
            ->setCancelUrl(URL::route('user.dashboard'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));            
        try {
            $payment->create($this->_api_context);
            foreach($payment->getLinks() as $link) {
	            if($link->getRel() == 'approval_url') {
	                $redirect_url = $link->getHref();
	                break;
	            }
	        }
	        Session::put('paypal_payment_id', $payment->getId());
	        if(isset($redirect_url)) {            
	            return Redirect::away($redirect_url);
	        }
        }catch (\Exception $ex) { 
           	$notify[] = ['error', 'Payment process is failed. '.$ex->getMessage()];
            return back()->withNotify($notify);
        }
        Session::put('error','Unknown error occurred');
    	return back();
    }


    public function getPaymentStatus(Request $request)
    {        
        $payment_id = Session::get('paypal_payment_id');
        Session::forget('paypal_payment_id');
        if (empty($request->input('PayerID')) || empty($request->input('token'))) {
            Session::put('error','Payment failed');
            return back();
        }
        $payment = Payment::get($payment_id, $this->_api_context);        
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));        
        $result = $payment->execute($execution, $this->_api_context);
        if ($result->getState() == 'approved') { 
            $paymentTrackNumber = session()->get('payment_track');
            $paymentLog = PaymentLog::where('trx_number', $paymentTrackNumber)->first();       
            PaymentController::paymentUpdate($paymentLog->trx_number);
            $notify[] = ['success', 'Payment successful!'];
            return redirect()->route('user.dashboard')->withNotify($notify);
        }else{
        	$notify[] = ['error', 'Payment failed !!'];
            return redirect()->route('user.dashboard')->withNotify($notify);
        }
    }
}
