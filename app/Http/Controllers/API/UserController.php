<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;

class UserController extends Controller
{
    public $successStatus = 200;
	
	/** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
	 public static function test_api(){
		 return [
			'name'=>'neeraj',
			'email' =>'neeraj@example.com'
		 ];
	 }
	 public static function student(){
		 return [
			'name' => 'arun',
			'rollno' => 123,
			'class' => 'six',
			'parent_number' => 9876567654
		 ];
	 }
	 public static function teacher(){
		 return [
			[
				'name' => 'anita pareek',
				'subject teach' => ['gk','english','social science'=>['history'=>array('akbar'=>array('wife'=>'jodha'))]],
				'experience' => '1 year',
			],
			[
				'name' => 'kalpana chawala',
				'subject teach' => ['science','chemistry','pysics'],
				'experience' => '2 year',
			],
			[
				'name' => 'rakesh sharma',
				'subject teach' => ['maths','biology','sanskrit'],
				'experience' => '1 year',
			]
		 ];
	 }
    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            return response()->json(['success' => $success], $this-> successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }
/** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email', 
            'password' => 'required', 
            'c_password' => 'required|same:password', 
        ]);
		if ($validator->fails()) { 
					return response()->json(['error'=>$validator->errors()], 401);            
				}
		$input = $request->all(); 
				$input['password'] = bcrypt($input['password']); 
				$user = User::create($input); 
				$success['token'] =  $user->createToken('MyApp')->accessToken; 
				$success['name'] =  $user->name;
		return response()->json(['success'=>$success], $this->successStatus); 
	}
	/** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function details() 
    { 
        $user = Auth::user(); 
        return response()->json(['success' => $user], $this-> successStatus); 
    } 
}
