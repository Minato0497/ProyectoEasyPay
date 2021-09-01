<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RecordMoneyTransfer;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RecordMoneyTransferController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $register = RecordMoneyTransfer::all();
        return view('Envios.register', compact('register'));
    }

    public function show($id)
    {
        //$cuerrent_user=$id->id;
        $cuerrent_user = Auth::user()->id;
        //$regiter_transfer_user = RecordMoneyTransfer::where('envia_id', $cuerrent_user)->get();
        $regiter_transfer_user = User::find($cuerrent_user);
        //dd($regiter_transfer_user->email_envia);
        return view('Envios.register', compact('regiter_transfer_user'));
    }
}
