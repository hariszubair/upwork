<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;
use Mail;
use Illuminate\Support\Str;
use PHPUnit\TextUI\XmlConfiguration\IniSetting;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function invitation()
    {
        return view('send_invitation');
    }
    public function send_invitation(Request $request)
    {
        $uid = Str::uuid();
        $link =  URL('/invitation_link/' . $uid);
        $this->validate($request, [
            'email' => 'unique:invitations,email',
        ]);
        Invitation::create([
            'email' => $request->email,
            'invitation_token' => $uid
        ]);
        Mail::send('mail_template', ['link' => $link], function ($message) use ($request) {
            $message->to($request->email, 'Dear Member')->subject('Invitation to signup');
            $message->from('harissaib@gmail.com', 'Haris Zubair');
        });
        return redirect()->back()->with('success', 'Invitation sent successfully');
    }
}
