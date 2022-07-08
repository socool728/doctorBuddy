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
//use Vsmoraes\Pdf\Pdf;

class HealthcareprofessionalController extends Controller {

        //  show login page for admin   
    public function getIndex($flag='')    
    {
        if(Session::get('hp_id')==''){
            return Redirect::action('HealthcareprofessionalController@anyLogin',array());
        }else{
            return Redirect::action('HealthcareprofessionalController@anyDashboard',array());
        }
    }
    public function anyRegister(){
        session_start();
        $reg_data = array();
        $country = $state = array();
   
            $countries = DB::table('country')->orderBy('status', 'DESC')->orderBy('country_id', 'ASC')->select('country_id','countryname')->get();
            if(count($countries)>0){$y=0;
                foreach($countries as $cntry){
                    $country[$y]['country_id'] = $cntry->country_id;
                    $country[$y]['countryname'] = $cntry->countryname;
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
                    $err_msg .= '<i>Validation code does not match!</i><br />';
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
                    'healthcare_professional_last_name' => 'required',
                    'healthcare_professional_phone_number' => 'required',
                    'healthcare_professional_zip_code' => 'required',
                    'healthcare_professional_country' => 'required',
                    'healthcare_professional_state' => 'required',
                    'healthcare_professional_city' => 'required',
                     'healthcare_professional_password' => 'required|min:6' ,
                     'healthcare_professional_password2' => 'required|same:healthcare_professional_password',
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
              

              
                $insert_arr['healthcare_professional_first_name']       = $post_arr['healthcare_professional_first_name'];
                $insert_arr['healthcare_professional_middle_name']      =$post_arr['healthcare_professional_middle_name'];
                $insert_arr['healthcare_professional_last_name']        =$post_arr['healthcare_professional_last_name'];
                $insert_arr['healthcare_professional_email_address']    =$post_arr['healthcare_professional_email_address'];
                $insert_arr['healthcare_professional_phone_number']     =$post_arr['healthcare_professional_phone_number'];
                
                $insert_arr['healthcare_professional_country']          =$post_arr['healthcare_professional_country'];

                $insert_arr['healthcare_professional_state']            = $healthcare_professional_state;
                
                $insert_arr['healthcare_professional_city']              =$post_arr['healthcare_professional_city'];
                
                $insert_arr['healthcare_professional_zip_code']         =$post_arr['healthcare_professional_zip_code'];
                $insert_arr['healthcare_professional_password']         =(new BaseController)->encrypt_decrypt(trim($post_arr['healthcare_professional_password']));
                
                $insert_arr['healthcare_professional_date_created'] = date('Y-m-d');
                $insert_arr['healthcare_professional_date_modified'] = date('Y-m-d');   
                
                

             
              
              $hpId = DB::table('healthcare_professional')->insertGetId($insert_arr);
              
              if($hpId){
                 $email = $post_arr['healthcare_professional_email_address']; 
                 $name = $post_arr['healthcare_professional_first_name'];
                 if(isset($post_arr['healthcare_professional_middle_name']) && !empty($post_arr['healthcare_professional_middle_name'])){
                     $name .= " ".$post_arr['healthcare_professional_middle_name'];
                 }
                 
                 $name .= " ".$post_arr['healthcare_professional_last_name'];
                 
                 $this->sendVerifyMail($hpId,$email,$name);
                  
                echo json_encode(array('error' => 0)); exit;
                 
              }
               
              echo json_encode(array('error' => 1,'err_msg'=>'Something went wrong, please try again.')); exit;
         }
            
         return View::make('healthcare_professional.register')->with(array('reg_data'=>$reg_data,'country'=>$country,'state'=>$state));
       
    }
    
    public function anyLogin($redirect=''){
     
        
        // Already Logined
        if(Session::get('hp_id')!= ''){
           
            if ($redirect != ''){
                return Redirect::to("healthcare_professional/$redirect");
            }else {
                return Redirect::to("healthcare_professional/dashboard");
            }
        } 
        

        $data['redirect'] = $redirect;
        $data['site_url'] = URL::to('/');
        
        $post = Input::all();
        if(isset($post['user_email_id']) && $post['user_email_id'] != ''){
            $hp = DB::table('healthcare_professional')->where('healthcare_professional_email_address', '=', $post['user_email_id'])->where('healthcare_professional_password', '=', (new BaseController)->encrypt_decrypt($post['user_password']))->where('healthcare_professional_status','=', 1)->first();   
            if(count($hp)>0){           
                Session::put('hp_id',$hp->healthcare_professional_id);
                return json_encode(array('error' => 0, 'redirect'=>$redirect)); exit;
            }else{
                $hp = DB::table('healthcare_professional')->where('healthcare_professional_email_address', '=', $post['user_email_id'])->where('healthcare_professional_password', '=', (new BaseController)->encrypt_decrypt($post['user_password']))->where('healthcare_professional_status','=', 0)->first();   
                if(count($hp)>0){           
                    return json_encode(array('error' => 1,'err_msg'=>'Your account is disabled.Please try after some time')); exit;
                }
                return json_encode(array('error' => 1,'err_msg'=>'Invalid Username or Password.')); exit;
            }
        }    
        return View::make('healthcare_professional.login')->with(array('data'=>$data));
    }
    
    public function anyDashboard(){

        if(!Session::get('hp_id')){
            return Redirect::to('healthcare_professional/login/dashboard');   
        } 
        
        $hpId = Session::get('hp_id');
        $data['hp'] =  DB::table('healthcare_professional')->where('healthcare_professional_id', '=', $hpId)->first();
        return View::make('healthcare_professional.dashboard')->with(array('data'=>$data));
        
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
                  $update_data['healthcare_professional_status'] = 1;
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
        
        if(!Session::get('hp_id')){
            return Redirect::to('healthcare_professional/login');   
        } 
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
                
                
                $subject = "Forgot Password-(Healthcare Professional)-Doctorbuddy.com";
                $site_link = URL::to('/');
                $body = View::make('healthcare_professional.mail_template_forgot_password')->with(array("name"=>$name,"rand_pwd"=>$rand_pwd,"site_link"=>$site_link));                 
                $result = (new BaseController)->mail($email,$subject,$body);
                if($result){
                    echo json_encode(array('error' => 0,'msg'=>'A new password has been sent to your email address')); exit;
                }else{
                    echo json_encode(array('error' => 1,'err_msg'=>'Some error occured.Please try after some time')); exit;
                }
            }else{
                 echo json_encode(array('error' => 1,'err_msg'=>'Email address is not exist in our records')); exit;
            }
        }
        return View::make('healthcare_professional.forgotpassword');
    }
    
    public function anyChangepassword(){
        
        if(!Session::get('hp_id')){
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
                     'healthcare_professional_password' => 'required|min:6' ,
                     'healthcare_professional_password2' => 'required|same:healthcare_professional_password',
                 )
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

                 return json_encode(array('error' => 0)); exit;

             } 

         }else{
             return View::make('healthcare_professional.changepassword')->with(array("data"=>$data)); 
         }
       
    }
    
    public function anyEditprofile(){
        
        if(!Session::get('hp_id')){
            return Redirect::to('healthcare_professional/login/editprofile');   
        } 
        
        $data['site_url'] = URL::to('/');
        $hpId = Session::get('hp_id');
        
        $country = array();
   
        $countries = DB::table('country')->orderBy('status', 'DESC')->orderBy('country_id', 'ASC')->select('country_id','countryname')->get();
        if(count($countries)>0){$y=0;
            foreach($countries as $cntry){
                $country[$y]['country_id'] = $cntry->country_id;
                $country[$y]['countryname'] = $cntry->countryname;
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
                 'healthcare_professional_phone_number'  => $post_arr['healthcare_professional_phone_number'],
                 'healthcare_professional_zip_code'  => $post_arr['healthcare_professional_zip_code'],
                 'healthcare_professional_country'  => $post_arr['healthcare_professional_country'],
                 'healthcare_professional_state'  => $healthcare_professional_state,
                 'healthcare_professional_city'  => $post_arr['healthcare_professional_city'],
                 'healthcare_professional_fees'  => $post_arr['healthcare_professional_fees'],
                 'healthcare_professional_dob'  => $post_arr['healthcare_professional_dob'],
                 
             ),
             array(
                 'healthcare_professional_first_name' => 'required',
                 'healthcare_professional_last_name' => 'required',
                 'healthcare_professional_phone_number' => 'required',
                 'healthcare_professional_zip_code' => 'required',
                 'healthcare_professional_country' => 'required',
                 'healthcare_professional_state' => 'required',
                 'healthcare_professional_city' => 'required',
                 'healthcare_professional_dob' => 'required',
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
            $input_arr1['healthcare_professional_phone_number']     =$post_arr['healthcare_professional_phone_number'];
            $input_arr1['healthcare_professional_zip_code']         =$post_arr['healthcare_professional_zip_code'];

            $input_arr1['healthcare_professional_country']          =$post_arr['healthcare_professional_country'];
            $input_arr1['healthcare_professional_state']            = $healthcare_professional_state;
            $input_arr1['healthcare_professional_city']             =$post_arr['healthcare_professional_city'];
            $input_arr1['healthcare_designation']                   =$post_arr['healthcare_designation'];
            
            $datetime = new DateTime();
            $datetime = $datetime->createFromFormat('m-d-Y', $post_arr['healthcare_professional_dob']);
            $input_arr1['healthcare_professional_dob']              = $datetime->format('Y-m-d');
            
            
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
            
         return View::make('healthcare_professional.editprofile')->with(array('data'=>$data,'country'=>$country));
       
    }
    
    public function anyLogout(){
        Session::flush(); 
        return Redirect::to('healthcare_professional'); 
    }
}
