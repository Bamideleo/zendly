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
            'email' => 'required|email|max:120',
            'name' => 'required|max:90',
            'email_group_id' => 'required|exists:email_groups,id,user_id,'.$user->id,
            'status' => 'required|in:1,2'
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
            'email' => 'required|email|max:120',
            'name' => 'required|max:90',
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
