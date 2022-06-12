<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\User;
use App\Events\Envios;
use App\Models\Movement;
use Illuminate\Http\Request;
use App\Models\OperationType;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RetireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('movement.retirar');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        // dd(request()->all());

        $validator = Validator::make(request()->all(), [
            'id' => 'required',
            'amount' => [
                'required',
            ],
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'validation_error' => $validator->errors()->toArray()]);
        } else {
            try {
                DB::beginTransaction();
                // dd(request()->all());
                $data = $validator->validated();
                $model = User::find($data['id']);
                if ($model->monedero < $data['amount']) {
                    $response = 'Saldo insuficiente';
                    return response()->json(['submit_store_error' => $response]);
                }
                $codEmisor = auth()->user()->id;
                $codReceptor = auth()->user()->id;
                $codOperationType = OperationType::where('operation_type', 'retiro')->first()->codOperationType;
                $datos_envio = [$codOperationType, $codEmisor, $codReceptor, $data['amount'], 1];
                Envios::dispatch($datos_envio);
                $model->decrement('monedero', $data['amount']);
                $response = 'Retire created successfully';
                DB::commit();
                return response()->json(['submit_store_success' => $response, 'monedero' => $model->monedero]);
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
