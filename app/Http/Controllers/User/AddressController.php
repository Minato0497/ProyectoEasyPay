<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Address;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $countries=Country::all()->sortBy('country');
        return view('User.profile-address-create', compact('countries'));
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
            'name'=>'required',
            'addressPrimary'=>'required',
            'postal_code'=>'required',
            'city'=>'required',
            'state'=>'required',
            'country_id'=>'required',
        ]);
        $address_new=Address::create($request->all());
        User::where('id', Auth::user()->id)->update(['address_id'=>$address_new->id]);
        return redirect()->route('profile.show', Auth::user()->id)->with('info', 'Direccion añadida');
    }

    public function edit(Address $address)
    {
        $countries=Country::all();
        return view('User.profile-address-edit', compact('address', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Address $address)
    {
        $request->validate([
            'name'=>'required',
            'addressPrimary'=>'required',
            'postal_code'=>'required',
            'city'=>'required',
            'state'=>'required',
            'country_id'=>'required',
        ]);
        $address->update($request->all());
        $address->save();
        return redirect()->route('profile.show', Auth::user()->id)->with('info', 'Direccion actualizada');
    }
}