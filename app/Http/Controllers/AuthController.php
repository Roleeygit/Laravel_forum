<?php

namespace App\Http\Controllers;
use \App\Http\Controllers\BaseController as Basecontroller;
use Illuminate\Support\Facedes\Auth;
use Validator;
Use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends BaseController
{
    public function signIn(Request $request)
    {
        if(Auth::attempt(['email' => $request->$email, 'password' => $request->$password]));

        $authUser = Auth::user();
        $success["token"] = $authUser->createToken("MyAuthApp")->plainTextToken;
        $success["name"] = $authUser->name;

        return $this->sendRespose($success, "Sikeres bejelentkezés.");

    }
    // else {
    //     return $this->sendError("Unauthorizd.".["error" => "Hibás adatok"]);
    // }



    public function signUp(Request $request)
    {
        $validator = Validator::make($request->all(), 
        [
            "name" => "required",
            "email" => "required",
            "password" => "required",
            "confirm_password" => "required|same:password"
        ]);

        if($validator->fails()) 
        {
            return sendError("Error validation", $validator->errors() );
        }

        $input = $request->all();
        $input["password"] = bcrypt($input["password"]);
        $user = User::create($input);
        $success ["name"] = $user->name;

        return sendResponse($success, "Sikeres regisztráció.");
    }
}
