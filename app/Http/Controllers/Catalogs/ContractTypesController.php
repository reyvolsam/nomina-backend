<?php

namespace App\Http\Controllers\Catalogs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\ContractTypes;
use App\Worker;

use Validator;

class ContractTypesController extends Controller
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
            $contract_type_list = [];
            $contract_type_list = ContractTypes::with('Company')->get();

            if(count($contract_type_list) > 0){
                foreach ($contract_type_list as $kc => $vc) $vc->loader = false;
                $this->res['message'] = 'Lista de Tipos de Contratos obtenida correctamente.';
                $this->res['data'] = $contract_type_list;
                $this->status_code = 200;
            } else {
                $this->res['message'] = 'No hay Contratos registrados hasta el momento.';
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

                $contract_types_repeated = ContractTypes::where('name', $name)->count();
                if($contract_types_repeated == 0){
                    $contract_types_trash = ContractTypes::withTrashed()->where('name', $name)->count();

                    if($contract_types_trash == 0){
                        $contract_types = new ContractTypes;
                        $contract_types->create($this->request->all());

                        $this->res['message'] = 'Tipo de Contrado creado correctamente.';
                        $this->status_code = 200;
                    } else {
                        ContractTypes::withTrashed()->where('name', $name)->restore();

                        $contract_types = ContractTypes::where('name', $name)->first();

                        $contract_types->updateOrCreate(['id' => $contract_types->id], $this->request->all());

                        $this->res['message'] = 'Tipo de Contrato restaurado correctamente.';
                        $this->status_code = 422;
                    }
                } else {
                    $this->res['message'] = 'El Tipo de Contrato ya existe.';
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
                    $contract_types_exist = ContractTypes::find($id);
                    if($contract_types_exist){
                        ContractTypes::updateOrCreate(['id' => $id], $this->request->all());
                        $this->res['message'] = 'Tipo de Contrato actualizado correctamente.';
                        $this->status_code = 200;
                    } else {
                        $this->res['message'] = 'El Tipo de Contrato no existe.';
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
                $exist_worker = Worker::where('contract_type_id', $id)->count();

                if($exist_worker == 0){
                    $ContractTypes = ContractTypes::find($id);
                    $ContractTypes->delete();
                    $this->res['message'] = 'Tipo de Contrato eliminado correctamente.';
                    $this->status_code = 200;
                } else {
                    $this->res['message'] = 'Existe un Trabajador utilizando este Tipo de Contrato.';
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
