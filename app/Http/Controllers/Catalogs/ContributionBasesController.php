<?php

namespace App\Http\Controllers\Catalogs;

use App\ContributionBases;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Worker;
use Validator;

class ContributionBasesController extends Controller
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
        try {
            $contribution_bases_list = [];
            $contribution_bases_list = ContributionBases::with('Company')->get();

            if(count($contribution_bases_list) > 0){
                foreach ($contribution_bases_list as $kc => $vc) $vc->loader = false;
                $this->res['message'] = 'Bases de Cotización obtenida correctamente.';
                $this->res['data'] = $contribution_bases_list;
                $this->status_code = 200;
            } else {
                $this->res['message'] = 'No hay Bases de Cotización registradas hasta el momento.';
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

                $contribution_bases_repeated = ContributionBases::where('name', $name)->count();
                if($contribution_bases_repeated == 0){
                    $contribution_bases_trash = ContributionBases::withTrashed()->where('name', $name)->count();

                    if($contribution_bases_trash == 0){
                        $contribution_bases = new ContributionBases;
                        $contribution_bases->create($this->request->all());

                        $this->res['message'] = 'Base de Cotización creada correctamente.';
                        $this->status_code = 200;
                    } else {
                        ContributionBases::withTrashed()->where('name', $name)->restore();

                        $contribution_bases = ContributionBases::where('name', $name)->first();

                        $contribution_bases->updateOrCreate(['id' => $contribution_bases->id], $this->request->all());

                        $this->res['message'] = 'Base de Cotización restaurada correctamente.';
                        $this->status_code = 422;
                    }
                } else {
                    $this->res['message'] = 'La Base de Cotización ya existe.';
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
                    $contribution_bases_exist = ContributionBases::find($id);
                    if($contribution_bases_exist){
                        ContributionBases::updateOrCreate(['id' => $id], $this->request->all());
                        $this->res['message'] = 'Base de Cotización actualizada correctamente.';
                        $this->status_code = 200;
                    } else {
                        $this->res['message'] = 'La Base de Cotización no existe.';
                        $this->status_code = 422;
                    }
                } else {
                    $this->res['message'] = 'Por favor llene todos los campos requeridos o revise la longitud de los campos.';
                    $this->res["data"] = $this->request->all();
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
                $exist_worker = Worker::where('contribution_bases_id', $id)->count();

                if($exist_worker == 0){
                    $contribution_bases = ContributionBases::find($id);
                    $contribution_bases->delete();
                    $this->res['message'] = 'Base de Cotización eliminado correctamente.';
                    $this->status_code = 200;
                } else {
                    $this->res['message'] = 'Existe un Trabajador utilizando esta Base de Cotización.';
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
