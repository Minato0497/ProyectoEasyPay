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
        // dd($usersReceptor);
        return view('user.movements.index', compact('usersEmisor', 'usersReceptor'));
    }

    /* public function show($id)
    {
        # code...
    } */

    public function getMovementDatatable()
    {
        if (auth()->user()->getRoleNames()->first() == 'admin') {
            $models = Movement::select();
        } else {
            $models = Movement::where('codEmisor', auth()->user()->id)->select();
        }
        // if (request()->ajax()) {
        return DataTables::of($models->orderBy('date_movement', 'DESC'))
            ->addIndexColumn()
            ->addColumn('operation_type', function ($model) {
                return $model->has_operation_type->operation_type;
            })
            ->addColumn('emisor', function ($model) {
                return $model->has_emisor->email;
            })
            ->addColumn('receptor', function ($model) {

                if ($model->has_receptor->getRoleNames()->first() == 'admin') {
                    $return = 'Admin';
                } elseif (auth()->user()->getRoleNames()->first() == 'admin') {
                    $return = $model->has_receptor->email;
                } else {
                    $return = $model->has_receptor->email;
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
            ->make(true);
    }
    // }
}
