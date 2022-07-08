<?php namespace App\Http\Controllers;
//namespace App\Http\BaseController;
use DB;
use Input;
use Session;
use View;
use App;
use Validator;
use Redirect;
use URL;
use DateTime;
//use Vsmoraes\Pdf\Pdf;

class CustomerController extends Controller {

    
	/*
	|--------------------------------------------------------------------------
	| Default Customer Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'CustomerController@showWelcome');
	|
	*/    
    
    public function __construct(){
         
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        } 
       
    }     
        //  show login page for admin   
    public function getIndex($flag='')    
    {
        if(!$this->anyChecklogin()){
            return Redirect::action('CustomerController@anyLogin',array());
        }else{
            return Redirect::action('CustomerController@anyDashboard',array());
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
        $post_arr    =$data       = Input::all();     
        if(!empty($post_arr)){
            $customer_state = '';
             if(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $post_arr['captcha_code']) != 0){ 
                $err_msg  = '<br />';
                $err_msg .= '<i>Validation code does not match!</i>';
                return json_encode(array('error' => 1, 'err_msg' => $err_msg)); exit;	
            }

            if(isset($post_arr['customer_state_select']) && !empty($post_arr['customer_state_select'])){
                $customer_state      =$post_arr['customer_state_select'];
            }

            if(isset($post_arr['customer_state_text']) && !empty($post_arr['customer_state_text'])){
                $customer_state = $post_arr['customer_state_text'];
            }
            $validator = Validator::make(
             array(
                 'customer_email_id'  => $post_arr['customer_email_id'],
                 'customer_fname'  => $post_arr['customer_fname'],
                'customer_lname'  => $post_arr['customer_lname'],
                'customer_phone_code'  => $post_arr['customer_phone_code'], 
                'customer_phone'  => $post_arr['customer_phone'],
                'customer_zip'  => $post_arr['customer_zip'],
                'customer_country'  => $post_arr['customer_country'],
                'customer_state'  => $customer_state,
                'customer_city'  => $post_arr['customer_city'],
                 'password'  => $post_arr['password'],
                 'password2'  => $post_arr['password2']

             ),
             array(
                 'customer_email_id' => 'required|unique:customers,customer_email_id',
                 'customer_fname' => 'required',
                'customer_lname' => 'required',
                'customer_phone_code' => 'required', 
                'customer_phone' => 'required|max:13',
                'customer_zip' => 'required',
                'customer_country' => 'required',
                'customer_state' => 'required',
                'customer_city' => 'required',
//                'password' => 'required|regex:/(^(?=.{6,})(?=.*[!@#$%^&*()+=]).*$)+/' ,
                'password' => 'required|min:4' ,
                'password2' => 'required|same:password',
             )
//            array(
//                 'password.regex' => 'Password should contain atleast 6 characters with minimum one special character' ,   
// 
//            )

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
            
            
            $customer_no = 1;
            $customers = DB::table('customer_detail')->orderBy('customer_id', 'DESC')->select('customer_code')->first(); 
            if(is_object($customers))
                $cust_cod = $customers->customer_code;
            else
                $cust_cod =0;
            
            if($cust_cod>0){
                $customer_code = $cust_cod+1;
            }else{
                $customer_code = '1001';
            }
            $insert_data = array();
            $insert_data['customer_email_id'] = $email =trim($data['customer_email_id']);
            $insert_data['customer_fname'] = trim($data['customer_fname']);
            $insert_data['customer_lname'] = trim($data['customer_lname']);
            $insert_data['customer_status'] = 1;  
            $insert_data['email_verify'] = 1; 
            $insert_data['customer_password'] = (new BaseController)->encrypt_decrypt(trim($data['password']));
            $insert_data['customer_phone_code'] = trim($data['customer_phone_code']);
            $insert_data['customer_phone'] = trim($data['customer_phone']);
            $insert_data['created_at'] = date('Y-m-d H:i:s');
            $insert_data['updated_at'] = date('Y-m-d H:i:s');
            
            $customer_id = DB::table('customers')->insertGetId($insert_data);
            $detail_data = array();
            $detail_data['customer_id'] = $customer_id;
            $detail_data['customer_code'] = $customer_code;
            //$detail_data['customer_nickname'] = trim($data['nick_name']);
            $detail_data['customer_no'] = $customer_no;
            $detail_data['country_id'] = trim($data['customer_country']);
            $detail_data['customer_state'] = $customer_state;
            $detail_data['customer_city'] = trim($data['customer_city']);
            $detail_data['customer_zip'] = trim($data['customer_zip']); 
            $detail_data['customer_area'] = trim($data['customer_area']);  
            $detail_data['customer_status'] = 1;
            $detail_data['is_casefile'] = 0;  // This is  registration , not a case file
            $detail_data['created_at'] = date('Y-m-d H:i:s');
            $detail_data['updated_at'] = date('Y-m-d H:i:s');
            $detail_id = DB::table('customer_detail')->insertGetId($detail_data);
            if($detail_id >0){
                // $this->anyVerifysend($customer_id,$email,$customer_name);    
                // Send Mail    
                $result= (new BaseController)->send_customer_registration_mail($customer_id,trim($data['password'])); 
                echo json_encode(array('error' => 0)); exit;
            }else{
                echo json_encode(array('error' => 1,'err_msg'=>'Something went wrong, please try again.')); exit;
            }
            //return Redirect::action('CustomerController@anyFinish',array());
        }
        return View::make('customer.register')->with(array('reg_data'=>$reg_data,'country'=>$country,'state'=>$state));
    } 
    public function anyNickcheck(){
        $data = Input::all();
        $result ='';
        if($data['nick']!=''){  
            $customers = DB::table('customer_detail')->where('customer_nickname', '=', $data['nick'])->get();            
            $message = 'Nickname already exist';
            if(count($customers)>0){                
                return $message;
            }else{
                return '1';
            }             
        }else{
            return $result;
        }           
    }  
    public function anyUsercheck(){
        $data = Input::all();
        $result = 1;       
        if($data['user']!=''){     
            $customers = DB::table('customers')->where('customer_email_id', '=', $data['user'])->where('customer_password', '=', (new BaseController)->encrypt_decrypt($data['pwd']))->where('customer_status','!=', 0)->first();   
            if(count($customers)>0){  
                 $output['id'] = $customers->customer_id;
                    $output['verify'] = $customers->email_verify;
                if($customers->email_verify ==0){
                    $output['linkmsg'] = 'You havenot verified the email account. Please <a class="lnkbtnajx" onclick="resend('.$customers->customer_id.')">click here</a> to resend account activation link';
                }
                return json_encode(array('error' => 0)); exit;
            }else{
                return json_encode(array('error' => 1,'err_msg'=> 'Invalid username & password'));exit;
            }             
        }else{
            return json_encode(array('error' => 1,'err_msg'=> 'Error! Something went wrong, please try again.'));exit;
        }           
    }
    public function anyUserexist(){
        $data = Input::all();
        $result =0;
        if($data['user']!=''){  
            $customers = DB::table('customers')->where('customer_email_id', '=', $data['user'])->first();            
            if(count($customers)>0){                  
                $result = $customers->customer_id;
            }           
        }
        echo $result;
    }    
    public function anyEmailcheck($emal){
        $result ='';
        if($emal!=''){  
            $customers = DB::table('customers')->leftjoin('customer_detail', 'customers.customer_id', '=', 'customer_detail.customer_id')->where('customers.customer_email_id', '=', $emal)->select('customer_detail.customer_code','customers.customer_id')->get();            
            if(count($customers)>0){  
                foreach($customers as $cust_dat){
                    $result['customer_code'] = $cust_dat->customer_code;
                    $result['customer_id'] = $cust_dat->customer_id;
                }
                return $result;
            }else{
                return '0';
            }             
        }else{
            return $result;
        }           
    }
    public function anyVerifyemail(){

        $data = Input::all();
        $data['site_url'] = URL::to('/');
        
        
        /*
        if(isset($data['form_submit']) && $data['form_submit'] =='save'){ 
            
            $key = $data['key'];
            $decrypted = base64_decode($data['key']);
            $customerId = substr($decrypted,6);
            $customer = DB::table('customers')->where('customers.customer_id', '=', $customerId)->first();
            $update_data = array();
            $update_data['email_verify'] = 1; 
            $update_data['customer_status'] = 1; 
            $update_data['customer_password'] = (new BaseController)->encrypt_decrypt(trim($data['customer_password']));
            if (count($update_data) > 0 && $customerId > 0) {
                    DB::table('customers')->where('customer_id', $customerId)->update($update_data);
                    Session::put('flash_msg','Password creation and Account verification completed successfully. Please login');
                    return json_encode(array('error' => 0)); exit;
            }else{
                return json_encode(array('error' => 1,'err_msg'=> 'Some error has happend, please try after some time')); exit;
            }
            
            
        }*/
        
        if(isset($data['key']) && $data['key'] !=''){ 
            $decrypted = base64_decode(urldecode($data['key']));
            $customerId = substr($decrypted,6);
            $customers = DB::table('customers')->where('customers.customer_id', '=', $customerId)->first();
             if(count($customers)>0){  
                if($customers->email_verify == 0){
                    $update_data = array();
                    $update_data['email_verify'] = 1;          
                    if (count($update_data) > 0 && $customerId > 0) {
                    DB::table('customers')->where('customer_id', $customerId)->update($update_data);
                    }
                    Session::put('flash_msg','Account is activated. Please login');
                     return Redirect::to('customer/login'); 
                }else{
                     Session::put('flash_msg','Account is already activated. Please login');
                     return Redirect::to('customer/login'); 
                }
                
            }  
//            if($customer->email_verify==1 && $customer->customer_status ==1 && $customer->customer_password !=''){
//               Session::put('flash_msg','This account is already verified. Please login');
//               return Redirect::to('customer/login');
//            }
        }  
        
     /*   if(isset($data['key']) && $data['key'] !=''){  
            $decrypted = (new BaseController)->encrypt_decrypt(urldecode($data['key']));
            $id = substr($decrypted,6);
            $customers = DB::table('customers')->where('customers.customer_id', '=', $id)->first();            
            if(count($customers)>0){  
                if($customers->email_verify == 0){
                    $update_data = array();
                    $update_data['email_verify'] = 1;          
                    if (count($update_data) > 0 && $id > 0) {
                    DB::table('customers')->where('customer_id', $id)->update($update_data);
                    }
                }else{
                     Session::put('flash_msg','Account is already activated. Please login');
                     return Redirect::to('customer/login'); 
                }
                
            }           
        }*/
//        return Redirect::to('home');  */
        return View::make('customer.verify')->with(array('data' => $data));
    }
    public function anyVerifysend($id,$email=null,$name=null){
        if(isset($id) && $id > 0){  
            $val = 'doctor'.$id;
            $key = urlencode(base64_encode($val));
            $link = asset('customer/verifyemail?key='.$key);
            $return = '';
            if($name==null){                
                $customers = DB::table('customers')->leftjoin('customer_detail', 'customers.customer_id', '=', 'customer_detail.customer_id')->where('customers.customer_id', '=', $id)->select('customers.customer_fname','customers.customer_lname','customers.customer_email_id')->first();            
                if(count($customers)>0){  
                    $email = $customers->customer_email_id;
                    $name = $customers->customer_fname." ".$customers->customer_lname;
                }
                $return = 1;
            }
            $subject = "Account activation - Doctorbuddy.com";
            $body = '<h3>Dear '.$name. ' ,</h3>
                <p>Thank you for signing up with Doctorbuddy</p>
                            <p>To be able to sign in to your account, please verify your email address first by clicking the following link:
            <a href="'.$link.'">Click Here</a> or visit the following address <a href="'.$link.'">'.$link.'</a> <br/></p>
            <p>Reagrds,<br/>Doctorbuddy.com</p>';
            $result = (new BaseController)->mail($email,$subject,$body);
            if($result==true){
//                if($return =='1'){
//                    return true;
//                    exit;
//                }else{
//                echo "Thank you. Your account activation link is send to your email.";
//                }
                return $result;
                exit;
            }else{
               echo $result; 
            }  
        }
        //return Redirect::to('home');  
    }
    public function anyVerifyresend($id){
        $result = $this->anyVerifysend($id);
        if($result==1){
            return json_encode(array('error' => 0)); exit;
        }else{
            return json_encode(array('error' => 1)); exit;
        }
    }
    public function anyDashboard(){ 
        
        if(!$this->anyChecklogin()){
            return Redirect::to('customer/login/dashboard');
        }
        
        $datareport = array();
        $data = Input::all();
        $countries = DB::table('country')->orderBy('country_id', 'ASC')->select('country_id','countryname')->get();
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
        if(Session::get('customer_id')>0){
              
         
            $id = Session::get('customer_id');

            $logined=  1;
            $datareport = array();  
            $customer_detail = array();  
            
            $customerObj = DB::table('customers')->where('customers.customer_id','=',$id)->first(); 
            $data['customer_name'] =$customerObj->customer_fname." ".$customerObj->customer_lname;
                
                
            $customerinfo = DB::table('customer_detail')->leftjoin('customers', 'customer_detail.customer_id', '=', 'customers.customer_id')->leftjoin('country', 'customer_detail.country_id', '=', 'country.country_id')
                    ->select('customer_detail.customer_id','customer_detail.customer_nickname','customer_detail.updated_at','customer_detail.customer_detail_id')
                    ->where('customer_detail.customer_id', '=',$id)
                    ->where('customer_detail.is_casefile', '=',1)
                    ->orderBy('customer_detail.customer_detail_id', 'DESC')->get();

                if(count($customerinfo)>0){
                    

//                    foreach($customersinfo as $customerinfo){
//                                              
//                        $customer_detail['customer_detail_id'] = $customerinfo->customer_detail_id;     
//                        $customer_detail['customer_nickname'] = $customerinfo->customer_nickname;
//                        
//                        $detail_data[] = $customerinfo->customer_detail_id;
//                        $data[$detaild]['customer_nickname'] = $customerinfo->customer_nickname;
//                        $data[$detaild]['customer_state'] = $customerinfo->customer_state;
//                        $data[$detaild]['customer_zip'] = $customerinfo->customer_zip;
//                        $data[$detaild]['customer_city'] = $customerinfo->customer_city;
//                        $data[$detaild]['customer_country'] = $customerinfo->countryname;
//                        $data[$detaild]['known_disease'] = $customerinfo->known_disease;
//                        $data[$detaild]['did'] = $customerinfo->customer_detail_id;
//
//                        $data[$detaild]['customer_fileno'] = 'DB'.$customerinfo->customer_code."-".$customerinfo->customer_no;
//                        
//                        $symptomdetail = DB::table('customer_symptoms')->where('detail_id', '=', $detaild)->get();
//                        if (count($symptomdetail) > 0) {
//                            foreach ($symptomdetail as $symptomdata) {
//                                $data[$detaild]['symptoms'][] = $symptomdata;
//                            }
//                        }
//                        $p++;
//                    }
                   $data['customerinfo'] =$customerinfo;
                }
               
               
             return View::make('customer.dashboard')->with(array('data' => $data,'country'=>$country,'state'=>$state));
             exit;
        
          }else{
             return Redirect::to('home');   
        }
    }
    public function anyEditprofile(){ 
        
        if(!$this->anyChecklogin()){
            return Redirect::to('customer/login/editprofile');
        }        

        $datareport = array();       
       
        
            $id = Session::get('customer_id');
            $logined=  1;
            
            $post_arr           = Input::all();            
            if(!empty($post_arr) && $post_arr['form_submit'] == "save"){    
                $customer_state ='';
                if(isset($post_arr['customer_state_select']) && !empty($post_arr['customer_state_select'])){
                    $customer_state      =$post_arr['customer_state_select'];
                }

                if(isset($post_arr['customer_state_text']) && !empty($post_arr['customer_state_text'])){
                    $customer_state = $post_arr['customer_state_text'];
                }
                
                $validator = Validator::make(
                 array(
                     'customer_fname'  => $post_arr['customer_fname'],
                     'customer_lname'  => $post_arr['customer_lname'],
                     'customer_phone_code'  => $post_arr['customer_phone_code'],
                     'customer_phone'  => $post_arr['customer_phone'],
                     'customer_zip'  => $post_arr['customer_zip'],
                     'customer_country'  => $post_arr['customer_country'],
                     'customer_state'  => $customer_state,
                     'customer_city'  => $post_arr['customer_city']
                 ),
                 array(
                     'customer_fname' => 'required',
                     'customer_lname' => 'required',
                     'customer_phone_code' => 'required',
                     'customer_phone' => 'required|max:13',
                     'customer_zip' => 'required',
                     'customer_country' => 'required',
                     'customer_state' => 'required',
                     'customer_city' => 'required'
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
                
                $update_data = array();
                $update_data['customer_fname']       = $post_arr['customer_fname'];
                $update_data['customer_lname']        =$post_arr['customer_lname'];
                $update_data['customer_phone_code']     =$post_arr['customer_phone_code'];
                $update_data['customer_phone']     =$post_arr['customer_phone'];
                $update_data['updated_at']         =    date('Y-m-d H:i:s');

                //Update  customer Table
                DB::table('customers')->where('customer_id', $id)->update($update_data);
                
                
                $detail_data = array();                
                $detail_data['country_id'] = $post_arr['customer_country']; 
                $detail_data['customer_state'] = $customer_state;
                $detail_data['customer_city'] = $post_arr['customer_city'];
                $detail_data['customer_zip'] = $post_arr['customer_zip'];
                $detail_data['customer_area'] = $post_arr['customer_area']; 
                $detail_data['updated_at'] = date('Y-m-d H:i:s');
                    
                $customerDetailObj = DB::table('customer_detail')->where('customer_id', $id)->where('customer_detail.is_casefile', '=',0);
                if(count($customerDetailObj->first()) >0){

                    $customerDetailObj->update($detail_data);
                }else{
                    
                        //This situation will only comes for old existing records
                        $customerDetailObj = DB::table('customer_detail')->where('customer_id', $id)->where('customer_detail.is_casefile', '=',1)->orderBy('customer_no', 'DESC')->first();
                        if(count($customerDetailObj) >0){   
                            $customer_code = $customerDetailObj->customer_code;
                            $customer_no = $customerDetailObj->customer_no;
                            $customer_no = (int)$customer_no+1;                                       
                            $detail_data['customer_id'] = $id;
                            $detail_data['customer_code'] = $customer_code;
                            $detail_data['customer_no'] = $customer_no;
                            $detail_data['is_casefile'] = 0;  // This is  registration , not a case file
                            $detail_data['created_at'] = date('Y-m-d H:i:s');
                            $detail_data['updated_at'] = date('Y-m-d H:i:s');
                            $detail_data['customer_status'] = 1;
                            $detail_id = DB::table('customer_detail')->insertGetId($detail_data);   
                        }
                     
               }
               Session::flash('flash_msg','Record saved successfully');
               return json_encode(array('error' => 0)); exit;
            }    
            
            $datareport = array();    
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
            $datareport['site_url'] = URL::to('/');

            
                 $customerinfo = DB::table('customers')->where('customers.customer_id', '=',$id)->first();
                 
                $datareport['customer_email_id'] = $customerinfo->customer_email_id;
                $datareport['customer_name'] = $customerinfo->customer_fname." ".$customerinfo->customer_lname;
                $datareport['customer_fname'] = $customerinfo->customer_fname;
                $datareport['customer_lname'] = $customerinfo->customer_lname;
                $datareport['customer_phone_code'] = $customerinfo->customer_phone_code;
                $datareport['customer_phone'] = $customerinfo->customer_phone;

                 
                $datareport['customer_state'] = "";
                $datareport['customer_zip'] = "";
                $datareport['customer_city'] = "";
                $datareport['customer_area'] = "";                                     
                $datareport['customer_country'] = "";
                 
                 $customerinfo = DB::table('customer_detail')
                        ->leftjoin('country', 'customer_detail.country_id', '=', 'country.country_id')
                        ->where('customer_detail.customer_id', '=',$id)
                        ->where('customer_detail.is_casefile', '=',0)
                        ->first();

                if(count($customerinfo)>0){                    
                    
                    $datareport['customer_state'] = $customerinfo->customer_state;
                    $datareport['customer_zip'] = $customerinfo->customer_zip;
                    $datareport['customer_city'] = $customerinfo->customer_city;
                    $datareport['customer_area'] = $customerinfo->customer_area;                                        
                    $datareport['customer_country'] = $customerinfo->country_id;
                    
//                    $datareport['customer_nickname'] = $customerinfo->customer_nickname;
//                    $datareport['customer_fileno'] = 'DB'.$customerinfo->customer_code."-".$customerinfo->customer_no;     
//                    $datareport['known_disease'] = $customerinfo->known_disease;
//                    $datareport['logined'] = $logined;
//                    $detail_id = $customerinfo->customer_detail_id;
                }
                
//                $ansdetail = DB::table('customer_answers')->where('detail_id', '=', $detail_id)->get();
// 
//                if (count($ansdetail) > 0) {
//                    foreach ($ansdetail as $ansdata) {
//                        $datareport['answers'][] = $ansdata;
//                    }
//                }
//                $symptomdetail = DB::table('customer_symptoms')->where('detail_id', '=', $detail_id)->get();
//
//                if (count($symptomdetail) > 0) {
//                    foreach ($symptomdetail as $symptomdata) {
//                        $datareport['symptoms'][] = $symptomdata;
//                    }
//                }    
              
            return View::make('customer.editprofile')->with(array('data' => $datareport,'country'=>$country,'state'=>$state));
            exit;
        
          
    }
    
    
    
    public function anyState(){
        
//        if(!Session::get('customer_id')){
//            return Redirect::to('customer/login');   
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
    
    public function anyUploadfiles($customerDetailId,$action=null,$fileId=null){ 
                
        if(!$this->anyChecklogin()){
            return Redirect::to('customer/login/reports');
        }        
        
        $customerid = Session::get('customer_id');
        $customerObj = DB::table('customers')->where('customers.customer_id','=',$customerid)->first();
        $data['customer_name'] =$customerObj->customer_fname." ".$customerObj->customer_lname;
        $data['site_url'] =URL::to('/');
        
        $post_arr           = Input::all();
        
        switch($action){
            
            case 'add':
                $input = array();
                $input['file_name']=$post_arr['customer_medicalreport'];
                $input['customer_detail_id']=$customerDetailId;
                DB::table('customer_files')->insert($input); 
                return json_encode(array('error' => 0)); exit; 
                
            case 'delete':
                 DB::table('customer_files')->where('customer_files.customer_file_id','=',$fileId)->delete(); 
                 return json_encode(array('error' => 0)); exit;   
            
            case 'ajaxlist':
                $files = DB::table('customer_files')->where('customer_detail_id', '=', $customerDetailId)->get();
                $html ="";
                foreach($files as $file) {
                    $html .='<p id="'.$file->customer_file_id.'">';
                    $html .='<a href="'.asset('uploads/files/'.$file->file_name).'" target="_blank">';
                    $html .= $file->file_name;
                    $html .= '</a>';
                    $html .= '&nbsp;';
                    $html .= '<a href="javascript:void(0);" onclick="delete_files('.$file->customer_file_id.')">';
                    $html .= '<i aria-hidden="true" class="fa fa-times-circle"></i>';
                    $html .= '</a></p>';                   
                }
                return json_encode(array('error' => 0,'html' => $html)); exit;   
                 
            default:  
             $data['customer_detail_id'] = $customerDetailId;
             return View::make('customer.uploadfiles')->with(array('data' => $data));
             exit;   
        }
        
        $data['customer_detail_id'] = $customerDetailId;
        return View::make('customer.uploadfiles')->with(array('data' => $data));
        exit;
    }
    public function anyReports($id=null){ 

        if(!$this->anyChecklogin()){
            return Redirect::to('customer/login/reports');
        }        
        
        $datareport = array();
        $data = Input::all();
        $data['site_url'] =URL::to('/');
        $countries = DB::table('country')->orderBy('country_id', 'ASC')->select('country_id','countryname')->get();
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
        if(Session::get('customer_id')>0){      
                $customerid = Session::get('customer_id');
                $logined=  1;
                $datareport = array();    

                $customerObj = DB::table('customers')->where('customers.customer_id','=',$customerid)->first();
                $data['customer_name'] =$customerObj->customer_fname." ".$customerObj->customer_lname;

                $reportsArr = array();
                if($id >0){
                    $datareport = (new BaseController)->get_casefile_report($id);
                    array_push($reportsArr,$datareport);
                }else{
                    $customerObjs = DB::table('customer_detail')
                            ->where('customer_detail.customer_id', '=',$customerid)
                            ->where('customer_detail.is_casefile', '=',1)
                            ->orderBy('customer_detail.customer_detail_id', 'ASC')->get();

                    foreach ($customerObjs as $customerObj){
                        $customerDetailId = $customerObj->customer_detail_id;
                        $datareport = (new BaseController)->get_casefile_report($customerDetailId);
                        array_push($reportsArr,$datareport);
                    }
                }
                 return View::make('customer.report')->with(array('data' => $data,'reportsArr' => $reportsArr,'country'=>$country,'state'=>$state));
                 exit;
        
          }else{
             return Redirect::to('customer');   
          }
    }
    public function anySymptom($id=null){ 

        if(!$this->anyChecklogin()){
            return Redirect::to('customer/login/symptom');
        }          
        $siteUrl = URL::to('/');
        
        $datareport = array();
        $data = Input::all();        
        if(Session::get('customer_id')>0){      
            $customerid = Session::get('customer_id');
            $logined=  1;
            $datareport = array();    
            if($id >0){
                $customerinfo = DB::table('customer_detail')->leftjoin('customers', 'customer_detail.customer_id', '=', 'customers.customer_id')->where('customer_detail.customer_detail_id', '=',$id)->first();
                if(count($customerinfo)>0){
                    $datareport['customer_email_id'] = $customerinfo->customer_email_id;
                    $datareport['customer_name'] = $customerinfo->customer_fname." ".$customerinfo->customer_lname;     
                    $datareport['customer_nickname'] = $customerinfo->customer_nickname;  
                }
            
                
                $symptomdetails = DB::table('customer_symptoms')->where('detail_id', '=', $id)->orderBy('customer_symptom_id', 'DESC')->get();
                $datareport['symptomdetails'] = $symptomdetails;
                $datareport['id'] = $id;
                /*
                $symptomdetail = DB::table('customer_symptoms')->where('detail_id', '=', $id)->get();
    //                print_r($ansdetail);
                if (count($symptomdetail) > 0) {
                    foreach ($symptomdetail as $symptomdata) {
                        $datareport['symptoms'][] = $symptomdata;
    //                        $data['username'] = $admindata->username;
                    }
                }
                $symptomdetail = DB::table('customer_symptoms_his')->where('detail_id', '=', $id)->orderBy('customer_his_id', 'DESC')->get();
    //                print_r($ansdetail);
                $his = array();
                if (count($symptomdetail) > 0) {
                    $i =0;
                    foreach ($symptomdetail as $symptomdata) {
                        $his[$symptomdata->symptom_id][$i]['date_added'] = date("d/m/Y",strtotime($symptomdata->created_date));
                        $his[$symptomdata->symptom_id][$i]['created_date'] = $symptomdata->created_date;
                        $his[$symptomdata->symptom_id][$i]['symptom_id'] = $symptomdata->symptom_id;
                        $his[$symptomdata->symptom_id][$i]['symptom_name'] = $symptomdata->symptom_name;
                        $his[$symptomdata->symptom_id][$i]['symptom_rate'] = $symptomdata->symptom_rate;
                        $his[$symptomdata->symptom_id][$i]['customer_note'] = $symptomdata->customer_note;
                        $i++;
                    }
                }

                $datareport['symptoms_his'] = $his;*/
                return View::make('customer.symptom')->with(array('data' => $datareport,'site_url'=>$siteUrl));
                exit;
            }
        }else{
             return Redirect::to('customer');   
        }
    }
    public function anyViewsymptom($id=null){ 
         
        if(!$this->anyChecklogin()){
            return Redirect::to('customer/login/symptom');
        }
        
        $datareport = array();
        $data = Input::all();        
        if(Session::get('customer_id')>0){      
            $customerid = Session::get('customer_id');
            $logined=  1;
            $datareport = array(); 
            $id = $data['detailid'];
            if($id >0){
               
                $symptomdetail = DB::table('customer_symptoms_his')->where('detail_id', '=', $id)->orderBy('customer_his_id', 'DESC')->get();
    //                print_r($ansdetail);
                $his = array();
                if (count($symptomdetail) > 0) {
                    $i =0;
                    foreach ($symptomdetail as $symptomdata) {
//                        $datareport['symptoms_his'][] = $symptomdata;
//                        $date_added_his = $datetime->createFromFormat('Y-m-d H:i:s',$symptomdata->created_date);
//                        $his[$i]['date_added'] = $datetime->format('m-d-Y H:i:s');
                        $his[$i]['date_added'] = date("m-d-Y",strtotime($symptomdata->created_date));
                        $his[$i]['created_date'] = $symptomdata->created_date;
                        $his[$i]['symptom_name'] = $symptomdata->symptom_name;
                        $his[$i]['symptom_rate'] = $symptomdata->symptom_rate;
                        $his[$i]['customer_note'] = $symptomdata->customer_note;
//                        $his[$i]['date_added'] = $date_added_his;
                        $i++;
                    }
                }
                $datareport['symptoms_his'] = $his;
                return View::make('customer.symptomhis')->with(array('data' => $datareport));
                exit;
            }
        }else{
             return Redirect::to('customer');   
        }
    }
    public function anyFinish($id=null){ 
         $datareport = array();
         $data = Input::all();
         
         return View::make('customer.finish')->with(array('data' => $datareport));
        
    }   
    public function anyLogin($action='',$mainId='',$subid1=''){
        
        $redirect ="";
        
        if($action !=''){
            $redirect = $action;
            if($mainId !='')
                $redirect .= "/$mainId";
            if($subid1 !='')
                $redirect .= "/$subid1";            
            
        }
            
                // Already Logined
        if($this->anyChecklogin()){
           
            if ($redirect != ''){
                return Redirect::to("customer/$redirect");
            }else {
                return Redirect::to("customer/dashboard");
            }
        } 
        
        $data['redirect'] = $redirect;
        $data['site_url'] = URL::to('/');
        
        $post = Input::all();   
        if(isset($post['user_email_id']) && $post['user_email_id'] != ''){
            $customers = DB::table('customers')->where('customer_email_id', '=', $post['user_email_id'])->where('customer_password', '=', (new BaseController)->encrypt_decrypt($post['user_password']))->where('email_verify','=', 1)->where('customer_status','!=', 0)->where('is_deleted','==', 0)->first();   
            if(count($customers)>0){ 
                session_destroy();
                session::flush();
                
                session_start();
                $_SESSION['customer_id'] = $customers->customer_id;
                
                Session::put('customer_id',$customers->customer_id);
                Session::put('logined_user_displayname',$customers->customer_fname.' '.$customers->customer_lname); 

                return json_encode(array('error' => 0)); exit;
            }else{
                $customers = DB::table('customers')->where('customer_email_id', '=', $post['user_email_id'])->where('customer_password', '=', (new BaseController)->encrypt_decrypt($post['user_password']))->where('email_verify','=', 0)->first();   
                if(count($customers)>0){          
                    $customer_id = $customers->customer_id;
                    return json_encode(array('error' => 1,'err_msg'=>'Your account is not verified yet. Please <a href="javascript:void(0);" onclick="resend_verify('.$customer_id.');">click here</a> to resend verify email.')); exit;
                }
                $customers = DB::table('customers')->where('customer_email_id', '=', $post['user_email_id'])->where('customer_password', '=', (new BaseController)->encrypt_decrypt($post['user_password']))->where('customer_status','=', 0)->first();   
                if(count($customers)>0){           
                    return json_encode(array('error' => 1,'err_msg'=>'Your account is disabled.Please try after some time')); exit;
                }
                return json_encode(array('error' => 1,'err_msg'=>'Invalid Username or Password. Please try with your customer email id and the specific password')); exit;
            }
        }    
        return View::make('customer.login')->with(array('data'=>$data));
    }
       //  show logout page
    public function getLogout()
    {
        session_destroy();
        Session::flush();
        $msg='';
        return Redirect::action('CustomerController@anyLogin',array());
    }
    public function anyForgotpassword(){
        $result ='';
        $data = Input::all();
        $data['msg'] = '';
        $dataoutput = array();
        $dataoutput['msg'] = '';
        if(isset($data['user_email_id']) && $data['user_email_id'] != ''){
            $customers = DB::table('customers')->leftjoin('customer_detail', 'customers.customer_id', '=', 'customer_detail.customer_id')->where('customers.customer_email_id', '=', trim($data['user_email_id']))->select('customers.customer_fname','customers.customer_lname','customers.customer_id','customers.customer_email_id')->first();            
            if(count($customers)>0){  
                $email = $customers->customer_email_id;
                $name = $customers->customer_fname." ".$customers->customer_lname;
                $id = $customers->customer_id;
                $rand_pwd = (new BaseController)->Randompassword(); 
                $update_data = array();
                $update_data['customer_password'] = (new BaseController)->encrypt_decrypt(trim($rand_pwd));
                DB::table('customers')->where('customer_id', $id)->update($update_data);
                
                // Send Mail               
                $templateLocation = "customer.mail_template_forgot_password";

                $thingsToPassTemplate["site_link"] = URL::to('/'); 
                $thingsToPassTemplate["site_start_link"] = URL::to('/')."/home/basic";      
                $thingsToPassTemplate["receipent_name"] = $name;        
      
                $thingsToPassTemplate["rand_pwd"] = $rand_pwd;


                $subject = "Forgot Password -Customer"; 

                $receipents = $email;

                // Send mail
                $result= (new BaseController)->send_mail(
                        $templateLocation,
                        $thingsToPassTemplate,
                        $subject,
                        $receipents
                        );

                if($result==true){
                    $dataoutput['msg'] = "Success.New password has been sent to your email.";
                }
  
            }
            if(isset($data['casefile']) && $data['casefile'] == '1'){
                if($result==true){
                    return json_encode(array('error' => 0)); exit;
                }else{
                    return json_encode(array('error' => 1)); exit;
                }
            }
        }
        return View::make('customer.forgot')->with(array('dataoutput' => $dataoutput));;
//        return Redirect::to('home');  
    }
    public function anyForgotsend($id){
        if(isset($id) && $id > 0){  
            $customers = DB::table('customers')->leftjoin('customer_detail', 'customers.customer_id', '=', 'customer_detail.customer_id')->where('customers.customer_id', '=', $id)->select('customers.customer_fname','customers.customer_lname','customers.customer_email_id')->first();            
            if(count($customers)>0){  
                $email = $customers->customer_email_id;
                $name = $customers->customer_fname." ".$customers->customer_lname;
            
                $rand_pwd = (new BaseController)->Randompassword(); 
                $update_data = array();
                $update_data['customer_password'] = (new BaseController)->encrypt_decrypt(trim($rand_pwd));
                DB::table('customers')->where('customer_id', $id)->update($update_data);
                $subject = "Forgot Password - Doctorbuddy.com";
                $body = '<h3>Dear '.$name. ' ,</h3>
                    <p>We received a request to reset the password associated with this e-mail address. Your Doctorbuddy password has been changed to '.$rand_pwd.'</p>
                         </p>
                <p>Thanks,<br/>Doctorbuddy.com</p>';
                $result = (new BaseController)->mail($email,$subject,$body);
                if($result==true){
                    echo "Your account password reset information is send to your email.";
                }else{
                   echo $result; 
                }
            }
        }
        //return Redirect::to('home');  
    }
    public function anyChangepassword(){        

        if(!$this->anyChecklogin()){
            return Redirect::to('customer/login/changepassword');
        }        
        
        $customerId = Session::get('customer_id');       
        $post_arr           = Input::all();  
            $logined=  1;
            $datareport = array();   
             $datareport['site_url'] = URL::to('/');
                $customerinfo = DB::table('customers')->where('customers.customer_id', '=',$customerId)->first();
                if(count($customerinfo)>0){
                    $datareport['customer_email_id'] = $customerinfo->customer_email_id;
                    $datareport['customer_name'] = $customerinfo->customer_fname." ".$customerinfo->customer_lname;                   
                    $datareport['logined'] = $logined;
                }
          if(!empty($post_arr) && $post_arr['form_submit'] == "save"){

             // Check for duplicate
             $validator = Validator::make(
                 array(
                     'customer_password'  => $post_arr['customer_password'],
                     'customer_password2'  => $post_arr['customer_password2']
                 ),
                 array(
//                     'customer_password' => 'required|regex:/(^(?=.{6,})(?=.*[!@#$%^&*()+=]).*$)+/' ,
                     'customer_password' => 'required|min:4' ,
                     'customer_password2' => 'required|same:customer_password',
                 )
//                array(
//                 'customer_password.regex' => 'Password should contain atleast 6 characters with minimum one special character' ,   
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
                 $update_data['customer_password'] = (new BaseController)->encrypt_decrypt(trim($post_arr['customer_password']));

                 if (count($update_data) > 0 ) {
                     DB::table('customers')->where("customer_id","=",$customerId)->update($update_data);
                 }

                 return json_encode(array('error' => 0)); exit;

             } 

         }else{
             return View::make('customer.changepassword')->with(array("data"=>$datareport)); 
         }
       
    }
    public function anyUpdatesymptom(){
        
        if(!$this->anyChecklogin()){
            return Redirect::to('customer/login');
        }  
        
        $data = Input::all();
        $result = '';
        if(isset($data['detailid'])){
            if($data['detailid']>0){
                $cust = DB::table('customer_detail')->where('customer_detail.customer_detail_id', '=', $data['detailid'])->select('customer_id')->first();
                DB::table('customer_symptoms')->where('detail_id','=',$data['detailid'])->where('symptom_id','=',$data['symid'])->delete();  
                $sql = "SELECT s . * , (SELECT ss.symptom_name FROM `symptoms` ss WHERE ss.symptom_id = s.parent_id) AS parentname FROM `symptoms` AS s  WHERE s.symptom_id='".$data['symid']."'";
                $symptoms = DB::select($sql);     
                if(count($symptoms)>0){
                    foreach($symptoms as $symptom){  
                        if($symptom->parentname != ''){
                            $symptom_name = $symptom->parentname." - ".$symptom->symptom_name;
                        }else{
                            $symptom_name = $symptom->symptom_name;
                        }
                    }
                }
                $insert_data = array();
                $insert_data['customer_id'] = $cust->customer_id;
                $insert_data['detail_id'] = $data['detailid'];
                $insert_data['symptom_id'] = $data['symid'];
                $insert_data['symptom_name'] = $symptom_name;                
                $insert_data['symptom_rate'] = $data['rate'];   
                $insert_data['customer_note'] = $data['cmnt']; 
                DB::table('customer_symptoms')->insert($insert_data);
                DB::table('customer_symptoms_his')->insert($insert_data);
                $symptomdetail = DB::table('customer_symptoms_his')->where('detail_id', '=', $data['detailid'])->where('symptom_id', '=', $data['symid'])->orderBy('customer_his_id', 'DESC')->get();
    //                print_r($ansdetail);
                $his = array();
                if (count($symptomdetail) > 0) {
                    $i =0;
                    foreach ($symptomdetail as $symptomdata) {
                        $his[$i]['date_added'] = date("d/m/Y",strtotime($symptomdata->created_date));
                        $his[$i]['created_date'] = $symptomdata->created_date;
                        $his[$i]['symptom_id'] = $symptomdata->symptom_id;
                        $his[$i]['symptom_name'] = $symptomdata->symptom_name;
                        $his[$i]['symptom_rate'] = $symptomdata->symptom_rate;
                        $his[$i]['customer_note'] = $symptomdata->customer_note;
                        $i++;
                    }
                }
                $datareport['symptoms_id'] =$data['symid'];
                $datareport['symptoms_his'] = $his;
                return View::make('customer.upsymptom')->with(array('data' => $datareport));
               
            }
        } 
//        echo $result;
    }
    public function anyAddsymptom(){
        
        if(!$this->anyChecklogin()){
            return Redirect::to('customer/login');
        }
        
        $data = Input::all();
        $result = '';
        if(isset($data['detailid']) && $data['detailid']>0 ){
            
            $detailId = $data['detailid']; //echo '<pre>';print_r($data);die();
            $customerDetailObj =DB::table('customer_detail')->where('customer_detail.customer_detail_id', '=', $detailId)->first();
            
            
            
            if(isset($data['symp_id']) && count($data['symp_id'])>0){

                
                $symptomsIdWithDetailIds = $data['symp_id'];
  
                foreach($symptomsIdWithDetailIds as $symptomsIdWithDetailId){
                    
                    $rate = "";
                    $customerNote ="";
                    $symptomName="";
                    
                    // Get symptom Name
                    $symptomIdArr = explode($detailId."_",$symptomsIdWithDetailId);
                    $symptomId = $symptomIdArr[1]; 
                    $sql = "SELECT S . * , (SELECT SS.symptom_name FROM `symptoms` SS WHERE SS.symptom_id = S.parent_id) AS parentname FROM `symptoms` AS S  WHERE S.symptom_id='".$symptomId."'";
                    $res_symptoms = DB::select($sql);
                    if(count($res_symptoms)>0){
                        
                        $res_symptom = $res_symptoms[0];
                        
                        if($res_symptom->parentname != ''){
                            $symptomName = $res_symptom->parentname." - ".$res_symptom->symptom_name;
                        }else{
                            $symptomName = $res_symptom->symptom_name;
                        }
                    }


                    
                    // Rate
                    if(isset($data['rat_'.$symptomsIdWithDetailId]) && $data['rat_'.$symptomsIdWithDetailId] !=''){
                        $rate = $data['rat_'.$symptomsIdWithDetailId];
                    }
                    //Comment
                    if(isset($data['symcnt_'.$symptomsIdWithDetailId]) && $data['symcnt_'.$symptomsIdWithDetailId] !=''){
                        $customerNote = $data['symcnt_'.$symptomsIdWithDetailId];
                    }
                    
                    //Insert record into following tables
                    if($symptomId == 0)
                        $symptomName = "Custom symptom";
                    
                    $insert_data = array();

                    $insert_data['customer_id'] = $customerDetailObj->customer_id;
                    $insert_data['detail_id'] = $detailId;
                    $insert_data['symptom_id'] = $symptomId;
                    $insert_data['symptom_name'] = $symptomName;
                    $insert_data['symptom_rate'] = $rate;
                    $insert_data['customer_note'] =  $customerNote;   
                    DB::table('customer_symptoms')->insert($insert_data);
                    DB::table('customer_symptoms_his')->insert($insert_data);

                }
                
            }
            
            // Populate data
            $symptomdetails = DB::table('customer_symptoms')->where('detail_id', '=', $data['detailid'])->orderBy('customer_symptom_id', 'DESC')->get();
            $datareport['symptomdetails'] = $symptomdetails;
            $datareport['id'] = $data['detailid'];
            return View::make('customer.addsymptom')->with(array('data' => $datareport));
            exit;
            
        } 
//        echo $result;
    }
    
    public function anyDeletesymptom($customerSymptomId){
        $customerSymptomObj = DB::table('customer_symptoms')->where('customer_symptom_id', '=',$customerSymptomId)->first();
        
        $detailId = $customerSymptomObj->detail_id;
        $symptomId = $customerSymptomObj->symptom_id;
        
        DB::table('customer_symptoms')->where('customer_symptom_id', '=',$customerSymptomId)->delete();
        DB::table('customer_symptoms_his')->where('detail_id', '=',$detailId)->where('symptom_id', '=',$symptomId)->delete();
        echo json_encode(array('error' => 0,'detail_id'=>$detailId)); exit;
    }
//    public function anyPayment($encodedCasefileToHPId){
//
//        // This is paypal Pro payment integration
//        //Test credit cards will get from http://www.getcreditcardnumbers.com
//        
//        if(!$this->anyChecklogin()){
//            return Redirect::to('customer/login');
//        }         
//        $customerId = Session::get('customer_id');
//        
//        $data = array();
//        
//        //For left menu
//        $customerinfo = DB::table('customers')->where('customers.customer_id', '=',$customerId)->first();
//        if(count($customerinfo)>0){
//            $data['customer_email_id'] = $customerinfo->customer_email_id;
//            $data['customer_name'] = $customerinfo->customer_fname." ".$customerinfo->customer_lname;                   
//        }
//        
//
//        $casefileToHPId = base64_decode($encodedCasefileToHPId);
//        $caseFileToHPObj= DB::table('casefile_to_healthcare')->where('casefile_to_healthcare_id', '=',$casefileToHPId)->first();
//            
//        if(!$caseFileToHPObj){
//            $data['error-meesage'] ="There is some mismatch occured.Please try after some time";
//        }else if ($caseFileToHPObj->customer_id != $customerId){
//            $data['error-meesage'] ="You are not allowed to  view this page";
//        }else{
//            $data['amt'] =$caseFileToHPObj->healthcare_charge;
//        }
//        $data['encoded-casefile-hp-id'] = $encodedCasefileToHPId;
//        $data['site_url'] = URL::to('/');
//        
//        $post_arr           = Input::all();            
//        if(!empty($post_arr) && $post_arr['form_submit'] == "save"){
//            
//            $encodedCasefileToHPId = $post_arr['encoded-casefile-hp-id'];
//            $casefileToHPId = base64_decode($encodedCasefileToHPId);
//            $caseFileToHPObj= DB::table('casefile_to_healthcare')->where('casefile_to_healthcare_id', '=',$casefileToHPId)->first();
//
//            
//            // Start: Collect details  for inserting record into 'customer_to_healthcare_payment_details'
//            $customerId = $caseFileToHPObj->customer_id;      
//            $caseFileId = $caseFileToHPObj->customer_detail_id; 
//            $hpId = $caseFileToHPObj->healthcare_professional_id; 
//            $hpEmail = $caseFileToHPObj->healthcare_professional_email;  
//            if($hpId ==0){
//                $hPObj= DB::table('healthcare_professional')->where('healthcare_professional_email_address', '=',$hpEmail)->first();
//                $hpId = $hPObj->healthcare_professional_id;
//            }            
//            $hpCharge = $caseFileToHPObj->healthcare_charge; 
//            $customerDetailId = $caseFileToHPObj->customer_detail_id; 
//            $customerObj= DB::table('customers')->where('customer_id', '=',$customerId)->first();
//            $customerEmail = $customerObj->customer_email_id;
//            // END
//                 
//            // Start: Collecting customer profile informations for payment        
//            $customerDetailObj= DB::table('customer_detail')->where('customer_id', '=',$customerId)->where('is_casefile', '=','0')->first();
//            
//            if(!$customerDetailObj){
//                 echo json_encode(array('error' => 1, 'err_msg' => "Some of your profile  fields  are missing")); exit;
//            }
//            $countryObj = DB::table('country')->select('code')->where('country_id','=',$customerDetailObj->country_id)->first();
//            $countryCode = $countryObj->code;
//            
//            $customerFirstName = $customerObj->customer_fname;
//            $customerLastName = $customerObj->customer_lname;
//            $customerPhone = $customerObj->customer_phone;
//            
//            $customerState = $customerDetailObj->customer_state;
//            $customerCity = $customerDetailObj->customer_city;
//            $customerZip = $customerDetailObj->customer_zip;
//            $customerAddress = $customerDetailObj->customer_area;
//            // End: Collecting customer profile informations for payment     
//            
//            
//            
//            if(empty($countryCode)||empty($customerFirstName)||empty($customerLastName)||empty($customerPhone)||empty($customerState)||empty($customerCity)||empty($customerZip)||empty($customerAddress) ){
//                 echo json_encode(
//                         array('error' => 1,
//                             'err_msg' => "Some of your profile  fields  are missing.Please update the details <a href='".URL::to('/')."/customer/editprofile'>here<a>")
//                         ); exit;
//            }
//            
//            
//            $paypalObj =DB::table('payment_configuration')->where('payment_method','=','PAYPAL')->select('payment_details')->first();           
//            $paymentObj = json_decode($paypalObj->payment_details); 
//            
//            $orderId = rand(1000,9999);
//            $payment_type = 'Sale';
//            $request  = 'METHOD=DoDirectPayment';
//            $request .= '&VERSION=51.0';
//            $request .= '&USER='.$paymentObj->username; // your paypal pro username
//            $request .= '&PWD='.$paymentObj->password; //your paypal pro password  
//            $request .= '&SIGNATURE='.$paymentObj->signature;  ////your paypal signature password  
//            $request .= '&CUSTREF=' . (int)$casefileToHPId;
//            $request .= '&PAYMENTACTION=' . $payment_type;
//            $request .= '&AMT='.$hpCharge;
//            $request .= '&CREDITCARDTYPE=' . $post_arr['cc_type'];
//            $request .= '&ACCT=' . urlencode(str_replace(' ', '', $post_arr['cc_number']));
//            
//            if(isset($post_arr['cc_start_date_month']) && $post_arr['cc_start_date_month'] !='' && isset($post_arr['cc_start_date_year'])&& $post_arr['cc_start_date_year'] !='')
//                $request .= '&CARDSTART=' . urlencode($post_arr['cc_start_date_month'] . $post_arr['cc_start_date_year']);
//            
//            $request .= '&EXPDATE=' . urlencode($post_arr['cc_expire_date_month'] . $post_arr['cc_expire_date_year']);
//            $request .= '&CVV2=' . urlencode($post_arr['cc_cvv2']);
//
//            if ($post_arr['cc_type'] == 'SWITCH' || $post_arr['cc_type'] == 'SOLO') { 
//                    $request .= '&CARDISSUE=' . urlencode($post_arr['cc_issue']);
//            }
//
//            $request .= '&FIRSTNAME=' . urlencode($customerFirstName);
//            $request .= '&LASTNAME=' . urlencode($customerLastName);
//            $request .= '&EMAIL=' . urlencode($customerEmail);
//            $request .= '&PHONENUM=' . urlencode($customerPhone);
//            
//            $request .= '&IPADDRESS=' . urlencode($_SERVER['REMOTE_ADDR']);
//            $request .= '&STREET=' . urlencode($customerAddress);
//            $request .= '&CITY=' . urlencode($customerCity);
//            $request .= '&STATE=' . urlencode($customerState);
//            
//            $request .= '&ZIP=' . urlencode($customerZip);
//            $request .= '&COUNTRYCODE=' . urlencode($countryCode);
//            $request .= '&CURRENCYCODE=' . urlencode('USD');
//
//            /* $request .= '&SHIPTONAME=' . urlencode($order_info['shipping_firstname'] . ' ' . $order_info['shipping_lastname']);
//            $request .= '&SHIPTOSTREET=' . urlencode($order_info['shipping_address_1']);
//            $request .= '&SHIPTOCITY=' . urlencode($order_info['shipping_city']);
//            $request .= '&SHIPTOSTATE=' . urlencode(($order_info['shipping_iso_code_2'] != 'US') ? $order_info['shipping_zone'] : $order_info['shipping_zone_code']);
//            $request .= '&SHIPTOCOUNTRYCODE=' . urlencode($order_info['shipping_iso_code_2']);
//            $request .= '&SHIPTOZIP=' . urlencode($order_info['shipping_postcode']);
//             */	
//
//            /* $curl = curl_init('https://api-3t.paypal.com/nvp'); // This is for live account
//            $curl = curl_init('https://api-3t.sandbox.paypal.com/nvp'); // This is for sandbox account
//             */
//
//            $curl = curl_init($paymentObj->url);
//            curl_setopt($curl, CURLOPT_PORT, 443);
//            curl_setopt($curl, CURLOPT_HEADER, 0);
//            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
//            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//            curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
//            curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
//            curl_setopt($curl, CURLOPT_POST, 1);
//            curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
//
//            $response = curl_exec($curl);
//
//            curl_close($curl);
//            
//            $filename = time().'data.txt';
//            $filename =base_path()."/uploads/paypal_log/$filename";
//            $fp = fopen($filename,'w');
//            fwrite($fp, $response);
//
//
//
//            if (!$response) {
//                    //write curl error to log file
//                    $fp = fopen('data.txt', 'DoDirectPayment failed: ' . curl_error($curl) . '(' . curl_errno($curl) . ')');
//                    fwrite($fp, $request);
//                    fclose($fp);	
//            } 
//
//            $response_info = array();
//
//            parse_str($response, $response_info);
//            $json = array();
//
//            if ((($response_info['ACK'] == 'Success') || ($response_info['ACK'] == 'SuccessWithWarning')) && $hpCharge == $response_info['AMT']) {
//                    $message = "SUCCESS\n\n";
//
//                    if (isset($response_info['AVSCODE'])) {
//                            $message .= 'AVSCODE: ' . $response_info['AVSCODE'] . "\n";
//                    }
//
//                    if (isset($response_info['CVV2MATCH'])) {
//                            $message .= 'CVV2MATCH: ' . $response_info['CVV2MATCH'] . "\n";
//                    }
//
//                    if (isset($response_info['TRANSACTIONID'])) {
//                            $message .= 'TRANSACTIONID: ' . $response_info['TRANSACTIONID'] . "\n";
//                    }
//
//                    if (isset($response_info['AMT'])) {
//                            $message .= 'AMOUNT: ' . $response_info['AMT'] . "\n";
//                    }
//
//                    fwrite($fp, $message);
//                    fclose($fp);
//                    
//                    Session::flash('flash_msg',$message);
//                    
//                    $insert_data['transaction_id'] = $response_info['TRANSACTIONID'];
//                    $insert_data['casefile_to_healthcare_id'] = $casefileToHPId;
//                    $insert_data['transaction_amount'] = $hpCharge;
//                    $insert_data['payment_status'] = "success";
//                    $insert_data['healthcare_id'] = $hpId;
//                    
////                    $insert_data['customer_id'] = $customerId;
////                    $insert_data['customerdetail_id'] = $caseFileId;
////                    $insert_data['customer_email'] = $customerEmail;
////                    $insert_data['healthcare_email'] = $hpEmail;
//
//
//                    $customer_to_healthcare_payment_detail_id = DB::table('customer_to_healthcare_payment_details')->insertGetId($insert_data);
//                    
//                    //Update the payment status  in 'casefile_to_healthcare' 
//                    DB::table('casefile_to_healthcare')->where("casefile_to_healthcare_id","=",$casefileToHPId)->update(array('payment_status'=>1));
// 
//                    if($customer_to_healthcare_payment_detail_id)  {                  
//                        return json_encode(array('error' => 0,'customer_detail_id' =>$customerDetailId)); 
//                        exit;
//                    }else{
//                        return json_encode(array('error' => 1, 'err_msg' => "Some error occured  while inserting record to payment detail table")); 
//                        exit;
//                    }
//            } else {
//                
//
//                    $insert_data['casefile_to_healthcare_id'] = $casefileToHPId;
//                    $insert_data['transaction_amount'] = $hpCharge;
//                    $insert_data['payment_status'] = "failure";
//                    $insert_data['error_message'] = $response_info['L_LONGMESSAGE0'];
//                    $insert_data['healthcare_id'] = $hpId;
//                    
////                    $insert_data['customer_id'] = $customerId;
////                    $insert_data['customerdetail_id'] = $caseFileId;
////                    $insert_data['customer_email'] = $customerEmail;
////                    $insert_data['healthcare_email'] = $hpEmail;
//
//                    $customer_to_healthcare_payment_detail_id = DB::table('customer_to_healthcare_payment_details')->insertGetId($insert_data);
//                    
//                    return json_encode(array('error' => 1, 'err_msg' => $response_info['L_LONGMESSAGE0'])); 
//                    exit;
//            }
//            
// 
//        }
//
//        $data['site_url'] = URL::to('/');
//        return View::make('customer.payment')->with(array('data' => $data));
//    }
    
    public function anyAssignedproviders($customerDetailId){
        
        if(!$this->anyChecklogin()){
            return Redirect::to('customer/login/dashboard');
        }         
        
        if(!$customerDetailId){            
            return Redirect::to('customer/dashboard');
        }
        
        $data['site_url'] = URL::to('/');
        
        $customerId = Session::get('customer_id');
        $customerObj = DB::table('customers')->where('customers.customer_id','=',$customerId)->first(); 
        $data['customer_name'] =$customerObj->customer_fname." ".$customerObj->customer_lname;
        if(!is_numeric($customerDetailId)){
            $customerDetailId = substr(base64_decode(urldecode($customerDetailId)),4); 
        }
        $sql ="SELECT *
                FROM `casefile_to_healthcare` AS CH
                LEFT JOIN `healthcare_professional` AS HP ON CH.healthcare_professional_email = HP.healthcare_professional_email_address
                WHERE CH.customer_detail_id =$customerDetailId AND HP.healthcare_professional_status !=0 ";
        $caseFileToHPObjs =DB::select($sql); ;
        
        $data['caseFileToHPObjs'] = $caseFileToHPObjs;
        
        return View::make('customer.assignedproviders')->with(array('data' => $data));
        exit;
    }
    
    public function anyConversations($customerDetailId,$hpId){
        
        if(!$this->anyChecklogin()){
            return Redirect::to("customer/login/conversations/$customerDetailId/$hpId");
        }        
        
        $customerId = Session::get('customer_id');
        $customerObj = DB::table('customers')->where('customers.customer_id','=',$customerId)->first(); 
        $data['customer_name'] =$customerObj->customer_fname." ".$customerObj->customer_lname;
        $data['site_url'] = URL::to('/');
        
        $conversations = DB::table('casefile_conversations')
         ->where('customer_detail_id', '=', $customerDetailId)
         ->where('customer_id', '=', $customerId)       
         ->where('healthcare_professional_id', '=', $hpId)                
         ->orderby("date","DESC")
         ->get(); 
        $data['conversations'] = $conversations;
        
        $data['customer_detail_id'] = $customerDetailId;
        $data['healthcare_professional_id'] = $hpId;
        
        
        return View::make('customer.conversations')->with(array('data' => $data));
        exit;        
    }
    
    public function anySendcomment(){
        
        if(!$this->anyChecklogin()){
            return Redirect::to('customer/login/dashboard');
        } 
        
        $customerId = Session::get('customer_id');
        $post_arr           = Input::all(); 
        
           $validator = Validator::make(
            array(
                 'customer_comment'  => $post_arr['customer_comment']
             ),
            array(
                 'customer_comment' => 'required'
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
            
        // Insert an entry into casefile conversation table
        $conversationArr['customer_detail_id'] = $post_arr['customer_detail_id'];
        $conversationArr['healthcare_professional_id'] = $post_arr['healthcare_professional_id'];
        $conversationArr['customer_id'] = $customerId;
        $conversationArr['customer_comment'] = $post_arr['customer_comment'];
        DB::table('casefile_conversations')->insert($conversationArr);
       
        

        // Get Healthcare  Name & Email;
        $hpObj = DB::table('healthcare_professional')->where("healthcare_professional_id","=",$post_arr['healthcare_professional_id'])->first();
        $hpName = $hpObj->healthcare_professional_first_name;
        if($hpObj->healthcare_professional_middle_name)
            $hpName .= " ".$hpObj->healthcare_professional_middle_name;
        if($hpObj->healthcare_professional_last_name)
            $hpName .= " ".$hpObj->healthcare_professional_last_name;          
        
        $hpEmail = $hpObj->healthcare_professional_email_address;
        
        // Get Customer Nick Name;
        $customerDetailObj = DB::table('customer_detail')->where("customer_detail_id","=",$post_arr['customer_detail_id'])->first();
        $customerNickName = $customerDetailObj->customer_nickname;
        
        // Get link
        $casefileTOHelathcareObj = DB::table('casefile_to_healthcare')
                ->where("customer_detail_id","=",$post_arr['customer_detail_id'])
                ->where("healthcare_professional_id","=",$post_arr['healthcare_professional_id'])               
                ->first();
        
        $val = 'casefile_id='.$casefileTOHelathcareObj->casefile_to_healthcare_id;
        $key = urlencode(base64_encode($val));
        $link = asset('healthcare_professional/casefileview?key='.$key);
        

        // Send Mail               
        $templateLocation = "customer.mail_template_customer_comment_on_casefile";
        
        $thingsToPassTemplate["site_link"] = URL::to('/'); 
        $thingsToPassTemplate["site_start_link"] = URL::to('/')."/home/basic";      
        $thingsToPassTemplate["receipent_name"] = $hpName;        

        $thingsToPassTemplate["link"] = $link;  
        $thingsToPassTemplate["customer_nick_name"] = $customerNickName;
        $thingsToPassTemplate["customer_comment"] = $post_arr['customer_comment'];
        

        $subject = "Customer commented on the case file assigned to you"; 

        $receipents = $hpEmail;

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

    }
    
    public function anyAjaxconversationlisting(){

        $customerId = Session::get('customer_id');
        $post_arr           = Input::all(); 
        
        $conversations = DB::table('casefile_conversations')
         ->where('customer_detail_id', '=', $post_arr['customer_detail_id'])
         ->where('customer_id', '=', $customerId)       
         ->where('healthcare_professional_id', '=', $post_arr['healthcare_professional_id'])                
         ->orderby("date","DESC")
         ->get();
        
        return View::make('customer.ajaxconversationlisting')->with(array('conversations'=>$conversations));
        exit;
    } 
    
    public function anyAjaxsymptomhistory($casefileId,$symptomId){
        $symptomHistorydetails = DB::table('customer_symptoms_his')
                                        ->where('detail_id', '=', $casefileId)
                                        ->where('symptom_id', '=', $symptomId)->orderBy('customer_his_id', 'DESC')->get();

        
        return View::make('customer.ajaxsymptomhistory')->with(array('symptomHistorydetails'=>$symptomHistorydetails));
        exit;
    }
    
    public function anyAjaxsymptomedit($customer_symptom_id){

        $symptomdetail = DB::table('customer_symptoms')
                                 ->where('customer_symptom_id', '=', $customer_symptom_id)->first();

        return View::make('customer.ajaxsymptomedit')->with(array('symptomdetail'=>$symptomdetail));
        exit;
    }
    
    public function anyAjaxprocesssymptomedit(){

        $post_arr           = Input::all();
        
        // update data
        $customerSymptomTable = DB::table('customer_symptoms')->where('customer_symptom_id', '=', $post_arr['customer_symptom_id']);       
        $customerSymptomObj = $customerSymptomTable->first();
        $update_data = array();
        $update_data['symptom_rate'] = $post_arr['symptom_rate'];
        $update_data['customer_note'] =  $post_arr['symptom_comment'];   
        $update_data['modified_date'] =  date("y-m-d H:i:s");
        $customerSymptomTable->update($update_data);
        
        // Insert into history table
        $insert_data = array();
        $insert_data['customer_id'] = $customerSymptomObj->customer_id;
        $insert_data['detail_id'] = $customerSymptomObj->detail_id;
        $insert_data['symptom_id'] = $customerSymptomObj->symptom_id;
        $insert_data['symptom_name'] = $customerSymptomObj->symptom_name;                
        $insert_data['symptom_rate'] = $post_arr['symptom_rate'];   
        $insert_data['customer_note'] = $post_arr['symptom_comment']; 
        $insert_data['created_date'] = date("y-m-d H:i:s");

        DB::table('customer_symptoms_his')->insert($insert_data); 
        return json_encode(array('error' => 0,'detail_id'=>$customerSymptomObj->detail_id)); exit;	
        
    }
    
    public function anyAjaxpaypalformcreation(){
        
        //ref:http://www.codexworld.com/paypal-standard-payment-gateway-integration-php/
        
        $paypalObj =DB::table('payment_configuration')->where('payment_method','=','PAYPAL')->select('payment_details')->first();           
        $paymentObj = json_decode($paypalObj->payment_details); 
        $paypalUrl = $paymentObj->url; //'https://www.sandbox.paypal.com/cgi-bin/webscr'
        $paypalId = $paymentObj->email; //'linto.davis-facilitator@calpinetech.com'
            
        $casefileToHPId = $_POST['casefileToHPId'];
        $caseFileToHPObj= DB::table('casefile_to_healthcare')->where('casefile_to_healthcare_id', '=',$casefileToHPId)->first(); 
        $amtToPaid  = $caseFileToHPObj->healthcare_charge;
        
        $paypalInfo = array();
        $paypalInfo['action_url']= $paypalUrl;
        $paypalInfo['paypal_id']= $paypalId;
        $paypalInfo['item_name']= 'Provider Fee';
        $paypalInfo['item_number']= 1;
        $paypalInfo['amount']= $amtToPaid;
        $paypalInfo['currency_code']= 'USD';
        $paypalInfo['custom']= "casefileToHPId=".$casefileToHPId;
        
        $paypalInfo['cancel_return']= URL::to('/').'/customer/paypalcancel';
        $paypalInfo['return']= URL::to('/').'/customer/paypalsuccess';
        $paypalInfo['notify_url']= URL::to('/').'/customer/paypalnotify';
              
        return View::make('customer.ajaxpaypalformcreation')->with(array('data'=>$paypalInfo));
        exit;       
        
    }
    public function anyPaypalsuccess(){       
        
 
        $successMessage ="Thank you for making payment with us.Details will be sent your email.";
        Session::flash('flash_msg',$successMessage);
        return View::make('customer.paypalsuccess');
        exit; 
        
//        $paypalResponse = $_POST;
//        
//        $fileContent  ="\n\n========================";
//        $fileContent .="\nNew transaction";
//        $fileContent .="\n========================";
//        $fileContent .= print_r($paypalResponse,true);
//        
//        // Create log
//        $filename = date('M d,Y')."_success.txt";
//
//              
//        echo '<pre>';print_r($paypalResponse);
//        //Get casefileToHPId
//        $explodeArr = explode("=",$paypalResponse['custom']);
//        $casefileToHPId = $explodeArr[1];
//        echo "<br>casefileToHPId =".$casefileToHPId;
//        
//        if(strtolower($paypalResponse['payment_status']) == 'completed'){
//            
//            // Check, this transaction id is already exist in our DB or Not
//            $transactionId  = $paypalResponse['txn_id'];
//            $amtPaid = $paypalResponse['mc_gross'];
//            $currency = $paypalResponse['mc_currency'];
//            
//            $tableObj = DB::table('customer_to_healthcare_payment_details')->where('transaction_id', '=', $transactionId)->first(); 
//            if(count($tableObj)>0){
//                
//                $successMessage ="Transaction is successful,Transaction ID:$transactionId Amount:$amtPaid $currency";
//                
//                $errorMessage = "May it is already updated by notify url ,Transaction id : $transactionId is already exist.";
//                
//                $fileContent.="\n$errorMessage";
//                $this->write_paypal_log($filename,$fileContent);
//                
//                session::flash("flash_msg",$successMessage);
//                return View::make('customer.paypalsuccess');
//                exit;  
//                
//            }else{
//                // No such transaction id, so we can  continue with DB operation
//                              
//                $caseFileToHPObj= DB::table('casefile_to_healthcare')->where('casefile_to_healthcare_id', '=',$casefileToHPId)->first();            
//                
//
//                // Insert an entry to customer_to_healthcare_payment_details
//                $insert_data['transaction_id'] = $transactionId;
//                $insert_data['casefile_to_healthcare_id'] = $casefileToHPId;
//                $insert_data['healthcare_id'] = $caseFileToHPObj->healthcare_professional_id;   
//                $insert_data['transaction_amount'] = $amtPaid;
//                $insert_data['payment_status'] = "success";                   
//                $customer_to_healthcare_payment_detail_id = DB::table('customer_to_healthcare_payment_details')->insertGetId($insert_data);
//
//
//                //Update the payment status  in 'casefile_to_healthcare' 
//                DB::table('casefile_to_healthcare')->where("casefile_to_healthcare_id","=",$casefileToHPId)->update(array('payment_status'=>1));
//
//                if($customer_to_healthcare_payment_detail_id)  { 
//                    
//                    // Success Message    
//                    $successMessage ="Transaction is successful,Transaction ID:$transactionId Amount:$amtPaid $currency";
//
//                    $fileContent.="\n$successMessage";
//                    $this->write_paypal_log($filename,$fileContent);                     
//                    Session::flash('flash_msg',$successMessage);
//                
//                }else{
//                
//                    $errorMessage = "Some error has happend while updating the DB";
//
//                    $fileContent.="\n$errorMessage";
//                    $this->write_paypal_log($filename,$fileContent);   
//
//                    session::flash("error_msg",$errorMessage);
//                }               
//      
//                return View::make('customer.paypalsuccess');
//                exit;               
//            }
//           
//        }else{
//            
//            $errorMessage = "Some error has happend.Payment status : ".$paypalResponse['payment_status'];
//
//            $fileContent.="\n$errorMessage";
//            $this->write_paypal_log($filename,$fileContent); 
//            
//            session::flash("error_msg",$errorMessage);
//            return View::make('customer.paypalsuccess')->with(array('data'=>$paypalInfo));
//            exit;
//        }
    }
    
    public function anyPaypalnotify(){
        
        $paypalResponse = $_POST;
        $fileContent  ="\n\n========================";
        $fileContent .="\n New transaction";
        $fileContent .="\n========================";
        $fileContent .= print_r($paypalResponse,true);            
        // Create log
        $filename = date('M d,Y')."_notify.txt"; 
        
        //Get casefileToHPId
        $explodeArr = explode("=",$paypalResponse['custom']);
        $casefileToHPId = $explodeArr[1];

        
        if(strtolower($paypalResponse['payment_status']) == 'completed'){
            

            $transactionId  = $paypalResponse['txn_id'];
            $amtPaid = $paypalResponse['mc_gross'];
            $currency = $paypalResponse['mc_currency'];
            
            // Check, this transaction id is already exist in our DB or Not
            $tableObj = DB::table('customer_to_healthcare_payment_details')->where('transaction_id', '=', $transactionId)->first(); 
            if(count($tableObj)>0){
                
                $errorMessage = "Some error has happend.Transaction id : $transactionId is already exist.";
                
                $fileContent.="\n$errorMessage";
                $this->write_paypal_log($filename,$fileContent);
                die();
                
            }else{
                
                // No such transaction id, so we can  continue with DB operation
                              
                $caseFileToHPObj= DB::table('casefile_to_healthcare')->where('casefile_to_healthcare_id', '=',$casefileToHPId)->first();            
                

                // Insert an entry to customer_to_healthcare_payment_details
                $insert_data['transaction_id'] = $transactionId;
                $insert_data['casefile_to_healthcare_id'] = $casefileToHPId;
                $insert_data['healthcare_id'] = $caseFileToHPObj->healthcare_professional_id;   
                $insert_data['transaction_amount'] = $amtPaid;
                $insert_data['payment_status'] = "success";                   
                $customer_to_healthcare_payment_detail_id = DB::table('customer_to_healthcare_payment_details')->insertGetId($insert_data);


                //Update the payment status  in 'casefile_to_healthcare' 
                DB::table('casefile_to_healthcare')->where("casefile_to_healthcare_id","=",$casefileToHPId)->update(array('payment_status'=>1));

                if($customer_to_healthcare_payment_detail_id)  { 
                    
                    // Success Message    
                    $successMessage ="Transaction is successful,Transaction ID:$transactionId Amount:$amtPaid $currency";

                    $fileContent.="\n$successMessage";
                    $this->write_paypal_log($filename,$fileContent);                     
                    die();
                
                }else{
                
                    $errorMessage = "Some error has happend while updating the DB";

                    $fileContent.="\n$errorMessage";
                    $this->write_paypal_log($filename,$fileContent);   
                    die();
                }                            
            }
           
        }else{
            
            $errorMessage = "Some error has happend.Payment status : ".$paypalResponse['payment_status'];

            $fileContent.="\n$errorMessage";
            $this->write_paypal_log($filename,$fileContent); 
            die();
        }
        
        $this->write_paypal_log($filename,$fileContent);
        die();
    }
    
    public function anyPaypalcancel(){
        
        $paypalResponse = $_POST;
        $fileContent  ="\n\n========================";
        $fileContent .="\n New transaction";
        $fileContent .="\n========================";
        $fileContent .= print_r($paypalResponse,true);
        
        $errorMessage ="Transaction has cancelled by customer";
        $fileContent .= "\n$errorMessage";
        
        // Create log
        $filename = date('M d,Y')."_cancel.txt";        
        $this->write_paypal_log($filename,$fileContent);

        session::flash("error_msg",$errorMessage);
        return View::make('customer.paypalcancel');
        exit;      
    }
    
    public function anyTest(){
        
        $report = (new BaseController)->get_casefile_report(380);
        $html =  View::make('customer.test')->with(array('report' => $report))->render();

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($html);
        $filename = "testpdf".'.pdf';
        $pdf->save(base_path().'/pdfreports/'.$filename);
        return $report;   die("ok");
        
    }
    
        public function anyTest1(){
        
        $report = (new BaseController)->get_casefile_report(380);
        return View::make('customer.test',array('report'=>$report));
        
    }
    
    public function anyAjaxdropboxfiles($customerDetailId,$action=null,$fileId=null){ 
        
        // Add or Delete dropbox files
                
        if(!$this->anyChecklogin()){
            return Redirect::to('customer/login/');
        }        
        
        $customerid = Session::get('customer_id');
        $customerObj = DB::table('customers')->where('customers.customer_id','=',$customerid)->first();
        $data['site_url'] =URL::to('/');
        
        $post_arr           = Input::all();
        
        switch($action){
            
            case 'add':
       
            foreach($post_arr['drop_box_link'] as $dropboxLink){

                $insert_data = array();
                $insert_data['customer_detail_id'] = $customerDetailId;
                $insert_data['file_path'] = $dropboxLink;
                DB::table('customerdetail_to_dropbox')->insert($insert_data);

            }

            return json_encode(array('error' => 0)); exit; 
                
            case 'delete':
                 DB::table('customerdetail_to_dropbox')->where('customerdetail_to_dropbox.customerdetail_to_dropbox_id','=',$fileId)->delete(); 
                 return json_encode(array('error' => 0)); exit;   
            
            case 'list':
                $files = DB::table('customerdetail_to_dropbox')->where('customer_detail_id', '=', $customerDetailId)->get();
                $html ="";
                foreach($files as $file) {
                    $html .='<p id="dropbox_'.$file->customerdetail_to_dropbox_id.'">';
                    $html .='<a href="'.$file->file_path.'" target="_blank">';
                    $html .= $file->file_path;
                    $html .= '</a>&nbsp;';
                    $html .= '<a href="javascript:void(0);" onclick="delete_dropbox_files('.$file->customerdetail_to_dropbox_id.')">';
                    $html .= '<i aria-hidden="true" class="fa fa-times-circle"></i>';
                    $html .= '</a></p>';                   
                }
                return json_encode(array('error' => 0,'html' => $html)); exit;   
                   
        }
        
        $data['customer_detail_id'] = $customerDetailId;
        return View::make('customer.uploadfiles')->with(array('data' => $data));
        exit;
    }
    public function write_paypal_log($fileName, $str){
     
        $filename =base_path()."/uploads/paypal_log/$fileName";
        $fp = fopen($filename,'a+');
        fwrite($fp, $str); 
    }
    public function anyChecklogin(){
        
        // Check whether customer has logined or not
        if(isset($_SESSION['customer_id']) && $_SESSION['customer_id'] >0){
            return true;
        }else{
            return false;
        }
        
    }    
    
}
