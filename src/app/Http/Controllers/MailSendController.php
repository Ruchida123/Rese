<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendNoticeMail;

class MailSendController extends Controller
{
    public function send(Request $request){
        $admin = [
            "email" => $request->admin_email,
            "name" => $request->admin_name,
        ];

        $user = [
            "email" => $request->user_email,
            "name" => $request->user_name,
        ];

        Mail::send(new SendNoticeMail($admin, $user));
    }
}
