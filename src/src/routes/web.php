<?php
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\CronController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\PhoneBookController;
use App\Http\Controllers\User\ManageSMSController;
use App\Http\Controllers\User\PlanController;
use App\Http\Controllers\User\EmailContactController;
use App\Http\Controllers\User\ManageEmailController;
use App\Http\Controllers\User\SupportTicketController;
use App\Http\Controllers\PaymentMethod\PaymentController;
use App\Http\Controllers\PaymentMethod\PaymentWithStripe;
use App\Http\Controllers\PaymentMethod\PaymentWithPaypal;
use App\Http\Controllers\PaymentMethod\PaymentWithPayStack;
use App\Http\Controllers\PaymentMethod\PaymentWithPaytm;
use App\Http\Controllers\PaymentMethod\PaymentWithFlutterwave;
use App\Http\Controllers\PaymentMethod\PaymentWithRazorpay;
use App\Http\Controllers\PaymentMethod\PaymentWithInstamojo;
use App\Http\Controllers\PaymentMethod\SslCommerzPaymentController;
use App\Http\Controllers\PaymentMethod\CoinbaseCommerce;
use App\Http\Controllers\User\ManageWhatsappController;
use Illuminate\Http\Request;

Route::get('queue-work', function () {
    return Illuminate\Support\Facades\Artisan::call('queue:work', ['--stop-when-empty' => true]);
})->name('queue.work');

Route::get('cron/run', [CronController::class, 'run'])->name('cron.run');

