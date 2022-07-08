<?php namespace App\Http\Controllers;
//namespace App\Http\BaseController;
use DB;
use Input;
use Session;
use View;
use App;
use Redirect;
use Validator;
use URL;
use DateTime;
use Mail;
//use Vsmoraes\Pdf\Pdf;

class HealthcareprofessionalController extends Controller {

    public function __construct(){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        } 
    }     
    //  show login page for admin   
    public function getIndex($flag='')    
    {
        
        if(!$this->anyChecklogin()){
            return Redirect::action('HealthcareprofessionalController@anyLogin',array());
        }else{
            return Redirect::action('HealthcareprofessionalController@anyDashboard',array());
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
              
              
                if(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $post_arr['captcha_code']) != 0){ 
                    $err_msg  = '<br />';
                    $err_msg .= '<i>Validation code does not match!</i>';
                    return json_encode(array('error' => 1, 'err_msg' => $err_msg)); exit;	
                }
                
                if(isset($post_arr['healthcare_professional_state_select']) && !empty($post_arr['healthcare_professional_state_select'])){
                    $healthcare_professional_state      =$post_arr['healthcare_professional_state_select'];
                }

                if(isset($post_arr['healthcare_professional_state_text']) && !empty($post_arr['healthcare_professional_state_text'])){
                    $healthcare_professional_state = $post_arr['healthcare_professional_state_text'];
                }
                $validator = Validator::make(
                 array(
                     'healthcare_professional_email_address'  => $post_arr['healthcare_professional_email_address'],
                     'healthcare_professional_first_name'  => $post_arr['healthcare_professional_first_name'],
                    'healthcare_professional_last_name'  => $post_arr['healthcare_professional_last_name'],
                    'healthcare_professional_phone_code'  => $post_arr['healthcare_professional_phone_code'], 
                    'healthcare_professional_phone_number'  => $post_arr['healthcare_professional_phone_number'],
                    'healthcare_professional_zip_code'  => $post_arr['healthcare_professional_zip_code'],
                    'healthcare_professional_country'  => $post_arr['healthcare_professional_country'],
                    'healthcare_professional_state'  => $healthcare_professional_state,
                    'healthcare_professional_city'  => $post_arr['healthcare_professional_city'],
                     'healthcare_professional_password'  => $post_arr['healthcare_professional_password'],
                     'healthcare_professional_password2'  => $post_arr['healthcare_professional_password2']
 
                 ),
                 array(
                     'healthcare_professional_email_address' => 'required|unique:healthcare_professional,healthcare_professional_email_address',
                     'healthcare_professional_first_name' => 'required',
                    'healthcare_professional_phone_code' => 'required',
                    'healthcare_professional_last_name' => 'required', 
                    'healthcare_professional_phone_number' => 'required|max:13',
                    'healthcare_professional_zip_code' => 'required',
                    'healthcare_professional_country' => 'required',
                    'healthcare_professional_state' => 'required',
                    'healthcare_professional_city' => 'required',
//                    'healthcare_professional_password' => 'required|regex:/(^(?=.{6,})(?=.*[!@#$%^&*()+=]).*$)+/' ,
                    'healthcare_professional_password' => 'required|min:4' ,
                    'healthcare_professional_password2' => 'required|same:healthcare_professional_password',
                 )
//                array(
//                    'healthcare_professional_password.regex' => 'Password should contain atleast 6 characters with minimum one special character' , 
//                )
                        
                );

                if ($validator->fails())
                {
                    $messages   = $validator->messages();   
                    $err_msg  = '';
                    foreach ($messages->all() as $msg) {
                            $err_msg .= '<br /><i>'.$msg.'</i>';
                    }
                    echo json_encode(array('error' => 1, 'err_msg' => $err_msg)); exit;

                }
              

              
                $insert_arr['healthcare_professional_first_name']       = $post_arr['healthcare_professional_first_name'];
                $insert_arr['healthcare_professional_middle_name']      =$post_arr['healthcare_professional_middle_name'];
                $insert_arr['healthcare_professional_last_name']        =$post_arr['healthcare_professional_last_name'];
                $insert_arr['healthcare_professional_email_address']    =$post_arr['healthcare_professional_email_address'];
                $insert_arr['healthcare_professional_phone_code']     =$post_arr['healthcare_professional_phone_code'];
                $insert_arr['healthcare_professional_phone_number']     =$post_arr['healthcare_professional_phone_number'];
                
                $insert_arr['healthcare_professional_country']          =$post_arr['healthcare_professional_country'];

                $insert_arr['healthcare_professional_state']            = $healthcare_professional_state;
                
                $insert_arr['healthcare_professional_city']              =$post_arr['healthcare_professional_city'];
                
                $insert_arr['healthcare_professional_zip_code']         =$post_arr['healthcare_professional_zip_code'];
                $insert_arr['healthcare_professional_password']         =(new BaseController)->encrypt_decrypt(trim($post_arr['healthcare_professional_password']));
                
                $insert_arr['email_verify'] = 1;
                $insert_arr['healthcare_professional_status'] = 3; //waiting for approval
                
                $insert_arr['healthcare_professional_date_created'] = date('Y-m-d H:i:s');
                $insert_arr['healthcare_professional_date_modified'] = date('Y-m-d H:i:s');   
                
                

             
              
              $hpId = DB::table('healthcare_professional')->insertGetId($insert_arr);
              
              if($hpId){
//                 $email = $post_arr['healthcare_professional_email_address']; 
//                 $name = $post_arr['healthcare_professional_first_name'];
//                 if(isset($post_arr['healthcare_professional_middle_name']) && !empty($post_arr['healthcare_professional_middle_name'])){
//                     $name .= " ".$post_arr['healthcare_professional_middle_name'];
//                 }
//                 
//                 $name .= " ".$post_arr['healthcare_professional_last_name'];
//                 
//                 $this->sendVerifyMail($hpId,$email,$name);
                  
                
                         
 
                // Send Mail  
                $name = $insert_arr['healthcare_professional_first_name'];   
                if(isset($insert_arr['healthcare_professional_middle_name'])&& $insert_arr['healthcare_professional_middle_name'] !='')
                    $name .= " ".$insert_arr['healthcare_professional_middle_name'];
                $name .= " ".$insert_arr['healthcare_professional_last_name'];
                $userName = $insert_arr['healthcare_professional_email_address'];
                $userPassword= trim($post_arr['healthcare_professional_password']);
                $email = $insert_arr['healthcare_professional_email_address'];
                
                $templateLocation = "healthcare_professional.mail_template_registration";

                $thingsToPassTemplate["site_link"] = URL::to('/'); 
                $thingsToPassTemplate["site_start_link"] = URL::to('/')."/home/basic";      
                $thingsToPassTemplate["receipent_name"] = $name;   
                $thingsToPassTemplate["user_name"] = $userName;
                $thingsToPassTemplate["user_password"] = $userPassword;      

                $subject = "Provider Registration - Success"; 

                $receipents = $email;

                // Send mail
                $result= (new BaseController)->send_mail(
                        $templateLocation,
                        $thingsToPassTemplate,
                        $subject,
                        $receipents
                );                  
                  
                echo json_encode(array('error' => 0)); exit;
                 
              }
               
              echo json_encode(array('error' => 1,'err_msg'=>'Something went wrong, please try again.')); exit;
         }
            
         return View::make('healthcare_professional.register')->with(array('reg_data'=>$reg_data,'country'=>$country,'state'=>$state));
       
    }
    
    public function anyLogin($action='',$id=''){
     
        // Already Logined
        if($this->anyChecklogin()){
            return Redirect::to("healthcare_professional/dashboard");            
        } 
        
        $post = Input::all();
        
        
        $redirect='';
        if($action == "casefileview"){
            $redirect = $action."?key=".$post['key'];
        }else if($action != '' && $id !=''){
             $redirect = $action."/$id";
        }else if($action != ''){
             $redirect = $action;
        }
        $data['redirect'] = $redirect;
        $data['site_url'] = URL::to('/');
        
        
        if(isset($post['user_email_id']) && $post['user_email_id'] != ''){
            $hp = DB::table('healthcare_professional')->where('healthcare_professional_email_address', '=', $post['user_email_id'])->where('healthcare_professional_password', '=', (new BaseController)->encrypt_decrypt($post['user_password']))->whereIn('healthcare_professional_status',[1, 4])->where('is_deleted','==', 0)->first();   
            if(count($hp)>0){ 
                session_destroy();
                session::flush();
                
                session_start(); 
                $_SESSION['hp_id'] = $hp->healthcare_professional_id;
                Session::put('hp_id',$hp->healthcare_professional_id);
                return json_encode(array('error' => 0)); exit;
            }else{
                
                $hp = DB::table('healthcare_professional')->where('healthcare_professional_email_address', '=', $post['user_email_id'])->where('healthcare_professional_password', '=', (new BaseController)->encrypt_decrypt($post['user_password']))->where('email_verify','=', 0)->first();   
                if(count($hp)>0){           
                    return json_encode(array('error' => 1,'err_msg'=>'Your account is not verified.Please verify your account')); exit;
                }   
                
                $hp = DB::table('healthcare_professional')->where('healthcare_professional_email_address', '=', $post['user_email_id'])->where('healthcare_professional_password', '=', (new BaseController)->encrypt_decrypt($post['user_password']))->where('healthcare_professional_status','=', 3)->first();                   
                if(count($hp)>0){           
                    return json_encode(array('error' => 1,'err_msg'=>'Your account is not approved yet.Please try after some time')); exit;
                    
                }                
                $hp = DB::table('healthcare_professional')->where('healthcare_professional_email_address', '=', $post['user_email_id'])->where('healthcare_professional_password', '=', (new BaseController)->encrypt_decrypt($post['user_password']))->where('healthcare_professional_status','=', 0)->first();   
                if(count($hp)>0){           
                    return json_encode(array('error' => 1,'err_msg'=>'Your account is inactive.Please try after some time')); exit;
                }
                
                return json_encode(array('error' => 1,'err_msg'=>'Invalid Username or Password. Please try with your healthcare provider email id and the specific password.')); exit;
            }
        }    
        return View::make('healthcare_professional.login')->with(array('data'=>$data));
    }
    
    public function anyPartialsignup($redirect=''){
     
       
        // Already Logined
        if($this->anyChecklogin()){
            
            if ($redirect != ''){
                return Redirect::to("healthcare_professional/$redirect");
            }else {
                return Redirect::to("healthcare_professional/dashboard");
            }
        } 
        
        $partialSignupEmail = Session::get('partial_signup_email');
        $post = Input::all();
        
        if($redirect == "casefileview"){
            $redirect = $redirect."?key=".$post['key'];
        }
        $data['redirect'] = $redirect;
        $data['site_url'] = URL::to('/');
        
        
        if(isset($post['form_submit']) && $post['form_submit'] != ''){
            
            $validator = Validator::make(
             array(
                 'healthcare_professional_email_address'  => $partialSignupEmail,
             ),
             array(
                 'healthcare_professional_email_address' => 'unique:healthcare_professional,healthcare_professional_email_address',
             )
            );

            if ($validator->fails())
            {
                $messages   = $validator->messages();   
                $err_msg  = '<br />';
                foreach ($messages->all() as $msg) {
                        $err_msg .= '<i>'.$msg.'</i><br />';
                }
                return json_encode(array('error' => 1, 'err_msg' => $err_msg)); exit;

            } 
            $insertArr['healthcare_professional_email_address'] = $partialSignupEmail;
            $insertArr['healthcare_professional_password'] = (new BaseController)->encrypt_decrypt(trim($post['healthcare_professional_password']));
            $insertArr['email_verify'] = 1;
            $insertArr['healthcare_professional_status'] = 4;  //partial signup
            
            $hp = DB::table('healthcare_professional');
            $hpId =$hp->insertGetId($insertArr);
            if($hpId >0){
                $update_data = array();
                $update_data['healthcare_professional_id'] = $hpId; //waiting for approval
                if (count($update_data) > 0) {
                DB::table('casefile_to_healthcare')->where('healthcare_professional_email', $partialSignupEmail)->update($update_data);
                }
                Session::flush();
                Session::put('hp_id',$hpId);               
                return json_encode(array('error' => 0, 'redirect'=>$redirect)); exit;
            }else{
                return json_encode(array('error' => 1, 'err_msg' => '<i>Some error occured .Please try after some time</i><br />')); exit;
            }
        }
        return View::make('healthcare_professional.partial_signup')->with(array('data'=>$data));
    }    
    
    public function anyDashboard(){

        if(!$this->anyChecklogin()){
            return Redirect::to('healthcare_professional/login/dashboard');   
        } 
        
        $hpId = Session::get('hp_id');
        $hpObj = DB::table('healthcare_professional')->where("healthcare_professional_id","=",$hpId)->first();
        
        
        // Listing of assigned cases
        $hpEmail=$hpObj->healthcare_professional_email_address;
        $data = array();
        $data['site_url'] = URL::to('/');
       // $hpEmail
        $caseFileObjs = DB::table('casefile_to_healthcare')
                ->leftjoin('customer_detail','casefile_to_healthcare.customer_detail_id', '=', 'customer_detail.customer_detail_id')
                ->leftjoin('country', 'customer_detail.country_id', '=', 'country.country_id')
                ->where("casefile_to_healthcare.healthcare_professional_email","=",$hpEmail)
                ->where("customer_detail.is_casefile","=",1)
                ->where("customer_detail.customer_status","=",1)
                ->groupby("casefile_to_healthcare.customer_detail_id")
                ->orderby("casefile_to_healthcare.casefile_to_healthcare_id","DESC")
                ->get();
        $data['caseFileObjs'] = $caseFileObjs;
        return View::make('healthcare_professional.dashboard')->with(array('hpObj'=>$hpObj,'data'=>$data));
        exit;        
        
    }
    
    // Listing,Add,Edit,Delete,View of Health care professional's templates
    public function anyTemplates($action='',$templateId=''){

        
        if(!$this->anyChecklogin()){
            return Redirect::to('healthcare_professional/login/templates');   
        } 
        
        $hpId = Session::get('hp_id');
        $hpObj = DB::table('healthcare_professional')->where("healthcare_professional_id","=",$hpId)->first();
        
        
        // Listing of assigned cases
        $hpEmail=$hpObj->healthcare_professional_email_address;
        $data = array();
        $data['site_url'] = URL::to('/');
        
        $post = Input::all();
        
        switch($action){
            
            case "Delete":
                
                $templateId = (int)$templateId;                
               
                $templateTable =DB::table('communication_templates')->where("communication_template_id","=",$templateId);
                $templateObj=$templateTable->first();
                
                if(!is_object($templateObj)){
                    Session::flash('error_msg','No template exist !');
                    return Redirect::to('healthcare_professional/templates'); 
                } 
                
                if($templateObj->create_user_type !='HP' || $templateObj->create_user_id != $hpId){
                    Session::flash('error_msg','You are not allowed to edit the particular template !');
                    return Redirect::to('healthcare_professional/templates');                     
                }
                
                // Delete from template table
                $templateTable->delete() ;
                //Delete from  healthcare_professional_to_templates
                DB::table('healthcare_professional_to_templates')->where("communication_template_id","=",$templateId)->delete();
                

                $templates = DB::table('healthcare_professional_to_templates')
                ->leftjoin('communication_templates','healthcare_professional_to_templates.communication_template_id','=','communication_templates.communication_template_id')
                ->where("healthcare_professional_to_templates.healthcare_professional_id","=",$hpId)
                ->where("communication_templates.template_status","=",1)
                ->get();
                $data['templates'] = $templates;
                
                return View::make('healthcare_professional.ajaxtemplatelisting')->with(array('hpObj'=>$hpObj,'data'=>$data));
                exit;
                
            case "Add":
                if(isset($post['form_submit']) && $post['form_submit']=='save'){
  
                    
                    $validator = Validator::make(
                        array(
                            'template_title'  => $post['template_title'],
                            'template_text'  => $post['template_text']
                        ),
                        array(
                            'template_title' => 'required',
                            'template_text' => 'required',
                        )
                    );

                    if ($validator->fails())
                    {
                        $messages   = $validator->messages();   
                        $err_msg  = '';
                        foreach ($messages->all() as $msg) {
                                $err_msg .= '<br /><i>'.$msg.'</i>';
                        }
                        echo json_encode(array('error' => 1, 'err_msg' => $err_msg)); exit;

                    }      

                    $inputArr = array();
                    $inputArr['template_title']=$post['template_title'];
                    $inputArr['template_text']=$post['template_text'];
                    $inputArr['template_status']=1;
                    $inputArr['create_user_type']='HP';
                    $inputArr['create_user_id']= $hpId;
                    
                    
                    $inputArr['create_date']= date('Y-m-d H:i:s');
                    $templateId = DB::table('communication_templates')->insertGetId($inputArr);
                    
                    $inputArr1['communication_template_id'] = $templateId;
                    $inputArr1['healthcare_professional_id'] = $hpId;
                    DB::table('healthcare_professional_to_templates')->insert($inputArr1);
                    
                    if($templateId){
                        Session::flash('flash_msg','Record has been added successfully !');
                        echo json_encode(array("error"=>0));exit;
                    }else{
                        echo json_encode(array("error"=>1));exit;
                    }                    
                    
                }
                return View::make('healthcare_professional.template_add')->with(array('hpObj'=>$hpObj,'data'=>$data));
                exit;
                
            case "Edit":
                $templateId = (int)$templateId;
                $templateObj =DB::table('communication_templates')->where("communication_template_id","=",$templateId)->first();
                
                if(!is_object($templateObj)){
                    Session::flash('error_msg','No template exist !');
                    return Redirect::to('healthcare_professional/templates'); 
                }
                
                if($templateObj->create_user_type !='HP' || $templateObj->create_user_id != $hpId){
                    Session::flash('error_msg','You are not allowed to edit the particular template !');
                    return Redirect::to('healthcare_professional/templates');                     
                }
                
                if(isset($post['form_submit']) && $post['form_submit']=='save'){
  
                    
                    
                    $validator = Validator::make(
                        array(
                            'template_title'  => $post['template_title'],
                            'template_text'  => $post['template_text']
                        ),
                        array(
                            'template_title' => 'required',
                            'template_text' => 'required',
                        )
                    );

                    if ($validator->fails())
                    {
                        $messages   = $validator->messages();   
                        $err_msg  = '';
                        foreach ($messages->all() as $msg) {
                                $err_msg .= '<br /><i>'.$msg.'</i>';
                        }
                        echo json_encode(array('error' => 1, 'err_msg' => $err_msg)); exit;

                    } 
                    
                    $updateArr = array();
                    $updateArr['template_title']=$post['template_title'];
                    $updateArr['template_text']=$post['template_text'];

                    DB::table('communication_templates')->where("communication_template_id","=",$templateId)->update($updateArr);
                    
                    Session::flash('flash_msg','Record has been updated successfully !');
                    return json_encode(array("error"=>0));exit;                                        
                    
                }
                
                return View::make('healthcare_professional.template_edit')->with(array('hpObj'=>$hpObj,'templateObj'=>$templateObj,'data'=>$data));
                exit;
                
            case "View":
                $templateObj =DB::table('communication_templates')->where("communication_template_id","=",$templateId)->first();
                return json_encode(array("error"=>0,"title"=>$templateObj->template_title,"content"=>$templateObj->template_text));exit;  
                
            default:

                
                $templates = DB::table('healthcare_professional_to_templates')
                ->leftjoin('communication_templates','healthcare_professional_to_templates.communication_template_id','=','communication_templates.communication_template_id')
                ->where("healthcare_professional_to_templates.healthcare_professional_id","=",$hpId)
                ->where("communication_templates.template_status","=",1)
                ->get();      
                
                $data['templates'] = $templates;
                return View::make('healthcare_professional.templates')->with(array('hpObj'=>$hpObj,'data'=>$data));
                exit;   
        }
    
        
    }    
    
    public function anyFinish(){ 
         return View::make('healthcare_professional.finish');
    } 
    
    public function anyVerifyemail(){
      $result ='';
      $data = Input::all();        
      if(isset($data['key']) && $data['key'] !=''){  
          $decrypted = (new BaseController)->encrypt_decrypt(urldecode($data['key'])); 
          $id = substr($decrypted,2);
          $hp = DB::table('healthcare_professional')->where('healthcare_professional.healthcare_professional_id', '=', $id)->first();            
          if(count($hp)>0){  
              if($hp->email_verify == '0'){
                  $update_data = array();
                  $update_data['email_verify'] = 1;
                  $update_data['healthcare_professional_status'] = 3; //waiting for approval
                  if (count($update_data) > 0 && $id > 0) {
                  DB::table('healthcare_professional')->where('healthcare_professional_id', $id)->update($update_data);
                  }
              }else{
                   
                   Session::flash('flash_msg','Account is already activated. Please login');
                   return Redirect::to('healthcare_professional/login'); 
              }
              return View::make('healthcare_professional.verify');
          }else{
                Session::put('flash_msg','No Such account exist.');
                return Redirect::to('healthcare_professional/login'); 
          }           
      }
      
          return Redirect::to('healthcare_professional/login'); 
     

//        return Redirect::to('home');  
  }
    
    public function sendVerifyMail($id,$email,$name){
        if(isset($id) && $id > 0){  
            $val = 'hp'.$id;
            $key = urlencode((new BaseController)->encrypt_decrypt($val));
            $link = asset('healthcare_professional/verifyemail?key='.$key);
            $subject = "Account activation (Healthcare Professional) - Doctorbuddy.com";
            $body = View::make('healthcare_professional.mail_template')->with(array("name"=>$name,"link"=>$link));           
            $result = (new BaseController)->mail($email,$subject,$body);
            if(!$result){
               echo json_encode(array('error' => 1,'err_msg'=>'Mail sending Failed.')); exit;
            }  
        }
        //return Redirect::to('home');  
    }
    
    public function anyState(){
        
//        if(!Session::get('hp_id')){
//            return Redirect::to('healthcare_professional/login');   
//        } 
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
    
    public function anyForgotpassword(){
        $result ='';
        $data = Input::all();
        if(isset($data['user_email_id']) && $data['user_email_id'] != ''){
            $hp = DB::table('healthcare_professional')->where('healthcare_professional.healthcare_professional_email_address', '=', trim($data['user_email_id']))->first(); 
            if(count($hp)>0){  
                $email = $hp->healthcare_professional_email_address;
                
                $name = $hp->healthcare_professional_first_name;
                if($hp->healthcare_professional_middle_name){
                     $name .= " ".$hp->healthcare_professional_middle_name;
                }
                 
                $name .= " ".$hp->healthcare_professional_last_name;
                
                $hpId = $hp->healthcare_professional_id;
                
                $rand_pwd = (new BaseController)->Randompassword(); 
                
                $update_data = array();
                $update_data['healthcare_professional_password'] = (new BaseController)->encrypt_decrypt(trim($rand_pwd));
                DB::table('healthcare_professional')->where('healthcare_professional_id', $hpId)->update($update_data);
                
                // Send Mail               
                $templateLocation = "healthcare_professional.mail_template_forgot_password";

                $thingsToPassTemplate["site_link"] = URL::to('/'); 
                $thingsToPassTemplate["site_start_link"] = URL::to('/')."/home/basic";      
                $thingsToPassTemplate["receipent_name"] = $name;        
      
                $thingsToPassTemplate["rand_pwd"] = $rand_pwd;


                $subject = "Forgot Password - Provider"; 

                $receipents = $email;

                // Send mail
                $result= (new BaseController)->send_mail(
                        $templateLocation,
                        $thingsToPassTemplate,
                        $subject,
                        $receipents
                );

                if($result){
                    echo json_encode(array('error' => 0,'msg'=>'Success.New password has been sent to your email.')); exit;
                }else{
                    echo json_encode(array('error' => 1,'err_msg'=>'Some error occured.Please try after some time')); exit;
                }
            }else{
                 echo json_encode(array('error' => 1,'err_msg'=>"This email doesn't exist in our records.")); exit;
            }
        }
        return View::make('healthcare_professional.forgotpassword');
    }
    
    public function anyChangepassword(){
        
        if(!$this->anyChecklogin()){
            return Redirect::to('healthcare_professional/login/changepassword');   
        } 
        
        $data['site_url'] = URL::to('/');
        $hpId = Session::get('hp_id');
        $post_arr           = Input::all();  
        
        $data['hp'] =  DB::table('healthcare_professional')->where('healthcare_professional_id', '=', $hpId)->first();
        
        
          if(!empty($post_arr) && $post_arr['form_submit'] == "save"){

             // Check for duplicate
             $validator = Validator::make(
                 array(
                     'healthcare_professional_password'  => $post_arr['healthcare_professional_password'],
                     'healthcare_professional_password2'  => $post_arr['healthcare_professional_password2']
                 ),
                 array(
//                     'healthcare_professional_password' => 'required|regex:/(^(?=.{6,})(?=.*[!@#$%^&*()+=]).*$)+/' ,
                     'healthcare_professional_password' => 'required|min:4' ,                     
                     'healthcare_professional_password2' => 'required|same:healthcare_professional_password',
                 )
//                     ,
//                array(
//                     'healthcare_professional_password.regex' => 'Password should contain atleast 6 characters with minimum one special character' ,
//                     
//                )    
                     
             );

             if ($validator->fails())
             {
                 $messages   = $validator->messages();   
                 $err_msg  = '<br />';
                 foreach ($messages->all() as $msg) {
                         $err_msg .= '<i>'.$msg.'</i><br/><br/>';
                 }
                 return  json_encode(array('error' => 1, 'err_msg' => $err_msg)); exit;

             }else{
                 $update_data['healthcare_professional_password'] = (new BaseController)->encrypt_decrypt(trim($post_arr['healthcare_professional_password']));

                 if (count($update_data) > 0 ) {
                     DB::table('healthcare_professional')->where("healthcare_professional_id","=",$hpId)->update($update_data);
                 }
                 Session::flash('flash_msg','Password changed successfully');
                 return json_encode(array('error' => 0)); exit;

             } 

         }else{
             $hpObj = DB::table('healthcare_professional')->where("healthcare_professional_id","=",$hpId)->first();
             return View::make('healthcare_professional.changepassword')->with(array("data"=>$data,"hpObj"=>$hpObj)); 
         }
       
    }
    
    public function anyEditprofile(){
        
        if(!$this->anyChecklogin()){
            return Redirect::to('healthcare_professional/login/editprofile');   
        } 
        
        $data['site_url'] = URL::to('/');
        $hpId = Session::get('hp_id');
        
        $country = array();
   
        $countries = DB::table('country')->orderBy('country_id', 'ASC')->select('country_id','countryname','phoneCode')->get();
        if(count($countries)>0){$y=0;
            foreach($countries as $cntry){
                $country[$y]['country_id'] = $cntry->country_id;
                $country[$y]['countryname'] = $cntry->countryname;
                $country[$y]['phone_code'] = $cntry->phoneCode;
                $y++;
            }
        }
   
        $languages = DB::table('languages')->where('language_status','=',1)->select('language_id','language_name')->orderBy('language_id', 'ASC')->get();
        $data['languages'] = $languages;
        
        $specilizations = DB::table('specilizations')->where('specilization_status','=',1)->select('specilization_id','specilization_name')->orderBy('specilization_id', 'ASC')->get();
        $data['specilizations'] = $specilizations;
        
        $insurances = DB::table('insurance_companies')->where('insurance_status','=',1)->select('insurance_id','insurance_name')->orderBy('insurance_id', 'ASC')->get();
        $data['insurances'] = $insurances;
        
        
        
        $hpObj = DB::table('healthcare_professional')->where("healthcare_professional_id","=",$hpId);

        $data['hp'] =  DB::table('healthcare_professional')->leftjoin('healthcare_professional_details', 'healthcare_professional.healthcare_professional_id', '=', 'healthcare_professional_details.healthcare_professional_id')->where('healthcare_professional.healthcare_professional_id', '=',$hpId)->first();
        
        $hpToLanguages =  DB::table('healthcare_professional_to_languages')->where('healthcare_professional_id','=',$hpId)->get();
        $selectedLanguages = array();
        foreach ($hpToLanguages as $hpToLanguage){
            $selectedLanguages [] = $hpToLanguage->language_id;
        }
        $data['selectedLanguages'] =  $selectedLanguages;
        
        $hpToInsurances =  DB::table('healthcare_professional_to_insurance_companies')->where('healthcare_professional_id','=',$hpId)->get();
        $selectedInsurances = array();
        foreach ($hpToInsurances as $hpToInsurance){
            $selectedInsurances [] = $hpToInsurance->insurance_id;
        }
        $data['selectedInsurances'] =  $selectedInsurances;
        
        $hpToSpecilizations =  DB::table('healthcare_professional_to_specilizations')->where('healthcare_professional_id','=',$hpId)->get();
        $selectedSpecilizations = array();
        foreach ($hpToSpecilizations as $hpToSpecilization){
            $selectedSpecilizations[] = $hpToSpecilization->specilization_id;
        }
        $data['selectedSpecilizations'] =  $selectedSpecilizations;
        
        
        $post_arr           = Input::all();    
          
        if(!empty($post_arr) && $post_arr['form_submit'] == "save"){
            
 

              
            $healthcare_professional_state ='';
            if(isset($post_arr['healthcare_professional_state_select']) && !empty($post_arr['healthcare_professional_state_select'])){
                $healthcare_professional_state      =$post_arr['healthcare_professional_state_select'];
            }

            if(isset($post_arr['healthcare_professional_state_text']) && !empty($post_arr['healthcare_professional_state_text'])){
                $healthcare_professional_state = $post_arr['healthcare_professional_state_text'];
            }

            $validator = Validator::make(
             array(
                 'healthcare_professional_first_name'  => $post_arr['healthcare_professional_first_name'],
                 'healthcare_professional_last_name'  => $post_arr['healthcare_professional_last_name'],
                 'healthcare_professional_phone_code'  => $post_arr['healthcare_professional_phone_code'],
                 'healthcare_professional_phone_number'  => $post_arr['healthcare_professional_phone_number'],
                 'healthcare_professional_zip_code'  => $post_arr['healthcare_professional_zip_code'],
                 'healthcare_professional_country'  => $post_arr['healthcare_professional_country'],
                 'healthcare_professional_state'  => $healthcare_professional_state,
                 'healthcare_professional_city'  => $post_arr['healthcare_professional_city'],
                 'healthcare_professional_fees'  => $post_arr['healthcare_professional_fees'],
               //  'healthcare_professional_dob'  => $post_arr['healthcare_professional_dob'],
                 
             ),
             array(
                 'healthcare_professional_first_name' => 'required',
                 'healthcare_professional_last_name' => 'required',
                 'healthcare_professional_phone_code' => 'required',
                 'healthcare_professional_phone_number' => 'required|max:13',
                 'healthcare_professional_zip_code' => 'required',
                 'healthcare_professional_country' => 'required',
                 'healthcare_professional_state' => 'required',
                 'healthcare_professional_city' => 'required',
                // 'healthcare_professional_dob' => 'required',
                 'healthcare_professional_fees' => 'regex:/^\d{0,8}(\.\d{1,2})?$/'
                 
                 
             )
            );

            if ($validator->fails())
            {
                $messages   = $validator->messages();   
                $err_msg  = '<br />';
                foreach ($messages->all() as $msg) {
                        $err_msg .= '<i>'.$msg.'</i><br />';
                }
                echo json_encode(array('error' => 1, 'err_msg' => $err_msg)); exit;

            } 


            // Healthcare Professional table
            $input_arr1['healthcare_professional_first_name']       = $post_arr['healthcare_professional_first_name'];
            $input_arr1['healthcare_professional_middle_name']      =$post_arr['healthcare_professional_middle_name'];
            $input_arr1['healthcare_professional_last_name']        =$post_arr['healthcare_professional_last_name'];
            $input_arr1['healthcare_professional_phone_code']     =$post_arr['healthcare_professional_phone_code'];
            $input_arr1['healthcare_professional_phone_number']     =$post_arr['healthcare_professional_phone_number'];
            $input_arr1['healthcare_professional_zip_code']         =$post_arr['healthcare_professional_zip_code'];
            $input_arr1['healthcare_professional_introduction']     =$post_arr['healthcare_professional_introduction'];

            $input_arr1['healthcare_professional_country']          =$post_arr['healthcare_professional_country'];
            $input_arr1['healthcare_professional_state']            = $healthcare_professional_state;
            $input_arr1['healthcare_professional_city']             =$post_arr['healthcare_professional_city'];
            $input_arr1['healthcare_designation']                   =$post_arr['healthcare_designation'];
            $input_arr1['healthcare_professional_status']           =1;
            
            if(isset($post_arr['healthcare_professional_dob'])&& $post_arr['healthcare_professional_dob'] !=''){
                $datetime = new DateTime();
                $datetime = $datetime->createFromFormat('m-d-Y', $post_arr['healthcare_professional_dob']);
                $input_arr1['healthcare_professional_dob']              = $datetime->format('Y-m-d');               
            }

            
            
            $input_arr1['healthcare_professional_date_modified'] = date('Y-m-d H:i:s');   
   
            $hpObj->update($input_arr1);
            
            // Healthcare Professional details table
            
            $input_arr2['healthcare_professional_nickname']       = $post_arr['healthcare_professional_nickname'];
            $input_arr2['healthcare_professional_organization']   = $post_arr['healthcare_professional_organization'];
            $input_arr2['healthcare_professional_fees']           = $post_arr['healthcare_professional_fees'];
            $input_arr2['healthcare_professional_profile']        = $post_arr['healthcare_professional_profile'];
            
            if(isset($post_arr['document_image']) && $post_arr['document_image'] !=''){
               $input_arr2['healthcare_professional_image']        = $post_arr['document_image']; 
            }
            if(isset($post_arr['document_biodata']) && $post_arr['document_biodata'] !=''){
               $input_arr2['healthcare_professional_biodata']        = $post_arr['document_biodata']; 
            }
            
            
            
            $hpDetailsTable = DB::table('healthcare_professional_details');
            $hpDetailsObj = DB::table('healthcare_professional_details')->where("healthcare_professional_id","=",$hpId);
            if($hpDetailsObj->get()){               
                $hpDetailsObj->update($input_arr2);
            }else{
                $input_arr2['healthcare_professional_id'] = $hpId;
                $hpDetailsTable->insert($input_arr2);
            }
            
            // healthcare_professional_to_languages table
            if(isset($post_arr['language_id'])){
                $hpTolanguages = DB::table('healthcare_professional_to_languages'); 
                // Delete old languages
                $hpTolanguages->where('healthcare_professional_id','=',$hpId)->delete();

                $languageIds = $post_arr['language_id'];
                foreach ($languageIds as $languageId){
                    if((int)$languageId != 0){
                        $hpTolanguages->insert(array('healthcare_professional_id'=>$hpId,'language_id'=>$languageId));
                    }

                }
            }

            
            // healthcare_professional_to_insurance_companies table
            if(isset($post_arr['insurance_id'])){
                $hpToInsurances = DB::table('healthcare_professional_to_insurance_companies'); 
                // Delete old Insurances
                $hpToInsurances->where('healthcare_professional_id','=',$hpId)->delete();

                $insuranceIds = $post_arr['insurance_id'];
                foreach ($insuranceIds as $insuranceId){
                    if((int)$insuranceId != 0){
                        $hpToInsurances->insert(array('healthcare_professional_id'=>$hpId,'insurance_id'=>$insuranceId));
                    }

                }
            }

            
            // healthcare_professional_to_specilizations
            if(isset($post_arr['specilization_id'])){
                $hpToSpecilizations = DB::table('healthcare_professional_to_specilizations'); 
                // Delete old specilizations
                $hpToSpecilizations->where('healthcare_professional_id','=',$hpId)->delete();

                $specilizationIds = $post_arr['specilization_id'];
                foreach ($specilizationIds as $specilizationId){
                    if((int)$specilizationId != 0){
                        $hpToSpecilizations->insert(array('healthcare_professional_id'=>$hpId,'specilization_id'=>$specilizationId));
                    }

                }
            }

            
            Session::flash('flash_msg','Record saved successfully');
            return json_encode(array('error' => 0)); exit;

         }
         
         $hpObj = DB::table('healthcare_professional')->where("healthcare_professional_id","=",$hpId)->first();
         return View::make('healthcare_professional.editprofile')->with(array('data'=>$data,'country'=>$country,'hpObj'=>$hpObj));
       
    }
    
    
    
    public function anyCasefileview(){
        
        
        if($this->anyChecklogin())
        {
            
            $data = array();
            $data['site_url'] = URL::to('/');

            $hpId = Session::get('hp_id');
            $hpObj = DB::table('healthcare_professional')->where("healthcare_professional_id","=",$hpId)->first();
            $data['hpObj'] = $hpObj;
        

            $post_arr = Input::all();
            $key =$post_arr['key']; 
            //Get HP email ID & Customer Detail ID
            $decreptedKey = base64_decode($key);   
            $keyArr = explode('=',$decreptedKey);
            $casefileToHealthcareId = $keyArr[1];
            
            
            $caseFileToHP =DB::table('casefile_to_healthcare')->where("casefile_to_healthcare_id","=",$casefileToHealthcareId)->first();
            
            if(!$caseFileToHP){
                Session::flash('error_message',"No such record found in the system");
                return Redirect::to('healthcare_professional/dashboard');
            }else{
                $customerDetailId = $caseFileToHP->customer_detail_id;
            }

            //display case file details
            $datareport = (new BaseController)->get_casefile_report($customerDetailId);
            $data['report']=$datareport;

            return View::make('healthcare_professional.view_casereport')->with(array('data'=>$data));
            exit;
            
        }else{
            
            $post_arr = Input::all();
            $key =$post_arr['key']; 
            //Get HP email ID & Customer Detail ID
            $decreptedKey = base64_decode($key);   
            $keyArr = explode('=',$decreptedKey);
            $casefileToHealthcareId = $keyArr[1];

            $caseFileToHP =DB::table('casefile_to_healthcare')->where("casefile_to_healthcare_id","=",$casefileToHealthcareId)->first();
            
            if(!$caseFileToHP){
                 return Redirect::to('healthcare_professional/login');
            }else{
                $assignedHpId = (int)$caseFileToHP->healthcare_professional_id;
                $assignedHpemail = $caseFileToHP->healthcare_professional_email;
                $customerDetailId = $caseFileToHP->customer_detail_id;
            }
            
            // Check Provider already exist
            if($assignedHpemail!= ''){
                $assignedHpObj = DB::table('healthcare_professional')->where("healthcare_professional_email_address","=",$assignedHpemail)->first();
                if(is_object($assignedHpObj)){
                  $assignedHpId =$assignedHpObj->healthcare_professional_id ;
                }
            }
            
            if($assignedHpObj){
                $redirect = "casefileview?key=$key";
                return Redirect::to('healthcare_professional/login/'.$redirect);
            }else{
                //If no such HP is created yet,so  redirect to a  partial signup page
                $redirect = "casefileview?key=$key";
                Session::put('partial_signup_email',$assignedHpemail);
                return Redirect::to('healthcare_professional/partialsignup/'.$redirect);
            }            
            
        }
    
    }
    public function anyConversation($id){
        
        
        if(!$this->anyChecklogin()){
              return Redirect::to("healthcare_professional/login/conversation/$id");   
        } 

            
        $data = array();
        $data['site_url'] = URL::to('/');

        $datareport= array();

        //If some HP is already login    
        $hpId = Session::get('hp_id');
        $hpObj = DB::table('healthcare_professional')->where("healthcare_professional_id","=",$hpId)->first();
        $data['hpObj'] = $hpObj;
        $post_arr = Input::all();

        $casefileToHealthcareId = $id;


        $caseFileToHP =DB::table('casefile_to_healthcare')->where("casefile_to_healthcare_id","=",$casefileToHealthcareId)->first();

        if(!$caseFileToHP){
            Session::flash('error_message',"No such record found in the system");   
            return Redirect::to('healthcare_professional/dashboard');
        }else{
            $customerDetailId = $caseFileToHP->customer_detail_id;
        }

        //display case file details

        $data['casefile_to_healthcare_id']=$casefileToHealthcareId;
        $data['customer_detail_id']=$customerDetailId;

        $hpTemplates = DB::table('healthcare_professional_to_templates')
                ->leftjoin('communication_templates','healthcare_professional_to_templates.communication_template_id','=','communication_templates.communication_template_id')
                ->where("healthcare_professional_to_templates.healthcare_professional_id","=",$hpId)
                ->where("communication_templates.template_status","=",1)
                ->get();
        $data['hpTemplates']= $hpTemplates;
        return View::make('healthcare_professional.conversation')->with(array('data'=>$data,'hpObj'=>$hpObj));
        exit;
    }
    
    
//    public function anyCasefileview(){
//        
//        //View a perticular case file from alink got in mail
//         
//         $data = array();
//         $data['site_url'] = URL::to('/');
//
//         $datareport= array();
//         $post_arr = Input::all();
//
//  
//         $caseFileId = $assignedHpemail = $assignedHpId = '';
//         if(isset($post_arr['key']) && $post_arr['key'] !=''){
//             
//            $key =$post_arr['key']; 
//            //Get HP email ID & Customer Detail ID
//            $decreptedKey = base64_decode($key);   
//            $keyArr = explode('=',$decreptedKey);
//            $caseFileId = $keyArr[1];
//
//            $caseFileToHP =DB::table('casefile_to_healthcare')->where("casefile_to_healthcare_id","=",$caseFileId)->first();
//            
//            if(!$caseFileToHP){
//                 return Redirect::to('healthcare_professional/login');
//            }else{
//                $assignedHpId = (int)$caseFileToHP->healthcare_professional_id;
//                $assignedHpemail = $caseFileToHP->healthcare_professional_email;
//                $customerDetailId = $caseFileToHP->customer_detail_id;
//            }
//         }elseif(isset($post_arr['k']) && $post_arr['k'] !=''){
//             
//            $key =$post_arr['k']; 
//            //Get HP email ID & Customer Detail ID
//            $decreptedKey = base64_decode($key);   
//            $keyArr = explode('=',$decreptedKey);
//            $customerDetailId = $keyArr[1];
//
//            $customerDetail =DB::table('customer_detail')->where("customer_detail_id","=",$customerDetailId)->first();
//            
//            if(!$customerDetail){
//                 return Redirect::to('healthcare_professional/login');
//            }else{
//                $customerDetailId = $customerDetail->customer_detail_id;
//            }
//         }else{
//             return Redirect::to('healthcare_professional/login');
//         }
//         
//         
//         if($assignedHpemail!= ''){
//            $assignedHpObj = DB::table('healthcare_professional')->where("healthcare_professional_email_address","=",$assignedHpemail)->first();
//            if(is_object($assignedHpObj)){
//              $assignedHpId =$assignedHpObj->healthcare_professional_id ;
//            }
//         }
//
//        
//        if($this->anyChecklogin())
//            {
//        //If some HP is already login    
//            $hpId = Session::get('hp_id');
//            $hpObj = DB::table('healthcare_professional')->where("healthcare_professional_id","=",$hpId)->first();
//            
//            
//            if($hpId ==$assignedHpId){
//                 
//                //display case file details
//                $datareport = (new BaseController)->get_casefile_report($customerDetailId);
//                $data['report']=$datareport;
//                $data['casefile_to_healthcare_id']=$caseFileId;
//                $data['customer_detail_id']=$customerDetailId;
//                
//                $hpTemplates = DB::table('communication_templates')
//                        ->where("healthcare_professional_id","=",$hpId)
//                        ->where("status","=",1)
//                        ->get();
//                $data['hpTemplates']= $hpTemplates;
//                return View::make('healthcare_professional.view_casereport')->with(array('data'=>$data,'hpObj'=>$hpObj));
//                exit;
//            }elseif($customerDetailId >0){
//                $datareport = (new BaseController)->get_casefile_report($customerDetailId);
//                $data['report']=$datareport;
////                $data['casefile_to_healthcare_id']=$caseFileId;
//                $data['customer_detail_id']=$customerDetailId;
//                
//                return View::make('healthcare_professional.view_casesearch')->with(array('data'=>$data,'hpObj'=>$hpObj));
//                exit;
//            }else{
//                //This HP has no right to view this case file
//                $data['report']=$datareport;
//                $data['error'] = 'Sorry, You  don\'t have access to this record.';
//                return View::make('healthcare_professional.view_casereport')->with(array('data'=>$data,'hpObj'=>$hpObj));
//                exit;
//            }
//
//        }
//        else{
//            // No HP is logined
//            
//            if($assignedHpObj){
//                $redirect = "casefileview?key=$key";
//                return Redirect::to('healthcare_professional/login/'.$redirect);
//            }else{
//                //If no such HP is created yet,so  redirect to a  partial signup page
//                $redirect = "casefileview?key=$key";
//                Session::put('partial_signup_email',$assignedHpemail);
//                return Redirect::to('healthcare_professional/partialsignup/'.$redirect);
//            }
//        }
//    }
    
    
    
    public function anyCasefileviewfromsearch(){
        
        //Just view a particular case file ,only view , no commenting 
         
         $data = array();
         $data['site_url'] = URL::to('/');

         $datareport= array();
         $post_arr = Input::all();
         $customerDetailId = $post_arr['detail_id'];
         $datareport = (new BaseController)->get_casefile_report($customerDetailId);
         
         $data['report']=$datareport;
                
         return View::make('healthcare_professional.view_casereport_from_search')->with(array('data'=>$data));
    }
    
    public function anySavecasefilecomment(){
        
        //This is a ajax action for saving HP commen t & price , related to a case file
        $post_arr = Input::all();
        if(isset($post_arr['form_submit']) && $post_arr['form_submit'] == 'save'){
            
            $validator = Validator::make(
            array(
                 'introduction'  => $post_arr['introduction'],
                 'healthcare_comment'  => $post_arr['healthcare_comment'],
             ),
            array(
                 'introduction' => 'required',
                 'healthcare_comment' => 'required',
             )
            );
            
            if ($validator->fails())
            {
                $messages   = $validator->messages();   
                $err_msg  = '<br />';
                foreach ($messages->all() as $msg) {
                        $err_msg .= '<i>'.$msg.'</i><br />';
                }
                echo json_encode(array('error' => 1, 'err_msg' => $err_msg)); exit;

            }

            if(isset($post_arr['casefile_to_healthcare_id']) && $post_arr['casefile_to_healthcare_id'] >0){
                $casefileToHealthcareObj = DB::table('casefile_to_healthcare')->where("casefile_to_healthcare_id","=",$post_arr['casefile_to_healthcare_id']);
                
                $customer_detail_id = $casefileToHealthcareObj->first()->customer_detail_id; 
                $healthcare_professional_id = $casefileToHealthcareObj->first()->healthcare_professional_id;
                $customer_id = $casefileToHealthcareObj->first()->customer_id;
                
                $update_arr['regular_amount'] = $regularPrice =$post_arr['regular_amount'];
                $update_arr['currency'] = $currency =$post_arr['currency'];
                $update_arr['discount'] = $reduction=$post_arr['discount'];
                $update_arr['tax'] =$tax=$post_arr['tax'];         
                $update_arr['healthcare_charge'] = $total =$post_arr['healthcare_charge'];
                $update_arr['commented_date'] = date ('Y-m-d H:i:s');
                $casefileToHealthcareObj->update($update_arr);
                
                $customer_detailObj = DB::table('customer_detail')->leftjoin('customers', 'customers.customer_id', '=', 'customer_detail.customer_id')
                            ->where("customer_detail.customer_detail_id","=",$casefileToHealthcareObj->first()->customer_detail_id)->first();
                
                $email_id = $customer_detailObj->customer_email_id;
            }
            
//            elseif(isset($post_arr['customer_detail_id']) && $post_arr['customer_detail_id'] >0){
//                $customer_detail_id = $post_arr['customer_detail_id'];
//                $customer_detailObj = DB::table('customer_detail')->leftjoin('customers', 'customers.customer_id', '=', 'customer_detail.customer_id')
//                            ->where("customer_detail.customer_detail_id","=",$post_arr['customer_detail_id'])->first();
//                
//                $casefileToHealthcareObj = DB::table('casefile_to_healthcare')->where("healthcare_professional_id","=",$post_arr['healthcare_professional_id'])->where("customer_detail_id","=",$post_arr['customer_detail_id'])->first();
//                
//                $email_id = $customer_detailObj->customer_email_id;
//                $customer_id = $customer_detailObj->customer_id;
//                $healthcare_professional_id = $post_arr['healthcare_professional_id'];
//                
//                if(count($casefileToHealthcareObj)>0){
// 
//                    $update_arr['regular_amount'] = $post_arr['regular_amount'];
//                    $update_arr['currency'] = $post_arr['currency'];
//                    $update_arr['discount'] = $post_arr['discount'];
//                    $update_arr['tax'] = $post_arr['tax'];         
//                    $update_arr['healthcare_charge'] = $post_arr['healthcare_charge'];
//                    $update_arr['commented_date'] = date ('Y-m-d H:i:s');
//                    $casefileToHealthcareObj->update($update_arr);
//                    
//                }else{
//                    
//                    $healthcare_Obj = DB::table('healthcare_professional')->where("healthcare_professional_id","=",$post_arr['healthcare_professional_id'])->first();
//                    $insert_data = array();
//                    $insert_data['customer_id'] = $customer_detailObj->customer_id;
//                    $insert_data['customer_detail_id'] = $post_arr['customer_detail_id'];
//                    $insert_data['healthcare_professional_id'] = $post_arr['healthcare_professional_id'];
//                    $insert_data['healthcare_professional_email'] = $healthcare_Obj->healthcare_professional_email_address;
//                    $insert_data['date'] = date('Y-m-d H:i:s');     
//                    
//
//                    $insert_data['regular_amount'] = $post_arr['regular_amount'];
//                    $insert_data['currency'] = $post_arr['currency'];
//                    $insert_data['discount'] = $post_arr['discount'];
//                    $insert_data['tax'] = $post_arr['tax'];         
//                    $insert_data['healthcare_charge'] = $post_arr['healthcare_charge'];
//                    $insert_data['commented_date'] = date ('Y-m-d H:i:s'); 
//                    
//                    $case_file_id = DB::table('casefile_to_healthcare')->insertGetId($insert_data);
//                    
//                    
//                }
//            }
            
           
            // Insert an entry into casefile conversation table
            $conversationArr['customer_detail_id'] = $customer_detail_id;
            $conversationArr['healthcare_professional_id'] = $healthcare_professional_id;
            $conversationArr['customer_id'] = $customer_id;

            if(isset($post_arr['healthcare_charge'])&& $post_arr['healthcare_charge'] !=''){
                // Adding the price details into the comment
                $healthcareComment = $post_arr['healthcare_comment'];
                $healthcareComment.="<br/>"; 
                $healthcareComment.="<p><b>Price Details</b></p>";
                $healthcareComment.="<p>Regular Price : $regularPrice&nbsp;$currency</p>";
                $healthcareComment.="<p>Reduction (%) : $reduction%</p>";
                $healthcareComment.="<p>Tax (%): $tax </p>";
                $healthcareComment.="<p>Total : $total &nbsp; $currency</p>";
                $conversationArr['healthcare_comment'] = $healthcareComment;

            }else{
               $conversationArr['healthcare_comment'] = $post_arr['healthcare_comment'];
            }
                  
            DB::table('casefile_conversations')->insert($conversationArr);
            
            
            
            /* Start Mail  Sending */
            
            // conversation display link , for customer
             $link = asset("customer/conversations/$customer_detail_id/$healthcare_professional_id");

            // Get customer nick Name;
             $customerNickName = $customer_detailObj->customer_nickname;
            
      
            // Get Healthcare  Name;
            $hpName="" ;
            $hpObj = DB::table('healthcare_professional')->where("healthcare_professional_id","=",$healthcare_professional_id);
            
            if(is_object($hpObj)){
                $hpObj= $hpObj->first();
                $hpName = $hpObj->healthcare_professional_first_name;
                if($hpObj->healthcare_professional_middle_name)
                    $hpName .= " ".$hpObj->healthcare_professional_middle_name;
                if($hpObj->healthcare_professional_last_name)
                    $hpName .= " ".$hpObj->healthcare_professional_last_name;       
            }
      
            
            $thingsToPassTemplate["hpName"] = $hpName;       
            $thingsToPassTemplate["introduction"] = $post_arr['introduction'];
            $thingsToPassTemplate["treatmentPlan"] = $post_arr['healthcare_comment'];
            $thingsToPassTemplate["currency"] = $currency;
            $thingsToPassTemplate["regularPrice"] = $regularPrice;
            $thingsToPassTemplate["reduction"] = $reduction;
            $thingsToPassTemplate["tax"] = $tax;
            $thingsToPassTemplate["total"] = $total;
            $thingsToPassTemplate["link"] = $link;

                          
            $templateLocation = "healthcare_professional.mail_template_provider_comment_on_casefile";

            $thingsToPassTemplate["site_link"] = URL::to('/'); 
            $thingsToPassTemplate["site_start_link"] = URL::to('/')."/home/basic";      
            $thingsToPassTemplate["receipent_name"] = $customerNickName;        


            $subject = "Treatment plan for your case file"; 

            $receipents = $email_id;

            // Send mail
            $result= (new BaseController)->send_mail(
                    $templateLocation,
                    $thingsToPassTemplate,
                    $subject,
                    $receipents
            );
                           
                        
            if($result){
                return json_encode(array('error' => 0)); exit;
            }else{
               return json_encode(array('error' => 1)); exit; 
            }
            
           /* End Mail  Sending */
        }
        

    }
    
    public function anySendcasefilepdf(){
        
        //This is a ajax action for sending case file PDF
        $post_arr = Input::all();
        if(isset($post_arr['form_submit']) && $post_arr['form_submit'] == 'save'){
            
            $validator = Validator::make(
            array(
                 'forward_email'  => $post_arr['forward_email'],

             ),
            array(
                 'forward_email' => 'required|email',
             )
            );
            
            if ($validator->fails())
            {
                $messages   = $validator->messages();   
                $err_msg  = '<br />';
                foreach ($messages->all() as $msg) {
                        $err_msg .= '<i>'.$msg.'</i><br />';
                }
                echo json_encode(array('error' => 1, 'err_msg' => $err_msg)); exit;

            }
            
            $customerDetailId = $post_arr['customer_detail_id'];
            $customerDetailObj = DB::table('customer_detail')->where("customer_detail_id","=",$customerDetailId)->first();

            $pdfFile ="DB".$customerDetailObj->customer_code."-".$customerDetailObj->customer_no.".pdf"; 
            $pdfFilePath = asset("pdfreports/$pdfFile");

            $email = $post_arr['forward_email'];
            
            // Send Mail               
            $templateLocation = "healthcare_professional.mail_template_casefile_pdf";

            $thingsToPassTemplate["site_link"] = URL::to('/'); 
            $thingsToPassTemplate["site_start_link"] = URL::to('/')."/home/basic";              

            $subject = "A forwarded case file"; 

            $receipents = $email;
            $attachments = array();
            $attachments[0]=$pdfFilePath;

            // Send mail
            $result= (new BaseController)->send_mail(
                    $templateLocation,
                    $thingsToPassTemplate,
                    $subject,
                    $receipents,
                    $attachments
            );            

            if(!$result){
              return json_encode(array('error' => 1,'err_msg'=>'Mail sending Failed.')); exit;
            }else{
             return json_encode(array('error' => 0)); exit; 
            } 
        }
        
    }
            
    public function anyRemovestoredimage(){
        
        //Its Ajax section 
        // Remove already saved image
        if(!$this->anyChecklogin()){
              return Redirect::to('healthcare_professional/login/editprofile');   
          } 
        $hpId = Session::get('hp_id'); 
        $hp = DB::table('healthcare_professional')->leftjoin('healthcare_professional_details', 'healthcare_professional.healthcare_professional_id', '=', 'healthcare_professional_details.healthcare_professional_id')->where('healthcare_professional.healthcare_professional_id', '=',$hpId)->first();

        unlink("uploads/healthcare_professional/thumbnail/".$hp->healthcare_professional_image);
        unlink("uploads/healthcare_professional/".$hp->healthcare_professional_image);

        $hpDetailsObj = DB::table('healthcare_professional_details')->where("healthcare_professional_id","=",$hpId);
        $input_arr['healthcare_professional_image'] = '';
        $hpDetailsObj->update($input_arr);
        Session::flash('flash_msg','Image Deleted Successfully');
        return json_encode(array('error' => 0)); exit;
      
      
    }
    
    public function anyRemoveimage(){
        
        //Its Ajax section 
        // Remove just uploaded image
            
        if(!$this->anyChecklogin()){
              return Redirect::to('healthcare_professional/login/editprofile');   
        } 
        $post_arr           = Input::all();       

        unlink("uploads/healthcare_professional/thumbnail/".$post_arr['document_image']);
        unlink("uploads/healthcare_professional/".$post_arr['document_image']);

        return json_encode(array('error' => 0)); exit;
      
      
    }

    public function anyRemovestoredbiodata(){
        
        //Its Ajax section 
        // Remove already saved biodata 
        if(!$this->anyChecklogin()){
              return Redirect::to('healthcare_professional/login/editprofile');   
          } 
        $hpId = Session::get('hp_id'); 
        $hp = DB::table('healthcare_professional')->leftjoin('healthcare_professional_details', 'healthcare_professional.healthcare_professional_id', '=', 'healthcare_professional_details.healthcare_professional_id')->where('healthcare_professional.healthcare_professional_id', '=',$hpId)->first();

        unlink("uploads/healthcare_professional/".$hp->healthcare_professional_biodata);

        $hpDetailsObj = DB::table('healthcare_professional_details')->where("healthcare_professional_id","=",$hpId);
        $input_arr['healthcare_professional_biodata'] = '';
        $hpDetailsObj->update($input_arr);
        Session::flash('flash_msg','Biodata Deleted Successfully');
        return json_encode(array('error' => 0)); exit;
      
      
    }    
    
    public function anyRemovebiodata(){
       
        //Its Ajax section 
        // Remove just uploaded biodata
        
        if(!$this->anyChecklogin()){
              return Redirect::to('healthcare_professional/login/editprofile');   
        } 
        $post_arr           = Input::all();       

        unlink("uploads/healthcare_professional/".$post_arr['document_biodata']);

        return json_encode(array('error' => 0)); exit;
      
      
    }
        
    public function anyListing($action=''){
        
        // Listing of HP
        $data = array();
        $data['site_url'] = URL::to('/');
        
   
        switch($action){
            
        case "search":
            
            $postArr =Input::all();
            $specilizationIds = array();
            $insuranceIds = array();
            $searchWords = array();
            
            if(isset($postArr['specilization_id']) && count($postArr['specilization_id'])>0){
                $specilizationIds = $postArr['specilization_id'];
                if(($key = array_search(0, $specilizationIds)) !== false) {
                    unset($specilizationIds[$key]);
                }  
            }
            if(isset($postArr['insurance_id']) && count($postArr['insurance_id'])>0){
                $insuranceIds = $postArr['insurance_id'];
                if(($key = array_search(0, $insuranceIds)) !== false) {
                    unset($insuranceIds[$key]);
                }  
            }            

//            echo '<pre>';print_r($specilizationIds);
//            echo '<pre>';print_r($insuranceIds);die("yes");

            $hpTable =  DB::table('healthcare_professional AS HP')
                        ->leftjoin('healthcare_professional_details AS HPD','HP.healthcare_professional_id', '=', 'HPD.healthcare_professional_id')
                        ->leftjoin('country AS C', 'HP.healthcare_professional_country', '=', 'C.country_id')
                        ->leftjoin('healthcare_professional_to_insurance_companies AS HPIC', 'HP.healthcare_professional_id', '=', 'HPIC.healthcare_professional_id')
                        ->leftjoin('insurance_companies AS IC', 'HPIC.insurance_id', '=', 'IC.insurance_id')
                        ->leftjoin('healthcare_professional_to_specilizations AS HPS', 'HP.healthcare_professional_id', '=', 'HPS.healthcare_professional_id')
                        ->leftjoin('specilizations AS S', 'HPS.specilization_id', '=', 'S.specilization_id');
                    
            
            if(isset($postArr['healthcare_professional_country']) && $postArr['healthcare_professional_country'] !=''){
                $hpTable->where('HP.healthcare_professional_country','=',(int)$postArr['healthcare_professional_country']);
            }
            
            if(isset($postArr['healthcare_professional_state_select']) && $postArr['healthcare_professional_state_select'] !=''){
                $hpTable->where('HP.healthcare_professional_state','=',$postArr['healthcare_professional_state_select']);
                
            }
            
            if(isset($postArr['healthcare_professional_state_text']) && $postArr['healthcare_professional_state_text'] !=''){
                $hpTable->Where('HP.healthcare_professional_state', 'like', '%' . $postArr['healthcare_professional_state_text'] . '%');
                
            }
            if(isset($postArr['healthcare_professional_city']) && $postArr['healthcare_professional_city'] !=''){
                $hpTable->Where('HP.healthcare_professional_city', 'like', '%' . $postArr['healthcare_professional_city'] . '%');
                
            }
            
            if(isset($postArr['healthcare_designation']) && $postArr['healthcare_designation'] !=''){
               $hpTable->Where('HP.healthcare_designation', 'like', '%' . $postArr['healthcare_designation'] . '%'); 
            }
            
            if(isset($postArr['healthcare_professional_fees']) && $postArr['healthcare_professional_fees'] !=''){
                 $hpTable->where('HPD.healthcare_professional_fees','=',(int)$postArr['healthcare_professional_fees']);
                
            }
            if(isset($postArr['healthcare_professional_organization']) && $postArr['healthcare_professional_organization'] !=''){
                $hpTable->Where('HPD.healthcare_professional_organization', 'like', '%' . $postArr['healthcare_professional_organization'] . '%'); 
            }
            
            if(count($specilizationIds)>0){
                $hpTable->whereIn('HPS.specilization_id',$specilizationIds);               
            }
            
            if(count($insuranceIds)>0){
                $hpTable->whereIn('HPIC.insurance_id',$insuranceIds);                 
            }            
            
            if(isset($postArr['search_words']) && $postArr['search_words'] !=''){
                $searchWords =  explode(",",$postArr['search_words']);
                
                
                   $hpTable->where(
                        function($query)use ($searchWords){
                            foreach ($searchWords as $searchWord){
                            $query->orWhere('HPD.healthcare_professional_biodata', 'like', '%' . $searchWord . '%');
                            }
                            foreach ($searchWords as $searchWord){
                                $query->orWhere('HPD.healthcare_professional_profile', 'like', '%' . $searchWord . '%');
                            }
                            
                        }
                    );
                
                
            } 
            $hpTable->where("HP.healthcare_professional_status","=",1);
             //$hpTable->groupby("HP.healthcare_professional_id");
             $hpTable->where("HP.is_deleted","=",0);
             $hpTable->select(
                    'HP.*',
                    'HPD.healthcare_professional_profile','HPD.healthcare_professional_biodata','HPD.healthcare_professional_nickname',
                    'HPD.healthcare_professional_organization','HPD.healthcare_professional_fees',
                    'C.*'
                     );
             $hpTable->groupby('HP.healthcare_professional_id');
            $hpObjects = $hpTable->get();  
            
            $data['hpObjects'] = $hpObjects;    
            return View::make('healthcare_professional.listing_ajax')->with(array('data'=>$data));
            exit;
            
        default:
            $countries = DB::table('country')->orderBy('country_id', 'ASC')->get();
            $data['countries'] =$countries;  

            $specilizations = DB::table('specilizations')->get();
            $data['specilizations'] =$specilizations;

            $insuranceCompanies = DB::table('insurance_companies')->get();
            $data['insuranceCompanies'] =$insuranceCompanies;


            $hpObjects = DB::table('healthcare_professional AS HP')
                    ->leftjoin('healthcare_professional_details AS HPD','HP.healthcare_professional_id', '=', 'HPD.healthcare_professional_id')
                    ->leftjoin('country AS C', 'HP.healthcare_professional_country', '=', 'C.country_id')
                    ->where("HP.healthcare_professional_status","=",1)
                    ->where("HP.is_deleted","=",0)
                    ->select(
                    'HP.*',
                    'HPD.healthcare_professional_profile','HPD.healthcare_professional_biodata','HPD.healthcare_professional_nickname',
                    'HPD.healthcare_professional_organization','HPD.healthcare_professional_fees',
                    'C.*'
                     )
                    ->get();
            $data['hpObjects'] = $hpObjects;
            return View::make('healthcare_professional.listing')->with(array('data'=>$data));
            exit; 
        }    
                
        
 
      
      
    } 
    
    
    public function anyDetails($hpId){
        
        $hpId = (int)$hpId;
        // Listing of Counselors
        $data = array();
        $data['site_url'] = URL::to('/');
        $hpObject = DB::table('healthcare_professional')
                ->leftjoin('healthcare_professional_details','healthcare_professional.healthcare_professional_id', '=', 'healthcare_professional_details.healthcare_professional_id')
                ->leftjoin('country', 'healthcare_professional.healthcare_professional_country', '=', 'country.country_id')
                ->where("healthcare_professional.healthcare_professional_status","!=",0)
                ->where("healthcare_professional.healthcare_professional_id","=",$hpId) 
                ->where("healthcare_professional.is_deleted","=",0) 
                ->first();
        
        if(!$hpObject){
            Session::flash('flash_msg','No such Provider exist.Or account is deleted !');
            return Redirect::to('healthcare_professional/listing');   
        }
        
        // Get Languages
        $langArr = array();
        $langNameArr = array();
        $hpLangObjs = DB::table('healthcare_professional_to_languages')->where('healthcare_professional_id','=',$hpId)->get();
        foreach($hpLangObjs as $hpLangObj){
            $langArr[] = $hpLangObj->language_id;
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
        $hpSpecilizationObjs = DB::table('healthcare_professional_to_specilizations')->where('healthcare_professional_id','=',$hpId)->get();
        foreach($hpSpecilizationObjs as $hpSpecilizationObj){
            $specilizationArr[] = $hpSpecilizationObj->specilization_id;
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
                 

        // Get Insurances
        $insuranceArr = array();
        $insuranceNameArr = array();
        $hpInsuranceObjs = DB::table('healthcare_professional_to_insurance_companies')->where('healthcare_professional_id','=',$hpId)->get();
        foreach($hpInsuranceObjs as $hpInsuranceObj){
            $insuranceArr[] = $hpInsuranceObj->	insurance_id;
        }
        $insuranceArr = array_unique($insuranceArr);
        if(count($insuranceArr)>0){
            $insuranceObjs = DB::table('insurance_companies')->whereIn('insurance_id',$insuranceArr)->where('insurance_status','=',1)->get();
            if($insuranceObjs){
                foreach($insuranceObjs as $insuranceObj){
                    $insuranceNameArr[] =$insuranceObj->insurance_name;
                }
            }
        }        
        
        $data['languages'] = $langNameArr;
        $data['specilizations'] = $specilizationNameArr;
        $data['insurances'] = $insuranceNameArr;
        $data['hpObject'] = $hpObject;
        return View::make('healthcare_professional.details')->with(array('data'=>$data));
        exit;
 
      
      
    }
    
    public function anyAssignedcases(){
        
        if(!$this->anyChecklogin()){
              return Redirect::to('healthcare_professional/login');   
        }         
        
        $hpObj = DB::table('healthcare_professional')->where('healthcare_professional_id','=',Session::get('hp_id'))->first();
        $hpEmail=$hpObj->healthcare_professional_email_address;

        
        // Listing of assigned cases
        $data = array();
        $data['site_url'] = URL::to('/');
       // $hpEmail
        $caseFileObjs = DB::table('casefile_to_healthcare')
                ->leftjoin('customer_detail','casefile_to_healthcare.customer_detail_id', '=', 'customer_detail.customer_detail_id')
                ->leftjoin('country', 'customer_detail.country_id', '=', 'country.country_id')
                ->where("casefile_to_healthcare.healthcare_professional_email","=",$hpEmail)
                ->where("customer_detail.is_casefile","=",1)
                ->where("customer_detail.customer_status","=",1)
                ->groupby("casefile_to_healthcare.customer_detail_id")
                ->orderby("casefile_to_healthcare.casefile_to_healthcare_id","DESC")
                ->get();
        $data['caseFileObjs'] = $caseFileObjs;
        return View::make('healthcare_professional.assignedcases')->with(array('hpObj'=>$hpObj,'data'=>$data));
        exit;
 
      
      
    }     
    public function anySearchcases(){
        
        if(!$this->anyChecklogin()){
              return Redirect::to('healthcare_professional/login');   
        }         
        $country = array();
   
        $countries = DB::table('country')->orderBy('country_id', 'ASC')->select('country_id','countryname')->get();
        if(count($countries)>0){$y=0;
            foreach($countries as $cntry){
                $country[$y]['country_id'] = $cntry->country_id;
                $country[$y]['countryname'] = $cntry->countryname;
                $y++;
            }
        }
        $hpObj = DB::table('healthcare_professional')->where('healthcare_professional_id','=',Session::get('hp_id'))->first();
        $hpEmail=$hpObj->healthcare_professional_email_address;

        
        // Listing of assigned cases
        $data = array();
        $data['site_url'] = URL::to('/');
       // $hpEmail
        $caseFileObjs = DB::table('casefile_to_healthcare')
                ->leftjoin('customer_detail','casefile_to_healthcare.customer_detail_id', '=', 'customer_detail.customer_detail_id')
                ->leftjoin('country', 'customer_detail.country_id', '=', 'country.country_id')
                ->where("casefile_to_healthcare.healthcare_professional_email","=",$hpEmail)
                ->where("customer_detail.is_casefile","=",1)
                ->where("customer_detail.customer_status","=",1)
                ->groupby("casefile_to_healthcare.customer_detail_id")
                ->get();
        $data['caseFileObjs'] = $caseFileObjs;
        $post_arr           = Input::all();    
        $result_symptom = array();
        $sql = "SELECT s . * , (SELECT ss.symptom_name FROM `symptoms` ss WHERE ss.symptom_id = s.parent_id) AS parentname, st.symptom_id AS subsymptom_id, st.symptom_name AS subsymptom_name FROM `symptoms` AS s LEFT JOIN `symptoms` st ON ( st.parent_id = s.symptom_id ) ";
        $symptoms = DB::select($sql);
            
        if(count($symptoms)>0){
            $symptom_idarr = $subsymptom_idarr = array();
            foreach($symptoms as $symptom){ 
                if($symptom->subsymptom_id > 0){
                         $symptom_data[] = array(
                        'symptom_name' => ucfirst($symptom->symptom_name).' - '.$symptom->subsymptom_name
                        );                           
                        $symptom_idarr[] = $symptom->symptom_id;
                }else{
                    if(!in_array($symptom->symptom_id,$symptom_idarr)){
                        $symptom_data[] = array(
                            'symptom_name' => ucfirst($symptom->parentname).' - '.$symptom->symptom_name
                            );
                        $symptom_idarr[] = $symptom->subsymptom_id;
                    }
                }
            }
            $result_symptom = $symptom_data;
        }
        return View::make('healthcare_professional.searchcase')->with(array('hpObj'=>$hpObj,'country'=>$country,'symptom_arr'=>$result_symptom,'data'=>$data));
        exit;
 
      
      
    }  
    public function anyAjaxsearchcaselisting(){
        
        if(!$this->anyChecklogin()){
              return Redirect::to('healthcare_professional/login');   
        }         
        $country = array();
   
        $countries = DB::table('country')->orderBy('country_id', 'ASC')->select('country_id','countryname')->get();
        if(count($countries)>0){$y=0;
            foreach($countries as $cntry){
                $country[$y]['country_id'] = $cntry->country_id;
                $country[$y]['countryname'] = $cntry->countryname;
                $y++;
            }
        }
        $hpObj = DB::table('healthcare_professional')->where('healthcare_professional_id','=',Session::get('hp_id'))->first();
        $hpEmail=$hpObj->healthcare_professional_email_address;

        
        $data = array();
        $data['site_url'] = URL::to('/');
     
      
        $post_arr           = Input::all();    
        
        $post_arr['tags'] =''; //for temporary adjustment
        
        if(!empty($post_arr) && $post_arr['form_submit'] == "search"){
            $healthcare_professional_state ='';
            if(isset($post_arr['healthcare_professional_state_select']) && !empty($post_arr['healthcare_professional_state_select'])){
                $healthcare_professional_state      =$post_arr['healthcare_professional_state_select'];
            }

            if(isset($post_arr['healthcare_professional_state_text']) && !empty($post_arr['healthcare_professional_state_text'])){
                $healthcare_professional_state = $post_arr['healthcare_professional_state_text'];
            }

            $sql = "SELECT * FROM `customer_detail`  ";
            if(($post_arr['customer_sex']!='' || $post_arr['customer_city']!='' || $post_arr['healthcare_professional_country']!='' || $healthcare_professional_state !='') && $post_arr['tags']=='')
                $sql = $sql." Where";
            if($post_arr['tags']!='')
                $sql = $sql." LEFT JOIN customer_symptoms ON ( `customer_symptoms`.detail_id = `customer_detail`.customer_detail_id ) Where";
            if($post_arr['customer_city']!='')
            $sql = $sql." customer_city like '%".  trim($post_arr['customer_city'])."%' and ";
            if($post_arr['healthcare_professional_country']!='')
            $sql = $sql." country_id = ".trim($post_arr['healthcare_professional_country'])." and ";
            if($healthcare_professional_state !='')
            $sql = $sql." customer_state like '%".  trim($healthcare_professional_state)."%' and ";
            if($post_arr['customer_sex']!='')
            $sql = $sql." customer_sex='".  trim($post_arr['customer_sex'])."' and ";
            if(strlen($sql)>35 && $post_arr['tags']=='')
                $sql = substr($sql,0,-4);
            if($post_arr['tags']!=''){
                $sql_tag ="";
                $tags = explode(",",$post_arr['tags']);
                if(count($tags)>0){
                    foreach($tags as $tag){
                        if($tag != ''){
                            $sql_tag  .= " `customer_symptoms`.symptom_name LIKE '%".$tag."%' OR";
                        }
                    }
                }
                $sql = $sql.substr($sql_tag,0,-3)." GROUP BY `customer_detail`.customer_detail_id";
            }
            $customers = DB::select($sql);
            
            if(count($customers)>0){
                $data['caseFileObjs'] = $customers;
            }
        }
        return View::make('healthcare_professional.ajaxsearchcaselisting')->with(array('hpObj'=>$hpObj,'country'=>$country,'data'=>$data));
        exit;
 
      
    }
    
    public function anyAjaxconversationlisting($customerDetailId){
        $conversations = DB::table('casefile_conversations')
                    ->where('customer_detail_id', '=', $customerDetailId)
                    ->where('healthcare_professional_id', '=', Session::get('hp_id'))
                    ->orderby("date","DESC")
                    ->get();  
        return View::make('healthcare_professional.ajaxconversationlisting')->with(array('conversations'=>$conversations));
        exit;
    }

    public function anyAjaxtemplate($templateId){
        $template = DB::table('communication_templates')
                    ->where('communication_template_id', '=', $templateId)
                    ->first();
        return json_encode(
                array(
                    'error' => 0, 
                    'template_title' => $template->template_title,
                    'template_body' => $template->template_text
                )
            ); 
        exit;
    }    
    
    public function anyLogout(){
        session_destroy();
        Session::flush(); 
        return Redirect::to('healthcare_professional'); 
    }
    
    public function anyChecklogin(){
        
        // Check whether customer has logined or not
        if(isset($_SESSION['hp_id']) && $_SESSION['hp_id'] >0){
            return true;
        }else{
            return false;
        }
        
    }      
}
