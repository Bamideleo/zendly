<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailGroup;
use App\Models\EmailContact;
use Illuminate\Support\Facades\Auth;
use App\Imports\EmailContactImport;
use App\Exports\EmailContactExport;
use Maatwebsite\Excel\Facades\Excel;


class EmailContactController extends Controller
{
public function getLead(Request $request){
    $offset = $request->query('model');
    $user = Auth::user();
    $groups = $user->emailGroup()->paginate(paginateNumber());
    if($offset == null){
        $offset = '';
    }
$title = "Lead";     
$API_KEY ="l_sdhz5UDGCv-zhyhWNeQZT8CxvpbnQmrSIlct-o5AU2kp2uUnK83BcbQX8UgucUzD7PzUxHXYC2v5bX0AhKEW210HMm9RADVS3XbRq52Yptjjy7mjW7oLWhyVUAX3Yx";

$curl = curl_init($offset);
curl_setopt_array($curl, [
//   CURLOPT_URL=>"https://api.yelp.com/v3/businesses/Xg-FyjVKAN70LO4u4Z1ozg",
  CURLOPT_URL => "https://api.yelp.com/v3/businesses/search?latitude=37.786882&longitude=-122.399972&limit=20&offset=".$offset,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_SSL_VERIFYPEER=> false,
  CURLOPT_HTTPHEADER => [
    "authorization: Bearer $API_KEY",
    "cache-control: no-cache",
  ],
]);
$response = curl_exec($curl);

$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
    $data = json_decode($response, TRUE);
    $value = $data['businesses'];
        return view('user.email_group.lead', compact('title','value','groups'));
}

}

public function get_bussiness_data( Request $request)
{   
 $id = $request->id;
$API_KEY ="l_sdhz5UDGCv-zhyhWNeQZT8CxvpbnQmrSIlct-o5AU2kp2uUnK83BcbQX8UgucUzD7PzUxHXYC2v5bX0AhKEW210HMm9RADVS3XbRq52Yptjjy7mjW7oLWhyVUAX3Yx";

$curl = curl_init();
curl_setopt_array($curl, [
  CURLOPT_URL=>"https://api.yelp.com/v3/businesses/".$id,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_SSL_VERIFYPEER=> false,
  CURLOPT_HTTPHEADER => [
    "authorization: Bearer $API_KEY",
    "cache-control: no-cache",
  ],
]);
$response = curl_exec($curl);

$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
    $data = json_decode($response, TRUE);
    $value = $data['url'];
    $get_url = $this->extract_url($value);
    $get_email = $this->extract_email($get_url);
    return response()->json(
        [
        'name' => $data['name'],
        'image' => $data['image_url'],
        'address' => $data['location']['address1'],
        'city' => $data['location']['city'],
        'country' => $data['location']['country'],
        'zip' => $data['location']['zip_code'],
        'phone' => $data['phone'],
        'rating' => $data['rating'],
        'hours' => $data['hours'][0]['hours_type'],
        'review' => $data['review_count'],
        'status' =>200,
        'email' => $get_email,
        'link' => $get_url,
    ]
    ); 
   
}

}


// Section To Extract Url
public function extract_url($link)
{
    $url =  $link;
    $options = array(

        CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
        CURLOPT_POST           =>false,        //set to GET
        //CURLOPT_USERAGENT      => $user_agent, //set user agent
        CURLOPT_COOKIEFILE     =>"cookie.txt", //set cookie file
        CURLOPT_COOKIEJAR      =>"cookie.txt", //set cookie jar
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,     // return web page
        CURLOPT_HEADER         => false,    // don't return headers
        CURLOPT_FOLLOWLOCATION => true,     // follow redirects
        CURLOPT_ENCODING       => "",       // handle all encodings
        CURLOPT_AUTOREFERER    => true,     // set referer on redirect
        CURLOPT_CONNECTTIMEOUT => 12000,      // timeout on connect
        CURLOPT_TIMEOUT        => 12000,      // timeout on response
        CURLOPT_MAXREDIRS      => 500,       // stop after 10 redirects
    );

    $ch      = curl_init( $url );
    curl_setopt_array( $ch, $options );
    $content = curl_exec( $ch );
    $err     = curl_errno( $ch );
    $errmsg  = curl_error( $ch );
    $header  = curl_getinfo( $ch );
    curl_close( $ch );
    $matches = array();
    preg_match_all('#<a\s.*?(?:href=[\'"](.*?)[\'"]).*?>#is', $content, $matches);
   
  foreach($matches[0] as $url) 
{
if ( strpos($url, 'biz_redir?url') !== false )
{ 
$x = explode("biz_redir?url=", $url);
$a = explode("&", $x[1]);
$b = urldecode($a[0]);
$c = explode("/", $b);
$d = 'https://'.$c[2];
// dd($d);
return $d;
} 
}
}



