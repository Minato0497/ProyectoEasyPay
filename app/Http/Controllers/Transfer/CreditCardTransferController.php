<?php

namespace App\Http\Controllers\Transfer;

use App\Models\User;
use App\Events\Envios;
use App\Models\CreditCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CreditCardTransferController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$creditCards = CreditCard::where('id', Auth::user()->id)->get();
        return view('creditcard.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CreditCard $creditCard)
    {
        return view('creditcard.transferMoney', compact('creditCard'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CreditCard $creditCard)
    {
        if ($request->monto < 0) {
            return back()->with('error', 'No se puede transferir cantidades negativas');
        }
        $id = Auth::user()->id;
        if ($request->cuenta == 'savings_account') {
            if ($creditCard->saving_account < $request->monto) {
                return back()->with('error', 'Saldo insufuciente');
            }
            $request->validate([
                'monto' => 'required'
            ]);
            DB::beginTransaction();
            try {
                CreditCard::where('id', $creditCard->id)->decrement('savings_account', $request->monto);
                User::where('id', $id)->increment('monedero', $request->monto);
                DB::commit();
                return redirect()->route('home')->with('info', 'Transferencia al monedero realizada +' . $request->monto);
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with('error', 'Transferencia al monedero no se pudo realizar');
            }
        } elseif ($request->cuenta == 'current_account') {
            if ($creditCard->current_account < $request->monto) {
                return back()->with('error', 'Saldo insufuciente');
            }
            $request->validate([
                'monto' => 'required',
            ]);
            DB::beginTransaction();
            try {
                CreditCard::where('id', $creditCard->id)->decrement('current_account', $request->monto);
                User::where('id', $id)->increment('monedero', $request->monto);
                DB::commit();
                return redirect()->route('home')->with('info', 'Transferencia al monedero realizada +' . $request->monto);
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with('error', 'Transferencia al monedero no se pudo realizar');
            }
        } else {
            return  back()->with('error', 'No se pudo realizar la transferencia');
        }
    }
}
