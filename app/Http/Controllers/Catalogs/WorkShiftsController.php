<?php

namespace App\Http\Controllers\Catalogs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\WorkShifts;

class WorkShiftsController extends Controller
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
            $work_shifts_list = [];
            $work_shifts_list = WorkShifts::all();

            if(count($work_shifts_list) > 0){
                foreach ($work_shifts_list as $kc => $vc) $vc->loader = false;
                $this->res['message'] = 'Lista de Turno de Trabajo obtenida correctamente.';
                $this->res['data'] = $work_shifts_list;
                $this->status_code = 200;
            } else {
                $this->res['message'] = 'No hay Turno de Trabajo registrados hasta el momento.';
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

                $work_shifts_repeated = WorkShifts::where('name', $name)->count();
                if($work_shifts_repeated == 0){
                    $work_shifts_trash = WorkShifts::withTrashed()->where('name', $name)->count();

                    if($work_shifts_trash == 0){
                        $work_shifts = new WorkShifts;
                        $work_shifts->create($this->request->all());

                        $this->res['message'] = 'Tipo de Turno de Trabajo creado correctamente.';
                        $this->status_code = 200;
                    } else {
                        WorkShifts::withTrashed()->where('name', $name)->restore();

                        $work_shifts = WorkShifts::where('name', $name)->first();

                        $work_shifts->updateOrCreate(['id' => $work_shifts->id], $this->request->all());

                        $this->res['message'] = 'Tipo de Turno de Trabajo restaurado correctamente.';
                        $this->status_code = 422;
                    }
                } else {
                    $this->res['message'] = 'El Turno de Trabajo ya existe.';
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
                    $work_shifts_exist = WorkShifts::find($id);
                    if($work_shifts_exist){
                        WorkShifts::updateOrCreate(['id' => $id], $this->request->all());
                        $this->res['message'] = 'Turno de Trabajo actualizado correctamente.';
                        $this->status_code = 200;
                    } else {
                        $this->res['message'] = 'El Turno de Trabajo no existe.';
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
                $exist_worker = Worker::where('work_shift_id', $id)->count();

                if($exist_worker == 0){
                    $work_shifts = WorkShifts::find($id);
                    $work_shifts->delete();
                    $this->res['message'] = 'Turno de Trabajo eliminado correctamente.';
                    $this->status_code = 200;
                } else {
                    $this->res['message'] = 'Existe un Trabajador utilizando este Turno de Trabajo.';
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
