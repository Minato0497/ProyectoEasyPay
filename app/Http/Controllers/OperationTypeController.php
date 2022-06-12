<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OperationType;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class OperationTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.operationTypes.destroy')->only('destroy');
        $this->middleware('can:admin.operationTypes.edit')->only('edit', 'store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.operation.operation');
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
            'codOperationType' => 'nullable',
            'operation_type' => [
                'required',
                Rule::unique('operation_types')->ignore(request()->codOperationType, 'codOperationType')
            ],
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'validation_error' => $validator->errors()->toArray()]);
        } else {
            try {
                DB::beginTransaction();

                $data = $validator->validated();
                $model = OperationType::updateOrCreate(['codOperationType' => $data['codOperationType']], $data);
                if (!$model->wasRecentlyCreated && $model->wasChanged()) {
                    $response = 'OperationType updated successfully';
                    DB::commit();
                }
                //updateOrCreate hace update sin realizar cambios
                elseif (!$model->wasRecentlyCreated && !$model->wasChanged()) {
                    $response = 'OperationType not changed';
                    DB::commit();
                }
                //updateOrCreate hace create
                elseif ($model->wasRecentlyCreated) {
                    $response = 'OperationType created successfully';
                    DB::commit();
                }
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
        if (request()->ajax()) {
            return response()->json(OperationType::find($id));
        }
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
        try {
            OperationType::findOrFail($id)->delete();
            return response()->json(['submit_delete_success' => 'OperationType deleted successfully.']);
        } catch (\Exception $myException) {
            DB::rollback();
        }
    }

    public function getOperationTypeDatatable()
    {
        $canEdit = auth()->user()->can('admin.operationTypes.edit');
        $canDelete = auth()->user()->can('admin.operationTypes.destroy');
        if (request()->ajax()) {
            return DataTables::of(OperationType::select())
                ->addIndexColumn()
                ->addColumn('Actions', function ($data) use ($canEdit, $canDelete) {
                    $btn = '';
                    if ($canEdit) {
                        $btn = '<a href="javascript:void(0)" data-codoperationtype="' . $data->codOperationType . '" class="edit btn btn-primary btn-sm edit"><i class="fas fa-edit"></i></a>';
                    }
                    if ($canDelete) {
                        $btn .= '<a href="javascript:void(0)" data-codoperationtype="' . $data->codOperationType . '"  class="btn btn-danger btn-sm delete"><i class="fas fa-minus-square"></i></a>';
                    }
                    return $btn;
                })
                ->rawColumns(['Actions'])
                ->make(true);
        }
    }
}
