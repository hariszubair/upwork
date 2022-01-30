<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\User;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PHPUnit\TextUI\XmlConfiguration\IniSetting;
use Mail;

class InvitationController extends Controller
{
    public function invitation_link($token)
    {
        $invitation = Invitation::where('invitation_token', $token)->first();
        return view('sign_up', compact('invitation'));
    }
    public function send_pin(Request $request)
    {
        $random_number = rand(100000, 999999);
        $invitation = Invitation::where('invitation_token', $request->invitation_token)->first();
        if (!$invitation) {
            return response()->json(['error' => 'Something went wrong'], 404);
        } else {
            Mail::send('mail_pin_template', ['rand' => $random_number], function ($message) use ($invitation) {
                $message->to($invitation->email, 'Dear Member')->subject('Pin code for verification');
                $message->from('harissaib@gmail.com', 'Haris Zubair');
            });
            $invitation->pin = $random_number;
            $invitation->save();
            return response()->json(['success' => 'Pin sent'], 200);
        }
    }
    public function sign_up(Request $request)
    {

        $this->validate($request, [
            'email' => 'unique:users,email',
            'user_name' => ['unique:users,user_name|max:20|min:4', 'regex:/^\S*$/u'],
            'pin' => 'required|max:6|min:6',
            'password' => 'required|max:20|min:8|confirmed'
        ]);
        $invitation = Invitation::where('email', $request->email)->where('pin', $request->pin)->first();
        if (!$invitation) {
            return redirect()->back()->with('error', 'Incorrect Pin code')->withInput($request->input());
        } else {
            User::create([
                'email' => $invitation->email,
                'password' => Hash::make($request->password),
                'user_name' => $request->user_name,
                'user_role' => 'user',
            ]);
            return redirect('/home');
        }
    }
}
