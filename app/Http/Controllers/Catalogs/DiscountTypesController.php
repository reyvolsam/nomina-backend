<?php

namespace App\Http\Controllers\Catalogs;

use App\DiscountTypes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Worker;
use Validator;

class DiscountTypesController extends Controller
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
            $discount_types_list = [];
            $discount_types_list = DiscountTypes::all();

            if(count($discount_types_list) > 0){
                foreach ($discount_types_list as $kc => $vc) $vc->loader = false;
                $this->res['message'] = 'Lista de Tipos de Descuento obtenida correctamente.';
                $this->res['data'] = $discount_types_list;
                $this->status_code = 200;
            } else {
                $this->res['message'] = 'No hay Tipos de Descuento registrados hasta el momento.';
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

                $discount_types_repeated = DiscountTypes::where('name', $name)->count();
                if($discount_types_repeated == 0){
                    $discount_types_trash = DiscountTypes::withTrashed()->where('name', $name)->count();

                    if($discount_types_trash == 0){
                        $discount_types = new DiscountTypes;
                        $discount_types->create($this->request->all());

                        $this->res['message'] = 'Tipo de Descuento creado correctamente.';
                        $this->status_code = 200;
                    } else {
                        DiscountTypes::withTrashed()->where('name', $name)->restore();

                        $discount_types = DiscountTypes::where('name', $name)->first();

                        $discount_types->updateOrCreate(['id' => $discount_types->id], $this->request->all());

                        $this->res['message'] = 'Tipo de Descuento restaurado correctamente.';
                        $this->status_code = 422;
                    }
                } else {
                    $this->res['message'] = 'El Tipo de Descuento ya existe.';
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
                    $discount_type_exist = DiscountTypes::find($id);
                    if($discount_type_exist){
                        DiscountTypes::updateOrCreate(['id' => $id], $this->request->all());
                        $this->res['message'] = 'Tipo de Descuento actualizado correctamente.';
                        $this->status_code = 200;
                    } else {
                        $this->res['message'] = 'El Tipo de Descuento no existe.';
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
                $exist_worker = Worker::where('discount_type_id', $id)->count();

                if($exist_worker == 0){
                    $discount_types = DiscountTypes::find($id);
                    $discount_types->delete();
                    $this->res['message'] = 'Tipo de Descuento eliminado correctamente.';
                    $this->status_code = 200;
                } else {
                    $this->res['message'] = 'Existe un Trabajador utilizando este Tipo de Descuento.';
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
