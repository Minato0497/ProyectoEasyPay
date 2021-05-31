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
        $envia_id = Auth::user()->id;
        $email_envia = Auth::user()->email;
        $request->validate(['correo' => 'required', 'monto' => 'required']);
        $monto = $request->input('monto');
        $email_recibe = $request->input('correo');

        $datos_envio = [$email_envia, $email_recibe, $monto, $envia_id];
        //dd($datos_envio);

        DB::beginTransaction();
        try {
            User::where('email', $email_recibe)->increment('monedero', $monto);
            User::where('email', $email_envia)->decrement('monedero', $monto);
            Envios::dispatch($datos_envio);
            DB::commit();
            return redirect()->route('home')->with('info', 'Envio realizado');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('envioBasico.create')->with('info', $e->getMessage());
        }
    }
}
