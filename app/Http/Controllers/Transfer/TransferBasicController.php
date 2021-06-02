<?php

namespace App\Http\Controllers\Transfer;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Events\Envios;

class TransferBasicController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        //$email_envia = Auth::user()->email;
        return view('Envios.EnviosBasicos');
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
        $request->validate(['correo' => 'required', 'monto' => 'required']);
        $monto = $request->input('monto');
        $email_recibe = $request->input('correo');
        $saldo = Auth::user()->monedero;
        $datos_envio = [$email_envia, $email_recibe, $monto, $envia_id];
        //dd($datos_envio);
        //$user = User::find(Auth::user()->id);
        DB::beginTransaction();
        try {
            if ($email_recibe == Auth::user()->email) {
                return back()->with('error', 'No se puede enviar dinero a uno mismo');
            }
            if ($saldo < $monto) {
                return back()->with('error', 'Saldo insuficiente');
            }
            //$saldo = User::where('monedero', '>', $email_recibe)->get();
            User::where('email', $email_recibe)->firstOrFail()->increment('monedero', $monto);
            User::where('email', $email_envia)->decrement('monedero', $monto);
            Envios::dispatch($datos_envio);
            DB::commit();
            return redirect()->route('home')->with('info', 'Envio realizado -' . $monto);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Usuario no encontrado');
        }
    }
}
