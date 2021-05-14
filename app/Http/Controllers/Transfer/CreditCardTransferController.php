<?php

namespace App\Http\Controllers\Transfer;

use App\Models\User;
use App\Events\Envios;
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
        return view('Envios.EnviosBasicos');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $email_envia = Auth::user()->email;
        return view('Envios.EnviosBasicos', compact('email_envia'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $envia_id=Auth::user()->id;
        $email_envia=Auth::user()->email;
        $request->validate(['correo'=>'required','monto'=>'required']);
        $monto=$request->input('monto');
        $email_recibe=$request->input('correo');
        $datos_envio=[$email_envia,$email_recibe,$monto,$envia_id];
        DB::beginTransaction();
        try {
            User::where('email', $email_envia)->decrement('monedero', $monto);
            User::where('email', $email_recibe)->increment('monedero', $monto);
            Envios::dispatch($datos_envio);
            DB::commit();
            return redirect()->route('home')->with('info', 'Envio realizado');
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        /*$email_envia = Auth::user()->email;
        return view('Envios.EnviosBasicos', compact('email_envia'));*/
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
        /*$email_envia=Auth::user()->email;
        $request->validate(['correo'=>'required','monto'=>'required']);
        $monto=$request->input('monto');
        $email_recibe=$request->input('correo');
        DB::beginTransaction();
        try {
            User::where('email', $email_envia)->decrement('monedero', $monto);
            User::where('email', $email_recibe)->increment('monedero', $monto);
            DB::commit();
            return redirect()->route('home')->with('info', 'Envio realizado');
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
