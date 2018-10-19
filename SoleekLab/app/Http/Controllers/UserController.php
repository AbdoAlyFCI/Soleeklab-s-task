<?php

namespace App\Http\Controllers;
use App\User;
use Auth;
use JWTFactory;
use JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;

class UserController extends Controller
{

    public function login(Request $request){   
        $validator =Validator::make($request->all(),[
            'email' =>'required|email',
            'password' =>'required',
        ]);
        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()], 401);
        }
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user=Auth::user();
            $success['token']=$user->createToken('MyApp')->accessToken;
            return response()->json(['success'=>$success], 200);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }
//  Register api
      
    public function register(Request $request) 
    { 
        $validator =validator::make($request->all(),[
            'name' =>'required',
            'email' =>'required|email',
            'password' =>'required',
            'c_password' =>'required|same:password',
        ]);
        if($validator ->fails()){
            return response()->json(['error'=>$validator->errors()],401);
        }
        $input =$request->all();
        $input['password']=bcrypt($input['password']);
        $user =User::create($input);
        $success['token']=$user->createToken('MyApp')->accessToken;
        return response()->json(['success'=>$success], 200);
    }
    public function details(){

        $users=User::get();
        return response()->json(['success'=>$users], 200);
    }

    public function CountriesList(){
        $countries = 
        [
            ['AF' => 'Afghanistan'],
            ['AX' => 'Aland Islands'],
            ['AL' => 'Albania'],
            ['DZ' => 'Algeria'],
            ['AS' => 'American Samoa'],
            ['AD' => 'Andorra'],
            ['AO' => 'Angola'],
            ['AI' => 'Anguilla'],
            ['AQ' => 'Antarctica'],
            ['AG' => 'Antigua And Barbuda'],
            ['AR' => 'Argentina'],
            ['AM' => 'Armenia'],
            ['AW' => 'Aruba'],
            ['AU' => 'Australia'],
            ['AT' => 'Austria'],
        ];
        
        return response()->json(['$countries'=>$countries], 200);
       
        
    }
}

