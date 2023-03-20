<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\EmailGroup;
use App\Models\Contact;
use App\Models\EmailContact;

class OwnGroupController extends Controller
{
	public function smsIndex()
    {
    	$title = "Manage own sms group";
    	$groups = Group::whereNull('user_id')->paginate(paginateNumber());
    	return view('admin.phone_book.own_sms_group', compact('title', 'groups'));
    }

    public function smsStore(Request $request)
    {
    	$data = $request->validate([
    		'name' => 'required|max:255',
    		'status' => 'required|in:1,2'
    	]);
    	Group::create($data);
    	$notify[] = ['success', 'SMS group has been created'];
    	return back()->withNotify($notify);
    }

    public function smsUpdate(Request $request)
    {
    	$data = $request->validate([
    		'name' => 'required|max:255',
    		'status' => 'required|in:1,2'
    	]);
    	$group = Group::whereNull('user_id')->where('id', $request->id)->firstOrFail();
    	$group->update($data);
    	$notify[] = ['success', 'SMS group has been created'];
    	return back()->withNotify($notify);
    }

    public function smsDelete(Request $request)
    {
    	$group = Group::whereNull('user_id')->where('id', $request->id)->firstOrFail();
    	$contact = Contact::whereNull('user_id')->where('group_id', $group->id)->delete();
    	$group->delete();
    	$notify[] = ['success', 'SMS group has been deleted'];
    	return back()->withNotify($notify);
    }

    public function smsOwnContactByGroup($id)
    {
        $group = Group::findOrFail($id);
        $title = "SMS contact list by ".$group->name;
        $groups = Group::whereNull('user_id')->get();
        $contacts = Contact::whereNull('user_id')->where('group_id', $id)->latest()->with('group')->paginate(paginateNumber());
        return view('admin.phone_book.own_sms_contact', compact('title', 'contacts', 'groups'));
    }

    public function emailOwnContactByGroup($id)
    {
        $group = EmailGroup::findOrFail($id);
        $title = "Email contact list by ".$group->name;
        $groups = EmailGroup::whereNull('user_id')->get();
        $contacts = EmailContact::whereNull('user_id')->where('email_group_id', $id)->latest()->with('user', 'emailGroup')->paginate(paginateNumber());
        return view('admin.phone_book.own_email_contact', compact('title', 'contacts', 'groups'));
    }

    public function emailIndex()
    {
    	$title = "Manage own email group";
    	$emailGroups = EmailGroup::whereNull('user_id')->paginate(paginateNumber());
    	return view('admin.phone_book.own_email_group', compact('title', 'emailGroups'));
    }

    public function emailStore(Request $request)
    {
    	$data = $request->validate([
    		'name' => 'required|max:255',
    		'status' => 'required|in:1,2'
    	]);
    	EmailGroup::create($data);
    	$notify[] = ['success', 'Email group has been created'];
    	return back()->withNotify($notify);
    }

    public function emailUpdate(Request $request)
    {
    	$data = $request->validate([
    		'name' => 'required|max:255',
    		'status' => 'required|in:1,2'
    	]);
    	$group = EmailGroup::whereNull('user_id')->where('id', $request->id)->firstOrFail();
    	$group->update($data);
    	$notify[] = ['success', 'Email Group has been created'];
    	return back()->withNotify($notify);
    }

    public function emailDelete(Request $request)
    {
    	$group = EmailGroup::whereNull('user_id')->where('id', $request->id)->firstOrFail();
    	$contact = EmailContact::whereNull('user_id')->where('email_group_id', $group->id)->delete();
    	$group->delete();
    	$notify[] = ['success', 'SMS Group has been deleted'];
    	return back()->withNotify($notify);
    }
}
