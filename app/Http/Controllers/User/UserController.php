<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Address;
use App\Models\CreditCard;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
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
        $users = User::all();
        return view('user.user-list', compact('users'));
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
    public function store()
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
            'id' => 'present',
            'email' => [
                'required',
                Rule::unique('users')->ignore(request()->id, 'id')
            ],
            'name' => 'required',
            'phoneNumber' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'validation_error' => $validator->errors()->toArray()]);
        } else {
            try {

                DB::beginTransaction();
                // dd(request()->all());
                $data = $validator->validated();
                $model = User::updateOrCreate(['id' => $data['id']], $data);
                if (request()->hasFile('profile')) {
                    $model->addMediaFromRequest('profile')
                        ->toMediaCollection('profile', 'media');
                }
                // $cancel_store_trait = in_array(CancelStoring::class, class_uses(new User));
                //El trait deshabilita la edición
                /* if ($cancel_store_trait == true) {
                    DB::rollback();
                    return response()->json(['cancel_store_trait_error' => 'This external module has disabled any changes']);
                }
                //updateOrCreate hace un update
                else */
                if (!$model->wasRecentlyCreated && $model->wasChanged()) {
                    DB::commit();
                    $response = 'User updated successfully';
                }
                //updateOrCreate hace update sin realizar cambios
                elseif (!$model->wasRecentlyCreated && !$model->wasChanged()) {
                    DB::commit();
                    $response = 'User not changed';
                }
                //updateOrCreate hace create
                elseif ($model->wasRecentlyCreated) {
                    DB::commit();
                    $response = 'User created successfully';
                }
                return response()->json(['submit_store_success' => $response]);
            } catch (\Exception $myException) {
                DB::rollback();
                // throw new StoreErrorException('store','panel-fleet-brand-store', json_encode($data), $myException);
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
        // $id = Auth::user()->id;
        $current_user = User::find($id);
        // dd(auth()->user()->adminlte_image());
        // $credit_cards_user = CreditCard::where('codUser', $id)->get();
        // $address_user = Address::where('codUser', $id)->get();
        //dd(auth()->user()->credit_card->credit_card_numbers);
        return view('User.profile-show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $user = Auth::user();
        return view('user.profiles-edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate(['name' => 'required']);
        $user->update($request->all());
        return redirect()->route('profile.show', Auth::user()->id)->with('info', 'Usuario actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('login');
    }
}