Route::middleware(['auth','maintanance','demo.mode'])->prefix('user')->name('user.')->group(function () {
    Route::middleware(['checkUserStatus'])->group(function(){
    	Route::get('dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    	Route::get('profile', [HomeController::class, 'profile'])->name('profile');
    	Route::post('profile/update', [HomeController::class, 'profileUpdate'])->name('profile.update');
    	Route::get('password', [HomeController::class, 'password'])->name('password');
    	Route::post('password/update', [HomeController::class, 'passwordUpdate'])->name('password.update');

        //credit Log
        Route::get('transaction/log', [HomeController::class, 'transaction'])->name('transaction.history');
        Route::get('transaction/search', [HomeController::class, 'transactionSearch'])->name('transaction.search');

        //credit Log
        Route::get('credit/log', [HomeController::class, 'credit'])->name('credit.history');
        Route::get('credit/search', [HomeController::class, 'creditSearch'])->name('credit.search');

        //Email credit Log
        Route::get('email/credit/log', [HomeController::class, 'emailCredit'])->name('credit.email.history');
        Route::get('email/credit/search', [HomeController::class, 'emailCreditSearch'])->name('credit.email.search');

    	//Phone book
    	Route::get('sms/groups', [PhoneBookController::class, 'groupIndex'])->name('phone.book.group.index');
        Route::get('sms/contact/group/{id}', [PhoneBookController::class, 'smsContactByGroup'])->name('phone.book.sms.contact.group');
    	Route::post('sms/group/store', [PhoneBookController::class, 'groupStore'])->name('phone.book.group.store');
    	Route::post('sms/group/update', [PhoneBookController::class, 'groupUpdate'])->name('phone.book.group.update');
    	Route::post('sms/group/delete', [PhoneBookController::class, 'groupdelete'])->name('phone.book.group.delete');

    	Route::get('sms/contacts', [PhoneBookController::class, 'contactIndex'])->name('phone.book.contact.index');
    	Route::post('sms/contact/store', [PhoneBookController::class, 'contactStore'])->name('phone.book.contact.store');
    	Route::post('sms/contact/update', [PhoneBookController::class, 'contactUpdate'])->name('phone.book.contact.update');
    	Route::post('sms/contact/delete', [PhoneBookController::class, 'contactDelete'])->name('phone.book.contact.delete');
        Route::post('sms/contact/import', [PhoneBookController::class, 'contactImport'])->name('phone.book.contact.import');
        Route::get('sms/contact/export', [PhoneBookController::class, 'contactExport'])->name('phone.book.contact.export');

        Route::get('sms/templates', [PhoneBookController::class, 'templateIndex'])->name('template.index');
        Route::post('sms/template/store', [PhoneBookController::class, 'templateStore'])->name('phone.book.template.store');
        Route::post('sms/template/update', [PhoneBookController::class, 'templateUpdate'])->name('phone.book.template.update');
        Route::post('sms/template/delete', [PhoneBookController::class, 'templateDelete'])->name('phone.book.template.delete');

        //Email
        Route::get('email/groups', [EmailContactController::class, 'emailGroupIndex'])->name('email.group.index');
        Route::get('email/contact/group/{id}', [EmailContactController::class, 'emailContactByGroup'])->name('email.contact.group');
        Route::post('email/group/store', [EmailContactController::class, 'emailGroupStore'])->name('email.group.store');
        Route::post('email/group/update', [EmailContactController::class, 'emailGroupUpdate'])->name('email.group.update');
        Route::post('email/group/delete', [EmailContactController::class, 'emailGroupdelete'])->name('email.group.delete');

        Route::get('email/contacts', [EmailContactController::class, 'emailContactIndex'])->name('email.contact.index');
        Route::post('email/contact/store', [EmailContactController::class, 'emailContactStore'])->name('email.contact.store');
        Route::post('email/contact/update', [EmailContactController::class, 'emailContactUpdate'])->name('email.contact.update');
        Route::post('email/contact/import', [EmailContactController::class, 'emailContactImport'])->name('email.contact.import');
        Route::get('email/contact/export', [EmailContactController::class, 'emailContactExport'])->name('email.contact.export');
        Route::post('email/contact/delete', [EmailContactController::class, 'emailContactDelete'])->name('email.contact.delete');

        Route::get('email/send', [ManageEmailController::class, 'create'])->name('manage.email.send');
        Route::get('email/log/history', [ManageEmailController::class, 'index'])->name('manage.email.index');
        Route::get('email/log/pending', [ManageEmailController::class, 'pending'])->name('manage.email.pending');
        Route::get('email/log/delivered', [ManageEmailController::class, 'delivered'])->name('manage.email.delivered');
        Route::get('email/log/failed', [ManageEmailController::class, 'failed'])->name('manage.email.failed');
        Route::get('email/log/schedule', [ManageEmailController::class, 'scheduled'])->name('manage.email.schedule');
        Route::get('email/log/search/{scope}', [ManageEmailController::class, 'search'])->name('manage.email.search');
        Route::get('email/view/{id}', [ManageEmailController::class, 'viewEmailBody'])->name('email.view');
        Route::post('email/store', [ManageEmailController::class, 'store'])->name('manage.email.store');

        //Sms log
        Route::get('sms/send', [ManageSMSController::class, 'create'])->name('sms.send');
        Route::get('sms/history', [ManageSMSController::class, 'index'])->name('sms.index');
        Route::get('sms/pending', [ManageSMSController::class, 'pending'])->name('sms.pending');
        Route::get('sms/delivered', [ManageSMSController::class, 'delivered'])->name('sms.delivered');
        Route::get('sms/failed', [ManageSMSController::class, 'failed'])->name('sms.failed');
        Route::get('sms/schedule', [ManageSMSController::class, 'scheduled'])->name('sms.schedule');
        Route::get('sms/processing', [ManageSMSController::class, 'processing'])->name('sms.processing');
        Route::get('sms/search/{scope}', [ManageSMSController::class, 'search'])->name('sms.search');
        Route::post('sms/store', [ManageSMSController::class, 'store'])->name('sms.store');

         //whatsapp log
         Route::get('whatsapp/send', [ManageWhatsappController::class, 'create'])->name('whatsapp.send');
         Route::get('whatsapp/history', [ManageWhatsappController::class, 'index'])->name('whatsapp.index');
         Route::get('whatsapp/pending', [ManageWhatsappController::class, 'pending'])->name('whatsapp.pending');
         Route::get('whatsapp/delivered', [ManageWhatsappController::class, 'delivered'])->name('whatsapp.delivered');
         Route::get('whatsapp/failed', [ManageWhatsappController::class, 'failed'])->name('whatsapp.failed');
         Route::get('whatsapp/schedule', [ManageWhatsappController::class, 'scheduled'])->name('whatsapp.schedule');
         Route::get('whatsapp/processing', [ManageWhatsappController::class, 'processing'])->name('whatsapp.processing');
         Route::get('whatsapp/search/{scope}', [ManageWhatsappController::class, 'search'])->name('whatsapp.search');
         Route::post('whatsapp/store', [ManageWhatsappController::class, 'store'])->name('whatsapp.store');

        //Plan
        Route::get('plans', [PlanController::class, 'create'])->name('plan.create');
        Route::post('plan/store', [PlanController::class, 'store'])->name('plan.store');
        Route::get('plan/subscriptions', [PlanController::class, 'subscription'])->name('plan.subscription');
        Route::post('plan/renew', [PlanController::class, 'subscriptionRenew'])->name('plan.renew');

        //Payment
        Route::get('payment/preview', [PaymentController::class, 'preview'])->name('payment.preview');
        Route::get('payment/confirm', [PaymentController::class, 'paymentConfirm'])->name('payment.confirm');
        Route::get('manual/payment/confirm', [PaymentController::class, 'manualPayment'])->name('manual.payment.confirm');
        Route::post('manual/payment/update', [PaymentController::class, 'manualPaymentUpdate'])->name('manual.payment.update');

        //Payment Action
        Route::post('ipn/strip', [PaymentWithStripe::class, 'stripePost'])->name('payment.with.strip');
        Route::post('ipn/paypal', [PaymentWithPaypal::class, 'postPaymentWithpaypal'])->name('payment.with.paypal');
        Route::get('ipn/paypal/status', [PaymentWithPaypal::class, 'getPaymentStatus'])->name('payment.paypal.status');
        Route::get('ipn/paystack', [PaymentWithPayStack::class, 'store'])->name('payment.with.paystack');
        Route::post('ipn/pay/with/sslcommerz', [SslCommerzPaymentController::class, 'index'])->name('payment.with.ssl');
        Route::post('success', [SslCommerzPaymentController::class, 'success']);
        Route::post('fail', [SslCommerzPaymentController::class, 'fail']);
        Route::post('cancel', [SslCommerzPaymentController::class, 'cancel']);
        Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);


        Route::post('ipn/paytm/process', [PaymentWithPaytm::class,'getTransactionToken'])->name('paytm.process');
        Route::post('ipn/paytm/callback', [PaymentWithPaytm::class,'ipn'])->name('paytm.ipn');

        Route::get('flutterwave/{trx}/{type}', [PaymentWithFlutterwave::class,'callback'])->name('flutterwave.callback');

        Route::post('ipn/razorpay', [PaymentWithRazorpay::class,'ipn'])->name('razorpay');

        Route::get('instamojo', [PaymentWithInstamojo::class,'process'])->name('instamojo');
        Route::post('ipn/instamojo', [PaymentWithInstamojo::class,'ipn'])->name('ipn.instamojo');

        Route::get('ipn/coinbase', [CoinbaseCommerce::class, 'store'])->name('coinbase');
        Route::any('ipn/callback/coinbase', [CoinbaseCommerce::class, 'confirmPayment'])->name('callback.coinbase');

        //Support Ticket
        Route::get('support/tickets', [SupportTicketController::class, 'index'])->name('ticket.index');
        Route::get('support/create/new/ticket', [SupportTicketController::class, 'create'])->name('ticket.create');
        Route::post('support/ticket/store', [SupportTicketController::class, 'store'])->name('ticket.store');
        Route::get('support/ticket/reply/{id}', [SupportTicketController::class, 'detail'])->name('ticket.detail');
        Route::post('support/ticket/reply/{id}', [SupportTicketController::class, 'ticketReply'])->name('ticket.reply');
        Route::post('support/closed/{id}', [SupportTicketController::class, 'closedTicket'])->name('ticket.closed');
        Route::get('support/ticket/file/download/{id}', [SupportTicketController::class, 'supportTicketDownlode'])->name('ticket.file.download');
    });
});
 

Route::get('/language/change/{lang?}', [FrontendController::class, 'languageChange'])->name('language.change');
Route::get('/default/image/{size}', [FrontendController::class, 'defaultImageCreate'])->name('default.image');
Route::get('email/contact/demo/file', [FrontendController::class, 'demoImportFile'])->name('email.contact.demo.import');
Route::get('sms/demo/import/file', [FrontendController::class, 'demoImportFilesms'])->name('phone.book.demo.import.file');


Route::get('demo/file/downlode/{extension}', [FrontendController::class, 'demoFileDownlode'])->name('demo.file.downlode');

Route::get('demo/email/file/downlode/{extension}', [FrontendController::class, 'demoEmailFileDownlode'])->name('demo.email.file.downlode');