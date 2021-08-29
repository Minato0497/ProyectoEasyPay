<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PhoneController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit(User $user)
    {
        $user_phone = $user->phoneNumber;
        return view('User.profile-phone-edit', compact('user_phone'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate(['phoneNumberNew' => 'required']);
        $user = User::find(Auth::user()->id);
        $user->phoneNumber = $request->input('phoneNumberNew');
        $user->save();
        return redirect()->route('profile.show', Auth::user()->id)->with('info', 'Móvil actualizado');
    }
}