public function get_contact_email($links)
{
    header("Access-Control-Allow-Origin: *");
    $client = new \GuzzleHttp\Client();
    $response = $client->get($links, ['verify' => false]);
    $data = (string) $response->getBody();
    preg_match_all('#<a\s.*?(?:href=[\'"](.*?)[\'"]).*?>#is' , $data, $matches);
    // dd($links);
    $results = array();
    foreach($matches[0] as $link) 
    {
        if ( strpos($link, 'href="mailto:') !== false ){
            $x = explode('href="mailto:', $link);
            $a = explode('"', $x[1]);
            // dd($a);
            $results[] = $a[0];   
        }
    }
    if( empty($results) ) 
    { 
        $t = explode('https://', $links);
        $s = explode('www.', $t[1]);        
        $keys=  array('info@','support@','host@','contact@', 'office@');
                
        shuffle($keys);
                   foreach($keys as $key) {
                       $new = $key;
                   }
                   if(count($s)>1){
                    $email[] = $new.$s[1];
                    return $email; 
                   }
                   else{
                    $email[] = $new.$s[0];
                    return $email; 
                   }

    }
    else{
 return $results;
    }

}

public function extract_email($links)
{
    
    header("Access-Control-Allow-Origin: *");
    $proxySetting=[
        'headers' => [
              'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)
               AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Safari/537.36',
          ]
      ];

    $client = new \GuzzleHttp\Client();
    $response = $client->get($links, ['verify' => false, $proxySetting]);
    $data = (string) $response->getBody();
    preg_match_all('#<a\s.*?(?:href=[\'"](.*?)[\'"]).*?>#is', $data, $matches);
    //   dd($links);
  
    $results = array();
    foreach ($matches[0] as $value) {
    
      if (strpos($value, 'href="mailto:') !== false)
       { 
           $x = explode('href="mailto:',$value);
            $a = explode('"', $x[1]);
               $results[] = $a[0];   
        }

        elseif (strpos($value, '_contact.html') !== false) {
                    $x = explode("_contact.html", $value);
                    $a = explode('href="', $x[0]);
                    // dd($a[1]);
                    $contact = $links.$a[1].'_contact.html';
                    $results = $this->get_contact_email($contact);
                }
        
        elseif (strpos($value, '-contact.html') !== false) {
            $x = explode("-contact.html", $value);
            $a = explode('href="', $x[0]);
            // dd($a[1]);
            $contact = $links.$a[1].'-contact.html';
            $results = $this->get_contact_email($contact);
        }

        elseif (strpos($value, 'contact_us.html') !== false) {
                    $x = explode("contact_us.html'", $value);
                    $a = explode('href="', $x[0]);
                    // dd($a[1]);
                    $contact = $links.$a[1].'contact_us.html';
                    $results = $this->get_contact_email($contact);
                }

        elseif (strpos($value, 'contact-us.html') !== false) {
                            $x = explode("contact-us.html'", $value);
                            $a = explode('href="', $x[0]);
                            // dd($a[1]);
                            $contact = $links.$a[1].'contact-us.html';
                            $results = $this->get_contact_email($contact);
                        }

        elseif (strpos($value, 'contact.html') !== false) {
                                    $x = explode("contact.html'",$value);
                                    $a = explode('href="', $x[0]);
                                    // dd($a[1]);
                                    $contact = $links.$a[1].'contact.html';
                                    $results = $this->get_contact_email($contact);
             }


        elseif (strpos($value, '_contact.php') !== false) {
                        $x = explode("_contact.php", $value);
                        $a = explode('href="', $x[0]);
                        // dd($a[1]);
                        $contact = $links.$a[1].'_contact.php';
                        $results = $this->get_contact_email($contact);
                    }
            
        elseif (strpos($value, '-contact.php') !== false) {
                        $x = explode("-contact.php", $value);
                        $a = explode('href="', $x[0]);
                        $contact = $links.$a[1].'-contact.php';
                        $results = $this->get_contact_email($contact);
                    }

     elseif (strpos($value, 'contact_us.php') !== false) {
                        $x = explode("_contact_us.php", $value);
                        $a = explode('href="', $x[0]);
                        // dd($a[1]);
                        $contact = $links.$a[1].'contact_us.php';
                        $results = $this->get_contact_email($contact);
                    }
            
    elseif (strpos($value, 'contact-us.php') !== false) {
                        $x = explode("contact-us.php", $value);
                        $a = explode('href="', $x[0]);
                        // dd($a[1]);
                        $contact = $links.$a[1].'contact-us.php';
                        $results = $this->get_contact_email($contact);
                    }
            
    elseif (strpos($value, 'contact.php') !== false) {
                        $x = explode("contact.php", $value);
                        $a = explode('href="', $x[0]);
                        // dd($a[1]);
                        $contact = $links.$a[1].'contact.php';
                        $results = $this->get_contact_email($contact);
                    }
    
    
    elseif(strpos($value, '_contact') !== false){
            $x = explode("_contact", $value);
            $a = explode('href="', $x[0]);
            $contact = $links.$a[1].'_contact';
            $results = $this->get_contact_email($contact);
           }

    elseif( strpos($value, '-contact') !== false )
           { 
           $x = explode("-contact", $value);
           $a = explode('href="', $x[0]);
           $contact = $links.$a[1].'-contact';
        $results = $this->get_contact_email($contact);
           }

    elseif(strpos($value, 'contact-us') !== false){
                $x = explode("contact-us",$value);
                $a = explode('href="', $x[0]);
                $contact = $links.$a[1].'contact-us';
                $results = $this->get_contact_email($contact);
                }


    elseif(strpos($value, 'contact_us') !== false){
                    $x = explode("contact_us", $value);
                    $a = explode('href="', $x[0]);
                    $contact = $links.$a[1].'contact_us';
            $results = $this->get_contact_email($contact);
            }



        elseif(strpos($value, 'contact') !== false){
    
           $x = explode("contact", $value);
                       
            $a = explode('href="', $x[0]);
            // dd($a);
            $tr = explode('https://', $a[1]);
            if(count($tr)==2){
                $t = explode('/', $tr[1]);
                $s = 'https://'.$t[0];
                if($links == $s){
                // dd($a[1]);
                 $contact =$links .'contact';
        
                 $results = $this->get_contact_email($contact); 
                        }
            }
                        
            else {
                            // dd($a[1]);
                        $contact = $links.$a[1].'contact';
        
                        $results = $this->get_contact_email($contact); 
                        }
                      
                       
    }
    
    }
    
    if( empty($results) ) 
    { 
        $t = explode('https://', $links);
        $s = explode('www.', $t[1]);        
      $keys=  array('info@','support@','host@','contact@','office@');
                
        shuffle($keys);
                   foreach($keys as $key) {
                       $new = $key;
                   }
                   if(count($s)>1){
                    $email[] = $new.$s[1];
                    return $email; 
                   }
                   else{
                       
                    $email[] = $new.$s[0];
                    return $email; 
                   }

    }
    else { 
        return $results[0];
        // dd($results);
       
     }


}

