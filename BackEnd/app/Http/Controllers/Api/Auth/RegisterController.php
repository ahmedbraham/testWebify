<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Client;

class RegisterController extends Controller
{

    private $client;


    public function __construct()
    {
        $this->client = Client::find(2);
    }


    public function  register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required'
        ], [
            'name.required' => 'First name required',
            'email.required' => 'email required',
            'email.email' => 'Email address Invalid',
            'email.unique' => 'this email is already used',
            'password.required' => 'password.required',
            'password.min' => 'The password must be at least 6 characters',
            'password.confirmed' => 'please check your password confirmation !',

        ]);


        if ($validator->fails()) {


            return response()->json([
                'seccess' => '0',
                'status' => '400',
                'message' => 'Registration failure',
                'error' => $validator->errors()->first(),
                'data' => null

            ]);
        } else {


            $user = User::create([
                'name' => request('name'),
                'email' => request('email'),
                'password' => bcrypt(request('password'))
            ]);

            //----------------------------------------------------------
            $params = [
                'grant_type' => 'password',
                'client_id' => $this->client->id,
                'client_secret' => $this->client->secret,
                'username' => $request->email,
                'scope' => '*'

            ];
            $request->request->add($params);
            $proxy = Request::create('oauth/token', 'POST');
            $response = Route::dispatch($proxy);
            $response = json_decode($response->getContent());
            //__________________________________________________________


            return response()->json([
                'seccess' => '1',
                'status' => '201',
                'message' => 'Utilisateur créé avec succès!',
                'error' => null,
                'data' => [
                    'user' => $user,
                    'token_type' => $response->token_type,
                    'access_token' => $response->access_token,
                    'refresh_token' => $response->refresh_token,
                    'expires_in' => $response->expires_in,
                ]


            ]);



        }


    }//fin function  register()



}
