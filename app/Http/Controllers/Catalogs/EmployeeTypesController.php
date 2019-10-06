<?php

namespace App\Http\Controllers\Catalogs;

use App\EmployeeTypes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Validator;

class EmployeeTypesController extends Controller
{
    private $res = [];
    private $request;

    function __construct(Request $request)
    {
        $this->request = $request;
        $this->res['message'] = '';
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
            $employee_types_list = [];
            $employee_types_list = EmployeeTypes::all();

            if(count($employee_types_list) > 0){
                foreach ($employee_types_list as $kc => $vc) $vc->loader = false;
                $this->res['message'] = 'Lista de Tipos de Empleados obtenida correctamente.';
                $this->res['data'] = $employee_types_list;
                $this->status_code = 200;
            } else {
                $this->res['message'] = 'No hay Tipos de Empleados registrados hasta el momento.';
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
                'name'          => 'required|max:255'
            ]);

            if(!$validator->fails()) {
                $name = $this->request->input('name');

                $employee_types_repeated = EmployeeTypes::where('name', $name)->count();
                if($employee_types_repeated == 0){
                    $employee_types_trash = EmployeeTypes::withTrashed()->where('name', $name)->count();

                    if($employee_types_trash == 0){
                        $employee_types = new EmployeeTypes;
                        $employee_types->create($this->request->all());

                        $this->res['message'] = 'Tipo de Empleado creado correctamente.';
                        $this->status_code = 200;
                    } else {
                        EmployeeTypes::withTrashed()->where('name', $name)->restore();

                        $employee_types = EmployeeTypes::where('name', $name)->first();

                        $employee_types->updateOrCreate(['id' => $employee_types->id], $this->request->all());

                        $this->res['message'] = 'Tipo de Empleado restaurado correctamente.';
                        $this->status_code = 422;
                    }
                } else {
                    $this->res['message'] = 'El Tipo de Empleado ya existe.';
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
                    'name'          => 'required|max:255'
                ]);

                if(!$validator->fails()) {
                    $employee_types_exist = EmployeeTypes::find($id);
                    if($employee_types_exist){
                        EmployeeTypes::updateOrCreate(['id' => $id], $this->request->all());
                        $this->res['message'] = 'Tipo de Empleado actualizado correctamente.';
                        $this->status_code = 200;
                    } else {
                        $this->res['message'] = 'El Tipo de Empleo no existe.';
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
                $exist_worker = Worker::where('employee_type_id', $id)->count();

                if($exist_worker == 0){
                    $employee_types = EmployeeTypes::find($id);
                    $employee_types->delete();
                    $this->res['message'] = 'Tipo de Empleo eliminado correctamente.';
                    $this->status_code = 200;
                } else {
                    $this->res['message'] = 'Existe un Trabajador utilizando este Tipo de Empleo.';
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
}
