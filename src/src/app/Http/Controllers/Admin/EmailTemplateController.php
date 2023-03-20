<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailTemplates;

class EmailTemplateController extends Controller
{
    public function index()
    {
        $title = "Manage mail template";
        $emailTemplates = EmailTemplates::latest()->paginate(paginateNumber());
        return view('admin.email_template.index', compact('title', 'emailTemplates'));
    }

    public function edit($id)
    {
        $title = "Mail template update";
        $emailTemplate = EmailTemplates::findOrFail($id);
        return view('admin.email_template.edit', compact('title', 'emailTemplate'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'subject' => 'required|max:255',
            'status'  => 'required|in:1,2',
            'body' => 'required'
        ]);
        $emailTemplate = EmailTemplates::findOrFail($id);
        $emailTemplate->subject = $request->subject;
        $emailTemplate->status = $request->status;
        $emailTemplate->body = $request->body;
        $emailTemplate->save();
        $notify[] = ['success', 'Email template has been updated'];
        return back()->withNotify($notify);
    }
}
