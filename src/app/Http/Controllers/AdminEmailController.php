<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\SendEmailJob;

class AdminEmailController extends Controller
{
    public function showEmailForm()
    {
        return view('admin.admin_email');
    }

    public function sendEmail(Request $request)
    {
        $validatedData = $request->validate([
            'subject' => 'required|max:255',
            'message' => 'required',
        ], [
            'subject.required' => '件名を入力してください。',
            'subject.max' => '件名は255文字以内で入力してください。',
            'message.required' => 'メッセージを入力してください。',
        ]);

        $subject = $validatedData['subject'];
        $message = $validatedData['message'];

        SendEmailJob::dispatch($subject, $message);

        return redirect()->back()->with('success', 'Email sent successfully');
    }
}
