<?php

class AdminController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'AdminController@showWelcome');
	|
	*/

	public function anyLogin(){  
            $data = Input::all();
            if(isset($data['log'])){
                $user = array();
                $user = User::where('user_email_id',$data['user_email_id'])->where('user_password',$data['user_password'])->where('user_status',1)->first();
                if(!empty($user)){
                    Session::put('user_id',$user['user_id']);
                    if($user['user_type'] == 1){
                        $counsellor = Counsellor::where('user_id',$user['user_id'])->first();
                        Session::put('counsellor_id',$counsellor['counsellor_id']);
                        return Redirect::to('counsellor/dashboard');
                    }
                }
            }
            return View::make('admin.login');
        }
        
        public function anyDashboard(){
            $answers = Answers::orderBy('modified_date', 'DESC')->get();
            return View::make('admin.dashboard')->with(array('answers' => $answers));
        }
        
        public function anyDownload($pdf = null){
            $file = public_path("uploads/pdfreports/".$pdf);
            return Response::download($file);
        }
        
        public function anyAssign(){
            DB::table('mind_answers')->where('answer_id', Input::get('answer'))->update(array('assign' => 1, 'counsellor_id' => Input::get('counsellor')));
        }

}
