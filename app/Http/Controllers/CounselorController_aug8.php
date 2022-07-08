<?php namespace App\Http\Controllers;

use DB;
use Input;
use Session;
use View;
use App;
use Redirect;
use Validator;
use URL;
use DateTime;
//use Vsmoraes\Pdf\Pdf;

class CounselorController extends Controller {

    
	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
  
    public function __construct(){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        } 
    }        
    public function anyIndex(){
        if(!$this->anyChecklogin()){
            return Redirect::action('CounselorController@anyLogin',array());
        }else{
            return Redirect::action('CounselorController@anyDashboard',array());
        }
    }
    public function anyRegister(){
        $reg_data = array();
        $country = $state = array();
   
            $countries = DB::table('country')->orderBy('country_id', 'ASC')->select('country_id','countryname','phoneCode')->get();
            if(count($countries)>0){$y=0;
                foreach($countries as $cntry){
                    $country[$y]['country_id'] = $cntry->country_id;
                    $country[$y]['countryname'] = $cntry->countryname;
                    $country[$y]['phone_code'] = $cntry->phoneCode;
                    $y++;
                }
            }
            $states = DB::table('states')->where('country_id', '=', '103')->orderBy('state_id', 'ASC')->get();
            if(count($states)>0){ $z=0;
                foreach($states as $cntrystate){
                    $state[$z]['state_id'] = $cntrystate->state_id;
                    $state[$z]['name'] = $cntrystate->name;
                    $z++;
                }
            }
            $post_arr           = Input::all(); 
            if(!empty($post_arr)){
             /*   if (!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $post_arr['password']))
                {
                    $err_msg  = '<br />';
                    $err_msg .= '<i>Password must conatin one special character and minimum 6 characters</i><br />';
                    return json_encode(array('error' => 1, 'err_msg' => $err_msg)); exit;
                }*/
                if(!isset($post_arr['terms'])){
                    $err_msg  = '<br />';
                    $err_msg .= '<i>You must agree terms and conditions</i>';
                    return json_encode(array('error' => 1, 'err_msg' => $err_msg)); exit;
                }
            
                if(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $post_arr['captcha_code']) != 0){ 
                    $err_msg  = '<br />';
                    $err_msg .= '<i>Validation code does not match!</i>';
                    return json_encode(array('error' => 1, 'err_msg' => $err_msg)); exit;	
                }
                $counselors_state ='';
                if(isset($post_arr['customer_state_select']) && !empty($post_arr['customer_state_select'])){
                    $counselors_state      =$post_arr['customer_state_select'];
                }

                if(isset($post_arr['customer_state_text']) && !empty($post_arr['customer_state_text'])){
                    $counselors_state = $post_arr['customer_state_text'];
                }
                
                $validator = Validator::make(
                 array(
                    'counselors_email_id'  => $post_arr['counselors_email_id'],
                    'counselors_firstname'  => $post_arr['counselors_firstname'],
                    'counselors_lastname'  => $post_arr['counselors_lastname'],
                    'counselors_phone_code'  => $post_arr['counselors_phone_code'], 
                    'counselors_phone'  => $post_arr['counselors_phone'],
                    'counselors_zip'  => $post_arr['counselors_zip'],
                    'country_id'  => $post_arr['customer_country'],
                    'counselors_state'  => $counselors_state,
                    'counselors_city'  => $post_arr['counselors_city'],
                    'counselors_password'  => $post_arr['password'],
                    'counselors_password2'  => $post_arr['password2']
 
                 ),
                 array(
                    'counselors_email_id' => 'required|unique:counselors,counselors_email_id',
                    'counselors_firstname' => 'required',
                    'counselors_lastname' => 'required',
                    'counselors_phone_code' => 'required',                      
                    'counselors_phone' => 'required|max:13',
                    'counselors_zip' => 'required',
                    'country_id' => 'required',
                    'counselors_state' => 'required',
                    'counselors_city' => 'required',
                    'counselors_password' => 'required|min:4' ,
                    'counselors_password2' => 'required|same:counselors_password',
                 )
                );

                if ($validator->fails())
                {
                    $messages   = $validator->messages();   
                    $err_msg  = '';
                    foreach ($messages->all() as $msg) {
                            $err_msg .= '<br/><i>'.$msg.'</i>';
                    }
                    echo json_encode(array('error' => 1, 'err_msg' => $err_msg)); exit;

                }

              
                $insert_arr['counselors_firstname']       = $post_arr['counselors_firstname'];
                $insert_arr['counselors_middlename']      =$post_arr['counselors_middlename'];
                $insert_arr['counselors_lastname']        =$post_arr['counselors_lastname'];
                $insert_arr['counselors_email_id']    =$post_arr['counselors_email_id'];
                $insert_arr['counselors_phone_code']     =$post_arr['counselors_phone_code'];
                $insert_arr['counselors_phone']     =$post_arr['counselors_phone'];
                
                $insert_arr['country_id']          =$post_arr['customer_country'];

                $insert_arr['counselors_state']            = $counselors_state;
                
                $insert_arr['counselors_city']              =$post_arr['counselors_city'];
                
                $insert_arr['counselors_zip']         =$post_arr['counselors_zip'];
                $insert_arr['counselors_password']         =(new BaseController)->encrypt_decrypt(trim($post_arr['password']));
                $curr_date = date('Y-m-d H:i:s');

                $insert_arr['email_verify'] = 1;        
                $insert_arr['counselors_status'] = 3; 
                
                $insert_arr['created_at'] = $curr_date;
                $insert_arr['updated_at'] = $curr_date;   
                
                

             
              
              $counselorId = DB::table('counselors')->insertGetId($insert_arr);
              
              if($counselorId){
                 // $this->anyVerifysend($counselorId,$email,$name);  
                $result = (new BaseController)->send_counselor_registration_mail($counselorId,$post_arr['password']);

                if($result){
                    return json_encode(array('error' => 0)); exit;
                }else{
                    return json_encode(array('error' => 1,'err_msg'=>'Some error happend during mail sending.')); exit;
                }                 

              } 
               
              echo json_encode(array('error' => 1,'err_msg'=>'Something went wrong, please try again.')); exit;
         }
        return View::make('counselor.register')->with(array('reg_data'=>$reg_data,'country'=>$country,'state'=>$state));
    }  
    public function anyLogin($redirect=''){
        
        // Already Logined
        if($this->anyChecklogin()){
           
            if ($redirect != ''){
                return Redirect::to("counselor/$redirect");
            }else {
                return Redirect::to("counselor/dashboard");
            }
        }
        $data['redirect'] = $redirect;
        $data['site_url'] = URL::to('/');
        
        //ini_set('max_execution_time', 120);
        
        $post = Input::all();
        if(isset($post['user_email_id']) && $post['user_email_id'] != ''){
            $counselor = DB::table('counselors')->where('counselors_email_id', '=', $post['user_email_id'])->where('counselors_password', '=', (new BaseController)->encrypt_decrypt($post['user_password']))->where('counselors_status','=', 1)->where('is_deleted','==', 0)->first();   
            if(count($counselor)>0){ 
               session_destroy();
               session::flush();
                
               session_start();               
               $_SESSION['counselor_id'] = $counselor->counselors_id;
               Session::put('counselor_id',$counselor->counselors_id);
               return json_encode(array('error' => 0, 'redirect'=>$redirect)); exit;
            }else{
                
                $hp = DB::table('counselors')->where('counselors_email_id', '=', $post['user_email_id'])->where('counselors_password', '=', (new BaseController)->encrypt_decrypt($post['user_password']))->where('email_verify','=', 0)->first();   
                if(count($hp)>0){           
                    return json_encode(array('error' => 1,'err_msg'=>'Your account is not verified.Please verify your account')); exit;
                }
                
                $hp = DB::table('counselors')->where('counselors_email_id', '=', $post['user_email_id'])->where('counselors_password', '=', (new BaseController)->encrypt_decrypt($post['user_password']))->where('counselors_status','=', 3)->first();   
                if(count($hp)>0){           
                    return json_encode(array('error' => 1,'err_msg'=>'Your account is not approved yet .Please try after some time')); exit;
                }
                
                $hp = DB::table('counselors')->where('counselors_email_id', '=', $post['user_email_id'])->where('counselors_password', '=', (new BaseController)->encrypt_decrypt($post['user_password']))->where('counselors_status','=', 0)->first();   
                if(count($hp)>0){           
                    return json_encode(array('error' => 1,'err_msg'=>'Your account is inactive .Please try after some time')); exit;
                }
                


                return json_encode(array('error' => 1,'err_msg'=>'Invalid Username or Password. Please try with your counselor email id and the specific password.')); exit;
            }
        }    
        return View::make('counselor.login')->with(array('data'=>$data));
    }
    
    public function anyDashboard(){
        
        if(!$this->anyChecklogin()){
            return Redirect::to('counselor/login/dashboard');   
        }         
        $counselorId = Session::get('counselor_id');
        $data['site_url'] = URL::to('/');
        $data['counselor'] =  DB::table('counselors')->where('counselors_id', '=', $counselorId)->first();
        return View::make('counselor.dashboard')->with(array('data'=>$data));
        
    }
    public function anyFinish($id=null){
        return View::make('counselor.finish');
    } 
    public function anyVerifysend($id,$email=null,$name=null){
        if(isset($id) && $id > 0){  
            $val = 'doctor'.$id;
            $key = urlencode((new BaseController)->encrypt_decrypt($val));
            $link = asset('counselor/verifyemail?key='.$key);
            if($name==null){
                $customers = DB::table('counselors')->where('counselors.counselors_id', '=', $id)->select('counselors.counselorss_firstname','counselors.counselors_lastname','counselors.counselors_email_id')->first();            
                if(count($customers)>0){  
                    $email = $customers->counselors_email_id;
                    $name = $customers->counselors_firstname." ".$customers->counselors_lastname;
                }
            }
            $subject = "Counselor Account activation - Doctorbuddy.com";
            $body = '<h3>Dear '.$name. ' ,</h3>
                <p>Thank you for signing up with Doctorbuddy</p>
                            <p>To be able to sign in to your account, please verify your email address first by clicking the following link:
            <a href="'.$link.'">Click Here</a> or visit the following address <a href="'.$link.'">'.$link.'</a><br/></p>
            <p>Reagrds,<br/>Doctorbuddy.com</p>';
            $result = (new BaseController)->mail($email,$subject,$body);
            if(!$result){
               echo json_encode(array('error' => 1,'err_msg'=>'Mail sending Failed.')); exit;
            }  
        }  
    }
    public function anyVerifyemail(){
        $result ='';
        $data = Input::all();        
        if(isset($data['key']) && $data['key'] !=''){  
            $decrypted = (new BaseController)->encrypt_decrypt(urldecode($data['key']));
            $id = substr($decrypted,6);
            $customers = DB::table('counselors')->where('counselors.counselors_id', '=', $id)->get();            
            if(count($customers)>0){  
                $update_data = array();
                $update_data['email_verify'] = 1;        
                $update_data['counselors_status'] = 3; 
                if (count($update_data) > 0 && $id > 0) {
                DB::table('counselors')->where('counselors_id', $id)->update($update_data);
                }
                return View::make('counselor.verify');
            }           
        }
        return Redirect::to('home');  
    }
          
    public function anyCounselorexist(){
        $data = Input::all();
        $result =0;
        if($data['user']!=''){  
            $counselors = DB::table('counselors')->where('counselors_email_id', '=', $data['user'])->first();            
            if(count($counselors)>0){                  
                $result = $counselors->counselors_id;
            }           
        }
        echo $result;
    } 
    public function anyForgotpassword(){
        $result ='';
        $data = Input::all();
        $data['msg'] = '';
        $dataoutput = array();
        $dataoutput['msg'] = '';
        if(isset($data['user_email_id']) && $data['user_email_id'] != ''){
            $counselors = DB::table('counselors')->where('counselors.counselors_email_id', '=', trim($data['user_email_id']))->select('counselors.counselors_firstname','counselors.counselors_lastname','counselors.counselors_id','counselors.counselors_email_id')->first();            
            if(count($counselors)>0){  
                $email = $counselors->counselors_email_id;
                $name = $counselors->counselors_firstname." ".$counselors->counselors_lastname;
                $id = $counselors->counselors_id;
                $rand_pwd = (new BaseController)->Randompassword(); 
                $update_data = array();
                $update_data['counselors_password'] = (new BaseController)->encrypt_decrypt(trim($rand_pwd));
                DB::table('counselors')->where('counselors_id', $id)->update($update_data);
                
                // Send Mail               
                $templateLocation = "counselor.mail_template_forgot_password";

                $thingsToPassTemplate["site_link"] = URL::to('/'); 
                $thingsToPassTemplate["site_start_link"] = URL::to('/')."/home/basic";      
                $thingsToPassTemplate["receipent_name"] = $name;        
      
                $thingsToPassTemplate["rand_pwd"] = $rand_pwd;


                $subject = "Forgot Password - Counselor"; 

                $receipents = $email;

                // Send mail
                $result= (new BaseController)->send_mail(
                        $templateLocation,
                        $thingsToPassTemplate,
                        $subject,
                        $receipents
                        );
                
                
                if($result==true){
                     echo json_encode(array('error' => 0,'msg'=>'Success.New password has been sent to your email.')); exit;
                }else{
                    echo json_encode(array('error' => 1,'err_msg'=>'Some error occured.Please try after some time')); exit;
                }
                
            }else{
                 echo json_encode(array('error' => 1,"err_msg"=>"This email doesn't exist in our records.")); exit;
            }
        }
        return View::make('counselor.forgot')->with(array('dataoutput' => $dataoutput));;
//        return Redirect::to('home');  
    }
    public function anyForgotsend($id){
        if(isset($id) && $id > 0){  
            $counselors = DB::table('counselors')->where('customers.customer_id', '=', $id)->select('counselors.counselors_firstname','counselors.counselors_lastname','counselors.counselors_email_id')->first();            
            if(count($counselors)>0){  
                $email = $counselors->counselors_email_id;
                $name = $counselors->counselors_firstname." ".$counselors->counselors_lastname;
            
                $rand_pwd = (new BaseController)->Randompassword(); 
                $update_data = array();
                $update_data['counselors_password'] = (new BaseController)->encrypt_decrypt(trim($rand_pwd));
                DB::table('counselors')->where('counselors_id', $id)->update($update_data);
                
                // Send Mail               
                $templateLocation = "counselor.mail_template_forgot_password";

                $thingsToPassTemplate["site_link"] = URL::to('/'); 
                $thingsToPassTemplate["site_start_link"] = URL::to('/')."/home/basic";      
                $thingsToPassTemplate["receipent_name"] = $name;        
      
                $thingsToPassTemplate["rand_pwd"] = $rand_pwd;


                $subject = "Forgot Password -Counselor"; 

                $receipents = $email;

                // Send mail
                $result= (new BaseController)->send_mail(
                        $templateLocation,
                        $thingsToPassTemplate,
                        $subject,
                        $receipents
                        );

                if($result==true){
                    echo "Success.New password has been sent to your email.";
                }else{
                   echo $result; 
                }
            }
        }
        //return Redirect::to('home');  
    }
    
    public function anyChangepassword(){
        
        if(!$this->anyChecklogin()){
            return Redirect::to('counselor/login/changepassword');   
        } 
        $counselorId = Session::get('counselor_id');
        $data['site_url'] = URL::to('/');
        $counselorId = Session::get('counselor_id');
        $post_arr           = Input::all();  
        
        $data['counselor'] =  DB::table('counselors')->where('counselors_id', '=', $counselorId)->first();
        
        
          if(!empty($post_arr) && $post_arr['form_submit'] == "save"){

             // 
             $validator = Validator::make(
                 array(
                     'counselors_password'  => $post_arr['counselors_password'],
                     'counselors_password2'  => $post_arr['counselors_password2']
                 ),
                 array(
//                     'counselors_password' => 'required|regex:/(^(?=.{6,})(?=.*[!@#$%^&*()+=]).*$)+/' ,
                     'counselors_password' => 'required|min:4' ,
                     'counselors_password2' => 'required|same:counselors_password',
                 )
//                     ,
//                array(
//                     'counselors_password.regex' => 'Password should contain atleast 6 characters with minimum one special character' ,   
//                )                      
             );

             if ($validator->fails())
             {
                 $messages   = $validator->messages();   
                 $err_msg  = '<br />';
                 foreach ($messages->all() as $msg) {
                         $err_msg .= '<i>'.$msg.'</i><br />';
                 }
                 return  json_encode(array('error' => 1, 'err_msg' => $err_msg)); exit;

             }else{
                 $update_data['counselors_password'] = (new BaseController)->encrypt_decrypt(trim($post_arr['counselors_password']));

                 if (count($update_data) > 0 ) {
                     DB::table('counselors')->where("counselors_id","=",$counselorId)->update($update_data);
                 }

                 Session::flash('flash_msg','Password changed successfully');
                 return json_encode(array('error' => 0)); exit;

             } 

         }else{
             return View::make('counselor.changepassword')->with(array("data"=>$data)); 
         }
       
    }
    
    public function anyEditprofile(){
        
        if(!$this->anyChecklogin()){
            return Redirect::to('counselor/login/editprofile');   
        } 
        
        $data['site_url'] = URL::to('/');
        $counselorId = Session::get('counselor_id');
        
        $countries = DB::table('country')->select('country_id','countryname','phoneCode')->orderBy('country_id', 'ASC')->get();
        $data['countries'] = $countries;
        
        $languages = DB::table('languages')->where('language_status','=',1)->select('language_id','language_name')->orderBy('language_id', 'ASC')->get();
        $data['languages'] = $languages;
        
        $specilizations = DB::table('specilizations')->where('specilization_status','=',1)->select('specilization_id','specilization_name')->orderBy('specilization_id', 'ASC')->get();
        $data['specilizations'] = $specilizations;
        
        $insurances = DB::table('insurance_companies')->where('insurance_status','=',1)->select('insurance_id','insurance_name')->orderBy('insurance_id', 'ASC')->get();
        $data['insurances'] = $insurances;
        
        
        
        $conselorObj = DB::table('counselors')->where("counselors_id","=",$counselorId);

        $data['counselor'] =  $conselorObj->first();
        
        $counselorToLanguages =  DB::table('counselors_to_languages')->where('counselors_id','=',$counselorId)->get();
        $selectedLanguages = array();
        foreach ($counselorToLanguages as $counselorToLanguage){
            $selectedLanguages [] = $counselorToLanguage->language_id;
        }
        $data['selectedLanguages'] =  $selectedLanguages;
                
        $counselorToSpecilizations =  DB::table('counselors_to_specilizations')->where('counselors_id','=',$counselorId)->get();
        $selectedSpecilizations = array();
        foreach ($counselorToSpecilizations as $counselorToSpecilization){
            $selectedSpecilizations[] = $counselorToSpecilization->specilization_id;
        }
        $data['selectedSpecilizations'] =  $selectedSpecilizations;
        
        
        $post_arr           = Input::all();    
          
        if(!empty($post_arr) && $post_arr['form_submit'] == "save"){
            
 

              
            $counselors_state ='';
            if(isset($post_arr['counselors_state_select']) && !empty($post_arr['counselors_state_select'])){
                $counselors_state      =$post_arr['counselors_state_select'];
            }

            if(isset($post_arr['counselors_state_text']) && !empty($post_arr['counselors_state_text'])){
                $counselors_state = $post_arr['counselors_state_text'];
            }

            $validator = Validator::make(
             array(
                 'counselors_firstname'  => $post_arr['counselors_firstname'],
                 'counselors_lastname'  => $post_arr['counselors_lastname'],
                 'counselors_phone_code'  => $post_arr['counselors_phone_code'],
                 'counselors_phone'  => $post_arr['counselors_phone'],
                 'counselors_zip'  => $post_arr['counselors_zip'],
                 'country_id'  => $post_arr['country_id'],
                 'counselors_state'  => $counselors_state,
                 'counselors_city'  => $post_arr['counselors_city'],
              //   'counselors_dob'  => $post_arr['counselors_dob'],
                 
             ),
             array(
                 'counselors_firstname' => 'required',
                 'counselors_lastname' => 'required',
                 'counselors_phone_code' => 'required',
                 'counselors_phone' => 'required',
                 'counselors_zip' => 'required',
                 'country_id' => 'required',
                 'counselors_state' => 'required',
                 'counselors_city' => 'required',
              //   'counselors_dob' => 'required',

                 
                 
             )
            );

            if ($validator->fails())
            {
                $messages   = $validator->messages();   
                $err_msg  = '<br />';
                foreach ($messages->all() as $msg) {
                        $err_msg .= '<i>'.$msg.'</i><br /><br />';
                }
                echo json_encode(array('error' => 1, 'err_msg' => $err_msg)); exit;

            } 


            // Healthcare Professional table
            $input_arr1['counselors_firstname']       = $post_arr['counselors_firstname'];
            $input_arr1['counselors_middlename']      =$post_arr['counselors_middlename'];
            $input_arr1['counselors_lastname']        =$post_arr['counselors_lastname'];
            $input_arr1['counselors_phone_code']      =$post_arr['counselors_phone_code'];
            $input_arr1['counselors_phone']            =$post_arr['counselors_phone'];
            $input_arr1['counselors_zip']               =$post_arr['counselors_zip'];

            $input_arr1['country_id']          =$post_arr['country_id'];
            $input_arr1['counselors_state']            = $counselors_state;
            $input_arr1['counselors_city']             =$post_arr['counselors_city'];
            $input_arr1['counselors_designation']      =$post_arr['counselors_designation'];
            $input_arr1['counselors_nickname']      =$post_arr['counselors_nickname'];
            $input_arr1['counselors_aboutme']      =$post_arr['counselors_aboutme'];
            
            if(isset($post_arr['counselors_dob'])&& $post_arr['counselors_dob'] !=''){
                $datetime = new DateTime();
                $datetime = $datetime->createFromFormat('m-d-Y', $post_arr['counselors_dob']);
                $input_arr1['counselors_dob']              = $datetime->format('Y-m-d');                
            }

            
            if(isset($post_arr['document']) && $post_arr['document'] !=''){
               $input_arr1['counselors_photo']        = $post_arr['document']; 
            }
                
            $input_arr1['updated_at'] = date('Y-m-d H:i:s');   
   
            $conselorObj->update($input_arr1);
            
     
            
            // counselors_to_languages table
            if(isset($post_arr['language_id'])){
                $counselorTolanguages = DB::table('counselors_to_languages'); 
                // Delete old languages
                $counselorTolanguages->where('counselors_id','=',$counselorId)->delete();

                $languageIds = $post_arr['language_id'];
                foreach ($languageIds as $languageId){
                    if((int)$languageId != 0){
                        $counselorTolanguages->insert(array('counselors_id'=>$counselorId,'language_id'=>$languageId));
                    }

                }
            }
            
            // counselors_to_specilizations
            if(isset($post_arr['specilization_id'])){
                $counselorToSpecilizations = DB::table('counselors_to_specilizations'); 
                // Delete old specilizations
                $counselorToSpecilizations->where('counselors_id','=',$counselorId)->delete();

                $specilizationIds = $post_arr['specilization_id'];
                foreach ($specilizationIds as $specilizationId){
                    if((int)$specilizationId != 0){
                        $counselorToSpecilizations->insert(array('counselors_id'=>$counselorId,'specilization_id'=>$specilizationId));
                    }

                }
            }

            
            Session::flash('flash_msg','Record saved successfully');
            return json_encode(array('error' => 0)); exit;

         }
            
         return View::make('counselor.editprofile')->with(array('data'=>$data));
       
    }
    
    public function anyState(){
        

        
        $data = Input::all();
        $result['state_exist'] =false;
        
        if(isset($data['cnty'])){  
            if($data['cnty']>0){  
                $states = DB::table('states')->where('country_id', '=', $data['cnty'])->orderBy('state_id', 'ASC')->get();
                if(count($states)>0){ 
                    $result['state_exist'] =true;
                    foreach($states as $cntrystate){
                        $stateArr[] = $cntrystate->name;
                    }
                    $result['state_arr'] =$stateArr;
                }
                
            }
            return json_encode($result);
        }else{
            return json_encode($result);
        }           
    }
    
    public function anyLatestcustomers(){
        
        // Ajax call to get the latest  logined, reached customers in the site
        if(!$this->anyChecklogin()){
            return Redirect::to('counselor/login');   
        } 
        
        $data = Input::all();
        $resultArr =array();
        $datetime = new DateTime();
        
            $input_arr1['counselors_dob']              = $datetime->format('Y-m-d');
        $customers = DB::table('customers_available')->orderBy('reached_time', 'DESC')->get();
        $i =0;
        if(count($customers)>0){ 
            foreach($customers as $customer){
                $resultArr[$i]['customer_nikname'] = $customer->customer_nikname;
                $resultArr[$i]['location'] = $customer->location;
                $resultArr[$i]['reached_time'] = $customer->reached_time;
                $i++;
            }             
        }
                
        return View::make('counselor.latestcustomers')->with(array('resultArr'=>$resultArr));
        exit;                   
    }
   
    
    public function anyRemovestoredimage(){
        
        //Its Ajax section 
        // Remove already saved image
        if(!$this->anyChecklogin()){
              return Redirect::to('counselor/login/editprofile');   
          } 
        $counselorId = Session::get('counselor_id'); 
        $conselorObj = DB::table('counselors')->where("counselors_id","=",$counselorId);
        $conselor = $conselorObj->first();
        
        unlink("uploads/counselor/thumbnail/".$conselor->counselors_photo);
        unlink("uploads/counselor/".$conselor->counselors_photo);


        $input_arr['counselors_photo'] = '';
        $conselorObj->update($input_arr);
        Session::flash('flash_msg','Image Deleted Successfully');
        return json_encode(array('error' => 0)); exit;
      
      
    }
    
    public function anyRemoveimage(){
        
        //Its Ajax section 
        // Remove just uploaded image
            
        if(!$this->anyChecklogin()){
              return Redirect::to('counselor/login/editprofile');   
        } 
        $post_arr           = Input::all();       

        unlink("uploads/counselor/thumbnail/".$post_arr['document']);
        unlink("uploads/counselor/".$post_arr['document']);

        return json_encode(array('error' => 0)); exit;
      
      
    }
    
    public function anyListing(){
        
        // Listing of Counselors
        $data = array();
        $data['site_url'] = URL::to('/');
        $counselorObjects = DB::table('counselors')
                ->leftjoin('country', 'counselors.country_id', '=', 'country.country_id')
                ->where("counselors.counselors_status","=",1)
                ->where("counselors.is_deleted","=",0)
                ->get();
        $data['counselorObjects'] = $counselorObjects;
        return View::make('counselor.listing')->with(array('data'=>$data));
        exit;
 
      
      
    } 
    
    
    public function anyDetails($counselorId){
        
        $counselorId = (int)$counselorId;
        // Listing of Counselors
        $data = array();
        $data['site_url'] = URL::to('/');
        $counselorObject = DB::table('counselors')
                             
                ->leftjoin('country', 'counselors.country_id', '=', 'country.country_id')
                ->where("counselors.counselors_id","=",$counselorId)
                ->where("counselors.is_deleted","=",0) 
                ->first();
        
        if(!$counselorObject){
            Session::flash('flash_msg','No such Counselor exist.Or account is deleted !');
            return Redirect::to('counselor/listing');
        }
               
        
        // Get Languages
        $langArr = array();
        $langNameArr = array();
        $counselorLangObjs = DB::table('counselors_to_languages')->where('counselors_id','=',$counselorId)->get();
        foreach($counselorLangObjs as $counselorLangObj){
            $langArr[] = $counselorLangObj->language_id;
        }
        $langArr = array_unique($langArr);
        if(count($langArr)>0){
            $languageObjs = DB::table('languages')->whereIn('language_id',$langArr)->where('language_status','=',1)->get();
            if($languageObjs){
                foreach($languageObjs as $languageObj){
                    $langNameArr[] =$languageObj->language_name;
                }
            }
        }
        
        
        // Get Specialization
        $specilizationArr = array();
        $specilizationNameArr = array();
        $counselorSpecilizationObjs = DB::table('counselors_to_specilizations')->where('counselors_id','=',$counselorId)->get();
        foreach($counselorSpecilizationObjs as $counselorSpecilizationObj){
            $specilizationArr[] = $counselorSpecilizationObj->specilization_id;
        }
        $specilizationArr = array_unique($specilizationArr);
        if(count($specilizationArr)>0){
            $specilizationObjs = DB::table('specilizations')->whereIn('specilization_id',$specilizationArr)->where('specilization_status','=',1)->get();
            if($specilizationObjs){
                foreach($specilizationObjs as $specilizationObj){
                    $specilizationNameArr[] =$specilizationObj->specilization_name;
                }
            }
        }        
                 
        $data['counselorObject'] = $counselorObject;
        $data['languages'] = $langNameArr;
        $data['specilizations'] = $specilizationNameArr;
        return View::make('counselor.details')->with(array('data'=>$data));
        exit;
 
      
      
    } 
        
    
    public function anyLogout(){
        session_destroy();
        Session::flush(); 
        return Redirect::to('counselor'); 
    }
    
    public function anyChecklogin(){
        
        // Check whether customer has logined or not
        if(isset($_SESSION['counselor_id']) && $_SESSION['counselor_id'] >0){
            return true;
        }else{
            return false;
        }
        
    }      
}
