<?php

namespace App\Http\Controllers\User;

use App\Models\CreditCard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CreditCardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //$creditCards = CreditCard::where('codUser', Auth::user()->id)->get();
        return view('creditcard.index');
    }

    public function create()
    {
        return view('user.profiles-creditcard-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'credit_card_type' => 'required',
            'credit_card_numbers' => 'required',
            'code' => 'required',
        ]);
        CreditCard::create([
            'name' => $request->input('name'),
            'credit_card_type' => $request->input('credit_card_type'),
            'credit_card_numbers' => $request->input('credit_card_numbers'),
            'credit_card_expiration_date' => $request->input('credit_card_expiration_date'),
            'code' => $request->input('code'),
            'codUser' => Auth::user()->id,
        ]);
        return redirect()->route('profile.show', Auth::user()->id)->with('info', 'Tarjeta añadida');
    }
    public function edit(CreditCard $creditCard)
    {
        return view('user.profiles-creditcard-edit', compact('creditCard'));
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
        $request->validate([
            'name' => 'required',
            'credit_card_type' => 'required',
            'credit_card_numbers' => 'required',
            'code' => 'required',
        ]);
        $creditCard->update($request->all());
        $creditCard->save();
        return redirect()->route('profile.show', Auth::user()->id)->with('info', 'dirección actualizada');
    }

    public function destroy(CreditCard $creditCard)
    {
        $creditCard->delete();
        return redirect()->route('profile.show', Auth::user()->id)->with('info', 'Tarjeta eliminada');
    }
}
