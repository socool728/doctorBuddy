<?php namespace App\Http\Controllers;
use Illuminate\Http\Request;
//use Illuminate\Routing\Controller;
Use Input;
Use View;
Use App\Models\Answers;
Use DB;
use Session;
use Redirect;
use Auth;
use App\Models\User;
use Event;
use Validator;
use URL;
use DateTime;
//use Symfony\Component\HttpFoundation\Request;
class AdminController extends Controller {

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
    function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        
        $this->beforeFilter(function()
        {
            if(!$this->anyChecklogin()){
//            if(Auth::check()!=true)
//            {    
                return Redirect::to('admin/login');
            }
        },array('except' => array('postCheck','anyLogin')));
//        },array('except' => array('login','postLogin')));
    }
    //  show login page for admin   
    public function getIndex($flag='')    
    {
        $questions = DB::table('questions')->leftjoin('depend_question', 'questions.question_id', '=', 'depend_question.depend_question_id')->orderBy('display_order', 'ASC')->groupBY('questions.question_id')->select('questions.*','depend_question.depend_id')->get();
        return View::make('admin.question')->with(array('questions' => $questions));
    }
    public function anyLogin($flag='')    
    {
        $data = array();
        $data['site_url'] =  URL::to('/');      
        $post = Input::all();
        
        if(isset($post['submit'])){
            $admin = array();
            $pwd = md5(trim($post['user_password']));  
            $admin = DB::table('administrators')->where('username',$post['user_email_id'])->where('admin_status',1)->first();
            if(count($admin)>0 && $admin->admin_password==$pwd){
                $_SESSION['admin_id']=$admin->admin_id;
                Session::put('admin_id',$admin->admin_id);

                if($admin->admin_type == 0 || $admin->admin_type == 1){
                    return Redirect::to('admin/questions');
                }
            }else{
                  $msg='Sorry login failed..Retry again';
                  Session::flash('login_msg','Sorry Login Failed');
                  return Redirect::to('admin/login');
            }
        }
        return View::make('admin.login')->with(array('data'=>$data));

    }
    public function postCheck(){  

        $data = Input::all();
        if(isset($data['log'])){
            $admin = array();
            $pwd = md5(trim($data['user_password']));  
//            $pwd = trim($data['user_password']); 
            $admin = DB::table('administrators')->where('username',$data['user_email_id'])->where('admin_status',1)->first();
            if(count($admin)>0 && $admin->admin_password==$pwd){
                $_SESSION['admin_id']=$admin->admin_id;
                Session::put('admin_id',$admin->admin_id);
//                     Auth::login($user);
                if($admin->admin_type == 0 || $admin->admin_type == 1){
                    return Redirect::to('admin/questions');
                }
            }else{
                  $msg='Sorry login failed..Retry again';
        Session::flash('login_msg','Sorry Login Failed');
//            return Redirect::action('AdminController@getIndex',array());
                return Redirect::to('admin/login');
            }
        }
        return View::make('admin.login');
    }
        //  show logout page

   
    public function anyQuestions(){
//            echo Session::get('admin_id')."KK";
        $questions = DB::table('questions')->leftjoin('depend_question', 'questions.question_id', '=', 'depend_question.depend_question_id')->leftjoin('questiongroup', 'questions.question_group_id', '=', 'questiongroup.group_id')->orderBy('questions.display_order', 'ASC')->groupBY('questions.question_id')->select('questions.*','depend_question.depend_id','questiongroup.group_name')->get();
        return View::make('admin.question')->with(array('questions' => $questions));
    }
    public function anyDelQuestion($id=''){       
        if($id!=''){
            $optiondetail = DB::table('options')->where('options.question_id', '=', $id)->get();
            if(count($optiondetail) > 0) {
                DB::table('options')->where('question_id', '=', $id)->delete();
            }
            $dependdetail = DB::table('depend_question')->where('depend_question.current_question_id', '=', $id)->get();
            if(count($dependdetail) > 0) {
                DB::table('depend_question')->where('current_question_id', $id)->delete();                
            }
            DB::table('questions')->where('question_id','=',$id)->delete();  
            return Redirect::action('AdminController@anyQuestions');
        }        
    }
    public function anyDelStaff($id=''){    
        if(Session::get('admin_id')!='1'){
            return Redirect::to('admin/questions');
        }
       if($id!=''){
        DB::table('administrators')->where('admin_id','=',$id)->delete();          
         return Redirect::action('AdminController@anyStaff');
       }        
    }
    public function anyDelSymptom($id=''){       
       if($id!=''){
        DB::table('symptoms')->where('symptom_id','=',$id)->delete();  
        
         return Redirect::action('AdminController@anySymptom');
       }        
    }
    public function anyStaff(){
        if(Session::get('admin_id')!='1'){
            return Redirect::to('admin/questions');
        }
        $staffs = DB::table('administrators')->orderBy('admin_id', 'DESC')->get();
        return View::make('admin.staff')->with(array('staffs' => $staffs));
    }
    
    public function anyCustomer($type='',$id=''){
        
        $data['site_url'] = URL::to('/');
        switch ($type) {
            
            case  'add':
                        $post_arr=Input::all();                            
 
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
                                    //'password' => 'required|regex:/(^(?=.{6,})(?=.*[!@#$%^&*()+=]).*$)+/' ,
                                    'password' => 'required|min:4' ,
                                    'password2' => 'required|same:password',
                                 )
   

                                );

                                if ($validator->fails())
                                {
                                    $messages   = $validator->messages();   
                                    $err_msg  = '';
                                    foreach ($messages->all() as $msg) {
                                            $err_msg .= '<br/><i>'.$msg.'</i>';
                                    }
                                    return json_encode(array('error' => 1, 'err_msg' => $err_msg)); exit;

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
                                $insert_data['customer_email_id'] = $email =trim($post_arr['customer_email_id']);
                                $insert_data['customer_fname'] = trim($post_arr['customer_fname']);
                                $insert_data['customer_lname'] = trim($post_arr['customer_lname']);
                                $insert_data['customer_status'] = 1;  
                                $insert_data['email_verify'] = 1; 
                                $insert_data['customer_password'] = (new BaseController)->encrypt_decrypt(trim($post_arr['password']));
                                $insert_data['customer_phone_code'] = trim($post_arr['customer_phone_code']);
                                $insert_data['customer_phone'] = trim($post_arr['customer_phone']);
                                $insert_data['created_at'] = date('Y-m-d H:i:s');
                                $insert_data['updated_at'] = date('Y-m-d H:i:s');

                                $customer_id = DB::table('customers')->insertGetId($insert_data);
                                $detail_data = array();
                                $detail_data['customer_id'] = $customer_id;
                                $detail_data['customer_code'] = $customer_code;
                                //$detail_data['customer_nickname'] = trim($post_arr['nick_name']);
                                $detail_data['customer_no'] = $customer_no;
                                $detail_data['country_id'] = trim($post_arr['customer_country']);
                                $detail_data['customer_state'] = $customer_state;
                                $detail_data['customer_city'] = trim($post_arr['customer_city']);
                                $detail_data['customer_zip'] = trim($post_arr['customer_zip']); 
                                $detail_data['customer_area'] = trim($post_arr['customer_area']);  
                                $detail_data['customer_status'] = 1;
                                $detail_data['is_casefile'] = 0;  // This is  registration , not a case file
                                $detail_data['created_at'] = date('Y-m-d H:i:s');
                                $detail_data['updated_at'] = date('Y-m-d H:i:s');
                                $detail_id = DB::table('customer_detail')->insertGetId($detail_data);
                                if($detail_id >0){
                                    // Send Mail    
                                    
                                    $result= (new BaseController)->send_customer_registration_mail($customer_id,trim($post_arr['password']));
                                    
                                    if($result){                                      
                                        Session::flash('flash_msg','Customer created successfully !');
                                        return json_encode(array('error' => 0)); exit;                                     
                                    }else{
                                        return json_encode(array('error' => 1,'err_msg'=>'Mail sending Failed.')); exit;
                                    }
                                    
                                }else{
                                    return json_encode(array('error' => 1,'err_msg'=>'Something went wrong, please try again.')); exit;
                                }                            
                
                

                        }else{ 
                            $countries = DB::table('country')->orderBy('country_id', 'ASC')->select('country_id','countryname','phoneCode')->get();
                            $data['countries'] = $countries;
                            return View::make('admin.addcustomer')->with(array('data' => $data));
                        }
            case  'edit': 
                
                        $post_arr           = Input::all();                     ;
  
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
                                 'customer_city'  => $post_arr['customer_city'],
                                 'password'  => $post_arr['password'],
                                 'repeat_password'  => $post_arr['password2']
                             ),
                             array(
                                 'customer_fname' => 'required',
                                 'customer_lname' => 'required',
                                 'customer_phone_code' => 'required',
                                 'customer_phone' => 'required|max:13',
                                 'customer_zip' => 'required',
                                 'customer_country' => 'required',
                                 'customer_state' => 'required',
                                 'customer_city' => 'required',
                                 'password' => 'same:repeat_password|min:4',
                                 'repeat_password' => 'same:password|min:4',
                                 
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
                            
                            $id = $post_arr['customer_id'];
                            $customerinfo = DB::table('customers')->where('customers.customer_id', '=',$id)->first();
                            
                            if(!is_object($customerinfo)){
                                return json_encode(array('error' => 1, 'err_msg' => "Customer dosen't exist in our account")); exit;
                            }
                          

                            $update_data = array();
                            $update_data['customer_fname']       = $post_arr['customer_fname'];
                            $update_data['customer_lname']       =$post_arr['customer_lname'];
                            $update_data['customer_phone_code']  =$post_arr['customer_phone_code'];
                            $update_data['customer_phone']       =$post_arr['customer_phone'];
                            $update_data['updated_at']           =    date('Y-m-d H:i:s');

                            if(isset($post_arr['password'])){
                                $update_data['customer_password']           =    (new BaseController)->encrypt_decrypt(trim($post_arr['password']));
                            }
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

                                //Not Important.This situation will only comes for old existing records
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

                        }else{ 
                            $countries = DB::table('country')->orderBy('country_id', 'ASC')->select('country_id','countryname','phoneCode')->get();
                            $data['countries'] = $countries;                            
                            $customerinfo = DB::table('customers')->where('customers.customer_id', '=',$id)->first();
                            
                            if(!is_object($customerinfo))
                                return Redirect::to('admin/customer');
                            
                            $data['customer_id'] = $id;
                            $data['customer_email_id'] = $customerinfo->customer_email_id;
                            $data['customer_name'] = $customerinfo->customer_fname." ".$customerinfo->customer_lname;
                            $data['customer_fname'] = $customerinfo->customer_fname;
                            $data['customer_lname'] = $customerinfo->customer_lname;
                            $data['customer_phone_code'] = $customerinfo->customer_phone_code;
                            $data['customer_phone'] = $customerinfo->customer_phone;
                            $data['customer_state'] = "";
                            $data['customer_zip'] = "";
                            $data['customer_city'] = "";
                            $data['customer_area'] = "";                                     
                            $data['customer_country'] = "";

                            $customerinfo = DB::table('customer_detail')
                                    ->leftjoin('country', 'customer_detail.country_id', '=', 'country.country_id')
                                    ->where('customer_detail.customer_id', '=',$id)
                                    ->where('customer_detail.is_casefile', '=',0)
                                    ->first();
                            
                                if(count($customerinfo)>0){                    
                                    $data['customer_state'] = $customerinfo->customer_state;
                                    $data['customer_zip'] = $customerinfo->customer_zip;
                                    $data['customer_city'] = $customerinfo->customer_city;
                                    $data['customer_area'] = $customerinfo->customer_area;                                        
                                    $data['customer_country'] = $customerinfo->country_id;
                                }
                            return View::make('admin.editcustomer')->with(array('data' => $data));
                        }        
            case  'delete':
                if($id){

                    $customerObj = DB::table('customers')->where("customer_id","=",$id);
                    if($customerObj){
                        $customerObj->update(array('is_deleted'=>1));
                        Session::flash('flash_msg','Record deleted successfully !');
                        return json_encode(array('error' => 0)); exit;
                    }else{
                        return json_encode(array('error' => 1,'err_msg' => "Some error has occured.Please try after some time")); exit;
                    }
                } 
                return  json_encode(array('error' => 1,'err_msg'=>'Customer is missing')); exit;  
            default:

                $customers = DB::table('customers')
                 ->leftjoin('customer_detail', 'customers.customer_id', '=', 'customer_detail.customer_id')
                 ->where('customer_detail.is_casefile','!=',1)
                 ->where('customers.is_deleted','=',0)   
                 ->select('customers.customer_id','customers.customer_email_id','customers.customer_fname','customers.customer_lname','customers.created_at')
                 ->orderBy('customers.customer_id', 'DESC')->groupBY('customers.customer_id')->get();

                return View::make('admin.customer')->with(array('data' => $data,'customers' => $customers));
        
        }
    }
    public function anyReport($id=null){    
            if($id >0){  
                $detail_data = array();
//                $customerinfo = DB::table('customers')->where('customer_id', '=',$id)->first();
//                if(count($customerinfo)>0){
//                    $data['customer_email_id'] = $customerinfo->customer_email_id;
//                    $data['customer_id'] = $customerinfo->customer_id;
//                    $data['customer_name'] = $customerinfo->customer_name;
//                    $data['customer_nickname'] = $customerinfo->customer_nickname;
//                }
                $custdetail = DB::table('customer_detail')->leftjoin('customers', 'customer_detail.customer_id', '=', 'customers.customer_id')->where('customer_detail_id', '=', $id)->get();
//                print_r($custdetail);
                if (count($custdetail) > 0) {
                    foreach ($custdetail as $custdata) {
                        $detailreport = array();
                        $detail_data[] = $custdata->customer_detail_id;
                        $detailreport[] = $custdata->customer_fname." ".$custdata->customer_lname;
                        $detailreport[] = $custdata->customer_nickname;
                        $detailreport[] = 'DB'.$custdata->customer_code."-".$custdata->customer_no;
                        
                        $data['customer_email_id'] = $custdata->customer_email_id;
                    $data['customer_id'] = $custdata->customer_id;
                    $data['customer_name'] = $custdata->customer_fname." ".$custdata->customer_lname;
                    $data['customer_nickname'] = $custdata->customer_nickname;
                    }
                }
//                print_r($detail_data);
                if(count($detail_data)>0){
                    $data['detail'] = $detail_data;
                    foreach($detail_data as $detaild){
//                        echo $detaild."DD<br>";
//                        $detail_data[] = $detaild;
                        $data[$detaild]['detailinfo'] = $detailreport;
//                        $detail = DB::table('customer_detail')->where('customer_detail_id', '=', $detaild)->first();
                        $detail = DB::table('customer_detail')->leftjoin('country', 'customer_detail.country_id', '=', 'country.country_id')->where('customer_detail_id', '=',$detaild)->first();
        //                print_r($custdetail);
//                        $data[$detaild]['customer_name'] = $detail->customer_name;
//                        $data[$detaild]['customer_name'] = $detail->customer_fname." ".$detail->customer_lname;
                        $data[$detaild]['customer_city'] = $detail->customer_city;
                        $data[$detaild]['customer_country'] = $detail->countryname;
                        $data[$detaild]['customer_state'] = $detail->customer_state;
                        $data[$detaild]['customer_zip'] = $detail->customer_zip;
                        $data[$detaild]['customer_nickname'] = $detail->customer_nickname;
                        $data[$detaild]['known_disease'] = $detail->known_disease;
                        $data[$detaild]['customer_for_whom'] = $detail->customer_for_whom;
                        $data[$detaild]['customer_age'] = $detail->customer_age;
                        $data[$detaild]['customer_sex'] = $detail->customer_sex;
                        $data[$detaild]['customer_fileno'] = 'DB'.$detail->customer_code."-".$detail->customer_no;
//                        if (count($detail) > 0) {
//                            foreach ($custdetail as $custdata) {
//                                $detailreport = array();
//                                $detail_data[] = $custdata->customer_detail_id;
//                                $detailreport[] = $custdata->customer_name;
//                                $detailreport[] = $custdata->customer_nickname;
//                                $detailreport[] = 'DB'.$custdata->customer_code."-".$custdata->customer_no;
//                            }
//                        }
                        $ansdetail = DB::table('customer_answers')->where('customer_answers.detail_id', '=', $detaild)->get();
        //                print_r($ansdetail);
                        if (count($ansdetail) > 0) {
                            foreach ($ansdetail as $ansdata) {
                                $data[$detaild]['answers'][] = $ansdata;
        //                        $data['username'] = $admindata->username;
                            }
                        }
                        $symptomdetail = DB::table('customer_symptoms')->where('customer_symptoms.detail_id', '=', $detaild)->get();
        //                print_r($symptomdetail);
                        if (count($symptomdetail) > 0) {
                            foreach ($symptomdetail as $symptomdata) {
                                $data[$detaild]['symptoms'][] = $symptomdata;
        //                        $data['username'] = $admindata->username;
                            }
                        }
                    }
                }
                /*
                $ansdetail = DB::table('customer_answers')->where('customer_answers.customer_id', '=', $id)->get();
//                print_r($ansdetail);
                if (count($ansdetail) > 0) {
                    foreach ($ansdetail as $ansdata) {
                        $data['answers'][] = $ansdata;
//                        $data['username'] = $admindata->username;
                    }
                }
                $symptomdetail = DB::table('customer_symptoms')->where('customer_symptoms.customer_id', '=', $id)->get();
//                print_r($symptomdetail);
                if (count($symptomdetail) > 0) {
                    foreach ($symptomdetail as $symptomdata) {
                        $data['symptoms'][] = $symptomdata;
//                        $data['username'] = $admindata->username;
                    }
                }*/
            }
//            echo '<pre>';
//            print_r($data);
//            $questions = DB::table('questions')->orderBy('display_order', 'ASC')->get();
            //$answers = Answers::orderBy('modified_date', 'DESC')->get();
//            echo '<pre>';
//            print_r($data);
            return View::make('admin.report')->with(array('data' => $data));

    }
    public function anyView($id=null){    
            if($id >0){  
                $detail_data = array();
                $customerinfo = DB::table('customers')->where('customer_id', '=',$id)->first();
                if(count($customerinfo)>0){
                    $data['customer_email_id'] = $customerinfo->customer_email_id;
                    $data['customer_id'] = $customerinfo->customer_id;
                    $data['customer_name'] = $customerinfo->customer_fname." ".$customerinfo->customer_lname;
//                    $data['customer_nickname'] = $customerinfo->customer_nickname;
                }
                $custdetail = DB::table('customer_detail')->where('customer_id', '=', $id)->get();
//                print_r($custdetail);
                if (count($custdetail) > 0) {
                    foreach ($custdetail as $custdata) {
                        $detailreport = array();
                        $detail_data[] = $custdata->customer_detail_id;
//                        $detailreport[] = $custdata->customer_fname." ".$custdata->customer_lname;
                        $detailreport[] = $custdata->customer_nickname;
                        $detailreport[] = 'DB'.$custdata->customer_code."-".$custdata->customer_no;
                    }
                }
//                print_r($detail_data);
                if(count($detail_data)>0){
                    $data['detail'] = $detail_data;
                    foreach($detail_data as $detaild){
//                        echo $detaild."DD<br>";
//                        $detail_data[] = $detaild;
                        $data[$detaild]['detailinfo'] = $detailreport;
//                        $detail = DB::table('customer_detail')->where('customer_detail_id', '=', $detaild)->first();
                        $detail = DB::table('customer_detail')->leftjoin('country', 'customer_detail.country_id', '=', 'country.country_id')->where('customer_detail_id', '=',$detaild)->first();
        //                print_r($custdetail);
                        $data[$detaild]['customer_id'] = $detail->customer_id;
                        $data[$detaild]['detail_id'] = $detail->customer_detail_id;
//                        $data[$detaild]['customer_name'] = $detail->customer_name;
//                        $data[$detaild]['customer_name'] = $detail->customer_fname." ".$detail->customer_lname;
                        $data[$detaild]['customer_city'] = $detail->customer_city;
                        $data[$detaild]['customer_country'] = $detail->countryname;
                        $data[$detaild]['customer_state'] = $detail->customer_state;
                        $data[$detaild]['customer_zip'] = $detail->customer_zip;
                        $data[$detaild]['customer_nickname'] = $detail->customer_nickname;
                        $data[$detaild]['known_disease'] = $detail->known_disease;
                        $data[$detaild]['customer_for_whom'] = $detail->customer_for_whom;
                        $data[$detaild]['customer_age'] = $detail->customer_age;
                        $data[$detaild]['customer_sex'] = $detail->customer_sex;
                        $data[$detaild]['customer_fileno'] = 'DB'.$detail->customer_code."-".$detail->customer_no;
                        $ansdetail = DB::table('customer_answers')->where('customer_answers.detail_id', '=', $detaild)->get();
        //                print_r($ansdetail);
                        if (count($ansdetail) > 0) {
                            foreach ($ansdetail as $ansdata) {
                                $data[$detaild]['answers'][] = $ansdata;
        //                        $data['username'] = $admindata->username;
                            }
                        }
                        $symptomdetail = DB::table('customer_symptoms')->where('customer_symptoms.detail_id', '=', $detaild)->get();
        //                print_r($symptomdetail);
                        if (count($symptomdetail) > 0) {
                            foreach ($symptomdetail as $symptomdata) {
                                $data[$detaild]['symptoms'][] = $symptomdata;
        //                        $data['username'] = $admindata->username;
                            }
                        }
                    }
                }
            }
            return View::make('admin.view')->with(array('data' => $data));

    }
    public function anyAddQuestion(){
        $data = Input::all();   
        if(isset($data['question'])){
            $insert_data = array();
            if (isset($data['question'])) {
                $insert_data['question'] = trim($data['question']);
            }
            if (isset($data['display_order'])) {
                $insert_data['display_order'] = trim($data['display_order']);
            }
            if (isset($data['question_group_id'])) {
                $insert_data['question_group_id'] = trim($data['question_group_id']);
            }
            if (isset($data['question_type'])) {
                $insert_data['question_type'] = trim($data['question_type']);
            }
            if (isset($data['dependable_question'])) {
                $insert_data['dependable_question'] = trim($data['dependable_question']);
            }
            if (isset($data['field_required'])) {
                $insert_data['field_required'] = trim($data['field_required']);
            }
            if (isset($data['validator_title'])) {
                $insert_data['validator_title'] = trim($data['validator_title']);
            }
            if (count($insert_data) > 0 ) {
                $qn_id = DB::table('questions')->insertGetId($insert_data);
            }
            if ($qn_id >0 && isset($data['options'])) {
                $option_arr = explode(",",trim($data['options']));                    
                foreach($option_arr as $val){
                    $option_data = array();
                    $option_data['option_name'] = $val;
                    $option_data['question_id'] = $qn_id;
                    DB::table('options')->insert($option_data);
                }
            }
            if($qn_id >0 && isset($data['dependable_question'])) {
                if($data['dependable_question'] ==1){
                    if(count($data['depend_ans']) >0){
                        $depend_op = '';
                        foreach($data['depend_ans'] as $val){
                            if($val != ''){
                             $depend_op .= $val.",";
                            }                               
                        }
                        $depend_data['depend_question_ans'] = substr($depend_op,0,-1);                            
                    }
                    $depend_data['current_question_id'] = $qn_id;
                    $depend_data['depend_question_id'] = $data['depend_option']; 
                    $depend_data['current_question_display'] = 1;
                    $depend_data['status'] = 1;
                    DB::table('depend_question')->insert($depend_data);
                }                    
            }
            return Redirect::to('admin/questions');               
        }else{
            $data['questiongroups'] = DB::table('questiongroup')->orderBy('questiongroup.display_order', 'ASC')->get();
            $data['questions'] = DB::table('questions')->whereIn('question_type', array('radio','select','check'))->orderBy('display_order', 'ASC')->get();
            return View::make('admin.addquestion')->with(array('data' => $data));
        }
        $questions = DB::table('questions')->orderBy('display_order', 'ASC')->get();
        return View::make('admin.addquestion')->with(array('questions' => $questions));
    }
    public function anyEditQuestion($id=null){
//              $answers = DB::table('mind_answers')->orderBy('modified_date', 'DESC')->get();
//            //$answers = Answers::orderBy('modified_date', 'DESC')->get();
//            return View::make('admin.dashboard')->with(array('answers' => $answers));
        $data = Input::all();

        if(isset($data['question'])){               

            $update_data = array();
            if (isset($data['question'])) {
                $update_data['question'] = trim($data['question']);
            }
            if (isset($data['question_type'])) {
                $update_data['question_type'] = trim($data['question_type']);
            }
            if (isset($data['display_order'])) {
                $update_data['display_order'] = trim($data['display_order']);
            }
            if (isset($data['question_group_id'])) {
                $update_data['question_group_id'] = trim($data['question_group_id']);
            }
            if (isset($data['dependable_question'])) {
                $update_data['dependable_question'] = trim($data['dependable_question']);
            }
            if (isset($data['field_required'])) {
                $update_data['field_required'] = trim($data['field_required']);
            }
            if (isset($data['validator_title'])) {
                $update_data['validator_title'] = trim($data['validator_title']);
            }
//                if (isset($data['admin_password'])) {
//                    $update_data['admin_password'] = md5(trim($data['admin_password']));
//                }
            if (count($update_data) > 0 && $data['question_id'] > 0) {
                DB::table('questions')->where('question_id', $data['question_id'])->update($update_data);
                $optiondetail = DB::table('options')->where('options.question_id', '=', $data['question_id'])->get();
                if(count($optiondetail) > 0) {                    
                    //Remove from depend_question
                    DB::table('depend_question')->where('depend_question_id', '=', $data['question_id'])->delete();
                    DB::table('options')->where('question_id', '=', $data['question_id'])->delete();
                }
                if(isset($data['option_name'])){
                    if(count($data['option_name']) >0){
                        foreach($data['option_name'] as $val){
                            if($val != ''){
                            $option_data = array();
                            $option_data['option_name'] = $val;
                            $option_data['question_id'] = $data['question_id'];
                            DB::table('options')->insert($option_data);
                            }
                        }
                    }
                }
                if($data['question_id'] >0 && isset($data['dependable_question'])) {          
                    $depend_data = array();
                    if($data['dependable_question'] ==1){
                        if(isset($data['depend_ans'])){
                            if(count($data['depend_ans']) >0){
                                $depend_op = '';
                                foreach($data['depend_ans'] as $val){
                                    if($val != ''){
                                     $depend_op .= $val.",";
                                    }                               
                                }
                                $depend_data['depend_question_ans'] = substr($depend_op,0,-1);                            
                            }  
                        }
                        $depend_data['depend_question_id'] = $data['depend_option']; 
                        $depend_data['current_question_display'] = 1;                            
                    }              
                    $dependdetail = DB::table('depend_question')->where('depend_question.current_question_id', '=', $data['question_id'])->get();
                    if(count($dependdetail) > 0) {
                        if(count($depend_data)>0){
                            DB::table('depend_question')->where('current_question_id', $data['question_id'])->update($depend_data);
                        }else{
                            DB::table('depend_question')->where('current_question_id', $data['question_id'])->delete();
                        } 
                    }else{
                        $depend_data['current_question_id'] = $data['question_id'];
                        $depend_data['status'] = 1;
                        DB::table('depend_question')->insert($depend_data);
                    }
                }
            }
            return Redirect::to('admin/questions');               
        }else{
            $qndetail = '';
            $data['questions'] = DB::table('questions')->whereIn('question_type', array('radio','select','check'))->orderBy('display_order', 'ASC')->get();
            $data['questiongroups'] = DB::table('questiongroup')->orderBy('questiongroup.display_order', 'ASC')->get();
            if($id >0){        
                $qndetail = DB::table('questions')->leftjoin('depend_question', 'questions.question_id', '=', 'depend_question.depend_question_id')->where('questions.question_id', '=', $id)->groupBY('questions.question_id')->get();
                if (count($qndetail) > 0) {
                    $drivingqns = array();
                    foreach ($qndetail as $qndata) {
                        $data['question_id'] = $qndata->question_id;
                        $data['question'] = $qndata->question;
                        $data['question_type'] = $qndata->question_type;
                        $data['question_group_id'] = $qndata->question_group_id;
                        $data['display_order'] = $qndata->display_order;
                        $data['dependable_question'] = $qndata->dependable_question;
                        $data['validator_title'] = $qndata->validator_title;
                        $data['field_required'] = $qndata->field_required;
                        if($qndata->depend_id>0){
                            $data['depend_qn'] =1;       
                            $dependqn = DB::table('depend_question')->leftjoin('questions', 'questions.question_id', '=', 'depend_question.current_question_id')->where('depend_question.depend_question_id', '=', $qndata->question_id)->select('questions.question_id','questions.question')->get();
                            if(count($dependqn)>0){                           
                                foreach($dependqn as $dependdata){
                                    $drivingqns[] = $dependdata->question; 
                                }
                            }
                        }else{
                            $data['depend_qn'] =0;
                        }
                        $data['driving_question'] = $drivingqns;
                        $optiondetail = DB::table('options')->where('options.question_id', '=', $qndata->question_id)->get();
                        if (count($optiondetail) > 0) {
                            $data_option_arr = array();
                            foreach ($optiondetail as $optiondata) {
                                $data_options = array();
                                $data_options['option_id'] = $optiondata->option_id; 
                                $data_options['option_name'] = $optiondata->option_name; 
                                $data_option_arr[] = $data_options;
                            }
                            $data['options'] = $data_option_arr;
                        }
                        if($qndata->dependable_question ==1){
                            $dependdetail = DB::table('depend_question')->leftjoin('questions', 'questions.question_id', '=', 'depend_question.depend_question_id')->leftjoin('questiongroup', 'questions.question_group_id', '=', 'questiongroup.group_id')->where('depend_question.current_question_id', '=', $qndata->question_id)->select('depend_question.depend_question_id','depend_question.depend_question_ans','questiongroup.group_name')->get();
                            if (count($dependdetail) > 0) {
                                $depend_option_arr = array();
                                foreach ($dependdetail as $dependdata) {
                                    $depend_options = array();
                                    $data['depend_question_id'] = $dependdata->depend_question_id;
                                    $depend_options = explode(",",$dependdata->depend_question_ans);
                                    $data['depend_question_ans'] = $depend_options;
                                    $data['depend_group_name'] = $dependdata->group_name;
                                }

                            }
                        }
                    }
                }
            }
        }
//            print_r($data);
//            $questions = DB::table('questions')->orderBy('display_order', 'ASC')->get();
        //$answers = Answers::orderBy('modified_date', 'DESC')->get();
        return View::make('admin.editquestion')->with(array('data' => $data));
    }
    public function anyEditStaff($id=null){
        if(Session::get('admin_id')!='1'){
            return Redirect::to('admin/questions');
        }
        $data = Input::all();
        if(isset($data['admin_email_id'])){
            include_once('class.phpmailer.php');
            $mail = new \PHPMailer();    
$mail->IsSMTP();
$mail->SMTPAuth = true;   
$smtp_mail ='calpinetechhelp@gmail.com';
$mail->SMTPSecure = "tls";
$mail->Host = "smtp.gmail.com";      
$mail->Port = "587"; 
$mail->Username = $smtp_mail;
$mail->Password = 'calpine123!';
$mail->From = $smtp_mail;
$mail->FromName = $smtp_mail;

$mail->Subject = "Account activation - Doctorbuddy.com";
$mail->Body = '<h3>Dear ,</h3>
    <p>Thank you for signing up with Doctorbuddy</p>
                <p>To be able to sign in to your account, please verify your email address first by clicking the following link:
Click Here<br/></p>
<p>Reagrds,<br/>Doctorbuddy.com</p>';
$mail->AltBody = "This is text only alternative body."; //Text Body


$mail->WordWrap = 500; // set word wrap
$emid ='georgejoseph77@gmail.com';
$mail->AddAddress($emid);
//        $mail->AddReplyTo($emid, "");

$mail->IsHTML(true); // send as HTML
if (!$mail->Send()) {

   echo "Error sending: " . $mail->ErrorInfo;;
}
else
{
   echo "Thank you. Your account activation link is send to your email.";
}
            $update_data = array();
            if (isset($data['admin_email_id'])) {
                $update_data['admin_email_id'] = trim($data['admin_email_id']);
            }
            if (isset($data['username'])) {
                $update_data['username'] = trim($data['username']);
            }
            if (isset($data['admin_status'])) {
                $update_data['admin_status'] = trim($data['admin_status']);
            }
//                if (isset($data['admin_password'])) {
//                    $update_data['admin_password'] = md5(trim($data['admin_password']));
//                }
            if (count($update_data) > 0 && $data['admin_id'] > 0) {
                DB::table('administrators')->where('admin_id', $data['admin_id'])->update($update_data);
            }

            return Redirect::to('admin/staff');               
        }else{
            $qndetail = '';
            if($id >0){        
                $admindetail = DB::table('administrators')->where('administrators.admin_id', '=', $id)->get();
                if (count($admindetail) > 0) {
                    foreach ($admindetail as $admindata) {
                        $data['admin_id'] = $admindata->admin_id;
                        $data['username'] = $admindata->username;
                        $data['admin_email_id'] = $admindata->admin_email_id;
                        $data['admin_status'] = $admindata->admin_status;
                    }
                }
            }
//            $questions = DB::table('questions')->orderBy('display_order', 'ASC')->get();
            //$answers = Answers::orderBy('modified_date', 'DESC')->get();
            return View::make('admin.editstaff')->with(array('data' => $data));
        }
    }
    public function anyAddStaff($id=null){
        if(Session::get('admin_id')!='1'){
            return Redirect::to('admin/questions');
        }
        $data = Input::all();
        if(isset($data['admin_email_id'])){
            $insert_data = array();
            if (isset($data['admin_email_id'])) {
                $insert_data['admin_email_id'] = trim($data['admin_email_id']);
            }
            if (isset($data['username'])) {
                $insert_data['username'] = trim($data['username']);
            }
            if (isset($data['password'])) {
                $insert_data['admin_password'] = md5(trim($data['password']));
            }
            if (isset($data['admin_status'])) {
                $insert_data['admin_status'] = trim($data['admin_status']);
            }
            if (count($insert_data) > 0 ) {
                $insert_data['admin_type'] = 1;
                DB::table('administrators')->insert($insert_data);
            }

            return Redirect::to('admin/staff');               
        }else{

            return View::make('admin.addstaff')->with(array('data' => $data));
        }
    }
    public function anyOption(){
        $data = Input::all();
        if($data['qnid'] >0){  
            $optiondetail = DB::table('options')->where('options.question_id', '=', $data['qnid'])->get();
            if (count($optiondetail) > 0) {
                $data_option_arr = array();
                $option ='';
                if($data['divid']==1){
                    $j= 0;
                }else{
                    $j= $data['divid']-1;
                }
                $result = '<div class="form-group" id="condition_'. $j.'">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Display if Answer is<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select class="form-control" id="depend_ans_'. $j.'" name="depend_ans[]" >
                                                    ';
                foreach ($optiondetail as $optiondata) {
                    $option .= '<option value="'.$optiondata->option_id.'" >'.$optiondata->option_name.'</option>';
//                    $data_options = array();
//                    $data_options['option_id'] = $optiondata->option_id; 
//                    $data_options['option_name'] = $optiondata->option_name; 
//                    $data_option_arr[] = $data_options;
                }
//                $data['options'] = $data_option_arr;
                $resultend =  '</select>
                                                <ul id="parsley-id-3638" class="parsley-errors-list"></ul>
                                            </div>
                                        </div>';
                if($data['divid']==1){
                  $nextdv = '<div id="dependoption_2"></div>';
                }else{
                    $val = $data['divid']+1;                
                  $nextdv = '<div id="dependoption_'.$val.'"></div>';   
                }
                $resultset =    $result.$option.$resultend.$nextdv;
//                $rslt ='<div class="form-group" id="dsp"><label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">
//                                            </label><div class="col-md-6 col-sm-6 col-xs-12"><a href="javascript:void(0);" onclick="javascript: add_condition();">Add more conditions </a></div>
//                                        </div>';
            }else{
                 if($data['divid']==1){
                  $nextdv = '<div id="dependoption_2"></div>';
                }else{
                    $val = $data['divid']+1;                
                  $nextdv = '<div id="dependoption_'.$val.'"></div>';   
                }
                $resultset = '<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Display if Answer is<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">No Answer options</div></div>'.$nextdv;
            }
            echo $resultset;
        }           
    }
    public function anySymptom(){
        $sql ="SELECT * , (SELECT count( * ) FROM `symptoms` WHERE parent_id = s.symptom_id) AS parentcnt FROM `symptoms` AS s";
        $symptoms = DB::select($sql);
//        $symptoms = DB::table('symptoms')->orderBy('symptom_id', 'DESC')->get();
        return View::make('admin.symptom')->with(array('symptoms' => $symptoms));
    }
    public function anyAddSymptom(){
        $data = Input::all();
        if(isset($data['symptom_name'])){
            $insert_data = array();            
            if (isset($data['symptom_name'])) {
                $insert_data['symptom_name'] = trim($data['symptom_name']);
            }
            if (isset($data['parent_id'])) {
                $insert_data['parent_id'] = trim($data['parent_id']);
            }
            if (isset($data['status'])) {
                $insert_data['status'] = trim($data['status']);
            }
            if (count($insert_data) > 0 ) {
                DB::table('symptoms')->insert($insert_data);
            }
            return Redirect::to('admin/symptom');               
        }else{
            $data['symptoms'] = DB::table('symptoms')->where('symptoms.parent_id', '=', 0)->orderBy('symptom_id', 'ASC')->get();
            return View::make('admin.addsymptom')->with(array('data' => $data));
        }
    }
    public function anyEditSymptom($id=null){
        $data = Input::all();
        if(isset($data['symptom_name'])){
            $update_data = array();
            if (isset($data['symptom_id'])) {
                $update_data['symptom_id'] = trim($data['symptom_id']);
            }
            if (isset($data['symptom_name'])) {
                $update_data['symptom_name'] = trim($data['symptom_name']);
            }
            if (isset($data['parent_id'])) {
                $update_data['parent_id'] = trim($data['parent_id']);
            }
            if (isset($data['status'])) {
                $update_data['status'] = trim($data['status']);
            }
            if (count($update_data) > 0 && $data['symptom_id'] > 0) {
                DB::table('symptoms')->where('symptom_id', $data['symptom_id'])->update($update_data);
            }

            return Redirect::to('admin/symptom');               
        }else{
            $symptomdetail = '';
            if($id >0){        
                $symptomdetail = DB::table('symptoms')->where('symptoms.symptom_id', '=', $id)->get();
                if (count($symptomdetail) > 0) {
                    foreach ($symptomdetail as $symptomdata) {
                        $data['symptom_id'] = $symptomdata->symptom_id;
                        $data['parent_id'] = $symptomdata->parent_id;
                        $data['symptom_name'] = $symptomdata->symptom_name;
                        $data['status'] = $symptomdata->status;
                    }
                }
            }
            $data['symptoms'] = DB::table('symptoms')->where('symptoms.parent_id', '=', 0)->orderBy('symptom_id', 'ASC')->get();
            return View::make('admin.editsymptom')->with(array('data' => $data));
        }
    }
    public function anyQuestiongroup(){
        $groups = DB::table('questiongroup')->leftjoin('questions', 'questiongroup.group_id', '=', 'questions.question_group_id')->orderBy('questiongroup.display_order', 'ASC')->groupBY('questiongroup.group_id')->select('questiongroup.*','questions.question_group_id')->get();
        return View::make('admin.questiongroup')->with(array('groups' => $groups));
    }
    public function anyAddQuestiongroup(){
        $data = Input::all();
        if(isset($data['group_name'])){
            $insert_data = array();            
            if (isset($data['group_name'])) {
                $insert_data['group_name'] = trim($data['group_name']);
            }  
            if (isset($data['display_order'])) {
                $insert_data['display_order'] = trim($data['display_order']);
            }
            if (isset($data['status'])) {
                $insert_data['status'] = trim($data['status']);
            }
            if (count($insert_data) > 0 ) {
                DB::table('questiongroup')->insert($insert_data);
            }
            return Redirect::to('admin/questiongroup');               
        }else{           
            return View::make('admin.addquestiongroup')->with(array('data' => $data));
        }
    }
    public function anyEditQuestiongroup($id=null){
        $data = Input::all();
        if(isset($data['group_name'])){
            $update_data = array();
            if (isset($data['group_id'])) {
                $update_data['group_id'] = trim($data['group_id']);
            }
            if (isset($data['group_name'])) {
                $update_data['group_name'] = trim($data['group_name']);
            }       
            if (isset($data['display_order'])) {
                $update_data['display_order'] = trim($data['display_order']);
            }
            if (isset($data['status'])) {
                $update_data['status'] = trim($data['status']);
            }
            if (count($update_data) > 0 && $data['group_id'] > 0) {
                DB::table('questiongroup')->where('group_id', $data['group_id'])->update($update_data);
            }

            return Redirect::to('admin/questiongroup');               
        }else{
            $groupdetail = '';
            if($id >0){        
                $groupdetail = DB::table('questiongroup')->where('questiongroup.group_id', '=', $id)->get();
                if (count($groupdetail) > 0) {
                    foreach ($groupdetail as $groupdata) {
                        $data['group_id'] = $groupdata->group_id;
                        $data['group_name'] = $groupdata->group_name;
                        $data['display_order'] = $groupdata->display_order;
                        $data['status'] = $groupdata->status;
                    }
                }
            }
            return View::make('admin.editquestiongroup')->with(array('data' => $data));
        }
    }
    public function anyDelQuestiongroup($id=''){       
       if($id!=''){
        DB::table('questiongroup')->where('group_id','=',$id)->delete();  
        
         return Redirect::action('AdminController@anyQuestiongroup');
       }        
    }
    public function anySecurityquestion(){
        $questions = DB::table('security_questions')->leftjoin('customer_security_answer', 'security_questions.question_id', '=', 'customer_security_answer.question_id')->orderBy('security_questions.display_order', 'ASC')->groupBY('security_questions.question_id')->select('security_questions.*','customer_security_answer.question_id as selected_question')->get();
        return View::make('admin.securityquestion')->with(array('questions' => $questions));
    }
    public function anyAddSecurityquestion(){
        $data = Input::all();
        if(isset($data['question'])){
            $insert_data = array();            
            if (isset($data['question'])) {
                $insert_data['question'] = trim($data['question']);
            }  
            if (isset($data['display_order'])) {
                $insert_data['display_order'] = trim($data['display_order']);
            }
            if (isset($data['status'])) {
                $insert_data['status'] = trim($data['status']);
            }
            if (count($insert_data) > 0 ) {
                DB::table('security_questions')->insert($insert_data);
            }
            return Redirect::to('admin/securityquestion');               
        }else{           
            return View::make('admin.addsecurityquestion')->with(array('data' => $data));
        }
    }
    public function anyEditSecurityquestion($id=null){
        $data = Input::all();
        if(isset($data['question'])){
            $update_data = array();
            if (isset($data['question_id'])) {
                $update_data['question_id'] = trim($data['question_id']);
            }
            if (isset($data['question'])) {
                $update_data['question'] = trim($data['question']);
            }       
            if (isset($data['display_order'])) {
                $update_data['display_order'] = trim($data['display_order']);
            }
            if (isset($data['status'])) {
                $update_data['status'] = trim($data['status']);
            }
            if (count($update_data) > 0 && $data['question_id'] > 0) {
                DB::table('security_questions')->where('question_id', $data['question_id'])->update($update_data);
            }

            return Redirect::to('admin/securityquestion');               
        }else{
            $securitydetail = '';
            if($id >0){        
                $securitydetail = DB::table('security_questions')->where('security_questions.question_id', '=', $id)->get();
                if (count($securitydetail) > 0) {
                    foreach ($securitydetail as $securitydata) {
                        $data['question_id'] = $securitydata->question_id;
                        $data['question'] = $securitydata->question;
                        $data['display_order'] = $securitydata->display_order;
                        $data['status'] = $securitydata->status;
                    }
                }
            }
            return View::make('admin.editsecurityquestion')->with(array('data' => $data));
        }
    }
    public function anyDelSecurityquestion($id=''){       
       if($id!=''){
        DB::table('security_questions')->where('question_id','=',$id)->delete();  
        
         return Redirect::action('AdminController@anySecurityquestion');
       }        
    }
   
    public function anyCounselor($type='',$id=''){
        
        $data['site_url'] = URL::to('/');
        switch ($type) {

            case  'add':
   
                $countries = DB::table('country')->orderBy('country_id', 'ASC')->select('country_id','countryname','phoneCode')->get();
                $data['countries']= $countries;
                $post_arr           = Input::all(); 
                if(!empty($post_arr) && $post_arr['form_submit'] == "save"){

                    $counselors_state ='';
                    if(isset($post_arr['counselor_state_select']) && !empty($post_arr['counselor_state_select'])){
                        $counselors_state      =$post_arr['counselor_state_select'];
                    }

                    if(isset($post_arr['counselor_state_text']) && !empty($post_arr['counselor_state_text'])){
                        $counselors_state = $post_arr['counselor_state_text'];
                    }

                    $validator = Validator::make(
                     array(
                        'counselors_email_id'  => $post_arr['counselors_email_id'],
                        'counselors_firstname'  => $post_arr['counselors_firstname'],
                        'counselors_lastname'  => $post_arr['counselors_lastname'],
                        'counselors_phone_code'  => $post_arr['counselors_phone_code'], 
                        'counselors_phone'  => $post_arr['counselors_phone'],
                        'counselors_zip'  => $post_arr['counselors_zip'],
                        'country_id'  => $post_arr['counselor_country'],
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
                    $insert_arr['counselors_email_id']        =$post_arr['counselors_email_id'];
                    $insert_arr['counselors_phone_code']      =$post_arr['counselors_phone_code'];
                    $insert_arr['counselors_phone']           =$post_arr['counselors_phone'];              
                    $insert_arr['country_id']                 =$post_arr['counselor_country'];
                    $insert_arr['counselors_state']           = $counselors_state;                
                    $insert_arr['counselors_city']            =$post_arr['counselors_city'];               
                    $insert_arr['counselors_zip']             =$post_arr['counselors_zip'];
                    $insert_arr['counselors_password']        =(new BaseController)->encrypt_decrypt(trim($post_arr['password']));
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
                            Session::flash('flash_msg','Counselor created successfully !.');
                            return json_encode(array('error' => 0)); exit;
                        }else{
                            return json_encode(array('error' => 1,'err_msg'=>'Mail sending Failed.')); exit;
                        }
                    } 
                    return json_encode(array('error' => 1,'err_msg'=>'Something went wrong, please try again.')); exit;
                }
                return View::make('admin.addcounselor')->with(array('data'=>$data));
            case  'edit':
                        $post_arr = Input::all();
                        $counselorId = $id;
        
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
                        if(!empty($post_arr) && $post_arr['form_submit'] == "save"){

                            $counselorId      =$post_arr['counselor_id'];
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
                                 'country_id'  => $post_arr['counselor_country'],
                                 'counselors_state'  => $counselors_state,
                                 'counselors_city'  => $post_arr['counselors_city'],
                                 'password'  => $post_arr['password'],
                                 'repeat_password'  => $post_arr['password2']
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
                                  'password' => 'same:repeat_password|min:4',
                                 'repeat_password' => 'same:password|min:4',



                             )
                            );

                            if ($validator->fails())
                            {
                                $messages   = $validator->messages();   
                                $err_msg  = '<br />';
                                foreach ($messages->all() as $msg) {
                                        $err_msg .= '<br /><i>'.$msg.'</i>';
                                }
                                return json_encode(array('error' => 1, 'err_msg' => $err_msg)); exit;

                            } 


                            // Counselor table
                            $input_arr1['counselors_firstname']       = $post_arr['counselors_firstname'];
                            $input_arr1['counselors_middlename']      =$post_arr['counselors_middlename'];
                            $input_arr1['counselors_lastname']        =$post_arr['counselors_lastname'];
                            $input_arr1['counselors_phone_code']      =$post_arr['counselors_phone_code'];
                            $input_arr1['counselors_phone']            =$post_arr['counselors_phone'];
                            $input_arr1['counselors_zip']               =$post_arr['counselors_zip'];

                            $input_arr1['country_id']          =$post_arr['counselor_country'];
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
                            if(isset($post_arr['password']) && $post_arr['password'] !=''){
                                $input_arr1['counselors_password'] =    (new BaseController)->encrypt_decrypt(trim($post_arr['password']));
                            }

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
                        return View::make('admin.editcounselor')->with(array('data'=>$data));
            case  'remove_stored_image':
                                $counselorId = $id; 
                                $counselorObj = DB::table('counselors')->where("counselors_id","=",$counselorId);
                                $counselor = $counselorObj->first();

                                unlink("uploads/counselor/thumbnail/".$counselor->counselors_photo);
                                unlink("uploads/counselor/".$counselor->counselors_photo);


                                $input_arr['counselors_photo'] = '';
                                $counselorObj->update($input_arr);
                                Session::flash('flash_msg','Image Deleted Successfully');
                                return json_encode(array('error' => 0)); exit;
                                
                                
            case  'remove_image':                    

                                $post_arr           = Input::all();       

                                unlink("uploads/counselor/thumbnail/".$post_arr['document']);
                                unlink("uploads/counselor/".$post_arr['document']);
                                return json_encode(array('error' => 0)); exit;

            case  'delete':
                        if($id){

                            $conselorObj = DB::table('counselors')->where("counselors_id","=",$id);
                            if($conselorObj){
                                $conselorObj->update(array('is_deleted'=>1));
                                Session::flash('flash_msg','Record deleted successfully !');
                                return json_encode(array('error' => 0)); exit;
                            }else{
                                return json_encode(array('error' => 1,'err_msg' => "Some error has occured.Please try after some time")); exit;
                            }
                        } 
                        return  json_encode(array('error' => 1,'err_msg'=>'Counselor is missing.')); exit;  
            default:
                        $counselors = DB::table('counselors')->where("is_deleted","=",0)->orderBy('counselors.counselors_id', 'DESC')->groupBY('counselors.counselors_id')->get();
                        return View::make('admin.counselor')->with(array('data' => $data,'counselors' => $counselors));       
        }
    }  
    
    public function anyApproveCounselor($id=''){    
       if($id>0){
            $update_data = array();
            $update_data['counselors_status'] = 1; //Approved
            DB::table('counselors')->where('counselors_id', $id)->update($update_data);
            
            $counselorObj = DB::table('counselors')->where('counselors_id', $id)->first();
            
            $conselorName = $counselorObj->counselors_firstname;
            if($counselorObj->counselors_middlename)
                $conselorName .= " ".$counselorObj->counselors_middlename;
            if($counselorObj->counselors_lastname)
                $conselorName .= " ".$counselorObj->counselors_lastname; 

            // Send Mail               
            $templateLocation = "admin.mail_template_counselor_approval";

            $thingsToPassTemplate["site_link"] = URL::to('/'); 
            $thingsToPassTemplate["site_start_link"] = URL::to('/')."/home/basic";      
            $thingsToPassTemplate["receipent_name"] = $conselorName;  
            $thingsToPassTemplate["link"] = asset("counselor/login"); 

            $subject = "Counselor Account Approval Notification"; 

            $receipents = $counselorObj->counselors_email_id;

            // Send mail
            $result= (new BaseController)->send_mail(
                    $templateLocation,
                    $thingsToPassTemplate,
                    $subject,
                    $receipents
            );
            
         Session::flash('flash_msg','Counselor has been approved successfully !');   
         return Redirect::action('AdminController@anyCounselor');
       }        
    }
    public function anyApproveHp($id=''){    
       if($id>0){
            $update_data = array();
            $update_data['healthcare_professional_status'] = 1; //Approved
            DB::table('healthcare_professional')->where('healthcare_professional_id', $id)->update($update_data);
            
            $hpObj = DB::table('healthcare_professional')->where('healthcare_professional_id', $id)->first();
            $hpName = $hpObj->healthcare_professional_first_name;
            if($hpObj->healthcare_professional_middle_name)
                $hpName .= " ".$hpObj->healthcare_professional_middle_name;
            if($hpObj->healthcare_professional_last_name)
                $hpName .= " ".$hpObj->healthcare_professional_last_name;    
            

            // Send Mail               
            $templateLocation = "admin.mail_template_hp_approval";

            $thingsToPassTemplate["site_link"] = URL::to('/'); 
            $thingsToPassTemplate["site_start_link"] = URL::to('/')."/home/basic";      
            $thingsToPassTemplate["receipent_name"] = $hpName;  
            $thingsToPassTemplate["link"] = asset("healthcare_professional/login"); 

            $subject = "Provider Account Approval Notification"; 

            $receipents = $hpObj->healthcare_professional_email_address;

            // Send mail
            $result= (new BaseController)->send_mail(
                    $templateLocation,
                    $thingsToPassTemplate,
                    $subject,
                    $receipents
            );
            
            
            Session::flash('flash_msg','Provider has been approved successfully !');  
            return Redirect::action('AdminController@anyHealthcareprofessional');
       }        
    }
     public function anyInactivateCounselor($id=''){    
       if($id>0){
            $update_data = array();
            $update_data['counselors_status'] = 'inactive';
            DB::table('counselors')->where('counselors_id', $id)->update($update_data);
            
         return Redirect::action('AdminController@anyCounselor');
       }        
    }
    public function anyViewcounselor($id=null){    
        if($id >0){  
            $counselorId = (int)$id;
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
                return Redirect::to('admin/counselor');
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
        }
        return View::make('admin.counselorview')->with(array('data' => $data));

    }
    
    
    
        public function anyViewcustomer($id=null){    
            
        if($id >0){  
            $customerId = (int)$id;
            // Listing of Counselors
            $data = array();
            $data['site_url'] = URL::to('/');
            $customerObject = DB::table('customers')
                    ->leftjoin('customer_detail', 'customers.customer_id', '=', 'customer_detail.customer_id')
                    ->leftjoin('country', 'customer_detail.country_id', '=', 'country.country_id')
                    ->leftjoin('status', 'customers.customer_status', '=', 'status.status_id')
                    ->where("customer_detail.is_casefile","=",0)
                    ->where("customers.customer_id","=",$customerId)
                    ->where("customers.is_deleted","=",0) 
                    ->first();

            if(!$customerObject){
                Session::flash("flash_msg","This customer doesn't exist.Or account is deleted !");
                return Redirect::to('admin/customer');
            }
      

            $data['customerObject'] = $customerObject;

        }
        return View::make('admin.view_customer')->with(array('data' => $data));

    }
    
    
   public function anyLanguage($type='',$id=''){
        

        $data['site_url'] = URL::to('/');

        switch ($type) {
            
        case  'add':
                        $post_arr           = Input::all();                            
 
                        if(!empty($post_arr) && $post_arr['form_submit'] == "save"){

                                // Check for duplicate
                                $validator = Validator::make(
                                    array(
                                        'language_name'  => $post_arr['language_name']
                                    ),
                                    array(
                                        'language_name' => 'required|unique:languages,language_name'                                            
                                    )
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
                                    $insert_data['language_name'] = $post_arr['language_name'];
                                    $insert_data['language_status'] = $post_arr['language_status'];
                                    
                                    if (count($insert_data) > 0 ) {
                                        DB::table('languages')->insert($insert_data);
                                        Session::flash('flash_msg','Record added successfully');
                                    }
                                    return json_encode(array('error' => 0)); exit;

                                } 

                        }else{ 
                            return View::make('admin.addlanguage')->with(array('data' => $data));
                        }
        case  'edit': 
            
                        $languageObj = DB::table('languages')->where('language_id', $id)->get(); 
                        $data['languageObj'] = $languageObj[0];

                        $post_arr           = Input::all();                     ;
  
                        if(!empty($post_arr) && $post_arr['form_submit'] == "save"){

                                // Check for duplicate
                                $validator = Validator::make(
                                    array(
                                        'language_name'  => $post_arr['language_name']
                                    ),
                                    array(
                                        'language_name' => 'required|unique:languages,language_name,'.$id.',language_id',                                            
                                    )
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
                                         
                                    $update_data['language_name'] = $post_arr['language_name'];
                                    $update_data['language_status'] = $post_arr['language_status'];
                                    if (count($update_data) > 0 ) {
                                        DB::table('languages')->where('language_id', $id)->update($update_data);
                                        Session::flash('flash_msg','Record saved successfully');

                                    }
                                    return json_encode(array('error' => 0)); exit;

                                } 

                        }else{ 
                            return View::make('admin.editlanguage')->with(array('data' => $data));
                        }
            
        case 'statuschange':
           if($id){
               
               $language = DB::table('languages')->where('language_id','=',$id); 
               $oldStatus = $language->pluck('language_status');
               if($oldStatus)
                   $newStatus = 0;
               else
                    $newStatus = 1;
               $language->update(array('language_status'=>$newStatus));
               
               return  json_encode(array('error' => 0,'status' => $newStatus)); exit;
           } 
           return  json_encode(array('error' => 1,'err_msg'=>'Language is missing')); exit;
           
        case 'delete':
           if($id){
                DB::table('languages')->where('language_id','=',$id)->delete();
                Session::flash('flash_msg','Record deleted successfully');
                return json_encode(array('error' => 0)); exit;
           } 
           return  json_encode(array('error' => 1,'err_msg'=>'Language is missing')); exit;  
           
        default: 

                $sql ="SELECT *  FROM `languages`";
                $languages = DB::select($sql);
                return View::make('admin.language')->with(array('languages' => $languages,'data' => $data));
        }
       
    }
    
    public function anySpecilization($type='',$id=''){

        $data['site_url'] = URL::to('/');

        switch ($type) {
            
        case  'add':
                        $post_arr           = Input::all();                            
 
                        if(!empty($post_arr) && $post_arr['form_submit'] == "save"){

                                // Check for duplicate
                                $validator = Validator::make(
                                    array(
                                        'specilization_name'  => $post_arr['specilization_name'],
                                        'specilization_description'  => $post_arr['specilization_description']
                                    ),
                                    array(
                                        'specilization_name' => 'required|unique:specilizations,specilization_name',
                                        'specilization_description' => 'required', 
                                    )
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
                                    $insert_data['specilization_name'] = $post_arr['specilization_name'];
                                    $insert_data['specilization_description'] = $post_arr['specilization_description'];
                                    $insert_data['specilization_status'] = $post_arr['specilization_status'];
                                    
                                    if (count($insert_data) > 0 ) {
                                        DB::table('specilizations')->insert($insert_data);
                                        Session::flash('flash_msg','Record added successfully');
                                    }
                                    return json_encode(array('error' => 0)); exit;

                                } 

                        }else{ 
                            return View::make('admin.addspecilization')->with(array('data' => $data));
                        }
        case  'edit': 
            
                        $specilizationObj = DB::table('specilizations')->where('specilization_id', $id)->get(); 
                        $data['specilizationObj'] = $specilizationObj[0];

                        $post_arr           = Input::all();                     ;
  
                        if(!empty($post_arr) && $post_arr['form_submit'] == "save"){

                                // Check for duplicate
                                $validator = Validator::make(
                                   array(
                                        'specilization_name'  => $post_arr['specilization_name'],
                                        'specilization_description'  => $post_arr['specilization_description']
                                    ),
                                    array(
                                        'specilization_name' => 'required|unique:specilizations,specilization_name,'.$id.',specilization_id',     
                                        'specilization_description' => 'required', 
                                    )
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
                                         
                                    $update_data['specilization_name'] = $post_arr['specilization_name'];
                                    $update_data['specilization_description'] = $post_arr['specilization_description'];
                                    $update_data['specilization_status'] = $post_arr['specilization_status'];
                                    if (count($update_data) > 0 ) {
                                        DB::table('specilizations')->where('specilization_id', $id)->update($update_data);
                                        Session::flash('flash_msg','Record saved successfully');

                                    }
                                    return json_encode(array('error' => 0)); exit;

                                } 

                        }else{ 
                            return View::make('admin.editspecilization')->with(array('data' => $data));
                        }
                        
        case 'statuschange':
           if($id){
               
               $specilization = DB::table('specilizations')->where('specilization_id','=',$id); 
               $oldStatus = $specilization->pluck('specilization_status');
               if($oldStatus)
                   $newStatus = 0;
               else
                    $newStatus = 1;
               $specilization->update(array('specilization_status'=>$newStatus));
               
               return  json_encode(array('error' => 0,'status' => $newStatus)); exit;
           } 
           return  json_encode(array('error' => 1,'err_msg'=>'Specilization is missing')); exit;
              
        case 'delete':
           if($id){
                DB::table('specilizations')->where('specilization_id','=',$id)->delete();
                Session::flash('flash_msg','Record deleted successfully');
                return json_encode(array('error' => 0)); exit;
           } 
           return  json_encode(array('error' => 1,'err_msg'=>'Language is missing')); exit;
           
           
        default: 

                $sql ="SELECT *  FROM `specilizations`";
                $specilizations = DB::select($sql);
                return View::make('admin.specilization')->with(array('specilizations' => $specilizations,'data' => $data));
        }
       
    }
    
    public function anyInsurance($type='',$id=''){
               
        $data['site_url'] = URL::to('/');

        switch ($type) {
            
        case  'add':
                        $post_arr           = Input::all();                            
 
                        if(!empty($post_arr) && $post_arr['form_submit'] == "save"){

                                // Check for duplicate
                                $validator = Validator::make(
                                    array(
                                        'insurance_name'  => $post_arr['insurance_name'],
                                        'insurance_description'  => $post_arr['insurance_description']
                                    ),
                                    array(
                                        'insurance_name' => 'required|unique:insurance_companies,insurance_name' ,
                                        'insurance_description' => 'required',
                                    )
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
                                    $insert_data['insurance_name'] = $post_arr['insurance_name'];
                                    $insert_data['insurance_description'] = $post_arr['insurance_description'];
                                    $insert_data['insurance_status'] = $post_arr['insurance_status'];
                                    
                                    if (count($insert_data) > 0 ) {
                                        DB::table('insurance_companies')->insert($insert_data);
                                        Session::flash('flash_msg','Record added successfully');
                                    }
                                    return json_encode(array('error' => 0)); exit;

                                } 

                        }else{ 
                            return View::make('admin.addinsurance')->with(array('data' => $data));
                        }
        case  'edit': 
            
                        $insuranceObj = DB::table('insurance_companies')->where('insurance_id', $id)->get(); 
                        $data['insuranceObj'] = $insuranceObj[0];

                        $post_arr           = Input::all();                     ;
  
                        if(!empty($post_arr) && $post_arr['form_submit'] == "save"){

                                // Check for duplicate
                                $validator = Validator::make(
                                   array(
                                        'insurance_name'  => $post_arr['insurance_name'],
                                        'insurance_description'  => $post_arr['insurance_description']
                                    ),
                                    array(
                                        'insurance_name' => 'required|unique:insurance_companies,insurance_name,'.$id.',insurance_id',
                                        'insurance_description' => 'required',
                                    )     
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
                                         
                                    $update_data['insurance_name'] = $post_arr['insurance_name'];
                                    $update_data['insurance_description'] = $post_arr['insurance_description'];
                                    $update_data['insurance_status'] = $post_arr['insurance_status'];
                                    if (count($update_data) > 0 ) {
                                        DB::table('insurance_companies')->where('insurance_id', $id)->update($update_data);
                                        Session::flash('flash_msg','Record saved successfully');

                                    }
                                    return json_encode(array('error' => 0)); exit;

                                } 

                        }else{ 
                            return View::make('admin.editinsurance')->with(array('data' => $data));
                        }
            
        case 'statuschange':
           if($id){
               
               $insurance = DB::table('insurance_companies')->where('insurance_id','=',$id); 
               $oldStatus = $insurance->pluck('insurance_status');
               if($oldStatus)
                   $newStatus = 0;
               else
                    $newStatus = 1;
               $insurance->update(array('insurance_status'=>$newStatus));
               
               return  json_encode(array('error' => 0,'status' => $newStatus)); exit;
           } 
           return  json_encode(array('error' => 1,'err_msg'=>'Insurance is missing')); exit;
           
        case 'delete':
           if($id){
                DB::table('insurance_companies')->where('insurance_id','=',$id)->delete();
                Session::flash('flash_msg','Record deleted successfully');
                return json_encode(array('error' => 0)); exit;
           } 
           return  json_encode(array('error' => 1,'err_msg'=>'Insurance is missing')); exit;
           
            
        default: 

                $sql ="SELECT *  FROM `insurance_companies`";
                $insurances = DB::select($sql);
                return View::make('admin.insurance')->with(array('insurances' => $insurances,'data' => $data));
        }
       
    }
    

    public function anyHealthcareprofessional($type='',$id=''){

        
        $data['site_url'] = URL::to('/');

        switch ($type) {
            
        case  'add': 
            
                    $countries = DB::table('country')->orderBy('country_id', 'ASC')->select('country_id','countryname','phoneCode')->get();
                    $data['countries'] = $countries;
                    $post_arr           = Input::all();
                    if(!empty($post_arr)){
              
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

                        $result= (new BaseController)->send_hp_registration_mail($hpId,trim($post_arr['healthcare_professional_password']));
                                       
                        if($result){
                            Session::flash('flash_msg','Providder has been added successfully');
                            return json_encode(array('error' => 0)); exit;
                        }else{
                            return json_encode(array('error' => 1,'err_msg'=>'Mail sending Failed.')); exit;
                        }
                        

                      }

                      return json_encode(array('error' => 1,'err_msg'=>'Something went wrong, please try again.')); exit;
         }
         
                    return View::make('admin.addhp')->with(array('data' => $data));
        case  'edit':
                    $hpId = $id;
                               
                    $hpObj = DB::table('healthcare_professional')->where("healthcare_professional_id","=",$hpId);
                    
                    // Redirect , if it is not valid
                    if(!is_object($hpObj->first())){
                        return Redirect::to('admin/healthcareprofessional');   
                    }
                    
                    
                    
                    $data['hpId'] = $hpId;
                    $data['hp'] =  DB::table('healthcare_professional')->leftjoin('healthcare_professional_details', 'healthcare_professional.healthcare_professional_id', '=', 'healthcare_professional_details.healthcare_professional_id')->where('healthcare_professional.healthcare_professional_id', '=',$hpId)->first();
                    
                    $countries = DB::table('country')->orderBy('country_id', 'ASC')->select('country_id','countryname','phoneCode')->get(); 
                    $data['countries'] = $countries;
                    $languages = DB::table('languages')->where('language_status','=',1)->select('language_id','language_name')->orderBy('language_id', 'ASC')->get();
                    $data['languages'] = $languages;

                    $specilizations = DB::table('specilizations')->where('specilization_status','=',1)->select('specilization_id','specilization_name')->orderBy('specilization_id', 'ASC')->get();
                    $data['specilizations'] = $specilizations;

                    $insurances = DB::table('insurance_companies')->where('insurance_status','=',1)->select('insurance_id','insurance_name')->orderBy('insurance_id', 'ASC')->get();
                    $data['insurances'] = $insurances;

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
                              'password'  => $post_arr['healthcare_professional_password'],
                              'repeat_password'  => $post_arr['healthcare_professional_password2']
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
                              'password' => 'same:repeat_password|min:4',
                              'repeat_password' => 'same:password|min:4',                             
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
                        //$input_arr1['healthcare_professional_status']           =1;

                        if(isset($post_arr['healthcare_professional_dob'])&& $post_arr['healthcare_professional_dob'] !=''){
                            $datetime = new DateTime();
                            $datetime = $datetime->createFromFormat('m-d-Y', $post_arr['healthcare_professional_dob']);
                            $input_arr1['healthcare_professional_dob']              = $datetime->format('Y-m-d');               
                        }

                        if(isset($post_arr['healthcare_professional_password'])&& $post_arr['healthcare_professional_password'] !=''){
                            $input_arr1['healthcare_professional_password']=(new BaseController)->encrypt_decrypt(trim($post_arr['healthcare_professional_password']));
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
                     
                    return View::make('admin.edithp')->with(array('data'=>$data)); 
        case  'remove_stored_image':
                                $hpId = $id; 
                                $hp = DB::table('healthcare_professional')->leftjoin('healthcare_professional_details', 'healthcare_professional.healthcare_professional_id', '=', 'healthcare_professional_details.healthcare_professional_id')->where('healthcare_professional.healthcare_professional_id', '=',$hpId)->first();

                                unlink("uploads/healthcare_professional/thumbnail/".$hp->healthcare_professional_image);
                                unlink("uploads/healthcare_professional/".$hp->healthcare_professional_image);

                                $hpDetailsObj = DB::table('healthcare_professional_details')->where("healthcare_professional_id","=",$hpId);
                                $input_arr['healthcare_professional_image'] = '';
                                $hpDetailsObj->update($input_arr);
                                Session::flash('flash_msg','Image Deleted Successfully');
                                return json_encode(array('error' => 0)); exit;
                 
        case  'remove_image':                    

                                $post_arr           = Input::all();       

                                unlink("uploads/healthcare_professional/thumbnail/".$post_arr['document_image']);
                                unlink("uploads/healthcare_professional/".$post_arr['document_image']);

                                return json_encode(array('error' => 0)); exit;    
                                
        case  'remove_stored_biodata':
                                        $hpId = $id; 
                                        $hp = DB::table('healthcare_professional')->leftjoin('healthcare_professional_details', 'healthcare_professional.healthcare_professional_id', '=', 'healthcare_professional_details.healthcare_professional_id')->where('healthcare_professional.healthcare_professional_id', '=',$hpId)->first();

                                        unlink("uploads/healthcare_professional/".$hp->healthcare_professional_biodata);

                                        $hpDetailsObj = DB::table('healthcare_professional_details')->where("healthcare_professional_id","=",$hpId);
                                        $input_arr['healthcare_professional_biodata'] = '';
                                        $hpDetailsObj->update($input_arr);
                                        Session::flash('flash_msg','Biodata Deleted Successfully');
                                        return json_encode(array('error' => 0)); exit; 
        case  'remove_biodata':   
            
                                        $post_arr           = Input::all();       
                                        unlink("uploads/healthcare_professional/".$post_arr['document_biodata']);

                                        return json_encode(array('error' => 0)); exit;        
        case  'view': 

                        $hpId = $id;
                        $hpObject = DB::table('healthcare_professional')
                                ->leftjoin('healthcare_professional_details','healthcare_professional.healthcare_professional_id', '=', 'healthcare_professional_details.healthcare_professional_id')
                                ->leftjoin('country', 'healthcare_professional.healthcare_professional_country', '=', 'country.country_id')
                                ->where("healthcare_professional.healthcare_professional_status","!=",0)
                                ->where("healthcare_professional.healthcare_professional_id","=",$id) 
                                ->where("healthcare_professional.is_deleted","=",0) 
                                ->first();         

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

                        return View::make('admin.viewhp')->with(array('data' => $data));
                        
                
        case 'statuschange':
           if($id){
               
               $healthcareprofessional = DB::table('healthcare_professional')->where('healthcare_professional_id','=',$id); 
               $oldStatus = $healthcareprofessional->pluck('healthcare_professional_status');
               if($oldStatus)
                   $newStatus = 0;
               else
                    $newStatus = 1;
               $healthcareprofessional->update(array('healthcare_professional_status'=>$newStatus));
               
               return  json_encode(array('error' => 0,'status' => $newStatus)); exit;
           } 
           return  json_encode(array('error' => 1,'err_msg'=>'Healthcare Professional is missing')); exit;
                     
        case  'delete':
            if($id){

                 $healthcareprofessional = DB::table('healthcare_professional')->where('healthcare_professional_id','=',$id); 
                if($healthcareprofessional){
                    $healthcareprofessional->update(array('is_deleted'=>1));
                    Session::flash('flash_msg','Record deleted successfully !');
                    return json_encode(array('error' => 0)); exit;
                }else{
                    return json_encode(array('error' => 1,'err_msg' => "Some error has occured.Please try after some time")); exit;
                }
            } 
            return  json_encode(array('error' => 1,'err_msg'=>'Healthcare Professional is missing')); exit;            
        default: 

                $sql ="SELECT *  FROM `healthcare_professional` WHERE `is_deleted` = 0 ORDER BY `healthcare_professional_id` DESC";
                $healthcareprofessionals = DB::select($sql);
                return View::make('admin.hp')->with(array('healthcareprofessionals' => $healthcareprofessionals,'data' => $data));
        }
       
    }
    
    
    public function anyCustomerpayments(){

        $data['site_url'] = URL::to('/');


                $sql ="
                    SELECT 
                    PD.transaction_id,PD.transaction_amount,PD.payment_date,PD.payment_status,PD.error_message,
                    CD.customer_nickname,HP.healthcare_professional_first_name,HP.healthcare_professional_last_name
                    FROM `customer_to_healthcare_payment_details` AS PD LEFT JOIN `casefile_to_healthcare` AS CH 
                    ON PD.casefile_to_healthcare_id = CH.casefile_to_healthcare_id
                    LEFT JOIN `customer_detail` AS CD
                    ON CH.customer_detail_id = CD.customer_detail_id
                    LEFT JOIN `healthcare_professional` AS HP 
                    ON PD.healthcare_id = HP.healthcare_professional_id"
                ;
                $paymentDetails = DB::select($sql);
                return View::make('admin.customerpayments')->with(array('paymentDetails' => $paymentDetails,'data' => $data));
        
       
    }

    public function anyContents($type='',$id=''){
               
        $data['site_url'] = URL::to('/');

        switch ($type) {
            
        case  'add':
                        $post_arr           = Input::all();                            
 
                        if(!empty($post_arr) && $post_arr['form_submit'] == "save"){

                                // Check for duplicate
                                $validator = Validator::make(
                                    array(
                                        'contents_title'  => $post_arr['contents_title'],
                                        'contents_position'  => $post_arr['contents_position'],
                                        'contents_key'  => $post_arr['contents_key'],
                                        'contents_description'  => $post_arr['contents_description'],
                                        'display_order'  => $post_arr['display_order'],
                                        'contents_status'  => $post_arr['contents_status']                                         
                                    ),
                                    array(
                                        'contents_title' => 'required' ,
                                        'contents_position' => 'required' ,
                                        'contents_key' => 'required|regex:/^[A-Za-z -]*$/i' ,
                                        'contents_description' => 'required' ,
                                        'display_order' => 'required' ,
                                        'contents_status' => 'required'
                                    )   
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
                                    
                                    $key = strtolower(trim($post_arr['contents_key']));
                                    $key = str_replace(" ", "-", $key);
                                    $contentRecord = DB::table('contents')->where('contents_key', $key)->first();
                                    
                                    if(count($contentRecord)>0){
                                        return  json_encode(array('error' => 1, 'err_msg' => "<br>Content Key already exist.")); exit;
                                    }
                                    
                                    $insert_data['contents_title'] = $post_arr['contents_title'];
                                    $insert_data['contents_position'] = $post_arr['contents_position'];
                                    $insert_data['contents_status'] = $post_arr['contents_status'];
                                    $insert_data['contents_description'] = $post_arr['contents_description'];
                                    $insert_data['contents_key'] = $key;
                                    $insert_data['display_order'] = $post_arr['display_order'];
                                    if (count($insert_data) > 0 ) {
                                        DB::table('contents')->insert($insert_data);
                                        Session::flash('flash_msg','Record added successfully');
                                    }
                                    return json_encode(array('error' => 0)); exit;

                                } 

                        }else{ 
                            $data['content_position'] = DB::table('content_position')->orderBy('content_position_id', 'ASC')->get();
                            return View::make('admin.addcontent')->with(array('data' => $data));
                        }
        case  'edit': 
            
                        $contentObj = DB::table('contents')->where('contents_id', $id)->get(); 
                        $data['contentObj'] = $contentObj[0];

                        $post_arr           = Input::all();                     ;
  
                        if(!empty($post_arr) && $post_arr['form_submit'] == "save"){

                             
                                $validator = Validator::make(
                                    array(
                                        'contents_title'  => $post_arr['contents_title'],
                                        'contents_position'  => $post_arr['contents_position'],
                                        'contents_key'  => $post_arr['contents_key'],
                                        'contents_description'  => $post_arr['contents_description'],
                                        'display_order'  => $post_arr['display_order'],
                                        'contents_status'  => $post_arr['contents_status']                                         
                                    ),
                                    array(
                                        'contents_title' => 'required' ,
                                        'contents_position' => 'required' ,
                                        'contents_key' => 'required|regex:/^[A-Za-z -]*$/i' ,
                                        'contents_description' => 'required' ,
                                        'display_order' => 'required' ,
                                        'contents_status' => 'required'
                                    )   
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
                                    
                                    $key = strtolower(trim($post_arr['contents_key']));
                                    $key = str_replace(" ", "-", $key);
                                    $contentRecord = DB::table('contents')->where('contents_key', $key)->where('contents_id','!=', $id)->first();
                                    
                                    if(count($contentRecord)>0){
                                        return  json_encode(array('error' => 1, 'err_msg' => "<br>Content Key already exist.")); exit;
                                    }
                                    
                                    
                                    $update_data['contents_title'] = $post_arr['contents_title'];
                                    $update_data['contents_position'] = $post_arr['contents_position'];
                                    $update_data['contents_status'] = $post_arr['contents_status'];
                                    $update_data['contents_description'] = $post_arr['contents_description'];
                                    $update_data['contents_key'] = $key;
                                    $update_data['display_order'] = $post_arr['display_order'];
                                    if (count($update_data) > 0 ) {
                                        DB::table('contents')->where('contents_id', $id)->update($update_data);
                                        Session::flash('flash_msg','Record saved successfully');

                                    }
                                    return json_encode(array('error' => 0)); exit;

                                } 

                        }else{ 
                            $data['content_position'] = DB::table('content_position')->orderBy('content_position_id', 'ASC')->get();
                            return View::make('admin.editcontent')->with(array('data' => $data));
                        }
            
        case 'statuschange':
           if($id){
               
               $contents = DB::table('contents')->where('contents_id','=',$id); 
               $oldStatus = $contents->pluck('contents_status');
               if($oldStatus)
                   $newStatus = 0;
               else
                    $newStatus = 1;
               $contents->update(array('contents_status'=>$newStatus));
               
               return  json_encode(array('error' => 0,'status' => $newStatus)); exit;
           } 
           return  json_encode(array('error' => 1,'err_msg'=>'Content is missing')); exit;
           
        case 'delete':
           if($id){
                DB::table('contents')->where('contents_id','=',$id)->delete();
                Session::flash('flash_msg','Record deleted successfully');
                return json_encode(array('error' => 0)); exit;
           } 
           return  json_encode(array('error' => 1,'err_msg'=>'Contents is missing')); exit;
           
            
        default: 

                $contents = DB::table('contents')->leftjoin('content_position', 'contents.contents_position', '=', 'content_position.content_position_id')->orderBy('contents.contents_id', 'ASC')->select('contents.*','content_position.content_position')->get();
                return View::make('admin.content')->with(array('contents' => $contents,'data' => $data));
        }
       
    }
    
    public function anyCasefiles($type='',$id=''){
        
            // Listing all case files or case files of a particular customer
            $data['site_url'] = URL::to('/');

            switch ($type) {
                
                case  'customer': 
                        // Get case files  of a particular customer
                        $sql ="SELECT * FROM `customer_detail` WHERE  customer_id =$id AND is_casefile =1 AND customer_status =1 ORDER BY `customer_detail_id` DESC"; 
                        break;
                case 'hp':

                        // Get assigned case files of a particular healthcare provider
                        $sql ="
                              SELECT CD.* FROM `casefile_to_healthcare` AS CTH LEFT JOIN `customer_detail` AS CD 
                              ON  CTH.customer_detail_id = CD.customer_detail_id 
                              WHERE  CTH.healthcare_professional_id = $id AND CD.is_casefile =1 AND CD.customer_status =1 ORDER BY CD.`customer_detail_id` DESC"; 
                        break;      

                default:  

                      // Get all case files
                      $sql ="SELECT * FROM `customer_detail` WHERE  is_casefile =1 AND customer_status =1 ORDER BY `customer_detail_id` DESC";
            }

            $caseFileDetails = DB::select($sql);
            return View::make('admin.casefiles')->with(array('caseFileDetails' => $caseFileDetails,'data' => $data));        
    
    } 
    
        public function anyTemplates($type='',$id=''){
        
            // Listing all templates or templates of a particular healthcare
            $data['site_url'] = URL::to('/');
            switch ($type) {
                
                case 'add': 
                        $post_arr           = Input::all();                            
 
                        if(!empty($post_arr) && $post_arr['form_submit'] == "save"){

                                // Check for duplicate
                                $validator = Validator::make(
                                    array(
                                        'template_title'  => $post_arr['template_title'],
                                        'template_text'  => $post_arr['template_text']
                                    ),
                                    array(
                                        'template_title' => 'required|unique:communication_templates,template_title',
                                        'template_text' => 'required'
                                    )
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
                                    $insert_data['template_title'] = $post_arr['template_title'];
                                    $insert_data['template_text']  = $post_arr['template_text'];
                                    $insert_data['template_status'] = $post_arr['template_status'];
                                    $insert_data['create_user_type']='ADMIN';
                                    $insert_data['create_user_id']= Session::get('admin_id');
                                    
                                    if (count($insert_data) > 0 ) {
                                        DB::table('communication_templates')->insert($insert_data);
                                        Session::flash('flash_msg','Record added successfully');
                                    }
                                    return json_encode(array('error' => 0)); exit;

                                } 

                        }else{ 
                            return View::make('admin.addtemplate')->with(array('data' => $data));
                        }                    
                    
                case 'edit': 
                    
                        $templateObj = DB::table('communication_templates')->where('communication_template_id', $id)->first(); 
                        $data['templateObj'] = $templateObj;

                        $post_arr           = Input::all();                     ;
  
                        if(!empty($post_arr) && $post_arr['form_submit'] == "save"){

                                // Check for duplicate
                                $validator = Validator::make(
                                    array(
                                        'template_title'  => $post_arr['template_title'],
                                        'template_text'  => $post_arr['template_text']
                                    ),
                                    array(
                                        'template_title' => 'required|unique:communication_templates,template_title,'.$id.',communication_template_id',
                                        'template_text' => 'required'   
                                    )
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
                                         
                                    $update_data['template_title'] = $post_arr['template_title'];
                                    $update_data['template_text'] = $post_arr['template_text'];
                                    $update_data['template_status'] = $post_arr['template_status'];
                                    if (count($update_data) > 0 ) {
                                        DB::table('communication_templates')->where('communication_template_id', $id)->update($update_data);
                                        Session::flash('flash_msg','Record saved successfully');

                                    }
                                    return json_encode(array('error' => 0)); exit;

                                } 

                        }else{ 
                            return View::make('admin.edittemplate')->with(array('data' => $data));
                        }                    
                    
                case 'delete': 
                        if($id){
                            DB::table('communication_templates')->where('communication_template_id','=',$id)->delete();
                            //Delete from  healthcare_professional_to_templates
                            DB::table('healthcare_professional_to_templates')->where("communication_template_id","=",$id)->delete(); 
                            
                            Session::flash('flash_msg','Record deleted successfully');
                            return json_encode(array('error' => 0)); exit;
                        } 
                        return  json_encode(array('error' => 1,'err_msg'=>'Template is missing')); exit;                      
                
                case 'statuschange': 
                        if($id){

                        $templateObj = DB::table('communication_templates')->where('communication_template_id','=',$id); 
                        $oldStatus = $templateObj->pluck('template_status');
                        if($oldStatus)
                            $newStatus = 0;
                            else
                            $newStatus = 1;
                            
                            $templateObj->update(array('template_status'=>$newStatus));
                            return  json_encode(array('error' => 0,'status' => $newStatus)); exit;
                        } 
                        return  json_encode(array('error' => 1,'err_msg'=>'Template is missing')); 
                        exit;
           
                case 'particular_provider': 
                            // Get templates of a particular Healthcare
                            $templateObjs = DB::table('healthcare_professional_to_templates')   
                                ->leftjoin('communication_templates','healthcare_professional_to_templates.communication_template_id','=','communication_templates.communication_template_id')
                                ->where('healthcare_professional_to_templates.healthcare_professional_id','=',$id)
                                ->orderBy('communication_templates.communication_template_id', 'DESC')->get();  
                            
                            $data['templateObjs'] = $templateObjs;
                            
                            $particularHpObj = DB::table('healthcare_professional')->where('healthcare_professional_id','=',$id)->first();   
                            $data['particularHpObj'] = $particularHpObj;
                            return View::make('admin.templates')->with(array('data' => $data));   
                            
                case 'assign_to_provider': 
                                $sql = "SELECT * FROM healthcare_professional AS HP LEFT JOIN country AS C
                                ON HP.healthcare_professional_country= C.country_id WHERE HP.healthcare_professional_status =1";
                                $hpObjs = DB::select($sql);
                                $data['hpObjs'] = $hpObjs;
                                $templateToHPs = DB::table('healthcare_professional_to_templates')->where('communication_template_id','=',$id)->get();
                                $alreadyAssignedHpIds = array();
                                foreach($templateToHPs as $templateToHP){
                                    $alreadyAssignedHpIds[] = $templateToHP->healthcare_professional_id;
                                }
                                $data['alreadyAssignedHpIds'] = $alreadyAssignedHpIds;
                                
                                $templateObj = DB::table('communication_templates')->where('communication_template_id','=',$id)->first();
                                $data['templateObj'] = $templateObj;
                                
                                return View::make('admin.assignprovider_to_template')->with(array('data' => $data));                                  
                    
                default: 

                    // Get all case files
                    $templateObjs = DB::table('communication_templates')                  
                        ->orderBy('communication_template_id', 'DESC')->get(); 
                    $data['templateObjs'] = $templateObjs;
                    return View::make('admin.templates')->with(array('data' => $data));                      

            }

    
    } 
    public function anyAssignprovider($id,$type=''){
        
        

 
        $data['site_url'] = URL::to('/');        
        switch ($type) {
            
        case 'assign': 
            
            // Assign healthcare(s) to a particular case files
            $post_arr           = Input::all();               
            $customerDetailId =$id;
            
            /* Start:validation */
            $providerArr = isset($post_arr['providers'])?$post_arr['providers']:array();
            if(count($providerArr)==0 && $post_arr['forwade_email']== ''){
                return  json_encode(array('error' => 1, 'err_msg' => " Please select or add atleast one Provider")); exit;
            }
            
            if($post_arr['forwade_email']!=''){
                $forwardEmailArr = explode(",", $post_arr['forwade_email']);
                if(count($forwardEmailArr)>0){
                    foreach ($forwardEmailArr as $forwardEmail){
                        
                        $validator = Validator::make(array('email'  => $forwardEmail),array('email' => 'email'));
                        if ($validator->fails())
                        {
                            $messages   = $validator->messages();   
                            $err_msg  = '<br />';
                            foreach ($messages->all() as $msg) {
                                    $err_msg .= '<i>'.$msg.'</i><br />';
                            }
                            return  json_encode(array('error' => 1, 'err_msg' => $err_msg)); exit;

                        }
                    }
                }
            }
            /* End:validation */
            
            
            $caseFileToHPs = DB::table('casefile_to_healthcare')->where('customer_detail_id','=',$customerDetailId)->get();
            $alreadyAssignedHpIds = array();
            foreach($caseFileToHPs as $caseFileToHP){
                if($caseFileToHP->healthcare_professional_id != '')
                    $alreadyAssignedHpIds[] = $caseFileToHP->healthcare_professional_id;
            }
            
            if(isset($post_arr['providers']))
                $submitedHpIds = $post_arr['providers'];
            else
                $submitedHpIds = array();

            $healthcare_professional_id = '';

            $HpIdsNeedToDelete = array_diff($alreadyAssignedHpIds,$submitedHpIds);            
            $HpIdsNeedToInsert = array_diff($submitedHpIds,$alreadyAssignedHpIds);

            
            if(count($HpIdsNeedToDelete)>0){
                foreach($HpIdsNeedToDelete as $HpId){
                    DB::table('casefile_to_healthcare') 
                    ->where('healthcare_professional_id','=',$HpId)
                    ->where('customer_detail_id','=',$customerDetailId)        
                    ->delete();
                }
                
            }
            
            if(count($HpIdsNeedToInsert)>0){
                foreach($HpIdsNeedToInsert as $HpId){
                    
                    $hpObj =DB::table('healthcare_professional') ->where('healthcare_professional_id','=',$HpId)->first();
                    $email_id = $hpObj->healthcare_professional_email_address;
                    
                    
                    
                    $customerDetailObj =DB::table('customer_detail') ->where('customer_detail_id','=',$customerDetailId)->first();
                    $customerId = $customerDetailObj->customer_id;                    
                    
                    $insert_data = array();
                    $insert_data['customer_id'] = $customerId;
                    
                    $insert_data['customer_detail_id'] = $customerDetailId;
                    $insert_data['healthcare_professional_id'] = $HpId;
                    $insert_data['healthcare_professional_email'] = $email_id;
                    $insert_data['date'] = date('Y-m-d H:i:s');       
                    $case_file_id = DB::table('casefile_to_healthcare')->insertGetId($insert_data);
                    
                    $val = 'casefile_id='.$case_file_id;
                    $key = urlencode(base64_encode($val));
                    $link = asset('healthcare_professional/casefileview?key='.$key);

                    $hp_name ="";
                    if($hpObj->healthcare_professional_first_name)
                        $hp_name = $hpObj->healthcare_professional_first_name;
                    
                    if($hpObj->healthcare_professional_middle_name)
                        $hp_name .= " ".$hpObj->healthcare_professional_middle_name;
                    
                    if($hpObj->healthcare_professional_last_name)
                        $hp_name .= " ".$hpObj->healthcare_professional_last_name;    
                    
                    
                    // Send Mail               
                    $templateLocation = "admin.mail_template_provider_assignment";

                    $thingsToPassTemplate["site_link"] = URL::to('/'); 
                    $thingsToPassTemplate["site_start_link"] = URL::to('/')."/home/basic";      
                    $thingsToPassTemplate["receipent_name"] = $hp_name;  
                    $thingsToPassTemplate["link"] = $link; 

                    $subject = "Casefile assignment notification"; 

                    $receipents = $email_id;

                    // Send mail
                    $result= (new BaseController)->send_mail(
                            $templateLocation,
                            $thingsToPassTemplate,
                            $subject,
                            $receipents
                    );
            
                }
                
            }
            
            
            // Forward Email section
            
           if(isset($post_arr['forwade_email']) && $post_arr['forwade_email'] !=''){
                $email_ids = explode(",",$post_arr['forwade_email']);
                foreach($email_ids as $email_id){
                                            
                    $casefileToHealthare = DB::table('casefile_to_healthcare')
                                            ->where('customer_detail_id','=',$customerDetailId)
                                            ->where('healthcare_professional_email','=',$email_id)
                                            ->first();

                    if(!is_object($casefileToHealthare)){
                        // No such entry so insert a new record

                        
                        $healthObj = DB::table('healthcare_professional')->where('healthcare_professional_email_address', '=', $email_id)->first(); 
                        $hp_name ="";
                        if(is_object($healthObj)){
                            $healthcare_professional_id = $healthObj->healthcare_professional_id;
                            $hp_name ="";
                            if($healthObj->healthcare_professional_first_name)
                                $hp_name = $healthObj->healthcare_professional_first_name;

                            if($healthObj->healthcare_professional_middle_name)
                                $hp_name .= " ".$healthObj->healthcare_professional_middle_name;

                            if($healthObj->healthcare_professional_last_name)
                                $hp_name .= " ".$healthObj->healthcare_professional_last_name;                             
                        }else{
                            $healthcare_professional_id = '';
                        }

                        $customerDetailObj =DB::table('customer_detail') ->where('customer_detail_id','=',$customerDetailId)->first();
                        $customerId = $customerDetailObj->customer_id;
                    
                        $insert_data = array();
                        $insert_data['customer_id'] = $customerId;
                        $insert_data['customer_detail_id'] = $customerDetailId;
                        $insert_data['healthcare_professional_id'] = $healthcare_professional_id;
                        $insert_data['healthcare_professional_email'] = $email_id;
                        $insert_data['date'] = date('Y-m-d H:i:s');       
                        $case_file_id = DB::table('casefile_to_healthcare')->insertGetId($insert_data);
                        $val = 'casefile_id='.$case_file_id;
                        $key = urlencode(base64_encode($val));
                        $link = asset('healthcare_professional/casefileview?key='.$key);

                        
                        // Send Mail               
                        $templateLocation = "admin.mail_template_provider_assignment";

                        $thingsToPassTemplate["site_link"] = URL::to('/'); 
                        $thingsToPassTemplate["site_start_link"] = URL::to('/')."/home/basic";      
                        $thingsToPassTemplate["receipent_name"] = $hp_name;  
                        $thingsToPassTemplate["link"] = $link; 

                        $subject = "Casefile assignment notification"; 

                        $receipents = $email_id;

                        // Send mail
                        $result= (new BaseController)->send_mail(
                                $templateLocation,
                                $thingsToPassTemplate,
                                $subject,
                                $receipents
                        );
                                                               
                    }
                        
                    
               }
                
                
            } 
            Session::flash('flash_msg','Provider(s) has been assigned successfully !');
            return json_encode(array('error' => 0)); exit;
        
        case 'assign_provider_to_template': 
           

            // Assignment of providers to the particular template
            
            $templateId = $id;
            $post_arr           = Input::all();
            $templateToHPs = DB::table('healthcare_professional_to_templates')->where('communication_template_id','=',$templateId)->get();
            $alreadyAssignedHpIds = array();
            foreach($templateToHPs as $templateToHP){
                if($templateToHP->healthcare_professional_id != '')
                    $alreadyAssignedHpIds[] = $templateToHP->healthcare_professional_id;
            }
            
            if(isset($post_arr['providers']))
                $submitedHpIds = $post_arr['providers'];
            else
                $submitedHpIds = array();


            $HpIdsNeedToDelete = array_diff($alreadyAssignedHpIds,$submitedHpIds);            
            $HpIdsNeedToInsert = array_diff($submitedHpIds,$alreadyAssignedHpIds);

            
            if(count($HpIdsNeedToDelete)>0){
                foreach($HpIdsNeedToDelete as $HpId){
                    DB::table('healthcare_professional_to_templates') 
                    ->where('healthcare_professional_id','=',$HpId)
                    ->where('communication_template_id','=',$templateId)        
                    ->delete();
                }
                
            }
            
            if(count($HpIdsNeedToInsert)>0){
                foreach($HpIdsNeedToInsert as $HpId){
                                   
                    $insert_data = array();                   
                    $insert_data['communication_template_id'] = $templateId;
                    $insert_data['healthcare_professional_id'] = $HpId;
      
                    DB::table('healthcare_professional_to_templates')->insert($insert_data);
            
                }
                
            }
            Session::flash('flash_msg','Provider(s) has been assigned successfully !');
            return json_encode(array('error' => 0)); exit;
            
        default:
            //Listing of healthcare professional, for assignment of a case file
            $customerDetailId =$id;
            $sql = "SELECT * FROM healthcare_professional AS HP LEFT JOIN country AS C
                    ON HP.healthcare_professional_country= C.country_id WHERE HP.healthcare_professional_status =1";
            $hpObjs = DB::select($sql);
            $data['hpObjs'] = $hpObjs;
            
            $caseFileToHPs = DB::table('casefile_to_healthcare')->where('customer_detail_id','=',$customerDetailId)->get();
            $alreadyAssignedHpIds = array();
            foreach($caseFileToHPs as $caseFileToHP){
                $alreadyAssignedHpIds[] = $caseFileToHP->healthcare_professional_id;
            }
            $data['alreadyAssignedHpIds'] = $alreadyAssignedHpIds;
            
            $caseFileObj = DB::table('customer_detail')->where('customer_detail_id','=',$customerDetailId)->first();
            $data['caseFileObj'] = $caseFileObj;            
            return View::make('admin.assignprovider')->with(array('data' => $data));  
            
        }
        
    }
    
    public function anyViewcasefile($casefileId){
        
        $data['site_url'] = URL::to('/');
        //display case file details
        $datareport = (new BaseController)->get_casefile_report($casefileId);
        $data['report']=$datareport;
        
        /*$data['casefile_to_healthcare_id']=$caseFileId;
        $data['customer_detail_id']=$customerDetailId;*/

        return View::make('admin.viewcasefile')->with(array('data'=>$data));
        exit;
    }
    public function anyTestimonial($type='',$id=''){
               
        $data['site_url'] = URL::to('/');

        switch ($type) {
            
        case  'add':
                        $post_arr           = Input::all();                            
 
                        if(!empty($post_arr) && $post_arr['form_submit'] == "save"){

                                // Check for duplicate
                                $validator = Validator::make(
                                    array(
                                        'user_name'  => $post_arr['user_name'],
                                        'testimonial_content'  => $post_arr['testimonial_content'],
                                    ),
                                    array(
                                        'user_name' => 'required' ,
                                        'testimonial_content' => 'required' ,
                                    )
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
                                    $insert_data['user_name'] = $post_arr['user_name'];
                                    $insert_data['user_location'] = $post_arr['user_location'];
                                    $insert_data['testimonial_status'] = $post_arr['testimonial_status'];
                                    $insert_data['testimonial_content'] = $post_arr['testimonial_content'];
                                    $insert_data['image'] = $post_arr['image'];
                                    $insert_data['display_order'] = $post_arr['display_order'];
                                    if (count($insert_data) > 0 ) {
                                        DB::table('testimonials')->insert($insert_data);
                                        Session::flash('flash_msg','Record added successfully');
                                    }
                                    return json_encode(array('error' => 0)); exit;

                                } 

                        }else{ 
                            $data['content_position'] = DB::table('content_position')->orderBy('content_position_id', 'ASC')->get();
                            return View::make('admin.addtestimonial')->with(array('data' => $data));
                        }
        case  'edit': 
            
                        $testimonialObj = DB::table('testimonials')->where('testimonial_id', $id)->get(); 
                        $data['testimonialObj'] = $testimonialObj[0];

                        $post_arr           = Input::all();                     ;
  
                        if(!empty($post_arr) && $post_arr['form_submit'] == "save"){

                             
                                $validator = Validator::make(
                                    array(
                                        'user_name'  => $post_arr['user_name'],
                                        'testimonial_content'  => $post_arr['testimonial_content'],
                                    ),
                                    array(
                                        'user_name' => 'required' ,
                                        'testimonial_content' => 'required' ,
                                    )
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
                                         
                                    $update_data['user_name'] = $post_arr['user_name'];
                                    $update_data['user_location'] = $post_arr['user_location'];
                                    $update_data['testimonial_status'] = $post_arr['testimonial_status'];
                                    $update_data['testimonial_content'] = $post_arr['testimonial_content'];
                                    $update_data['image'] = $post_arr['image'];
                                    $update_data['display_order'] = $post_arr['display_order'];
                                    if (count($update_data) > 0 ) {
                                        DB::table('testimonials')->where('testimonial_id', $id)->update($update_data);
                                        Session::flash('flash_msg','Record saved successfully');

                                    }
                                    return json_encode(array('error' => 0)); exit;

                                } 

                        }else{ 
                            
                            return View::make('admin.edittestimonial')->with(array('data' => $data));
                        }
            
        case 'statuschange':
           if($id){
               
               $testimonial = DB::table('testimonials')->where('testimonial_id','=',$id); 
               $oldStatus = $testimonial->pluck('testimonial_status');
               if($oldStatus)
                   $newStatus = 0;
               else
                    $newStatus = 1;
               $testimonial->update(array('testimonial_status'=>$newStatus));
               
               return  json_encode(array('error' => 0,'status' => $newStatus)); exit;
           } 
           return  json_encode(array('error' => 1,'err_msg'=>'Content is missing')); exit;
           
        case 'delete':
           if($id){
                DB::table('testimonials')->where('testimonial_id','=',$id)->delete();
                Session::flash('flash_msg','Record deleted successfully');
                return json_encode(array('error' => 0)); exit;
           } 
           return  json_encode(array('error' => 1,'err_msg'=>'Contents is missing')); exit;
           
            
        default: 

                $testimonials = DB::table('testimonials')->get();
                return View::make('admin.testimonial')->with(array('testimonials' => $testimonials,'data' => $data));
        }
       
    }
    public function anyRemoveuploadfile(){
       
        //Its Ajax section 
        // Remove just uploaded file 
        $post_arr           = Input::all();      
        if(file_exists("uploads/files/testimonial/".$post_arr['image']))
        unlink("uploads/files/testimonial/".$post_arr['image']);
     
        return json_encode(array('error' => 0)); exit;
      
      
    }
    public function anyDeletefile(){
        //Its Ajax section 
        // Remove just uploaded file 
        $post_arr           = Input::all();
        if(isset($post_arr['image'])){
            if($post_arr['image'] >0){
                $testimonial = DB::table('testimonials')->where('testimonial_id','=',$post_arr['image'])->first();
                if($testimonial->image !=''){
                    if(file_exists("uploads/files/testimonial/".$testimonial->image))
                unlink("uploads/files/testimonial/".$testimonial->image);  
                }
                $update_data['image'] = '';
                DB::table('testimonials')->where('testimonial_id', $post_arr['image'])->update($update_data);
            return json_encode(array('error' => 0)); exit; 
            }
        }
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
    public function getLogout()
    {
        session_destroy();
        Session::flush();
//        Auth::logout();
        $msg='';
        return Redirect::action('AdminController@anyLogin',array());
    }    
    public function anyChecklogin(){
        
        // Check whether customer has logined or not
        if(isset($_SESSION['admin_id']) && $_SESSION['admin_id'] >0){
            return true;
        }else{
            return false;
        }
        
    }         
}
