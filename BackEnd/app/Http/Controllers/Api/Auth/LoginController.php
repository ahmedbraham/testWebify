<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Client;

class LoginController extends Controller
{
    private $client;
    private $user;


    public function __construct()
    {
        $this->client = Client::find(1);
    }

    //------------------------------------function login ----------------------------------------------------------
    public function login(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'email required',
            'email.email' => 'email adress invalid',
            'password.required' => 'password required'

        ]);


        if ($validator->fails()) {
            return response()->json([
                'success' => '0',
                'status' => '400',
                'message' => 'login failure',
                'error' => $validator->errors()->first(),
                'data' => null

            ]);
        } else {
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {

                $params = [
                    'grant_type' => 'password',
                    'client_id' => $this->client->id,
                    'client_secret' => $this->client->secret,
                    'username' => $request->email,
                    'password' => $request->password,
                    'scope' => '*'

                ];

                $request->request->add($params);
                $proxy = Request::create('oauth/token', 'POST');
                $response = Route::dispatch($proxy);
                $response = json_decode($response->getContent());

                if (Auth::check()) {
                    $this->user = Auth::user();
                    // cas inscription avec Succès
                    return response()->json([
                        'success' => '1',
                        'status' => '200',
                        'message' => 'login with success',
                        'error' => null,
                        'data' => [
                            'user' => $this->user,
                            'token_type' => $response->token_type,
                            'access_token' => $response->access_token,
                            'refresh_token' => $response->refresh_token,
                            'expires_in' => $response->expires_in


                        ]


                    ]);


                }


            } else {
// cas où la mot de passe faux ou l'email faux
                return response()->json([
                    'success' => '0',
                    'status' => '400',
                    'message' => 'login failure',
                    'error' => "email or password incorrect",
                    'data' => null

                ]);

            }


        }


    }

}
