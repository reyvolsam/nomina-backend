<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\CompanyUser;
use App\User;

class UserController extends Controller
{

    private $res = [];
    private $request;
    private static $generic_password = "Nomina2019";

    function __construct(Request $request)
    {
        $this->request = $request;
        $this->res['message'] = '';
        $this->res['data'] = [];
        $this->status_code = 204;

        date_default_timezone_set('America/Mexico_City');
    }//__construct()

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $user_list = [];

            $user_list = User::with('Group')->select('id', 'name', 'email', 'group_id', 'default_company_id')->jsonPaginate();

            if(count($user_list) > 0){

                foreach ($user_list as $kul => $vul) $vul->loader = false;

                $this->res['data'] = $user_list;
            } else {
                $this->res['message'] = 'No hay usuarios hasta el momento.';
            }

            $this->status_code = 200;
        } catch(\Exception $e) {
            $this->res['message'] = 'Error en la Base de Datos.'.$e;
            $this->status_code = 500;
        }
        return response()->json($this->res, $this->status_code);
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
        try{
            $validator = Validator::make($this->request->all(), [
                'name'              => 'required|max:255',
                'email'             => 'required|max:255|email',
                'group_id'          => 'required',
                'default_company_id' => 'required'
            ]);

            $id                     = $this->request->input('id');
            $data['name']           = $this->request->input('name');
            $data['email']          = $this->request->input('email');
            $data['group_id']       = $this->request->input('group_id');
            $data['company_id']     = $this->request->input('company_id');
            $data['default_company_id'] = $this->request->input('default_company_id');
            $data['active']         = $this->request->input('active');

            if(!$validator->fails()) {
                $user = User::where('email', '=', $data['email'])->get();

                if(count($user) == 0){
                    $user = User::withTrashed()
                                    ->where('email', '=',$data['email'])
                                    ->get();
                    if( count($user) > 0 ){
                        User::withTrashed()->where('email', '=', $data['email'])->restore();

                        $user = User::where('email', '=', $data['email'])->first();

                        $user->password         = bcrypt(self::$generic_password);

                        $user->avatar           = 'avatar.png';
                        $user->group_id         = $data['group_id'];
                        $user->active           = $data['active'];
                        $user->save();

                        $CompanyUser_exist = CompanyUser::withTrashed()
                                                    ->where('company_id', '=', $data['company_id'])
                                                    ->where('user_id', '=', $user->id)
                                                    ->get();

                        if($data['group_id'] != 1 || $data['group_id'] != 4){
                            if(count($CompanyUser_exist) > 0){
                                CompanyUser::withTrashed()
                                        ->where('user_id', '=', $user->id)
                                        ->where('company_id', '=', $data['company_id'])
                                        ->restore();
                            } else {
                                $CompanyUser = new CompanyUser();
                                $CompanyUser->user_id = $user->id;
                                $CompanyUser->company_id = $data['company_id'];
                                $CompanyUser->save();
                            }
                        }
                        $this->res['message'] = 'Usuario restaurado correctamente.';
                        $this->status_code = 201;
                    } else {
                        $user = new User;
                        $user->name             = $data['name'];
                        $user->email            = $data['email'];
                        $user->password         = bcrypt(self::$generic_password);
                        $user->avatar           = 'avatar.png';
                        $user->group_id         = $data['group_id'];
                        $user->active           = $data['active'];
                        $user->save();

                        if($data['group_id'] != 1 || $data['group_id'] != 4){
                            $CompanyUser = new CompanyUser();
                            $CompanyUser->user_id = $user->id;
                            $CompanyUser->company_id = $data['company_id'];
                            $CompanyUser->save();
                        }

                        $this->res['message'] = 'Usuario creado correctamente.';
                        $this->status_code = 201;
                    }
                } else {
                    $this->res['message'] = 'El correo electrónico ya existe.';
                    $this->status_code = 423;
                }
            } else {
                $this->res['message'] = 'Por favor llene todos los campos requeridos.';
                $this->status_code = 422;
            }
        } catch(\Exception $e) {
            $this->res['message'] = 'Error en la Base de Datos.'.$e;
            $this->status_code = 500;
        }
        return response()->json($this->res, $this->status_code);
    }//store

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
    public function update($id)
    {
        try{
            if(is_numeric($id)){
                $validator = Validator::make($this->request->all(), [
                    'name'              => 'required|max:255',
                    'email'             => 'required|max:255|email',
                    'group_id'          => 'required'
                ]);

                $data['name']           = $this->request->input('name');
                $data['email']          = $this->request->input('email');
                $data['group_id']       = $this->request->input('group_id');
                $data['active']         = $this->request->input('active');

                if(!$validator->fails()) {
                    $user_exist = User::where('email', '=', $data['email'])->where('id', '!=', $id)->count();

                    if($user_exist == 0){
                        $user = User::find($id);
                        if($user){
                            $user->name             = $data['name'];
                            $user->email            = $data['email'];
                            $user->group_id         = $data['group_id'];
                            $user->active           = $data['active'];
                            $user->save();

                            $this->res['message'] = 'Usuario actualizado correctamente.';
                            $this->status_code = 201;
                        } else {
                            $this->res['message'] = 'El usuario no existe.';
                            $this->status_code = 422;
                        }
                    } else {
                        $this->res['message'] = 'El correo electrónico ya existe.';
                        $this->status_code = 423;
                    }
                } else {
                    $this->res['message'] = 'Por favor llene todos los campos requeridos.';
                    $this->status_code = 422;
                }
            } else {
                $this->res['message'] = 'ID incorrecto.';
                $this->status_code = 422;
            }
        } catch(\Exception $e) {
            $this->res['message'] = 'Error en la Base de Datos.'.$e;
            $this->status_code = 500;
        }
        return response()->json($this->res, $this->status_code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            if(is_numeric($id)){
                $user = User::find($id);
                if($user){
                    $company_user = CompanyUser::where('user_id', $id)->first();
                    $company_user->delete();
                    $user->delete();
                    $this->res['message'] = 'Usuario eliminado correctamente.';
                    $this->status_code = 201;
                } else {
                    $this->res['message'] = 'El usuario no existe.';
                    $this->status_code = 422;
                }
            } else {
                $this->res['message'] = 'ID incorrecto.';
                $this->status_code = 422;
            }
        } catch(\Exception $e) {
            $this->res['message'] = 'Error en la Base de Datos.'.$e;
            $this->status_code = 500;
        }
        return response()->json($this->res, $this->status_code);
    }
}
