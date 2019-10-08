<?php

namespace App\Http\Controllers\Catalogs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Work;
use App\Job;

use Validator;

class JobsController extends Controller
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
            $job_list = [];
            $job_list = Job::all();

            if(count($job_list) > 0){
                foreach ($job_list as $kc => $vc) $vc->loader = false;
                $this->res['message'] = 'Lista de Puestos obtenida correctamente.';
                $this->res['data'] = $job_list;
                $this->status_code = 200;
            } else {
                $this->res['message'] = 'No hay Puestos registrados hasta el momento.';
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
                'department_id' => 'required',
            ]);

            if(!$validator->fails()) {
                $name = $this->request->input('name');

                $jobs_repeated = Job::where('name', $name)->count();
                if($jobs_repeated == 0){
                    $jobs_trash = Job::withTrashed()->where('name', $name)->count();

                    if($jobs_trash == 0){
                        $jobs = new Job;
                        $jobs->create($this->request->all());

                        $this->res['message'] = 'Puesto creado correctamente.';
                        $this->status_code = 200;
                    } else {
                        Job::withTrashed()->where('name', $name)->restore();

                        $jobs = Job::where('name', $name)->first();

                        $jobs->updateOrCreate(['id' => $jobs->id], $this->request->all());

                        $this->res['message'] = 'Puesto restaurado correctamente.';
                        $this->status_code = 422;
                    }
                } else {
                    $this->res['message'] = 'El Puesto ya existe.';
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
                    'department_id' => 'required'
                ]);

                if(!$validator->fails()) {
                    $jobs_exist = Job::find($id);
                    if($jobs_exist){
                        Job::updateOrCreate(['id' => $id], $this->request->all());
                        $this->res['message'] = 'Puesto actualizado correctamente.';
                        $this->status_code = 200;
                    } else {
                        $this->res['message'] = 'El Puesto no existe.';
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
                $exist_worker = Work::where('job_id', $id)->count();

                if($exist_worker == 0){
                    $job = Job::find($id);
                    $job->delete();
                    $this->res['message'] = 'Puesto eliminado correctamente.';
                    $this->status_code = 200;
                } else {
                    $this->res['message'] = 'Existe un Trabajador utilizando este Puesto.';
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
