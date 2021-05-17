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
        $creditCards = CreditCard::where('user_id', Auth::user()->id)->get();
        return view('creditcard.index', compact('creditCards'));
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
        $id = Auth::user()->id;
        if ($request->cuenta == 'savings_account') {
            $request->validate([
                'monto' => 'required'
            ]);
            DB::beginTransaction();
            try {
                CreditCard::where('id', $creditCard->id)->decrement('savings_account', $request->monto);
                User::where('id', $id)->increment('monedero', $request->monto);
                DB::commit();
                return redirect()->route('home')->with('info', 'Transferencia al monedero realizada realizado');
            } catch (\Exception $e) {
                DB::rollBack();
                return $e->getMessage();
            }
        } elseif ($request->cuenta == 'current_account') {
            $request->validate([
                'monto' => 'required',
            ]);
            DB::beginTransaction();
            try {
                CreditCard::where('id', $creditCard->id)->decrement('current_account', $request->monto);
                User::where('id', $id)->increment('monedero', $request->monto);
                DB::commit();
                return redirect()->route('home')->with('info', 'Transferencia al monedero realizada realizado');
            } catch (\Exception $e) {
                DB::rollBack();
                return $e->getMessage();
            }
        } else {
            return redirect()->route('home')->with('info', 'No se pudo realizar la transferencia');
        }
    }
}
