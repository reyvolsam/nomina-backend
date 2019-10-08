<?php

namespace App\Http\Controllers\Catalogs;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Department;
use App\Company;
use App\CompanyUser;
use Validator;

class CompanyController extends Controller
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
            $companies_list = [];
            $companies_list = Company::all();


            if(count($companies_list) > 0){
                foreach ($companies_list as $kc => $vc) $vc->loader = false;
                $this->res['message'] = 'Lista de Empresas obtenida correctamente.';
                $this->res['data'] = $companies_list;
                $this->status_code = 200;
            } else {
                $this->res['message'] = 'No hay Empresas registradas hasta el momento.';
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
                'contact'       => 'required|max:255',
                'rfc'           => 'required|max:13',
                'telephone'     => 'required|max:20'
            ]);

            if(!$validator->fails()) {
                $name = $this->request->input('name');

                $company_repeated = Company::where('name', $name)->count();
                if($company_repeated == 0){
                    $company_trash = Company::withTrashed()->where('name', $name)->count();

                    if($company_trash == 0){
                        $company = new Company;
                        $company->create($this->request->all());

                        $this->res['message'] = 'Empresa creada correctamente.';
                        $this->status_code = 200;
                    } else {
                        Company::withTrashed()->where('name', $name)->restore();

                        $company = Company::where('name', $name)->first();

                        $company->updateOrCreate(['id' => $company->id], $this->request->all());

                        $this->res['message'] = 'Empresa restaurado correctamente.';
                        $this->status_code = 422;
                    }
                } else {
                    $this->res['message'] = 'La Empresa ya existe.';
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
                    'contact'       => 'required|max:255',
                    'rfc'           => 'required|max:13',
                    'telephone'     => 'required|max:20'
                ]);

                if(!$validator->fails()) {
                    $company_exist = Company::find($id);
                    if($company_exist){
                        Company::updateOrCreate(['id' => $id], $this->request->all());
                        $this->res['message'] = 'Empresa actualizada correctamente.';
                        $this->status_code = 200;
                    } else {
                        $this->res['message'] = 'La Empresa no existe.';
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

                $exist_company_department = Department::where('company_id', $id)->count();

                $exist_company_user = CompanyUser::where('company_id', $id)->count();

                if($exist_company_department == 0 && $exist_company_user == 0){
                    $company = Company::find($id);

                    if($company){
                        $company->delete();
                        $this->res['message'] = 'Empresa eliminada correctamente.';
                        $this->status_code = 200;
                    } else {
                        $this->res['message'] = 'La Empresa no existe.';
                        $this->status_code = 422;
                    }
                } else {
                    $this->res['message'] = 'Hay un catalogo utilizando esta Empresa.';
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
