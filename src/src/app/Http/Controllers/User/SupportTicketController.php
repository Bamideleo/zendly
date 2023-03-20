<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\SupportMessage;
use App\Models\SupportFile;
use Carbon\Carbon;


class SupportTicketController extends Controller
{
    public function index()
    {
        $title = "Support Ticket";
        $user = auth()->user();
        $tickets = SupportTicket::where('user_id', $user->id)->latest()->paginate(paginateNumber());
        return view('user.support.index', compact('title', 'tickets'));
    }

    public function create()
    {
        $title = "Create new ticket";
        return view('user.support.create', compact('title'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'subject' => 'required|max:255',
            'priority' => 'required|in:1,2,3',
            'message' => 'required',
        ]);
        $user = auth()->user();
        $supportTicket = new SupportTicket();
        $supportTicket->ticket_number = randomNumber();
        $supportTicket->user_id = $user->id;
        $supportTicket->name = @$user->user;
        $supportTicket->subject = $request->subject;
        $supportTicket->priority = $request->priority;
        $supportTicket->status = 1;
        $supportTicket->save();

        $message = new SupportMessage();
        $message->support_ticket_id = $supportTicket->id;
        $message->admin_id = null;
        $message->message = $request->message;
        $message->save();

        if($request->hasFile('file')) {
            foreach ($request->file('file') as $file) {
                try {
                    $supportFile = new SupportFile();
                    $supportFile->support_message_id = $message->id;
                    $supportFile->file = uploadNewFile($file, filePath()['ticket']['path']);
                    $supportFile->save();
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Could not upload your ' . $file];
                    return back()->withNotify($notify);
                }
            }
        }
        $notify[] = ['success', "Support ticket has been created"];
        return redirect()->route('user.ticket.index')->withNotify($notify);
    }

    public function detail($id)
    {
        $title = "Ticket Reply";
        $user = auth()->user();
        $ticket = SupportTicket::where('user_id', $user->id)->where('id', $id)->firstOrFail();
        return view('user.support.detail', compact('title', 'ticket'));
    }

    public function ticketReply(Request $request, $id)
    {
        $user = auth()->user();
        $supportTicket = SupportTicket::where('user_id', $user->id)->where('id', $id)->firstOrFail();
        $supportTicket->status = 3;
        $supportTicket->save();

        $message = new SupportMessage();
        $message->support_ticket_id = $supportTicket->id;
        $message->admin_id = null;
        $message->message = $request->message;
        $message->save();
        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $file) {
                try {
                    $supportFile = new SupportFile();
                    $supportFile->support_message_id = $message->id;
                    $supportFile->file = uploadNewFile($file, filePath()['ticket']['path']);
                    $supportFile->save();
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Could not upload your ' . $file];
                    return back()->withNotify($notify);
                }
            }
        }
        $notify[] = ['success', "Support ticket replied successfully"];
        return back()->withNotify($notify);
    }

    public function closedTicket($id)
    {
        $user = auth()->user();
        $supportTicket =  SupportTicket::where('user_id', $user->id)->where('id', $id)->firstOrFail();
        $supportTicket->status = 4;
        $supportTicket->save();
        $notify[] = ['success', "Support ticket has been closed"];
        return back()->withNotify($notify);
    }

    public function supportTicketDownlode($id)
    {
        $supportFile = SupportFile::findOrFail(decrypt($id));
        $file = $supportFile->file;
        $path = filePath()['ticket']['path'].'/'.$file;
        $title = slug('file').'-'.$file;
        $mimetype = mime_content_type($path);
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($path);
    }
}
