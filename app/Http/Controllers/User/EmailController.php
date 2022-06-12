<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EmailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit($id)
    {
        $user_email = Auth::user()->email;
        return view('user.profiles-email-edit', compact('user_email'));
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
        $request->validate(['emailNew' => 'required']);
        $user = User::find(Auth::user()->id);
        $user->email = $request->input('emailNew');
        $user->save();
        return redirect()->route('profile.show', Auth::user()->id)->with('info', 'Correo actualizado');
    }
}
