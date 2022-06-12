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
use PHPUnit\Framework\Constraint\Operator;

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
            'email' => [
                'required',
                // 'exists:users,email',
                function ($attribute, $value, $onFailure) {
                    foreach ($value as $email) {
                        if (auth()->user()->email == $email) {
                            $onFailure('No se puede enviar dinero a uno mismo.');
                        }
                    }
                },
                function ($attribute, $value, $onFailure) {
                    $count = 0;
                    foreach ($value as $email) {
                        $count++;
                        if (!User::where('email', $email)->first()) {
                            $onFailure('El usuario ' . $count . ' no se encuentra.');
                        }
                    }
                }
            ],
            'amount' => [
                'required',
                'numeric',
                'gt:0',
                function ($attribute, $value, $onFailure) use ($request) {
                    // $user = User::where('email', $value)->first();
                    $cantidad = count($request->email);
                    $amount = $value * $cantidad;
                    if (auth()->user()->monedero < $amount) {
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
                $cantidad = count($data['email']);
                $amount = $data['amount'] * $cantidad;
                User::updateOrCreate(['id' => $data['id']], [
                    'monedero' => auth()->user()->monedero - $amount
                ]);
                $envio = null;
                $codOperationType = OperationType::where('operation_type', 'transferencia')->first()->codOperationType;
                $codEmisor = auth()->user()->id;
                foreach ($data['email'] as $email) {
                    $envio = User::where('email', $email)->firstOrFail()->increment('monedero', $data['amount']);
                    $codReceptor = User::where('email', $email)->first()->id;
                    $datos_envio = [$codOperationType, $codEmisor, $codReceptor, $data['amount']];
                    if ($envio) {
                        Envios::dispatch($datos_envio);
                    } else {
                        break;
                        DB::rollback();
                    }
                }
                DB::commit();
                return response()->json(['submit_store_success' => 'Envio realizado -' . $amount]);
            } catch (\Exception $myException) {
                DB::rollback();
            }
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