// public function leads_search($offset='', $search, $location=''){ 
public function leads_search(Request $request){ 
    
    $API_KEY = "l_sdhz5UDGCv-zhyhWNeQZT8CxvpbnQmrSIlct-o5AU2kp2uUnK83BcbQX8UgucUzD7PzUxHXYC2v5bX0AhKEW210HMm9RADVS3XbRq52Yptjjy7mjW7oLWhyVUAX3Yx";
    $sea = $request->search;
    // $search = 'food-restaurant';
    $search = preg_replace('#[ -]+#', '-', $sea);
    $loc = $request->location;
    $location = preg_replace('#[ -]+#', '-', $loc);
    // $location = 'Los-Angeles';
    
    $offset = $request->offset;
   if($location == null){
    $location = "San-Francisco,-CA";
   }
   if($offset == null){
    $offset = '';
   }
           
         $curl = curl_init();
                curl_setopt_array($curl, array(
                   CURLOPT_URL => "https://api.yelp.com/v3/businesses/search?term=".$search."&location=".$location."&limit=20&offset=".$offset,
                   CURLOPT_RETURNTRANSFER => true,  // Capture response.
                   CURLOPT_ENCODING => "",  // Accept gzip/deflate/whatever.
                   CURLOPT_MAXREDIRS => 10,
                   CURLOPT_SSL_VERIFYPEER => false,
                   CURLOPT_TIMEOUT => 30,
                   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                   CURLOPT_CUSTOMREQUEST => "GET",
                   CURLOPT_HTTPHEADER => array(
                       "authorization: Bearer $API_KEY",
                       "cache-control: no-cache",
                   ),
               ));
       
               $response = curl_exec($curl);
               $err = curl_error($curl);
           
               curl_close($curl);
           
               # Print any errors, to help with debugging.
               if ($err) {
                 echo "cURL Error #:" . $err;
               }
           
               $body = json_decode($response, true);
       
              $data=$body['businesses']; 
              
            //    return $e;
            return response()->json($data);
} 

    public function emailGroupIndex()
    {
    	$title = "Manage Email Group";
    	$user = Auth::user();
    	$groups = $user->emailGroup()->paginate(paginateNumber());
    	return view('user.email_group.index', compact('title', 'groups'));
    }

    public function emailGroupStore(Request $request)
    {
    	$data = $request->validate([
    		'name' => 'required|max:255',
    		'status' => 'required|in:1,2'
    	]);
    	$user = Auth::user();
    	$data['user_id'] = $user->id;
    	EmailGroup::create($data);
    	$notify[] = ['success', 'Email Group has been created'];
    	return back()->withNotify($notify);
    }

    public function emailGroupUpdate(Request $request)
    {
    	$data = $request->validate([
    		'name' => 'required|max:255',
    		'status' => 'required|in:1,2'
    	]);
    	$user = Auth::user();
    	$group = EmailGroup::where('user_id', $user->id)->where('id', $request->id)->firstOrFail();
    	$data['user_id'] = $user->id;
    	$group->update($data);
    	$notify[] = ['success', 'Email Group has been created'];
    	return back()->withNotify($notify);
    }

    public function emailGroupdelete(Request $request)
    {
    	$user = Auth::user();
    	$group = EmailGroup::where('user_id', $user->id)->where('id', $request->id)->firstOrFail();
    	$contact = EmailContact::where('user_id', $user->id)->where('email_group_id', $group->id)->delete();
    	$group->delete();
    	$notify[] = ['success', 'Email Group has been deleted'];
    	return back()->withNotify($notify);
    }

    public function emailContactByGroup($id)
    {
        $title = "Manage Email Contact List";
        $user = Auth::user();
        $contacts = EmailContact::where('user_id', $user->id)->where('email_group_id', $id)->with('emailGroup')->paginate(paginateNumber());
        return view('user.email_contact.index', compact('title', 'contacts', 'user'));
    }



    public function emailContactIndex()
    {
        $title = "Manage Email Contact List";
        $user = Auth::user();
        $contacts = $user->emailContact()->with('emailGroup')->paginate(paginateNumber());
        return view('user.email_contact.index', compact('title', 'contacts', 'user'));
    }

    public function emailContactStore(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'email' => 'required|email',
            'name' => 'required',
            'email_group_id' => 'required|exists:email_groups,id,user_id,'.$user->id,
            // 'status' => 'required|in:1,2'
        ]);
        $data['user_id'] = $user->id;
        EmailContact::create($data);
        $notify[] = ['success', 'Email Contact has been created'];
        return back()->withNotify($notify);
    }

    public function emailContactUpdate(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'email' => 'required|email',
            'name' => 'required',
            'email_group_id' => 'required|exists:email_groups,id,user_id,'.$user->id,
            'status' => 'required|in:1,2'
        ]);
        $data['user_id'] = $user->id;
        $contact = EmailContact::where('user_id', $user->id)->where('id', $request->id)->firstOrFail();
        $contact->update($data);
        $notify[] = ['success', 'Email Contact has been updated'];
        return back()->withNotify($notify);
    }

    public function emailContactImport(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'email_group_id' => 'required|exists:email_groups,id,user_id,'.$user->id,
            'file'=> 'required|mimes:xlsx'
        ]);
        $groupId = $request->email_group_id;
        $status = false;
        Excel::import(new EmailContactImport($groupId, $status), $request->file);
        $notify[] = ['success', 'Email Contact data has been imported'];
        return back()->withNotify($notify);
    }

    public function emailContactExport() 
    {
        $status = false;
        return Excel::download(new EmailContactExport($status), 'email_contact.xlsx');
    }

    public function emailContactDelete(Request $request)
    {
        $user = Auth::user();
        $contact = EmailContact::where('user_id', $user->id)->where('id', $request->id)->firstOrFail();
        $contact->delete();
        $notify[] = ['success', 'Email Contact has been deleted'];
        return back()->withNotify($notify);
    }
}
