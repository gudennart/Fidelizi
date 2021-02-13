<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private $_admin;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Admin $admin)
    {
        $this->_admin = $admin;
    }
    public function Login(Request $requestBody)
    {
        $user = $this->_admin->find($requestBody->get('email'));
        if($user->passwd == $requestBody->get('senha')){
            return response()->json(['data' => 
                    [
                        'Token' => $user->token]
                    ]);
        }
        else{
            return response()
            ->json(['data' => [
                        'message' => 'Usuário não encontrado']
                   ]);
        }
    }
    
}
