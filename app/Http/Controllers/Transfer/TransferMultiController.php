<?php

namespace App\Http\Controllers\Transfer;

use App\Models\User;
use App\Events\Envios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TransferMultiController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Envios.Envios-lote');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->monto < 0) {
            return back()->with('error', 'No se puede transferir cantidades negativas');
        }

        $envia_id = Auth::user()->id;
        $email_envia = Auth::user()->email;
        $request->validate(['email' => 'required', 'monto' => 'required']);
        $correos = $request->email;
        $saldo = Auth::user()->monedero;
        $datos_envio = [$email_envia, $request->email, $request->monto, $envia_id];

        $cantidad_dec = $request->monto * count($correos);
        //dd($cantidad_dec);
        DB::beginTransaction();
        try {
            if ($saldo < $cantidad_dec) {
                return back()->with('error', 'Saldo insuficiente');
            }
            foreach ($correos as $email) {
                if ($email == Auth::user()->email) {
                    return back()->with('error', 'No se puede enviar dinero a uno mismo');
                }
                $datos_envio = [$email_envia, $email, $request->monto, $envia_id];
                User::where('email', $email)->firstOrFail()->increment('monedero', $request->monto);
                Envios::dispatch($datos_envio);
            }
            User::where('email', $email_envia)->decrement('monedero', $cantidad_dec);
            DB::commit();
            return redirect()->route('home')->with('info', 'Envios realizado -' . $cantidad_dec);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Usuario no encontrado');
        }
        //dd($request->email);
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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