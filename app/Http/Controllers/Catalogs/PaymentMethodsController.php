<?php

namespace App\Http\Controllers\Catalogs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PaymentMethods;
use App\Work;
use Faker\Provider\de_DE\Payment;
use Validator;

class PaymentMethodsController extends Controller
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
            $payment_methods_list = [];
            $payment_methods_list = PaymentMethods::all();

            if(count($payment_methods_list) > 0){
                foreach ($payment_methods_list as $kc => $vc) $vc->loader = false;
                $this->res['message'] = 'Lista de Tipos de Pagos obtenida correctamente.';
                $this->res['data'] = $payment_methods_list;
                $this->status_code = 200;
            } else {
                $this->res['message'] = 'No hay Tipos de Pagos registrados hasta el momento.';
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

                $payment_methods_repeated = PaymentMethods::where('name', $name)->count();
                if($payment_methods_repeated == 0){
                    $payment_methods_trash = PaymentMethods::withTrashed()->where('name', $name)->count();

                    if($payment_methods_trash == 0){
                        $payment_methods = new PaymentMethods;
                        $payment_methods->create($this->request->all());

                        $this->res['message'] = 'Metodo de Pago creado correctamente.';
                        $this->status_code = 200;
                    } else {
                        PaymentMethods::withTrashed()->where('name', $name)->restore();

                        $payment_methods = PaymentMethods::where('name', $name)->first();

                        $payment_methods->updateOrCreate(['id' => $payment_methods->id], $this->request->all());

                        $this->res['message'] = 'Metodo de Pago restaurado correctamente.';
                        $this->status_code = 422;
                    }
                } else {
                    $this->res['message'] = 'El Metodo de Pago ya existe.';
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
                    $payment_methods_exist = PaymentMethods::find($id);
                    if($payment_methods_exist){
                        PaymentMethods::updateOrCreate(['id' => $id], $this->request->all());
                        $this->res['message'] = 'Metodo de Pago actualizado correctamente.';
                        $this->status_code = 200;
                    } else {
                        $this->res['message'] = 'El Metodo de Pago no existe.';
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
                $exist_worker = Work::where('payment_method_id', $id)->count();

                if($exist_worker == 0){
                    $payment_methods = PaymentMethods::find($id);
                    $payment_methods->delete();
                    $this->res['message'] = 'Metodo de Pago eliminado correctamente.';
                    $this->status_code = 200;
                } else {
                    $this->res['message'] = 'Existe un Trabajador utilizando este Metodo de Pago.';
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
