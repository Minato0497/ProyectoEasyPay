<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Movement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class IngressController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:admin.ingress.destroy')->only('destroy');
        $this->middleware('can:admin.ingress.edit')->only('edit', 'store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(auth()->user()->getRoleNames()->first());
        // Movement::with('has_emisor')->where('success', 0)->where('codOperationType', 1)->select()->get()->dd();
        return view('admin.ingress.index');
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

        $validator = Validator::make(request()->all(), [
            'codMovement' => 'required',
            // 'success' => 'boolean',
            // 'amount' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'validation_error' => $validator->errors()->toArray()]);
        } else {
            try {
                DB::beginTransaction();

                $data = $validator->validated();
                $model = Movement::find($data['codMovement']);
                User::find($model->codEmisor)->increment('monedero', $model->amount);
                $model->update(['success', 1]);
                $response = 'Ingress created successfully';
                DB::commit();
                return response()->json(['submit_store_success' => $response]);
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

    public function getMovementDatatable()
    {
        // $canEdit = auth()->user()->can('admin.ingress.edit');
        // $canDelete = auth()->user()->can('admin.ingress.destroy');
        if (request()->ajax()) {
            return DataTables::of(Movement::with('has_emisor', 'has_receptor')->where('codOperationType', 1)->select())
                ->addIndexColumn()
                ->addColumn('ingrees', function ($model) {
                    $btn = '';
                    if (!$model->success) {
                        $btn = '<a href="javascript:void(0)" data-codmovement="' . $model->codMovement . '" class="ingrees btn btn-success btn-sm ingrees"><i class="fas fa-check"></i></a>';
                    }

                    return $btn;
                })
                ->addColumn('emisor', function ($model) {
                    return $model->has_emisor->name;
                })
                ->addColumn('receptor', function ($model) {
                    return $model->has_receptor?->name;
                })
                ->editColumn('amount', function ($model) {
                    return $model->amount . '€';
                })
                ->editColumn('success', function ($model) {
                    $value = '';
                    if ($model->success) {
                        $value = 'Si';
                    } else {
                        $value = 'No';
                    }
                    return $value;
                })
                ->rawColumns(['ingrees'])
                ->make(true);
        }
    }

    public function ingreso($id)
    {
        try {
            DB::beginTransaction();
            // $data = $validator->validated();
            $model = Movement::find($id);
            User::find($model->codEmisor)->increment('monedero', $model->amount);
            $model->update([
                'success' => 1,
                'codReceptor' => auth()->user()->id
            ]);
            // dd($model);
            $response = 'Ingress created successfully';
            DB::commit();
            return response()->json(['submit_store_success' => $response]);
        } catch (\Exception $myException) {
            DB::rollback();
        }
    }
}
