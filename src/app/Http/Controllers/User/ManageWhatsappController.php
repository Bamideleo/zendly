<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contact;
use App\Models\SMSlog;
use App\Models\GeneralSetting;
use App\Models\CreditLog;
use App\Models\SmsGateway;
use Carbon\Carbon;
use Shuchkin\SimpleXLSX;
use App\Jobs\ProcessSms;
use App\Jobs\ProcessWhatsapp;
use App\Models\WhatsappCreditLog;
use App\Models\WhatsappDevice;
use App\Models\WhatsappLog;
use App\Rules\MessageFileValidationRule;
use Exception;
use Illuminate\Support\Facades\Http;

class ManageWhatsappController extends Controller
{

// whatsapp Api section start
public function whatsappapi()
{
        $tilte = "WhatsApp Device";
        $user = Auth::user();
        $whatsapps = WhatsappDevice::where('user_id',$user->id)->orderBy('id','desc');
        foreach ($whatsapps as $key => $value) {
            try {
                $findWhatsappsession = Http::get(strDec(config('requirements.core.wa_key')).'/sessions/find/'.$value->name);
                $findWhatsappsession = json_decode($findWhatsappsession);
                $wpu = WhatsappDevice::where('id', $value->id)->first();
                if ($findWhatsappsession->message == "Session found.") {
                    $wpu->status = 'connected';
                }else{
                    $wpu->status = 'disconnected';
                }
                $wpu->save();
            } catch (Exception $e) {
                
            }
        }
        $whatsapps = WhatsappDevice::where('user_id',$user->id)->orderBy('id', 'desc')->paginate(paginateNumber());
        return view('user.whatsapp.api', [
            'title' => $tilte,
            'whatsapps' => $whatsapps,
        ]);
}


public function savewhatapp(Request $request)
{
    $request->validate([
        'name' => 'required|unique:wa_device,name',
        'number' => 'required|numeric|unique:wa_device,number',
        'multidevice' => 'required|in:yes,no',
        'delay_time' => 'required',
    ]);

    $whatsapp = new WhatsappDevice();
    $whatsapp->user_id = $user = Auth::user()->id;
    $whatsapp->name = $request->name;
    $whatsapp->number = $request->number;
    $whatsapp->description = $request->description;
    $whatsapp->delay_time = $request->delay_time;
    $whatsapp->status = 'initiate';
    $whatsapp->multidevice = $request->multidevice;
    $whatsapp->save();
    $notify[] = ['success', 'Whatsapp Device successfully added'];
    return back()->withNotify($notify);
}

public function editwhatsapp($id)
{
    $tilte = "WhatsApp Device Edit";
    $user = Auth::user();
    $whatsapps = WhatsappDevice::where('user_id',$user->id)->orderBy('id','desc');
    foreach ($whatsapps as $key => $value) {
        try {
            $findWhatsappsession = Http::get(strDec(config('requirements.core.wa_key')).'/sessions/find/'.$value->name);
            $findWhatsappsession = json_decode($findWhatsappsession);
            $wpu = WhatsappDevice::where('id', $value->id)->first();
            if ($findWhatsappsession->message == "Session found.") {
                $wpu->status = 'connected';
            }else{
                $wpu->status = 'disconnected';
            }
            $wpu->save();
        } catch (Exception $e) {
            
        }
    }
    $whatsapps = WhatsappDevice::where('user_id',$user->id)->orderBy('id', 'desc')->paginate(paginateNumber());
    $whatsapp = WhatsappDevice::where('id', $id)->first();
    return view('user.whatsapp.edit', [
        'title' => $tilte,
        'whatsapp' => $whatsapp,
        'whatsapps' => $whatsapps,
    ]);
}

public function updatewhatsapp(Request $request)
{
    $request->validate([
        'name' => 'required|unique:wa_device,name,'.$request->id,
        'number' => 'required|numeric|unique:wa_device,number,'.$request->id,
        'multidevice' => 'required|in:YES,NO',
        'delay_time' => 'required',
        'status' => 'required|in:initiate,connected,disconnected',
    ]);

    $whatsapp = WhatsappDevice::where('id', $request->id)->first();
    $whatsapp->user_id = Auth::user()->id;
    if ($whatsapp->status!='connected') {
        $whatsapp->name = $request->name;
    }
    $whatsapp->number = $request->number;
    $whatsapp->description = $request->description;
    $whatsapp->status = $request->status;
    $whatsapp->multidevice = $request->multidevice;
    $whatsapp->delay_time = $request->delay_time;
    $whatsapp->update();
    $notify[] = ['success', 'WhatsApp Device successfully Updated'];
    return back()->withNotify($notify);
}

public function delete(Request $request)
{
    $whatsapp = WhatsappDevice::where('id', $request->id)->first();
    try {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => strDec(config('requirements.core.wa_key')).'/sessions/delete/'.$whatsapp->name,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $whatsapp->delete();
    } catch (Exception $e) {
        
    }
    $notify[] = ['success', 'Whatsapp Device successfully Deleted'];
    return back()->withNotify($notify);
}

public function statusUpdate(Request $request){  
        $whatsapp = WhatsappDevice::where('id', $request->id)->first();
        
        if ($request->status=='connected') {
            try {
                $findWhatsappsession = Http::get(strDec(config('requirements.core.wa_key')).'/sessions/find/'.$whatsapp->name);
                $findWhatsappsession = json_decode($findWhatsappsession);
                if ($findWhatsappsession->message == "Session found.") {
                    $whatsapp->status = 'connected';
                } 
                $whatsapp->update();
            } catch (Exception $e) {
                
            }
        }elseif ($request->status=='disconnected') {
            try {
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => strDec(config('requirements.core.wa_key')).'/sessions/delete/'.$whatsapp->name,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'DELETE',
                ));
                $response = curl_exec($curl);
                curl_close($curl);
                $whatsapp->status = 'disconnected';
                $whatsapp->update();
            } catch (Exception $e) {
                
            }
        }else{
            try {
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => strDec(config('requirements.core.wa_key')).'/sessions/delete/'.$whatsapp->name,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'DELETE',
                ));
                $response = curl_exec($curl);
                curl_close($curl);
                $whatsapp->status = 'disconnected';
                $whatsapp->update();
            } catch (Exception $e) {
                
            }
            $whatsapp->status = $request->status;
            $whatsapp->update();
        }

        return json_encode([
            'success' => "WhatsApp device updated" 
        ]);
    }

