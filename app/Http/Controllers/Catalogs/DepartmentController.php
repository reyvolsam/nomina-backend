<?php

namespace App\Http\Controllers\Catalogs;


use App\Work;
use App\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Validator;

class DepartmentController extends Controller
{
    private $res = [];
    private $request;

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
            $departments_list = [];
            $departments_list = Department::with('Company')->get();

            if(count($departments_list) > 0){
                foreach ($departments_list as $kc => $vc) $vc->loader = false;
                $this->res['message'] = 'Lista de Departamentos obtenida correctamente.';
                $this->res['data'] = $departments_list;
                $this->status_code = 200;
            } else {
                $this->res['message'] = 'No hay Departamentos registrados hasta el momento.';
                $this->status_code = 201;
            }
        } catch(\Exception $e){
            $this->res['msg'] = 'Error en el sistema.'.$e;
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
                'name'          => 'required|max:255',
                'company_id'    => 'required'
            ]);

            if(!$validator->fails()) {
                $name = $this->request->input('name');

                $departments_repeated = Department::where('name', $name)->count();
                if($departments_repeated == 0){
                    $departments_trash = Department::withTrashed()->where('name', $name)->count();

                    if($departments_trash == 0){
                        $departments = new Department;
                        $departments->create($this->request->all());

                        $this->res['message'] = 'Departamento creado correctamente.';
                        $this->status_code = 200;
                    } else {
                        Department::withTrashed()->where('name', $name)->restore();

                        $departments = Department::where('name', $name)->first();

                        $departments->updateOrCreate(['id' => $departments->id], $this->request->all());

                        $this->res['message'] = 'Departamento restaurado correctamente.';
                        $this->status_code = 422;
                    }
                } else {
                    $this->res['message'] = 'El Departamento ya existe.';
                    $this->status_code = 423;
                }
            } else {
                $this->res['message'] = 'Por favor llene todos los campos requeridos o revise la longitud de los campos.';
                $this->status_code = 422;
            }
        } catch(\Exception $e) {
            $this->res['message'] = 'Error en el sistema.'.$e;
            $this->status_code = 422;
        }

        return response()->json($this->res, $this->status_code);
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
    public function update($id)
    {
        try{
            if(is_numeric($id)){
                $validator = Validator::make($this->request->all(), [
                    'name'          => 'required|max:255',
                    'company_id'    => 'required'
                ]);

                if(!$validator->fails()) {
                    $departments_exist = Department::find($id);
                    if($departments_exist){
                        Department::updateOrCreate(['id' => $id], $this->request->all());
                        $this->res['message'] = 'Departamento actualizado correctamente.';
                        $this->status_code = 200;
                    } else {
                        $this->res['message'] = 'El Departamento no existe.';
                        $this->status_code = 422;
                    }
                } else {
                    $this->res['message'] = 'Por favor llene todos los campos requeridos o revise la longitud de los campos.';
                    $this->status_code = 422;
                }
            } else {
                $this->res['message'] = 'ID incorrecto.';
                $this->status_code = 422;
            }
        } catch(\Exception $e) {
            $this->res['message'] = 'Error en el sistema.'.$e;
            $this->status_code = 422;
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
                $exist_worker = Work::where('department_id', $id)->count();

                if($exist_worker == 0){
                    $departments = Department::find($id);
                    $departments->delete();
                    $this->res['message'] = 'Departamento eliminado correctamente.';
                    $this->status_code = 200;
                } else {
                    $this->res['message'] = 'Existe un Trabajador utilizando este Departamento.';
                    $this->status_code = 422;
                }
            } else {
                $this->res['message'] = 'ID incorrecto.';
                $this->status_code = 422;
            }
        } catch(\Exception $e) {
            $this->res['message'] = 'Error en el sistema.'.$e;
            $this->status_code = 422;
        }

        return response()->json($this->res, $this->status_code);
    }
}
