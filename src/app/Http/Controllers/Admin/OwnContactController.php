<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailContact;
use App\Models\Group;
use App\Models\Contact;
use App\Models\GeneralSetting;
use App\Models\EmailGroup;
use App\Imports\EmailContactImport;
use App\Exports\EmailContactExport;
use App\Imports\ContactImport;
use App\Exports\ContactExport;
use Maatwebsite\Excel\Facades\Excel;

class OwnContactController extends Controller
{
    public function emailContactIndex()
    {
        $title = "Manage Email Contact List";
        $groups = EmailGroup::whereNull('user_id')->get();
        $contacts = EmailContact::whereNull('user_id')->with('emailGroup')->paginate(paginateNumber());
        return view('admin.phone_book.own_email_contact', compact('title', 'contacts', 'groups'));
    }

    public function emailContactStore(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|max:120',
            'name' => 'required|max:90',
            'email_group_id' => 'required|exists:email_groups,id',
            'status' => 'required|in:1,2'
        ]);
        EmailContact::create($data);
        $notify[] = ['success', 'Email Contact has been created'];
        return back()->withNotify($notify);
    }

    public function emailContactUpdate(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|max:120',
            'name' => 'required|max:90',
            'email_group_id' => 'required|exists:email_groups,id',
            'status' => 'required|in:1,2'
        ]);
        $contact = EmailContact::whereNull('user_id')->where('id', $request->id)->firstOrFail();
        $contact->update($data);
        $notify[] = ['success', 'Email Contact has been updated'];
        return back()->withNotify($notify);
    }

    public function emailContactDelete(Request $request)
    {
        $contact = EmailContact::whereNull('user_id')->where('id', $request->id)->firstOrFail();
        $contact->delete();
        $notify[] = ['success', 'Email Contact has been deleted'];
        return back()->withNotify($notify);
    }


    public function emailContactImport(Request $request)
    {
        // dd($request->file);
        $request->validate([
            'email_group_id' => 'required|exists:email_groups,id',
            'file'=> 'required|mimes:xlsx'
        ]);
        $groupId = $request->email_group_id;
        $status = true;
        Excel::import(new EmailContactImport($groupId, $status), $request->file);
        $notify[] = ['success', 'Contact data has been imported'];
        return back()->withNotify($notify);
    }

    public function emailContactExport()
    {
        $status = true;
        return Excel::download(new EmailContactExport($status), 'email_contact.xlsx');
    }

    public function smsContactIndex()
    {
        $title = "Manage sms contact list";
        $groups = Group::whereNull('user_id')->get();
        $contacts = Contact::whereNull('user_id')->with('group')->paginate(paginateNumber());
        return view('admin.phone_book.own_sms_contact', compact('title', 'contacts', 'groups'));
    }

    public function smsContactStore(Request $request)
    {
        $data = $request->validate([
            'contact_no' => 'required|max:50',
            'name' => 'required|max:90',
            'group_id' => 'required|exists:groups,id',
            'status' => 'required|in:1,2'
        ]);
        $general = GeneralSetting::first();
        $data['contact_no'] = $data['contact_no'];
        Contact::create($data);
        $notify[] = ['success', 'SMS contact has been created'];
        return back()->withNotify($notify);
    }

    public function smsContactUpdate(Request $request)
    {
        $data = $request->validate([
            'contact_no' => 'required|max:50',
            'name' => 'required|max:90',
            'group_id' => 'required|exists:groups,id',
            'status' => 'required|in:1,2'
        ]);
        $contact = Contact::whereNull('user_id')->where('id', $request->id)->firstOrFail();
        $contact->update($data);
        $notify[] = ['success', 'SMS contact has been updated'];
        return back()->withNotify($notify);
    }

    public function smsContactDelete(Request $request)
    {
        $contact = Contact::whereNull('user_id')->where('id', $request->id)->firstOrFail();
        $contact->delete();
        $notify[] = ['success', 'SMS contact has been deleted'];
        return back()->withNotify($notify);
    }


    public function smsContactImport(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'file'=> 'required|mimes:xlsx'
        ]);
        $groupId = $request->group_id;
        $status = true;
        Excel::import(new ContactImport($groupId, $status), $request->file);
        $notify[] = ['success', 'Contact data has been imported'];
        return back()->withNotify($notify);
    }

    public function smsContactExport()
    {
        $status = true;
        return Excel::download(new ContactExport($status), 'sms_contact.xlsx');
    }
}
