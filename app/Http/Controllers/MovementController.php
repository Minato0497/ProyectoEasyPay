<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class MovementController extends Controller
{
    public function __construct()
    {
        // $this->middleware('can:admin.admin.index')->only('index');
    }

    public function index()
    {
        $usersEmisor = Movement::distinct()->with('has_emisor', 'has_receptor')->select('codEmisor')->get(); //el distinct lo hace sobre lo que indicas en el get
        $usersReceptor = Movement::distinct()->with('has_emisor', 'has_receptor')->select('codReceptor')->get(); //el distinct lo hace sobre lo que indicas en el get
        $movements = auth()->user()->has_movements;
        // dd($movements);
        // dd(auth()->user()->movements);

        // dd($usersReceptor);
        return view('user.movements.index', compact('usersEmisor', 'usersReceptor', 'movements'));
    }

    /* public function show($id)
    {
        # code...
    } */

    public function getMovementDatatable()
    {
        if (auth()->user()->getRoleNames()->first() == 'admin') {
            $models = Movement::orderBy('date_movement', 'DESC')->select();
        } else {
            $models = auth()->user()->has_movements;
        }
        // if (request()->ajax()) {
        return DataTables::of($models)
            ->addIndexColumn()
            ->addColumn('operation_type', function ($model) {
                return $model->has_operation_type->operation_type;
            })
            ->addColumn('emisor', function ($model) {
                return $model->has_emisor->email;
            })
            ->addColumn('receptor', function ($model) {
                if (auth()->user()->getRoleNames()->first() != 'admin') {
                    if ($model->codOperationType == 1) {
                        $return = 'Ingreso';
                    } elseif ($model->codOperationType == 2) {
                        $return = 'Retiro';
                    } elseif ($model->codOperationType == 3) {
                        $return = $model->has_receptor->email;
                    }
                } else {
                    $return = $model->has_receptor?->email;
                }
                return $return;
            })
            ->editColumn('amount', function ($model) {
                return $model->amount . '€';
            })
            ->filter(
                function ($query) {
                    if (request()->has('filter_emisor')) {
                        if (request()->filter_emisor != "xxx") {
                            $query->where('codEmisor', request()->filter_emisor);
                        }
                    }
                    if (request()->has('filter_receptor')) {
                        if (request()->filter_receptor != "xxx") {
                            $query->where('codReceptor', request()->filter_receptor);
                        }
                    }
                },
                true
            )
            ->editColumn('success', function ($model) {
                return $model->success ? 'Sí' : 'No';
            })
            ->make(true);
    }
    // }
}
