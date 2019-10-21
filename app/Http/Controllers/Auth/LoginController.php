<?php

namespace App\Http\Controllers\Auth;

use App\CompanyUser;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Validator;
use Auth;

use App\User;

class LoginController extends Controller
{

    private $res = [];
    private $request;
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('guest')->except('logout');

        $this->request = $request;
        $this->res['message'] = '';
        $this->status_code = 204;

        date_default_timezone_set('America/Mexico_City');
    }

    public function auth()
    {
        try {
            $messages = [
                'email.required' => 'El Usuario es requerido.',
                'password.required' => 'La Contraseña es requerida.'
            ];

            $validator = Validator::make($this->request->all(), [
                            'email'         => 'required|max:255',
                            'password'      => 'required'
            ], $messages);

            $usr = User::with(['Company' =>
                        function ($query){
                            $query->select('user_id', 'id');
                        }])
                        ->where('email', 'LIKE', $this->request->input('email'))->first();

            if($usr){
                if(!$validator->fails()) {
                    if($usr->active == 1){
                        if(Auth::attempt(['email' => $this->request->input('email'), 'password' =>  $this->request->input('password')])) {
                            //$this->res['companies'] = $usr->Company;
                            $this->res['profile_id'] = $this->request->user()->group_id;
                            $this->res['name'] = $this->request->user()->name;
                            $this->res['email'] = $this->request->user()->email;
                            $this->res['avatar'] = $this->request->user()->avatar;

                            $user = $this->request->user();
                            $tokenResult = $user->createToken('Personal Access Token');
                            $token = $tokenResult->token;
                            if ($this->request->remember_me) $token->expires_at = Carbon::now()->addWeeks(1);
                            $token->save();

                            $this->status_code = 200;
                            $this->res['access_token'] = $tokenResult->accessToken;
                            $this->res['token_type'] = 'Bearer';
                            $this->res['expires_at'] = Carbon::parse($tokenResult->token->expires_at)->toDateTimeString();
                        } else {
                            $this->status_code = 401;
                            $this->res['message'] = 'El correo electrónico o la contraseña son incorrectos.';
                        }
                    } else {
                        $this->status_code = 422;
                        $this->res['message'] = 'El usuario no esta activado.';
                    }
                } else {
                    $this->status_code = 422;
                    $this->res['message'] = 'El correo electrónico y contraseña son requeridos.';
                }
            } else {
                $this->status_code = 422;
                $this->res['message'] = 'El usuario no existe.';
            }
        } catch(\Exception $e) {
            $this->res['message'] = 'Error en la Base de Datos.'.$e;
            $this->status_code = 500;
        }
        return response()->json($this->res, $this->status_code);
    }//auth()

    public function logout()
    {
        if($this->request->user()){
            $this->request->user()->token()->revoke();
        }
        return response()->json(['message' =>
        'Cierre de sesión exitoso.']);
    }//logout()


}
