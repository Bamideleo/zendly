<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Contact;
use App\Models\GeneralSetting;
use App\Models\Template;
use Illuminate\Support\Facades\Auth;
use App\Imports\ContactImport;
use App\Exports\ContactExport;
use Maatwebsite\Excel\Facades\Excel;

class PhoneBookController extends Controller
{

    public function groupIndex()
    {
    	$title = "Manage SMS Group";
    	$user = Auth::user();
    	$groups = Group::whereNotNull('user_id')->where('user_id', $user->id)->paginate(paginateNumber());
    	return view('user.group.index', compact('title', 'groups'));
    }

    public function groupStore(Request $request)
    {
    	$data = $request->validate([
    		'name' => 'required|max:255',
    		'status' => 'required|in:1,2'
    	]);
    	$user = Auth::user();
    	$data['user_id'] = $user->id;
    	Group::create($data);
    	$notify[] = ['success', 'Group has been created'];
    	return back()->withNotify($notify);
    }

    public function groupUpdate(Request $request)
    {
    	$data = $request->validate([
    		'name' => 'required|max:255',
    		'status' => 'required|in:1,2'
    	]);
    	$user = Auth::user();
    	$group = Group::where('user_id', $user->id)->where('id', $request->id)->firstOrFail();
    	$data['user_id'] = $user->id;
    	$group->update($data);
    	$notify[] = ['success', 'Group has been created'];
    	return back()->withNotify($notify);
    }

    public function groupdelete(Request $request)
    {
    	$user = Auth::user();
    	$group = Group::where('user_id', $user->id)->where('id', $request->id)->firstOrFail();
    	$contact = Contact::where('user_id', $user->id)->where('group_id', $group->id)->delete();
    	$group->delete();
    	$notify[] = ['success', 'Group has been deleted'];
    	return back()->withNotify($notify);
    }

    public function smsContactByGroup($id)
    {
        $title = "Manage SMS Contact List";
        $user = Auth::user();
        $contacts = Contact::where('user_id', $user->id)->where('group_id', $id)->with('group')->paginate(paginateNumber());
        return view('user.contact.index', compact('title', 'contacts', 'user'));
    }

    public function contactIndex()
    {
    	$title = "Manage SMS Contact List";
    	$user = Auth::user();
    	$contacts = $user->contact()->with('group')->paginate(paginateNumber());
    	return view('user.contact.index', compact('title', 'contacts', 'user'));
    }

    public function contactStore(Request $request)
    {
    	$user = Auth::user();
    	$data = $request->validate([
    		'contact_no' => 'required|max:50',
    		'name' => 'required|max:90',
    		'group_id' => 'required|exists:groups,id,user_id,'.$user->id,
    		'status' => 'required|in:1,2'
    	]);
        $general = GeneralSetting::first();
        $data['contact_no'] = $data['contact_no'];
    	$data['user_id'] = $user->id;
    	Contact::create($data);
    	$notify[] = ['success', 'Contact has been created'];
    	return back()->withNotify($notify);
    }

    public function contactUpdate(Request $request)
    {
    	$user = Auth::user();
    	$data = $request->validate([
    		'contact_no' => 'required|max:50',
    		'name' => 'required|max:90',
    		'group_id' => 'required|exists:groups,id,user_id,'.$user->id,
    		'status' => 'required|in:1,2'
    	]);
    	$data['user_id'] = $user->id;
    	$contact = Contact::where('user_id', $user->id)->where('id', $request->id)->firstOrFail();
        $contact->update($data);
    	$notify[] = ['success', 'Contact has been updated'];
    	return back()->withNotify($notify);
    }

    public function contactImport(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'group_id' => 'required|exists:groups,id,user_id,'.$user->id,
            'file'=> 'required|mimes:xlsx'
        ]);
        $groupId = $request->group_id;
        $status = false;
        Excel::import(new ContactImport($groupId, $status), $request->file);
        $notify[] = ['success', 'New contact has been uploaded'];
        return back()->withNotify($notify);
    }

    public function contactExport(Request $request)
    {
        $status = false;
        return Excel::download(new ContactExport($status), 'sms_contact.xlsx');
    }

    public function contactDelete(Request $request)
    {
    	$user = Auth::user();
    	$contact = Contact::where('user_id', $user->id)->where('id', $request->id)->firstOrFail();
    	$contact->delete();
    	$notify[] = ['success', 'Contact has been deleted'];
    	return back()->withNotify($notify);
    }

    public function templateIndex()
    {
    	$title = "Manage Template List";
    	$user = Auth::user();
    	$templates = $user->template()->paginate(paginateNumber());
    	return view('user.template.index', compact('title', 'templates'));
    }

    public function templateStore(Request $request)
    {
        $request->validate([
    		'name' => 'required|max:255',
    		'message' => 'required',
    	]);
        $message = '';
    	$user = Auth::user();
    	$data  = Template::create([
			'name' 	  => $request->name,
			'message' => offensiveMsgBlock($request->message),
			'user_id' => $user->id,
			'status'  => 1,
		]);
        if (offensiveMsgBlock($request->message) != $request->message ){
            $message = session()->get('offsensiveNotify') ;
        }
    	$notify[] = ['success', 'Template has been created with '.$message];
    	return back()->withNotify($notify);
    }

    public function templateUpdate(Request $request)
    {
        $request->validate([
    		'name' => 'required|max:255',
    		'message' => 'required',
    	]);
        $message = '';
    	$user = Auth::user();
    	$template = Template::where('user_id', $user->id)->where('id', $request->id)->firstOrFail();
    	$template->update([
			'name' 	  => $request->name,
			'message' => offensiveMsgBlock($request->message),
			'user_id' => $user->id,
			'status'  => 1,
		]);
        if (offensiveMsgBlock($request->message) != $request->message ){
            $message = session()->get('offsensiveNotify') ;
        }
    	$notify[] = ['success', 'Template has been created '.$message];
    	return back()->withNotify($notify);
    }

    public function templateDelete(Request $request)
    {
    	$user = Auth::user();
    	$template = Template::where('user_id', $user->id)->where('id', $request->id)->firstOrFail();
    	$template->delete();
    	$notify[] = ['success', 'Template has been deleted'];
    	return back()->withNotify($notify);
    }

}