// whatsapp Api section end
    public function create()
    {
    	$title = "Compose Massage";
    	$user = Auth::user();
    	$groups = $user->group()->get();
    	$templates = $user->template()->get();
    	return view('user.whatsapp.create', compact('title', 'groups', 'templates'));
    }

    public function index()
    {
    	$title = "WhatsApp History";
        $user = Auth::user();
        $whatsApp = WhatsappLog::where('user_id', $user->id)->orderBy('id', 'DESC')->with('whatsappGateway')->paginate(paginateNumber());
    	return view('user.whatsapp.index', compact('title', 'whatsApp'));
    }


    public function pending()
    {
        $title = "Pending WhatsApp Message History";
        $user = Auth::user();
        $whatsApp = WhatsappLog::where('user_id', $user->id)->orderBy('id', 'DESC')->where('status', 1)->with('whatsappGateway')->paginate(paginateNumber());
        return view('user.whatsapp.index', compact('title', 'whatsApp'));
    }


    public function delivered()
    {
        $title = "Delivered WhatsApp Message History";
        $user = Auth::user();
        $whatsApp = WhatsappLog::where('user_id', $user->id)->orderBy('id', 'DESC')->where('status', 4)->with('whatsappGateway')->paginate(paginateNumber());
        return view('user.whatsapp.index', compact('title', 'whatsApp'));
    }

    public function failed()
    {
        $title = "Failed WhatsApp Message History";
        $user = Auth::user();
        $whatsApp = WhatsappLog::where('user_id', $user->id)->orderBy('id', 'DESC')->where('status', 3)->with('whatsappGateway')->paginate(paginateNumber());
        return view('user.whatsapp.index', compact('title', 'whatsApp'));
    }

    public function scheduled()
    {
    	$title = "Scheduled WhatsApp Message History";
    	$user = Auth::user();
        $whatsApp = WhatsappLog::where('user_id', $user->id)->orderBy('id', 'DESC')->where('status', 2)->with('whatsappGateway')->paginate(paginateNumber());
        return view('user.whatsapp.index', compact('title', 'whatsApp'));
    }

    public function processing()
    {
        $title = "Processing WhatsApp Message History";
        $user = Auth::user();
        $whatsApp = WhatsappLog::where('user_id', $user->id)->orderBy('id', 'DESC')->where('status', 5)->with('whatsappGateway')->paginate(paginateNumber());
        return view('user.whatsapp.index', compact('title', 'whatsApp'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $message = 'message';
        $rules = 'required';
        if($request->hasFile('document')){
            $message = 'document';
            $rules = ['required', new MessageFileValidationRule('document')];
        } else if($request->hasFile('audio')){
            $message = 'audio';
            $rules = ['required', new MessageFileValidationRule('audio')];
        } else if($request->hasFile('image')){
            $message = 'image';
            $rules = ['required', new MessageFileValidationRule('image')];
        } else if($request->hasFile('video')){
            $message = 'video';
            $rules = ['required', new MessageFileValidationRule('video')];
        }

        $request->validate([
            $message => $rules,
            'schedule' => 'required|in:1,2',
            'shedule_date' => 'required_if:schedule,2',
            'group_id' => 'nullable|array|min:1',
            'group_id.*' => 'nullable|exists:groups,id,user_id,'.$user->id,
        ]);

        if(!$request->number && !$request->group_id && !$request->file){
            $notify[] = ['error', 'Invalid number collect format'];
            return back()->withNotify($notify);
        }

        $allContactNumber = [];
        $numberGroupName  = [];
        if($request->number){
            $contactNumber = preg_replace('/[ ,]+/', ',', trim($request->number));
            $recipientNumber  = explode(",",$contactNumber);
            array_push($allContactNumber, $recipientNumber);
        }
        if($request->group_id){
            $groupNumber = Contact::where('user_id', $user->id)->whereIn('group_id', $request->group_id)->pluck('contact_no')->toArray();
            $numberGroupName = Contact::where('user_id', $user->id)->whereIn('group_id', $request->group_id)->pluck('name','contact_no')->toArray();
            array_push($allContactNumber, $groupNumber);
        }
        if($request->file){
            $extension = strtolower($request->file->getClientOriginalExtension());
            if(!in_array($extension, ['csv','txt','xlsx'])){
                $notify[] = ['error', 'Invalid file extension'];
                return back()->withNotify($notify);
            }
            if($extension == "txt"){
                $contactNumberTxt = file($request->file);
                unset($contactNumberTxt[0]);
                $txtNumber = array_values($contactNumberTxt);
                $txtNumber = preg_replace('/[^a-zA-Z0-9_ -]/s','',$txtNumber);
                array_push($allContactNumber, $txtNumber);
            }
            if($extension == "csv"){
                $contactNumberCsv = array();
                $contactNameCsv = array();
                $nameNumberArray[] = [];
                $csvArrayLength = 0;
                if(($handle = fopen($request->file, "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE){
                        if($csvArrayLength == 0){
                           $csvArrayLength = count($data);
                        }
                        foreach($data as $dataVal){
                            if(filter_var($dataVal, FILTER_SANITIZE_NUMBER_INT)){
                                array_push($contactNumberCsv, $dataVal);
                            }
                            else{
                                array_push($contactNameCsv, $dataVal);
                            }
                        }
                    }
                }
                for ($i = 0; $i < $csvArrayLength; $i++){
                    unset($contactNameCsv[$i]);
                }
                if((count($contactNameCsv)) == 0){
                    $contactNameCsv = $contactNumberCsv;
                }
                $nameNumberArray = array_combine($contactNumberCsv, $contactNameCsv);
                $numberGroupName = $numberGroupName +  $nameNumberArray;
                $csvNumber = array_values($contactNumberCsv);
                array_push($allContactNumber, $csvNumber);

            }
            if($extension == "xlsx"){
                $nameNumberArray[] = [];
                $contactNameXlsx = array();
                $exelArrayLength = 0;
                $contactNumberxlsx = array();
                $xlsx = SimpleXLSX::parse($request->file);
                $data = $xlsx->rows();
                foreach($data as $key=>$val){
                    if($exelArrayLength == 0){
                        $exelArrayLength = count($val);
                    }
                    foreach($val as $dataKey=>$dataVal){
                        if(filter_var($dataVal, FILTER_SANITIZE_NUMBER_INT)){
                            array_push($contactNumberxlsx, $dataVal);
                        }
                        else{
                            array_push($contactNameXlsx, (string)$dataVal);
                        }
                    }
                }
                for ($i = 0; $i < $exelArrayLength; $i++){
                    unset($contactNameXlsx[$i]);
                }
                if((count($contactNameXlsx)) == 0){
                    $contactNameXlsx = $contactNumberxlsx;
                }
                $nameNumberArray = array_combine($contactNumberxlsx, $contactNameXlsx);
                $numberGroupName = $numberGroupName +  $nameNumberArray;
                $excelNumber = array_values($contactNumberxlsx);
                array_push($allContactNumber, $excelNumber);
            }
        }

        $contactNewArray = [];
        foreach($allContactNumber as $childArray){
            foreach($childArray as $value){
                $contactNewArray[] = $value;
            }
        }
        $messages = str_split($request->message,320);
        $totalMessage = count($messages);
        $totalNumber = count($contactNewArray);
        $totalCredit = $totalNumber * $totalMessage;

        if($totalCredit > $user->whatsapp_credit){
            $notify[] = ['error', 'You do not have a sufficient credit for send message'];
            return back()->withNotify($notify);
        }

        $user->whatsapp_credit -=  $totalCredit;
        $user->save();

        $creditInfo = new WhatsappCreditLog();
        $creditInfo->user_id = $user->id;
        $creditInfo->type = "-";
        $creditInfo->credit = $totalCredit;
        $creditInfo->trx_number = trxNumber();
        $creditInfo->post_credit =  $user->whatsapp_credit;
        $creditInfo->details = $totalCredit." credits were cut for " .$totalNumber . " number send message";
        $creditInfo->save();

        $whatsappGateway = WhatsappDevice::where('status', 'connected')->pluck('delay_time','id')->toArray();

        if(count($whatsappGateway) < 1){
            $notify[] = ['error', 'Not available WhatsApp Gateway'];
            return back()->withNotify($notify);
        }
        $postData = [];
        if($request->hasFile('document')){
            $file = $request->file('document');
            $fileName = uniqid().time().'.'.$file->getClientOriginalExtension();
            $path = filePath()['whatsapp']['path_document'];
            if(!file_exists($path)){
                mkdir($path, 0777, true);
            }
            try {
                move_uploaded_file($file->getRealPath(), $path.'/'.$fileName);
            } catch (\Exception $e) {

            }
            $postData['type'] = 'pdf';
            $postData['url_file'] = $path.'/'.$fileName;
            $postData['name'] = $fileName;
        }
        if($request->hasFile('audio')){
            $file = $request->file('audio');
            $fileName = uniqid().time().'.'.$file->getClientOriginalExtension();
            $path = filePath()['whatsapp']['path_audio'];
            if(!file_exists($path)){
                mkdir($path, 0777, true);
            }
            try {
                move_uploaded_file($file->getRealPath(), $path.'/'.$fileName);
            } catch (\Exception $e) {

            }
            $postData['type'] = 'Audio';
            $postData['url_file'] = $path.'/'.$fileName;
            $postData['name'] = $fileName;
        }
        if($request->hasFile('image')){
            $file = $request->file('image');
            $fileName = uniqid().time().'.'.$file->getClientOriginalExtension();
            $path = filePath()['whatsapp']['path_image'];
            if(!file_exists($path)){
                mkdir($path, 0777, true);
            }
            try {
                move_uploaded_file($file->getRealPath(), $path.'/'.$fileName);
            } catch (\Exception $e) {

            }
            $postData['type'] = 'Image';
            $postData['url_file'] = $path.'/'.$fileName;
            $postData['name'] = $fileName;
        }
        if($request->hasFile('video')){
            $file = $request->file('video');
            $fileName = uniqid().time().'.'.$file->getClientOriginalExtension();
            $path = filePath()['whatsapp']['path_video'];
            if(!file_exists($path)){
                mkdir($path, 0777, true);
            }
            try {
                move_uploaded_file($file->getRealPath(), $path.'/'.$fileName);
            } catch (\Exception $e) {

            }
            $postData['type'] = 'Video';
            $postData['url_file'] = $path.'/'.$fileName;
            $postData['name'] = $fileName;
        }
        $delayTimeCount = [];
        $setTimeInDelay = 0;
        if($request->schedule == 2){
            $setTimeInDelay = $request->shedule_date;
        }else{
            $setTimeInDelay = Carbon::now();
        }
        $contactNewArray = array_unique($contactNewArray);
        $setWhatsAppGateway =  $whatsappGateway;
        $i = 1; $addSecond = 10;$gateWayid = null;
        foreach (array_filter($contactNewArray) as $key => $value) {
            foreach ($setWhatsAppGateway as $key => $appGateway){
                $addSecond = $appGateway * $i;
                $gateWayid = $key;
                unset($setWhatsAppGateway[$key]);
                if(empty($setWhatsAppGateway)){
                    $setWhatsAppGateway =  $whatsappGateway;
                    $i++;
                }
                break;
            } 
            $log = new WhatsappLog();
            $log->user_id = $user->id;
            if(count($whatsappGateway) > 0){
                $log->whatsapp_id =  $gateWayid;
            }
            $log->to = $value;
            $log->initiated_time = $request->schedule == 1 ? Carbon::now() : $request->shedule_date;
            if(array_key_exists($value,$numberGroupName)){
                $finalContent = str_replace('{{name}}', $numberGroupName ? $numberGroupName[$value]:$value, offensiveMsgBlock($request->message));
            }
            else{
                $finalContent = str_replace('{{name}}',$value, offensiveMsgBlock($request->message));
            }
            $log->message = $finalContent;
            $log->status = $request->schedule == 2 ? 2 : 1;
            if($request->hasFile('document')){
                $log->document = $fileName;
            }
            if($request->hasFile('audio')){
                $log->audio = $fileName;
            }
            if($request->hasFile('image')){
                $log->image = $fileName;
            }
            if($request->hasFile('video')){
                $log->video = $fileName;
            }
            $log->schedule_status = $request->schedule;
            $log->save();
              
            if(count($contactNewArray) == 1 && $request->schedule == 1){
                dispatch_now(new ProcessWhatsapp($finalContent, $value, $log->id, $postData));
            }
            else{
                dispatch(new ProcessWhatsapp($finalContent, $value, $log->id, $postData))->delay(Carbon::parse($setTimeInDelay)->addSeconds($addSecond));
            }
        }
        $notify[] = ['success', 'New WhatsApp Message request sent, please see in the WhatsApp Log history for final status'];
        return back()->withNotify($notify);
    }


    public function search(Request $request, $scope)
    {
        $title = "WhatsApp History";
        $search = $request->search;
        $searchDate = $request->date;
        $user = Auth::user();


        if ($search!="") {
            $smslogs = WhatsappLog::where('user_id', $user->id)->where('to','like',"%$search%");
        }
        if ($searchDate!="") {
            $searchDate_array = explode('-',$request->date);
            $firstDate = $searchDate_array[0];
            $lastDate = null;
            if (count($searchDate_array)>1) {
                $lastDate = $searchDate_array[1];
            }
            $matchDate = "/\d{2}\/\d{2}\/\d{4}/";
            if ($firstDate && !preg_match($matchDate,$firstDate)) {
                $notify[] = ['error','Invalid order search date format'];
                return back()->withNotify($notify);
            }
            if ($lastDate && !preg_match($matchDate,$lastDate)) {
                $notify[] = ['error','Invalid order search date format'];
                return back()->withNotify($notify);
            }
            if ($firstDate) {
                $smslogs = WhatsappLog::where('user_id', $user->id)->whereDate('created_at',Carbon::parse($firstDate));
            }
            if ($lastDate){
                $smslogs = WhatsappLog::where('user_id', $user->id)->whereDate('created_at','>=',Carbon::parse($firstDate))->whereDate('created_at','<=',Carbon::parse($lastDate));
            }

        }
        if ($search=="" && $searchDate==""){
                $notify[] = ['error','Please give any search filter data'];
                return back()->withNotify($notify);
        }
        if($scope == 'pending') {
            $smslogs = $smslogs->where('status',WhatsappLog::PENDING);
        }elseif($scope == 'delivered'){
            $smslogs = $smslogs->where('status',WhatsappLog::SUCCESS);
        }elseif($scope == 'schedule'){
            $smslogs = $smslogs->where('status',WhatsappLog::SCHEDULE);
        }elseif($scope == 'failed'){
            $smslogs = $smslogs->where('status',WhatsappLog::FAILED);
        }

        $whatsApp = $smslogs->orderBy('id','desc')->with('user', 'whatsappGateway')->paginate(paginateNumber());
        return view('user.whatsapp.index', compact('title', 'whatsApp', 'search','searchDate'));
    }

}

