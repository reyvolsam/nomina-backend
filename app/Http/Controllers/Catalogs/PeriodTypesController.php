<?php

namespace App\Http\Controllers\Catalogs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PeriodTypes;
use App\Worker;
use Validator;

class PeriodTypesController extends Controller
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
            $period_types_list = [];
            $period_types_list = PeriodTypes::all();

            if(count($period_types_list) > 0){
                foreach ($period_types_list as $kc => $vc) $vc->loader = false;
                $this->res['message'] = 'Lista de Tipos de Periodo obtenida correctamente.';
                $this->res['data'] = $period_types_list;
                $this->status_code = 200;
            } else {
                $this->res['message'] = 'No hay Tipos de Periodo registrados hasta el momento.';
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
            ]);

            if(!$validator->fails()) {
                $name = $this->request->input('name');

                $period_types_repeated = PeriodTypes::where('name', $name)->count();
                if($period_types_repeated == 0){
                    $period_types_trash = PeriodTypes::withTrashed()->where('name', $name)->count();

                    if($period_types_trash == 0){
                        $period_types = new PeriodTypes;
                        $period_types->create($this->request->all());

                        $this->res['message'] = 'Tipo de Periodo creado correctamente.';
                        $this->status_code = 200;
                    } else {
                        PeriodTypes::withTrashed()->where('name', $name)->restore();

                        $period_types = PeriodTypes::where('name', $name)->first();

                        $period_types->updateOrCreate(['id' => $period_types->id], $this->request->all());

                        $this->res['message'] = 'Tipo de Periodo restaurado correctamente.';
                        $this->status_code = 422;
                    }
                } else {
                    $this->res['message'] = 'El Tipo de Periodo ya existe.';
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
                    $period_type_exist = PeriodTypes::find($id);
                    if($period_type_exist){
                        PeriodTypes::updateOrCreate(['id' => $id], $this->request->all());
                        $this->res['message'] = 'Tipo de Periodo actualizado correctamente.';
                        $this->status_code = 200;
                    } else {
                        $this->res['message'] = 'El Tipo de Periodo no existe.';
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
                $exist_worker = Worker::where('period_type_id', $id)->count();

                if($exist_worker == 0){
                    $period_types = PeriodTypes::find($id);
                    $period_types->delete();
                    $this->res['message'] = 'Tipo de Periodo eliminado correctamente.';
                    $this->status_code = 200;
                } else {
                    $this->res['message'] = 'Existe un Trabajador utilizando este Tipo de Periodo.';
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
