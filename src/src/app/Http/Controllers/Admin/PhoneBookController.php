<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\EmailGroup;
use App\Models\EmailContact;
use App\Models\Contact;
use App\Models\User;
use App\Exports\AdminContactExport;
use App\Exports\AdminEmailContactExport;
use Maatwebsite\Excel\Facades\Excel;

class PhoneBookController extends Controller
{
    public function smsGroupIndex()
    {
    	$title = "Manage sms group";
    	$groups = Group::whereNotNull('user_id')->latest()->with('user')->paginate(paginateNumber());
    	return view('admin.phone_book.sms_group', compact('title', 'groups'));
    }

    public function emailGroupIndex()
    {
        $title = "Manage email group";
        $emailGroups = EmailGroup::whereNotNull('user_id')->latest()->with('user')->paginate(paginateNumber());
        return view('admin.phone_book.email_group', compact('title', 'emailGroups'));
    }

    public function smsContactIndex()
    {
    	$title = "Manage sms contact list";
        $users = User::select('id', 'name')->get();
    	$contacts = Contact::whereNotNull('user_id')->latest()->with('user', 'group')->paginate(paginateNumber());
    	return view('admin.phone_book.sms_contact', compact('title', 'contacts', 'users'));
    }

    public function smsContactByGroup($id)
    {
        $title = "Manage sms contact list";
        $users = User::select('id', 'name')->get();
        $contacts = Contact::whereNotNull('user_id')->where('group_id', $id)->latest()->with('user', 'group')->paginate(paginateNumber());
        return view('admin.phone_book.sms_contact', compact('title', 'contacts', 'users'));
    }

    public function emailContactIndex()
    {
        $title = "Manage email contact list";
        $users = User::select('id', 'name')->get();
        $emailContacts = EmailContact::whereNotNull('user_id')->latest()->with('user', 'emailGroup')->paginate(paginateNumber());
        return view('admin.phone_book.email_contact', compact('title', 'emailContacts', 'users'));
    }


    public function emailContactByGroup($id)
    {
        $title = "Manage email contact list";
        $users = User::select('id', 'name')->get();
        $emailContacts = EmailContact::whereNotNull('user_id')->where('email_group_id', $id)->latest()->with('user', 'emailGroup')->paginate(paginateNumber());
        return view('admin.phone_book.email_contact', compact('title', 'emailContacts', 'users'));
    }

    public function contactExport(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
        ]);
        if($request->user_id != 'all'){
            $users = User::findOrFail($request->user_id);
        }
        return Excel::download(new AdminContactExport($request->user_id), 'contact.xlsx');
    }

    public function emailContactExport(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
        ]);
        if($request->user_id != 'all'){
            $users = User::findOrFail($request->user_id);
        }
        return Excel::download(new AdminEmailContactExport($request->user_id), 'email_contact.xlsx');
    }
}
