<?php

namespace App\Http\Controllers\Admin;

use App\Models\Movement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class MovementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usersEmisor = Movement::distinct()->with('has_emisor', 'has_receptor')->select('codEmisor')->get(); //el distinct lo hace sobre lo que indicas en el get
        $usersReceptor = Movement::distinct()->with('has_emisor', 'has_receptor')->select('codReceptor')->get(); //el distinct lo hace sobre lo que indicas en el get
        $users = User::all();
        // $movements = auth()->user()->has_movements;
        // dd($movements);
        // dd(auth()->user()->movements);

        // dd($usersReceptor);
        return view('admin.movements.index', compact('users'));
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
        //
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
        if (request()->ajax()) {
            return DataTables::of(Movement::orderBy('date_movement', 'DESC')->select())
                ->addIndexColumn()
                ->addColumn('operation_type', function ($model) {
                    return $model->has_operation_type->operation_type;
                })
                ->addColumn('emisor', function ($model) {
                    return $model->has_emisor->email;
                })
                ->addColumn('receptor', function ($model) {
                    $return = $model->has_receptor?->email;
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
    }
}
