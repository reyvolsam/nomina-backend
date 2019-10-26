<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\User;
use App\Company;
use App\CompanyUser;
use App\Department;

class SharedController extends Controller
{

    private $res = [];
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->res['message'] = '';
        $this->res['data'] = [];
        $this->status_code = 204;

        date_default_timezone_set('America/Mexico_City');
    }

    public function getCompanyCatalogFromUser(){

        $this->res = $this->getCompanyCatalogFromUserMethod();
        $this->status_code = $this->res['status_code'];
        return response()->json($this->res, $this->status_code);
    }//

    public function getCompanyCatalogFromUserMethod(){
        $res = [];
        $res['status'] = false;
        $res['status_code'] = 204;
        $res['message'] = '';
        $res['data'] = [];

        try{
            $user = $this->request->user();

            if($user->default_company_id != null){
                $resCatalog = $this->getCompanyCatalog($user);
                if($resCatalog['status']){
                    $res['data'] = $resCatalog['companies'];
                    $res['status'] = true;
                    $res['status_code'] = 200;
                } else {
                    $res['message'] = $resCatalog['message'];
                    $res['status_code'] = 201;
                }
            } else {
                $res['message'] = 'No tiene asignado ninguna empresa';
                $res['status_code'] = 201;
            }
        } catch(\Exception $e) {
            $res['message'] = 'Error en el sistema.'.$e;
            $res['status_code'] = 500;
        }
        return $res;
    }

    public function getCompanyCatalog($user){
        $res = [];
        $res['status'] = false;
        $res['companies'] = [];
        $res['message'] = '';

        try {
            $companies = [];

            //ROOT
            if($user->group_id == 4){
                $companies = Company::all();
                $res['status'] = true;
            }

            //ADMINISTRATOR
            if($user->group_id == 1){
                $companies = User::whereHas('Company')->where('id', $user->id)->get();
                if(count($companies)){
                    $res['status'] = true;
                    $this->res['datas'] = $companies;
                } else {
                    $res['message'] = 'El usuario no tiene asignado ninguna empresa.';
                }
            }

            //OTROS
            if($user->group_id == 1){
                $companies = Company::where('id', $user->default_company_id)->get();
                $res['status'] = true;
            }

            $res['companies'] = $companies;

        } catch(\Exception $e) {
            $res['message'] = 'Error en el sistema.'.$e;
        }

        return $res;
    }

    public function getCompanyCatalogFromUserDepartments()
    {
        try{
            $user = $this->request->user();

            $companies_list = [];
            $departments_list = [];

            $resCompany = $this->getCompanyCatalogFromUserMethod();

            if($resCompany['status']){
                $companies_list = $resCompany['data'];
                $this->status_code = $resCompany['status_code'];
            } else {
                $this->res['message'] = $resCompany['message'];
                $this->status_code = $this->res['status_code'];
            }

            $departments_list = Department::where('company_id', $user->default_company_id)->get();

            $this->res['status'] = true;
            $this->res['data']['companies_list'] = $companies_list;
            $this->res['data']['departments_list'] = $departments_list;
        } catch (\Exception $e) {
            $this->res['message'] = 'Error en el sistema.'.$e;
            $this->status_code = 500;
        }

        return response()->json($this->res, $this->status_code);
    }//

}////
