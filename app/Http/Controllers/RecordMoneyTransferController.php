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
        $regiter_transfer_user = RecordMoneyTransfer::all();
        dd($regiter_transfer_user);
        return view('Envios.register', compact('regiter_transfer_user'));
    }

    public function show($id)
    {
        //$cuerrent_user=$id->id;
        $regiter_transfer_user = RecordMoneyTransfer::where('envia_id', Auth::user()->id)->get();
        //$regiter_transfer_user = User::find(Auth::user()->id);
        //dd($regiter_transfer_user);
        return view('Envios.register', compact('regiter_transfer_user'));
    }
}
