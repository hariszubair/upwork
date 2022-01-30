<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function profile_update(Request $request)
    {
        $validatedData = $request->validate([
            'avatar_image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'name' => 'required'
        ]);
        $user = Auth::user();
        $imageName = time() . '_' . $user->id . '.' . $request->avatar_image->extension();

        $request->avatar_image->move(public_path('avatar_image'), $imageName);
        User::where('id', $user->id)->update(
            [
                'avatar' => public_path('avatar_image/') . $imageName,
                'name' => $request->name
            ]
        );
        return redirect('/home');
    }
}
