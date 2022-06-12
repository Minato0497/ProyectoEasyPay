<?php

namespace App\Http\Controllers\Transfer;

use App\Models\User;
use App\Events\Envios;
use Illuminate\Http\Request;
use App\Models\OperationType;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        /*
        1º validar
        2º transaction
        3º crear auxiliares
        4º updateOrCreate
        */

        //Debo validar TODOS los campos que luego vaya a insertar o editar
        //Si intento insertar con request()->all me va a meter CSRF's y demás mierdas

        $validator = Validator::make(request()->all(), [
            'id' => 'required',
            'correo' => [
                'required',
                'exists:users,email',
                function ($attribute, $value, $onFailure) {
                    // $user = User::where('email', $value)->first();
                    if (auth()->user()->email == $value) {
                        $onFailure('No se puede enviar dinero a uno mismo');
                    }
                }
            ],
            'amount' => [
                'required',
                'numeric',
                'gt:0',
                function ($attribute, $value, $onFailure) {
                    // $user = User::where('email', $value)->first();
                    if (auth()->user()->monedero < $value) {
                        $onFailure('Saldo insuficiente');
                    }
                }
            ],
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'validation_error' => $validator->errors()->toArray()]);
        } else {
            try {

                DB::beginTransaction();

                $data = $validator->validated();
                User::updateOrCreate(['id' => $data['id']], [
                    'monedero' => auth()->user()->monedero - $data['amount']
                ]);
                $envio = null;
                $envio = User::where('email', $data['correo'])->firstOrFail()->increment('monedero', $data['amount']);
                $codOperationType = OperationType::where('operation_type', 'transferencia')->first()->codOperationType;
                $codEmisor = auth()->user()->id;
                $codReceptor = User::where('email', $data['correo'])->first()->id;
                $datos_envio = [$codOperationType, $codEmisor, $codReceptor, $data['amount']];
                if (!$envio) {
                    DB::rollback();
                }
                Envios::dispatch($datos_envio);
                DB::commit();
                return response()->json(['submit_store_success' => 'Envio realizado -' . $data['amount']]);
            } catch (\Exception $myException) {
                DB::rollback();
            }
        }
    }
}
