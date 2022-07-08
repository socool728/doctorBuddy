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
//use Vsmoraes\Pdf\Pdf;

class HomeController extends Controller {

    
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
     
//    public function anyDashboard(){
//        return View::make('question.dashboard');
//    }
//    
     public function __construct(){
         
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }  
              
     }
    public function anyIndex(){

         $data['site_url'] = URL::to('/');
         return View::make('home.index')->with(array('data'=>$data));
    }
    
    
    public function anyBasic(){

         $data['site_url'] = URL::to('/');
         
         $post_arr           = Input::all();       
        if(!empty($post_arr) && $post_arr['form_submit'] == "save"){
            
           $validator = Validator::make(
             array(
                 'customer_nickname'  => $post_arr['customer_nickname'], 
                 'customer_height'  => $post_arr['customer_height'],     
                 'customer_weight'  => $post_arr['customer_weight']     
             ),
             array(
                 'customer_nickname' => 'required|unique:customer_detail,customer_nickname',
                  'customer_height' => 'required|regex:/^\d*(\.\d{1,2})?$/',
                  'customer_weight' => 'required|regex:/^\d*(\.\d{12})?$/',
                      
             )
            );

            if ($validator->fails())
            {
                $messages   = $validator->messages();   
                $err_msg  = '';
                foreach ($messages->all() as $msg) {
                        $err_msg .= '<i>'.$msg.'</i><br />';
                }
                echo json_encode(array('error' => 1, 'err_msg' => $err_msg)); exit;

            } 
            
            
           Session::put('home_post',$post_arr);
           Session::put('customer_nickname',$post_arr['customer_nickname']);
           
            // Inserting customer location to  'customers_available' 
             $locationDetails = (new BaseController)->getLocationFromIp();
             $currentLocation='';

             if(isset($locationDetails['geoplugin_city']) &&  $locationDetails['geoplugin_city']!= '')
                 $currentLocation = $locationDetails['geoplugin_city'].",";

             if(isset($locationDetails['geoplugin_region']) &&  $locationDetails['geoplugin_region']!= '')
                 $currentLocation .= $locationDetails['geoplugin_region'].",";      

             if(isset($locationDetails['geoplugin_countryName']) && $locationDetails['geoplugin_countryName'] != '')
                 $currentLocation .= $locationDetails['geoplugin_countryName'];

             DB::table('customers_available')->insert(array('customer_nikname'=>$post_arr['customer_nickname'],'location'=>$currentLocation));
            
            return json_encode(array('error' => 0)); exit;
           
        }
         return View::make('question.index')->with(array('data'=>$data));
    }    
    
    public function anyLaunch(){
        $question_data = array();
        $data['site_url'] = URL::to('/');
        return View::make('question.question')->with(array('data'=>$data,'question'=>$question_data,'question_id'=>1));
    }
        
    public function anyLoadqn(){

        
        // Get Post values
        $post_arr           = Input::all();  

            if($post_arr['currord']){  
                
                // Initialise
                $sel_symptom_arr = $customer_data = array();
                $customer_ans = array();
                $optionid = $optionidar = array();
                
                $questiongroupsExceptFirst  = array();
                $skipedQuestionGroups = array();
                
                $currentDisplayOrderArr = array();
                $displayOrderArr = array();
                $tempdisplayOrderArr = array();
                $question_data = array();                
                $security = array();
                $currentOrder = $post_arr['currord'];
                
                // Get security questions
                $securities = DB::table('security_questions')->orderBy('display_order', 'ASC')->select('question_id','question')->get();
                if(count($securities)>0){$p=0;
                    foreach($securities as $securityqn){
                        $security[$p]['sec_question_id'] = $securityqn->question_id;
                        $security[$p]['sec_question'] = $securityqn->question;
                        $p++;
                    }
                }
                 
                // Display Country, state,question groups to skip
                $country = $state = array();
//                if($currentOrder==1){
                    
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
                    
                   if($currentOrder ==1){ 
                    //Get all question groups except the first one,for skip question group section.First guestion group will always display.
                    $questiongroupsExceptFirst = DB::table('questiongroup')->orderBy('display_order', 'ASC')->where('status', '=', 1)->where('display_order', '!=', 1)->get();                  
                   }
                
//                }                
                 

                // Get right overlay content
                if($post_arr != ''){

                    $rightOverlayData = $this->get_rightoverlay_content($post_arr);
                    
                    if(isset($rightOverlayData['customer_data']) && $rightOverlayData['customer_data'] !='')
                        $customer_data = $rightOverlayData['customer_data'];
                    if(isset($rightOverlayData['customer_ans']) && $rightOverlayData['customer_ans'] !='')
                        $customer_ans = $rightOverlayData['customer_ans'];
           
                    if(isset($rightOverlayData['sel_symptom_arr']) && $rightOverlayData['sel_symptom_arr'] !='')
                        $sel_symptom_arr = $rightOverlayData['sel_symptom_arr'];
                    
                    if(isset($rightOverlayData['optionidar']) && $rightOverlayData['optionidar'] !='')
                        $optionidar = $rightOverlayData['optionidar'];
   
                   // echo '<pre>';print_r($customer_data);
                }
                
                
                // Get current display order. 
                // ie ,from this , we can get the current question group need to show
                $currentOrder = $post_arr['currord'];

                // Create  display order array for question group
                $questiongroups = DB::table('questiongroup')->orderBy('display_order', 'ASC')->where('status', '=', 1)->get();
                foreach($questiongroups as $questiongroup){
                    $displayOrderArr[] = $questiongroup->display_order;
                }
                $currentDisplayOrderArr = $displayOrderArr;
                


                //Get the final display order array.This array always contain  a value 1, whch is the display order of Basic group
                if(isset($post_arr['skip_questiongroups']) &&  $post_arr['skip_questiongroups'] != ''){
                        $skipedQuestionGroups = $post_arr['skip_questiongroups'];
                        if(count($skipedQuestionGroups)>0){
                             $questiongroups = DB::table('questiongroup')->whereIn('group_id',$skipedQuestionGroups )->get();
                             if($questiongroups){
                                 foreach($questiongroups as $questiongroup){
                                     $tempdisplayOrderArr[] = $questiongroup->display_order;
                                     
                                 }
                             }
                             unset($currentDisplayOrderArr);
                             $currentDisplayOrderArr =array_diff($displayOrderArr,$tempdisplayOrderArr);
                             $currentDisplayOrderArr = array_values($currentDisplayOrderArr);
                             sort($currentDisplayOrderArr);
                        }
                } 

                
                // If all  question groups are skipped
                if(count($currentDisplayOrderArr) ==1){
                    // Display final page 
                   return View::make('question.ajfinish')->with(array('question'=>$question_data,'sel_symptom'=>$sel_symptom_arr,'customer_data'=>$customer_data,'customer_ans'=>$customer_ans,'currord'=>'f','sec_question'=>$security,'country'=>$country,'state'=>$state));                  
                   exit;
                }
                
                // if it is final page
                if($currentOrder == 'f'){
                  // Display final page 

                   return View::make('question.ajfinish')->with(array('question'=>$question_data,'sel_symptom'=>$sel_symptom_arr,'customer_data'=>$customer_data,'customer_ans'=>$customer_ans,'currord'=>'f','sec_question'=>$security,'country'=>$country,'state'=>$state));                  
                   exit;

                }

                // Calculate the previous, next display order of question group
                $displayOrderKey = array_search($currentOrder, $currentDisplayOrderArr);

          
             
                    
                   // Do while,  check if the given question group has questions, other wise take next question group
                do {
                    $continue = true;
                    
                     if($currentOrder == 'f'){                         
                      // Display final page 
                        return View::make('question.ajfinish')->with(array('question'=>$question_data,'sel_symptom'=>$sel_symptom_arr,'customer_data'=>$customer_data,'customer_ans'=>$customer_ans,'currord'=>'f','sec_question'=>$security,'country'=>$country,'state'=>$state));                     
                        exit;
                    }
                    
                    // Recalculate the current, next display order of question group
                    $displayOrderKey = array_search($currentOrder, $currentDisplayOrderArr);
                    
                    if($displayOrderKey === false && $currentOrder ==2){
                        // Special situation,
                        $currentOrder =$currentDisplayOrderArr[1];
                        if(count($currentDisplayOrderArr) ==2 )
                            $nextOrder = 'f'; 
                        else
                            $nextOrder= $currentDisplayOrderArr[2];
                                            
                    }else{
 
                        if($displayOrderKey+1 == count($currentDisplayOrderArr))
                            $nextOrder  ='f';
                        else                   
                            $nextOrder = $currentDisplayOrderArr[$displayOrderKey+1];

                    }
                    
                    
                    // Get questions of a question group by given order 
                    $question_data = $this->get_questions_from_questiongroup_by_displayorder($currentOrder,$post_arr);
                    if(count($question_data)>0){
                        $continue = false;
                    }else{
                        $currentOrder = $nextOrder;
                    }
                    
                }while($continue == true);

                
                

                
                
 
                $prevNextCurrent = array();
                $prevNextCurrent['current'] = $currentOrder;
                $prevNextCurrent['next'] = $nextOrder;
                    
                    
                return View::make('question.ajquestion')->with(
                        array(
                            'question'=>$question_data,
                            'depend'=>$optionidar,
                            'sel_symptom'=>$sel_symptom_arr,
                            'customer_data'=>$customer_data,
                            'customer_ans'=>$customer_ans,
                            'country'=>$country,
                            'state'=>$state,
                            'prev_next_current'=>$prevNextCurrent,
                            'sec_question'=>$security,
                            'questiongroups_except_first'=>$questiongroupsExceptFirst
                        )
                        );
            }
                
    }

    
 
    public function anyLoadsymptom(){
        $data = Input::all();
//        print_r($data);
//        echo $data['gpid'];
        if(!isset($data['gpid']))
            $data['gpid'] =3;
        $result = array();
        if($data['search'] !=''){  
            $symptom_data = $symptoms = array();
            $parent_data = $symptom_parentdata = array();
            $symptom_ids =array();
            $searchval = "*".trim($data['search'])."*";
            if(strtolower(trim($data['search'])) == 'all'){
                $sql = "SELECT s.symptom_id, s.symptom_name, (SELECT ss.symptom_name FROM `symptoms` ss WHERE ss.symptom_id = s.parent_id) AS parentname, st.symptom_id AS subsymptom_id, st.symptom_name AS subsymptom_name FROM `symptoms` AS s LEFT JOIN `symptoms` st ON ( st.parent_id = s.symptom_id ) ";
            }else{
                $sql = "SELECT s.symptom_id, s.symptom_name, (SELECT ss.symptom_name FROM `symptoms` ss WHERE ss.symptom_id = s.parent_id) AS parentname, st.symptom_id AS subsymptom_id, st.symptom_name AS subsymptom_name FROM `symptoms` AS s LEFT JOIN `symptoms` st ON ( st.parent_id = s.symptom_id ) WHERE MATCH (s.symptom_name) AGAINST ('".$searchval."' IN BOOLEAN MODE)";
            }
            $symptoms = DB::select($sql);
            if(count($symptoms)>0){
                $symptom_idarr = $subsymptom_idarr = array();
                foreach($symptoms as $symptom){ 
                    if($symptom->subsymptom_id > 0){
                             $symptom_data[] = array(
                            'symptom_id' => $symptom->subsymptom_id,
                            'symptom_name' => ucfirst($symptom->symptom_name).' - '.$symptom->subsymptom_name
                            );                           
                            $symptom_idarr[] = $symptom->symptom_id;
                    }else{
                        if(!in_array($symptom->symptom_id,$symptom_idarr)){
                            $symptom_data[] = array(
                                'symptom_id' => $symptom->symptom_id,
                                'symptom_name' => ucfirst($symptom->parentname).' - '.$symptom->symptom_name
                                );
                            $symptom_idarr[] = $symptom->subsymptom_id;
                        }
                    }
                }
                if(is_array($symptom_data)){                           
                    // Obtain a list of columns
                    foreach ($symptom_data as $key => $row) {
                        $symptom_col[$key]  = $row['symptom_name'];                                 
                    }
                    // Sort the data with symptom_name ascending
                    array_multisort($symptom_col, SORT_ASC, $symptom_data);
                }
                $result = $symptom_data;     
            }else{
                $symptom_data[] = array(
                                'symptom_id' => 0,
                                'symptom_name' => "New symptom  " 
                                );
                $result = $symptom_data; 
            }           
            return View::make('question.symptom')->with(array('symptom'=>$result,'gp_id'=>$data['gpid'],'data'=>$data));
        }
           
    }
    



//    public function anyState(){
//        $data = Input::all();
//        $result ='';
//        if(isset($data['cnty'])){  
//            if($data['cnty']>0){  
//                $states = DB::table('states')->where('country_id', '=', $data['cnty'])->orderBy('state_id', 'ASC')->get();
//                if(count($states)>0){ 
//                    $result = '<select class="form-control" name="customer_state" id="state">';
//                    foreach($states as $cntrystate){
//                        $result .= '<option value="'.$cntrystate->name.'" >'.$cntrystate->name.'</option>';
//                    }
//                    $result .= '</select>';
//                }else{
//                    $result ='';
////                    $result = '<input id="state" name="state" value="" title="State" required="required" class="form-control col-md-7 col-xs-12" type="text">';
//                }
//                return $result;
//            }
//        }else{
//            return $result;
//        }           
//    }  
    
    
    public function anyFinish($id=null){ 
        set_time_limit(0);
         $datareport = array();

         $data = Input::all(); 
   
         
          $registration = $logined=  0; 

           //Take the session set in home page
           $homePost  = Session::get('home_post'); 
           
           if(count($homePost)<=0){              
                Session::flash('err_msg','Your case session has expired.');
                return json_encode(array('error' => 2, 'err_msg' => "Questionaire session has expired.You will redirect to starting page")); exit;
           }
     
            if($data !=''){

                  $customerNickName = $homePost['customer_nickname'];
                  $customerForWhom = $homePost['customer_for_whom'];
                  $customerSex = $homePost['customer_sex'];
                  $customerAge = $homePost['customer_age'];
                  
                  $customerHeight = $homePost['customer_height'];
                  $customerHeightUnit = $homePost['customer_height_unit'];
                  $customerWeight = $homePost['customer_weight'];
                  $customerWeightUnit = $homePost['customer_weight_unit'];                  

                  //$customerKnownDisease = $homePost['known_disease'];
                 
                    
                  $customerStatus = 4; //incomplete status
                  
                    $detail_id = '';
                    if($data['customer_id']>0){
                        $email_exist = 1;
                    }else{
                        if($data['existing']==0){
                            $email = trim($data['email']);
                            $customer_password = (new BaseController)->encrypt_decrypt(trim($data['password']));                        
                        }else{
                            $email = trim($data['user_email_id']);
                            $customer_password = '';
                        }
                        $email_exist = (new CustomerController)->anyEmailcheck(trim($email));
                    }
                    $customer_no = 1;
                    if($email_exist =='0'){
                        // New customer
                        $customer = DB::table('customer_detail')->orderBy('customer_id', 'DESC')->select('customer_code')->first();
                        
                        $customer_code = $customer->customer_code;
                        if($customer_code>0){
                            $customer_code = $customer_code+1;
                        }else{
                            $customer_code = '1001';
                        }
                        
                        // For customer table
                        $insert_data = array();
                        $insert_data['customer_email_id'] = $email;
                        $insert_data['customer_password'] = $customer_password;
                        $insert_data['customer_status'] = $customerStatus;  
                        $insert_data['email_verify'] = 1;   
                        $customer_id = DB::table('customers')->insertGetId($insert_data);
                        $registration =1;
                        
                        
                       // START: Creating  an entry into customer_details table for customer  profile 
                       $profile_data = array(); 
                       
                       $profile_data['customer_id'] = $customer_id;
                       $profile_data['customer_code'] = $customer_code;
                       $profile_data['customer_no'] = $customer_no;
                       $profile_data['country_id'] = trim($data['country']);
                       if(isset($data['customer_state']) && $data['customer_state'] !='')
                            $profile_data['customer_state'] = trim($data['customer_state']);
                       if(isset($data['customer_city']) && $data['customer_city'] !='')
                            $profile_data['customer_city'] = trim($data['customer_city']);
                       if(isset($data['customer_area']) && $data['customer_area'] !='')
                            $profile_data['customer_area'] = trim($data['customer_area']);
                       if(isset($data['customer_zip']) && $data['customer_zip'] !='')
                            $profile_data['customer_zip'] = trim($data['customer_zip']);
                       $profile_data['created_at'] = date('Y-m-d H:i:s');
                       $profile_data['updated_at'] = date('Y-m-d H:i:s');
                       $profile_data['customer_status'] = 1;
                       $profile_data['is_casefile'] = 0;  //for profile purpose
                       
                       
                       DB::table('customer_detail')->insertGetId($profile_data);
                      // END: Creating  an entry into customer_details table for customer  profile  
                       
                       
                       $customer_no = $customer_no+1; 
                       
                       
                    }else{
                        
                        
                        // Existing Customer
                        $cust_codno =0;
                        if($data['customer_id']>0){
                            $customer = DB::table('customer_detail')->leftjoin('customers', 'customers.customer_id', '=', 'customer_detail.customer_id')->where('customers.customer_id', '=', $data['customer_id'])->select('customer_detail.customer_code','customer_detail.customer_no','customers.customer_id','customers.customer_email_id', 'customers.customer_status')->orderBy('customer_detail.customer_no', 'DESC')->first();
                        }else{
                            $customer = DB::table('customer_detail')->leftjoin('customers', 'customers.customer_id', '=', 'customer_detail.customer_id')->where('customers.customer_email_id', '=', $email)->select('customer_detail.customer_code','customer_detail.customer_no','customers.customer_id','customers.customer_email_id', 'customers.customer_status')->orderBy('customer_detail.customer_no', 'DESC')->first(); 
                        }
                        
                        
                        if(count($customer)>0){
                            $customer_id = $customer->customer_id;
                            $customer_code= $customer->customer_code;
                            $customer_no = $customer->customer_no;
                            $email = $customer->customer_email_id;
                            $customerStatus = $customer->customer_status;
                            
                            if($customer_no>0){
                                $customer_no = $customer_no+1;
                            }else{
                                $customer_no = '1';
                            }

                        } 
                    }
                        
                        // Case file entry, in customer detail table
                        $detail_data = array();
                        
                        $detail_data['customer_id'] = $customer_id;
                        $detail_data['customer_code'] = $customer_code;
                        $detail_data['customer_no'] = $customer_no;
                        
                        $detail_data['customer_nickname'] = $customerNickName;
                        $detail_data['country_id'] = trim($data['country']);
                        if(isset($data['customer_state']) && $data['customer_state'] !='')
                            $detail_data['customer_state'] = trim($data['customer_state']);
                        if(isset($data['customer_city']) && $data['customer_city'] !='')
                            $detail_data['customer_city'] = trim($data['customer_city']);
                        if(isset($data['customer_area']) && $data['customer_area'] !='')
                            $detail_data['customer_area'] = trim($data['customer_area']);
                        if(isset($data['customer_zip']) && $data['customer_zip'] !='')
                            $detail_data['customer_zip'] = trim($data['customer_zip']);
                        if(isset($data['forwade_email']) && $data['forwade_email'] !='')
                            $detail_data['forwade_email'] = trim($data['forwade_email']);
                        if(isset($data['forwade_phone']) && $data['forwade_phone'] !='')
                            $detail_data['forwade_phone'] = trim($data['forwade_phone']);
                        if(isset($data['known_disease']) && $data['known_disease'] !='')
                            $detail_data['known_disease'] = $data['known_disease'];   
                        
                        $detail_data['customer_for_whom'] = $customerForWhom;
                        $detail_data['customer_sex'] = $customerSex;
                        $detail_data['customer_age'] = $customerAge;                        
                        $detail_data['customer_status'] = '1';
                        if(isset($data['customer_past_illness_history']) && $data['customer_past_illness_history'] !='')
                            $detail_data['customer_past_illness_history'] = $data['customer_past_illness_history'];
//                        if(isset($data['customer_medicalreport']) && $data['customer_medicalreport'] !='')
//                            $detail_data['customer_medicalreport'] = $data['customer_medicalreport'];
                        if(isset($data['customer_hereditary_disease']) && $data['customer_hereditary_disease'] !='')
                            $detail_data['customer_hereditary_disease'] = $data['customer_hereditary_disease'];
                        
                        
                        $detail_data['customer_height'] = $customerHeight;
                        $detail_data['customer_height_unit'] = $customerHeightUnit;
                        $detail_data['customer_weight'] = $customerWeight;
                        $detail_data['customer_weight_unit'] = $customerWeightUnit;
                        
                        
                        if(isset($data['customer_present_medication']) && $data['customer_present_medication'] !='')
                            $detail_data['customer_present_medication'] = $data['customer_present_medication'];
                        if(isset($data['customer_allergic_reaction']) && $data['customer_allergic_reaction'] !='')
                            $detail_data['customer_allergic_reaction'] = $data['customer_allergic_reaction'];
                        
                        $detail_data['created_at'] = date('Y-m-d H:i:s');
                        $detail_data['updated_at'] = date('Y-m-d H:i:s');
                        
                        

                        
                        $detail_id = DB::table('customer_detail')->insertGetId($detail_data);
                        
                         // For customer files table
                        if(isset($data['customer_medicalreport']) && $data['customer_medicalreport'] != ''){
                            $upload_files = explode(',',$data['customer_medicalreport']);
                            if(count($upload_files)>0){
                                $doc_arrdata = array();
                                foreach($upload_files as $files){
                                    $doc_data = array();
                                    $doc_data['file_name'] = trim($files);
                                    $doc_data['customer_detail_id'] = $detail_id;
                                    DB::table('customer_files')->insert($doc_data);
                                }                                
                            }
                        }


                        
                    
          
                
                
                
                if($customer_id>0){

                     //Question answer details
                    // For customer_answers table
                    $currdate = date('Y-m-d H:i:s');
                    foreach($data as $key=>$value){
//                        if(is_numeric($key)){   
                        if(is_numeric($key) || strpos($key, 'chkbxqn_')!==false){
                            if(!is_numeric($key)){
                                //its related a checkbox question and customer not answered
                                $chkBoxQuestionArr = explode('chkbxqn_',$key);
                                $questionId = $chkBoxQuestionArr[1];
                                //Confirm  this question is not repeating
                                if(array_key_exists($questionId,$data)){
                                    continue;
                                }
                            }else{
                                $questionId = $key;
                            }
                            $question = DB::table('questions')->leftjoin('questiongroup', 'questions.question_group_id', '=', 'questiongroup.group_id')->where('questions.question_id', '=', $questionId)->first();

                            if(count($question)>0){

                                $optionval = $value;
                                $ansid = ''; 
                                
                                if(is_numeric($value)){
                                    $optionres  = DB::table('options')->where('options.option_id', '=', $value)->where('options.question_id', '=', $questionId)->first();
                                    if(count($optionres)>0){
                                        $optionval = $optionres->option_name;
                                        $ansid = $value;
                                    }else{
                                        $ansid = $value;
                                        if($question->question_type='check'){
                                            $optionval = "";  
                                            $ansid = "";
                                        }
                                    }
                                    
                                }elseif(is_array($value)){
                                    $result_sel = '';
                                    foreach($value as $optionsel){
                                        if($optionsel >0)
                                        $result_sel .= $optionsel.",";
                                    }
                                    if(strlen($result_sel)>1){
                                        $in_arr = substr($result_sel,0,-1);
                                        $sql = "SELECT GROUP_CONCAT( `option_name` ) as options FROM `options` WHERE `option_id` IN (".$in_arr.") GROUP BY `question_id`";
                                        $optionres_arr = DB::select($sql); 
                                        if(count($optionres_arr)>0){
                                            $optionval = $optionres_arr[0]->options;
                                            $ansid = $in_arr;
                                        }
                                    }
                                }
//                                if(is_array($ansid)){
//                                    foreach($ansid as $ans_ids){
//                                        $explod_ans .= $ans_ids.","; 
//                                    }
//                                    $ansid = substr($explod_ans,0,-1);
//                                }
                                DB::table('customer_answers')->insert(array(
                                        array(
                                            'customer_id' => $customer_id, 
                                            'detail_id' => $detail_id, 
                                            'question_id' => $questionId,
                                            'question' => $question->question,
                                            'group_id' => $question->group_id,
                                            'group_name' => $question->group_name,
                                            'option_id' => $ansid,
                                            'option_val' => $optionval,
                                            'created_date' => $currdate,
                                            'modified_date' => $currdate
                                            )
                                    )); 
                            }

                        }
                    }
                    
                    // For customer_symptoms,customer_symptoms_his table
                    
                    if(isset($data['symp_id'])&& $data['symp_id'] != '')
                        $symptomIds  = $data['symp_id'];
                    else
                        $symptomIds = array();

                    if(count($symptomIds) > 0){
                        $i = 0;                        
                        foreach($symptomIds as $symptomId){
                            $sympt = DB::table('symptoms')->where('symptoms.symptom_id', '=', $symptomId)->first();
                            if(count($sympt)>0){  
                                $symptom_name = $sympt->symptom_name;
                            }elseif($symptomId ==0){
                                $symptom_name = 'Custom symptom';
                            }
                                $insert_data = array();
                                $insert_data['customer_id'] = $customer_id;
                                $insert_data['detail_id'] = $detail_id;
                                $insert_data['symptom_id'] = trim($symptomId);
                                $insert_data['symptom_name'] = $symptom_name;
                                
                                if(isset($data['rat_'.$symptomId]) && $data['rat_'.$symptomId] !='')
                                    $insert_data['symptom_rate'] = $data['rat_'.$symptomId];  
                                else
                                    $insert_data['symptom_rate'] = "";
                                
                                if(isset($data['symcnt_'.$symptomId]) && $data['symcnt_'.$symptomId] !='')
                                    $insert_data['customer_note'] = $data['symcnt_'.$symptomId]; 
                                else
                                    $insert_data['customer_note'] = "";
                                
                                $insert_data['created_date'] = date("Y-m-d H:i:s");
                                $insert_data['modified_date'] = date("Y-m-d H:i:s");
                                DB::table('customer_symptoms')->insert($insert_data);
                                
                                unset($insert_data['modified_date']);
                                DB::table('customer_symptoms_his')->insert($insert_data);
                                $i++;
                        }
                    }

                    // Save Drop box links, if any
                    
                    if(isset($data['drop_box_link'])&& count($data['drop_box_link']) >0){
                        
                        foreach($data['drop_box_link'] as $dropboxLink){
                            
                            $insert_data = array();
                            $insert_data['customer_detail_id'] = $detail_id;
                            $insert_data['file_path'] = $dropboxLink;
                            DB::table('customerdetail_to_dropbox')->insert($insert_data);
                            
                        }
                        
                    }
                    
                
                  /*  // For customer_report table
                    DB::table('customer_report')->insert(array(
                        array(
                            'customer_id' => $customer_id, 
                            'detail_id' => $detail_id, 
                            'answers' => '',
                            'filepath' => 'DB'.$customer_code.'-'.$customer_no.'.pdf',
                            'created_date' => date('Y-m-d H:i:s'),
                            'modified_date' => date('Y-m-d H:i:s')
                            )
                    )); */
                }

            if($registration ==1){
                //its a new negistration
                // Verify mail
              //  $this->anyVerifymail($customer_id,$customerNickName);

                // For Registration success mail
                $this->anyRegistrationemail($customer_id,$customerNickName,trim($data['password']));
                
                // For Case file creation mail
                $this->anyCasefilemail($customer_id,$customerNickName);
            }else{
                // For Case file creation mail
                $this->anyCasefilemail($customer_id,$customerNickName);
            }
             
            //mail forwade to healthcare professional
          if(isset($data['send_option']) && $data['send_option'] =='yes')  {
            if(isset($data['forwade_email']) && $data['forwade_email'] !=''){
                $this->anyForwadehealthcare($customer_id,$detail_id,$data['forwade_email']);
            } 
          }

         // $report = (new BaseController)->get_casefile_report($detail_id);
          
          
          //Clear session started on home page
          Session::forget('home_post');

        if(!Session::has('customer_id')&& !Session::has('hp_id') && !Session::has('counselor_id')){
            
            // No one is already logined.So login the customer
             Session::flush();
             session_destroy();

             session_start();

             Session::put('customer_id',$customer_id);
             $_SESSION['customer_id'] = $customer_id;
        }else if(Session::has('counselor_id')){
            
            $insert_data = array();
            $insert_data['customer_detail_id'] = $detail_id;
            $insert_data['customer_id'] = $customer_id;
            $insert_data['counselor_id'] = Session::get('counselor_id');
            $insert_data['date'] = date("Y-m-d H:i:s");
            DB::table('casefile_to_counselor')->insert($insert_data);            
            
        }
         
         
         
         
         Session::flash('flash_msg','Thank you for submitting your case file.Please go to your account to edit and update your file');
         return json_encode(array('error' => 0,'detail_id' =>$detail_id)); exit;

        }

       return json_encode(array('error' => 1, 'err_msg' => "Some error has happened.Please try after some time")); exit;
 
       
    }    
    
    public function anyResult($detail_id=''){
        
       $detail_id = (int)$detail_id; 
       $casefileObj = DB::table('customer_detail')->where('customer_detail_id', '=', $detail_id)->first();

       if(is_object($casefileObj) && count($casefileObj) >0){
            $report = (new BaseController)->get_casefile_report($detail_id); 
            return View::make('question.result')->with(array('report' => $report));           
       }else{
           Session::flash('err_msg' ,'No record exist');
           return View::make('question.result');
       }

    }
//    public function anyReport($id=null){    
//
//        $report = (new BaseController)->get_casefile_report($id);
//        $html =  View::make('question.report')->with(array('report' => $report))->render();
//
//        $pdf = App::make('dompdf.wrapper');
//        $pdf->loadHTML($html);
//        $filename = $report['customer_fileno'].'.pdf';
//        $pdf->save(base_path().'/pdfreports/'.$filename);
//        return $report;   
//        
//    }
    function anyConvert(){
		$pdf = App::make('dompdf.wrapper');
//                print_r($pdf);
                $pdf->loadHTML('<h1>Test</h1>');
$filename = 'file1.pdf';
$pdf->save(base_path().'/pdfreports/'.$filename);
        //$pdf->loadHTML('<h1>Test</h1>')->save('test.pdf');
        return $pdf->stream();
    }
    
  public function get_rightoverlay_content($post_arr,$back=null){
      
        if(isset($post_arr['symp_id'])&& $post_arr['symp_id'] != '')
            $symptomIds  = $post_arr['symp_id'];
        else
            $symptomIds = array();

        if(count($symptomIds) > 0){
            $i = 0;                        
            foreach($symptomIds as $symptomId){
                $sympt = DB::table('symptoms')->where('symptoms.symptom_id', '=', $symptomId)->first();
                if(count($sympt)>0){                                   
                    $sel_symptom_arr[$i]['symptom_id'] = $symptomId;
                    $sel_symptom_arr[$i]['symptom_name'] = $sympt->symptom_name;
                    
                    if(isset($post_arr['rat_'.$symptomId]) && $post_arr['rat_'.$symptomId] !=''){
                        $sel_symptom_arr[$i]['symptom_rate'] =  $post_arr['rat_'.$symptomId]; 
                    }else{
                        $sel_symptom_arr[$i]['symptom_rate'] =  '';
                    }
                    
                    if(isset($post_arr['symcnt_'.$symptomId]) && $post_arr['symcnt_'.$symptomId] !=''){
                        $sel_symptom_arr[$i]['customer_note'] = $post_arr['symcnt_'.$symptomId]; 
                    }else{
                        $sel_symptom_arr[$i]['customer_note'] = "";
                    }  
                     
                    //Check the particular symptom has parent.If yes add that parent name   to the symptom name
                    $parentId = $sympt->parent_id;
                    if($parentId >0){
                        $parentSympt = DB::table('symptoms')->where('symptoms.symptom_id', '=', $parentId)->first();
                        if(count($parentSympt)>0){
                            $sel_symptom_arr[$i]['symptom_name'] = $parentSympt->symptom_name." - ".$sympt->symptom_name;
                        }
                        
                    }
                    
                    
                    $i++;
                }

            }
        }
        // Take session from home page
        $homePost  = Session::get('home_post');

        //Customer  details
        $customer_data['customer_nickname'] = $homePost['customer_nickname'];
        $customer_data['customer_for_whom'] = $homePost['customer_for_whom'];
        $customer_data['customer_age'] = $homePost['customer_age'];
        $customer_data['customer_sex'] = $homePost['customer_sex'];
        
        $customer_data['customer_height'] = $homePost['customer_height'];
        $customer_data['customer_height_unit'] = $homePost['customer_height_unit'];
        $customer_data['customer_weight'] = $homePost['customer_weight'];
        $customer_data['customer_weight_unit'] = $homePost['customer_weight_unit'];
        //$customer_data['known_disease'] = $homePost['known_disease'];
        
       if(isset($post_arr['known_disease']) && $post_arr['known_disease'] !='')
            $customer_data['known_disease'] = $post_arr['known_disease'];        
        if(isset($post_arr['customer_present_medication']) && $post_arr['customer_present_medication'] !='')
            $customer_data['customer_present_medication'] = $post_arr['customer_present_medication'];
        if(isset($post_arr['customer_allergic_reaction']) && $post_arr['customer_allergic_reaction'] !='')
            $customer_data['customer_allergic_reaction'] = $post_arr['customer_allergic_reaction'];
        if(isset($post_arr['customer_past_illness_history']) && $post_arr['customer_past_illness_history'] !='')
            $customer_data['customer_past_illness_history'] = $post_arr['customer_past_illness_history'];
        if(isset($post_arr['customer_hereditary_disease']) && $post_arr['customer_hereditary_disease'] !='')
            $customer_data['customer_hereditary_disease'] = $post_arr['customer_hereditary_disease'];

        if(isset($post_arr['customer_medicalreport']) && $post_arr['customer_medicalreport'] !='')
            $customer_data['customer_medicalreport'] = $post_arr['customer_medicalreport'];
        
        if(isset($post_arr['drop_box_link']) && count($post_arr['drop_box_link'])>0)
            $customer_data['drop_box_link'] = $post_arr['drop_box_link'];
     
        

        if(isset($post_arr['country']) && $post_arr['country'] !=''){
            $cntryinfo = DB::table('country')->where('country_id', '=',$post_arr['country'])->first();
            if(count($cntryinfo)>0)
                $customer_data['customer_country'] = $cntryinfo->countryname;
        }
        if(isset($post_arr['state']) && $post_arr['state'] !=''){
            $customer_data['customer_state'] = $post_arr['state'];
        }
        if(isset($post_arr['city']) && $post_arr['city'] !=''){
            $customer_data['customer_city'] = $post_arr['city'];
        }
        if(isset($post_arr['zip']) && $post_arr['zip'] !=''){
            $customer_data['customer_zip'] = $post_arr['zip'];
        }

        //Question answer details
//        echo '<pre>';
//        print_r($post_arr);
        foreach($post_arr as $key=>$value){
    
            if(is_numeric($key) || strpos($key, 'chkbxqn_')!==false){
                if(!is_numeric($key)){
                    //its related a checkbox question and customer not answered
                    $chkBoxQuestionArr = explode('chkbxqn_',$key);
                    $questionId = $chkBoxQuestionArr[1];
                    //Confirm  this question is not repeating
                    if(array_key_exists($questionId,$post_arr)){
                        continue;
                    }
                }else{
                    $questionId = $key;
                }
                $question = array();
                if(isset($back) && $back>0){
                    $question = DB::table('questions')->leftjoin('questiongroup', 'questions.question_group_id', '=', 'questiongroup.group_id')->where('questions.question_id', '=', $questionId)->where('questions.question_group_id', '!=', $back)->first();
                }elseif($back!='0'){
                $question = DB::table('questions')->leftjoin('questiongroup', 'questions.question_group_id', '=', 'questiongroup.group_id')->where('questions.question_id', '=', $questionId)->first();
                }elseif($back==null){
                    $question = DB::table('questions')->leftjoin('questiongroup', 'questions.question_group_id', '=', 'questiongroup.group_id')->where('questions.question_id', '=', $questionId)->first();
                }
                if(count($question)>0){
//                    if($back>0 || $back!=$question->group_id){
                        $questionArr =  array();
                        $questionArr['question_id'] =$questionId;
                        $questionArr['question'] =$question->question;
                        $questionArr['group_id'] =$question->group_id;
                        $questionArr['group_name'] =$question->group_name;
                        if(is_array($value) && count($value)>0){   // for multi checkbox                        
                            $result_sel = '';
                            foreach($value as $optionsel){
                                if($optionsel >0)
                                $result_sel .= $optionsel.",";
                            }
                            if(strlen($result_sel)>1){
                                $in_arr = substr($result_sel,0,-1);
                                $sql = "SELECT GROUP_CONCAT( `option_name` ) as options FROM `options` WHERE `option_id` IN (".$in_arr.") GROUP BY `question_id`";
                                $optionres_arr = DB::select($sql); 
                                if(count($optionres_arr)>0){
        //                        $optionres  = DB::table('options')->whereIn('option_id',$in_arr)->select('group_concat(options.option_name) as option')->first();
                                    $optionval = $optionres_arr[0]->options;
        //                            foreach($optionres_arr as $optionconcat)
        //                                $optionval = $optionconcat->options;
        //                            }
                                    $value = $in_arr;
                                }
                            }else{
                                $value = '';
                            }
                        }else{
                            $optionval = $value;
                            if(is_numeric($value)){
                                $optionres  = DB::table('options')->where('options.option_id', '=', $value)->where('options.question_id', '=', $questionId)->first();
                                if(count($optionres)>0){
                                    $optionval = $optionres->option_name;
                                }else{
                                    if($question->question_type='check')
                                    $optionval = "";    
                                }
                            }
                        }
                        $questionArr['ans'] =$optionval;
                        $questionArr['ansid'] =$value;
                        $customer_ans[$question->group_name][] = $questionArr;
//                    }
                }
                $depanquestion = DB::table('depend_question')->where('depend_question_id', '=', $questionId)->first();
                if(count($depanquestion)>0){
//                                        print_r($depanquestion);
                    $qnid = $questionId;   
                    $optionselval = $value;
//                                        echo $qnid."QQ<br>".$optionselval."<br>";
                    if($optionselval>0){
                    $optionidar[$questionId][] = $optionselval;                   
                    }
                }

            }
        }
        
        $resultArr = array();
        if(isset($customer_data) && $customer_data !=''){
            $resultArr['customer_data'] = $customer_data;
        }
        if(isset($customer_ans) && $customer_ans !=''){
            $resultArr['customer_ans'] = $customer_ans;
        }
        
        if(isset($sel_symptom_arr) && $sel_symptom_arr !=''){
            $resultArr['sel_symptom_arr'] = $sel_symptom_arr;
        }
        if(isset($optionidar) && $optionidar !=''){
            $resultArr['optionidar'] = $optionidar;
        }

        return $resultArr ;
        
  }
  
  
     public function anyRemoveuploadfile(){
       
        //Its Ajax section 
        // Remove just uploaded file 
        $post_arr           = Input::all();       

        unlink("uploads/files/".$post_arr['filename']);
        $upload_files = explode(',',$post_arr['customer_medicalreport']);
        if(count($upload_files)>0){
            $x =1;
            $result = '';
            $remove_elment = $post_arr['eltno'];
            foreach($upload_files as $files){
                if($files==$post_arr['filename']){                    
                }else{
                    if($files != 'false')
                    $result .= $files.",";
                }
                $x++;
            }  
            $result_str = substr($result,0,-1);
        }
        return json_encode(array('error' => 0,'result' =>$result_str)); exit;
      
      
    }

      public function get_questions_from_questiongroup_by_displayorder($currentDisplayOrder,$post_arr){
        $question_data  = array();
        $questiongroup = DB::table('questiongroup')->where('display_order', '=', $currentDisplayOrder)->first();
        if(count($questiongroup)>0){
            $ord = $questiongroup->display_order;             
            $gpid = $questiongroup->group_id;
        
            if($gpid > 0){
                $questions = DB::table('questions')->groupBy('questions.question_id')->where('questions.question_group_id', '=', $gpid)->get();
    //                    print_r($questions); 
    //                    echo count($questions)."WW<br>";
                if(count($questions)>0){
                    foreach($questions as $question){
                        $data_option_arr = array();
                        $optiondetail = DB::table('options')->where('options.question_id', '=', $question->question_id)->get();
                        if(count(($optiondetail))>0){                                
                            foreach ($optiondetail as $optiondata) {
                                $data_options = array();
                                $data_options['option_id'] = $optiondata->option_id; 
                                $data_options['option_name'] = $optiondata->option_name; 
                                $data_option_arr[] = $data_options;
                            }
                        }
                        $depend_ans = $depend_qn = '';
                        if($question->dependable_question ==1){
                             $dependdetail = DB::table('depend_question')->where('depend_question.current_question_id', '=', $question->question_id)->first();
                             if(count($dependdetail)>0){
                                 $depend_ans = $dependdetail->depend_question_ans;
                                 $depend_qn = $dependdetail->depend_question_id;
                             }
                        }
                        if($question->validator_title != '')
                            $validator_val = $question->validator_title;
                        else
                            $question->validator_title = 'valid data';
                        $question_data[] = array(
                        'question_id' => $question->question_id,
                        'question' => $question->question,
                        'question_group_id' => $question->question_group_id,
                        'question_type' => $question->question_type,
                        'validator_title' => $question->validator_title,
                        'option_arr' => $data_option_arr,
                        'field_required' => $question->field_required,
        //                'field_defaultval' => $question->field_defaultval,
                        'order' => $question->display_order,
                        'depend' => $question->dependable_question,
                        'depend_qn' => $depend_qn,
                        'depend_ans' => $depend_ans
                        );
                    }
                    $cnt_qns = 0;
                    $depend_cnt =0;
                    foreach($question_data as $questiondetails){
                        $hide = 0;
                        if($questiondetails['depend'] ==1){  
                            if($depend_cnt==0){
                                $rightOverlayData = $this->get_rightoverlay_content($post_arr);
                                if(isset($rightOverlayData['optionidar']) && $rightOverlayData['optionidar'] !='')
                                    $depend = $rightOverlayData['optionidar'];
                            }
                            $depend_cnt++;
                            $hide = 1;
                            if(isset($depend[$questiondetails['depend_qn']])){
                                $ans_depend = explode(",",$questiondetails['depend_ans']);
                                if(count($depend[$questiondetails['depend_qn']])>0){
                                    foreach($depend[$questiondetails['depend_qn']] as $selans){
//                                        if(in_array($selans,$ans_depend)){
//                                            $hide = 0;
//                                        }
                                        if(!is_array($selans)){
                                            // for multi checkbox
                                            if (strpos($selans, ',') !== false) {
                                                $sel_dependans_arr = explode(",",$selans);
                                                if(in_array($ans_depend[0],$sel_dependans_arr)){
                                                    $hide = 0;
                                                }
                                            }else{
                                                if($ans_depend[0] ==$selans){
                                                    $hide = 0;
                                                }
                                            }
                                        }else{
                                            // for multi checkbox
                                            if(in_array($selans,$ans_depend)){
                                                $hide = 0;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        if($hide ==0){
                            $cnt_qns++;
                        }
                    }
                    if($cnt_qns ==0){
                        $question_data  = array();
                    }
                }
            }
        }
        return $question_data;
    }
    
    

  
  
  
    public function anyVerifymail($customerId,$nikName){
        if(isset($customerId) && $customerId > 0){
            
            $val = 'doctor'.$customerId;
            $key = urlencode(base64_encode($val));
            $link = asset('customer/verifyemail?key='.$key);
                 
            $customers = DB::table('customers')->leftjoin('customer_detail', 'customers.customer_id', '=', 'customer_detail.customer_id')->where('customers.customer_id', '=', $customerId)->select('customers.customer_email_id')->first();            
            if(count($customers)>0){  
                $email = $customers->customer_email_id;
            }
            $return = 1;

            $subject = "Account activation - Doctorbuddy.com";
            $body = '<h3>Hi '.$nikName. ',</h3>
                <p>Thank you for signing up with Doctorbuddy</p>
                <p>To be able to sign in to your account, please verify your email address by clicking the following link:
            <a href="'.$link.'">Click Here</a> or visit the following address <a href="'.$link.'">'.$link.'</a><br/></p>
            <p>Reagrds,<br/>Doctorbuddy.com</p>';
            $result = (new BaseController)->mail($email,$subject,$body);
            if($result==true){
                return true;
                exit;
            }else{
               return false; 
            }  
        }
    
    }
    
    
    public function anyForwadehealthcare($customerId,$detailId,$email){
        if(isset($detailId) && $detailId > 0){  
            $email_ids = explode(",",$email);
            foreach($email_ids as $email_id){
                if($email_id != ''){
                    $healthcare_professional_id = '';
                    $healthcares = DB::table('healthcare_professional')->where('healthcare_professional_email_address', '=', $email_id)->select('healthcare_professional_id')->first(); 
                    if(count($healthcares)>0)
                        $healthcare_professional_id = $healthcares->healthcare_professional_id;
                    $insert_data = array();
                    $insert_data['customer_id'] = $customerId;
                    $insert_data['customer_detail_id'] = $detailId;
                    $insert_data['healthcare_professional_id'] = $healthcare_professional_id;
                    $insert_data['healthcare_professional_email'] = $email_id;
                    $insert_data['date'] = date('Y-m-d H:i:s');       
                    $case_file_id = DB::table('casefile_to_healthcare')->insertGetId($insert_data);
                    
                    $val = 'casefile_id='.$case_file_id;
//                    $key = urlencode((new BaseController)->encrypt_decrypt($val));
                    $key = urlencode(base64_encode($val));
                    $link = asset('healthcare_professional/casefileview?key='.$key);
                    
                                        
                    // Send Mail               
                    $templateLocation = "home.mail_template_forward_casefile";

                    $thingsToPassTemplate["site_link"] = URL::to('/'); 
                    $thingsToPassTemplate["site_start_link"] = URL::to('/')."/home/basic";      
                    $thingsToPassTemplate["link"] = $link;                    

                    $subject = "A case file is forwarded to you"; 

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
    
    
    public function anyCasefilemail($customerId,$nikName){
        if(isset($customerId) && $customerId > 0){  
            //$val = 'customer_'.$customerId;
            //$key = urlencode((new BaseController)->encrypt_decrypt($val));
            $link = asset('home');
                 
            $customers = DB::table('customers')->where('customers.customer_id', '=', $customerId)->select('customers.customer_email_id')->first();            
            if(count($customers)>0){  
                $email = $customers->customer_email_id;
            }
            $return = 1;

            
            // Send Mail               
            $templateLocation = "home.mail_template_casefile_creation";

            $thingsToPassTemplate["site_link"] = URL::to('/'); 
            $thingsToPassTemplate["site_start_link"] = URL::to('/')."/home/basic";      
            $thingsToPassTemplate["receipent_name"] = $nikName;        

            $subject = "Case file creation- Confirmation"; 

            $receipents = $email;

            // Send mail
            $result= (new BaseController)->send_mail(
                    $templateLocation,
                    $thingsToPassTemplate,
                    $subject,
                    $receipents
            );            
            
            
            if($result==true){
                return true;
                exit;
            }else{
               return false; 
            }  
        }
    
    }
    
    public function anyRegistrationemail($customerId,$nikName,$userPassword){
        
        
            // mail sending for registration
            // Send Mail    
    
            
            $customer = DB::table('customers')->where('customers.customer_id', '=', $customerId)->first();
            if(count($customer)>0){  
                
                $userName = $customer->customer_email_id;
                $email = $customer->customer_email_id;
                
                $templateLocation = "customer.mail_template_registration";

                $thingsToPassTemplate["site_link"] = URL::to('/'); 
                $thingsToPassTemplate["site_start_link"] = URL::to('/')."/home/basic";      
                $thingsToPassTemplate["receipent_name"] = $nikName;   
                $thingsToPassTemplate["user_name"] = $userName;
                $thingsToPassTemplate["user_password"] = $userPassword;
                $thingsToPassTemplate["login_link"] = URL::to('/')."/customer/login";  

                $subject = "Customer Registration - Success"; 

                $receipents = $email;

                // Send mail
                $result= (new BaseController)->send_mail(
                        $templateLocation,
                        $thingsToPassTemplate,
                        $subject,
                        $receipents
                );                 
            }
            

  
                        
    }
    
    public function anyContents($contentKey){
        if(!$contentKey)
            return Redirect::to('home'); 

        $contentObj = DB::table('contents')->where('contents_key','=',$contentKey)->first();
        if(!$contentObj)
            return Redirect::to('home'); 
        
        return View::make('home.contents')->with(array('contentObj'=>$contentObj));
    }
    

        // for right overlay content
    public function anyRightoverlay($back=null){        
        // Get Post values
        $post_arr           = Input::all();  
         // Get right overlay content
        if($post_arr != ''){
            // Initialise
            $sel_symptom_arr = $customer_data = array();
            $customer_ans = array();
            $optionidar = array();
            $rightOverlayData = $this->get_rightoverlay_content($post_arr,$back);

            if(isset($rightOverlayData['customer_data']) && $rightOverlayData['customer_data'] !='')
                $customer_data = $rightOverlayData['customer_data'];
            if(isset($rightOverlayData['customer_ans']) && $rightOverlayData['customer_ans'] !='')
                $customer_ans = $rightOverlayData['customer_ans'];

            if(isset($rightOverlayData['sel_symptom_arr']) && $rightOverlayData['sel_symptom_arr'] !='')
                $sel_symptom_arr = $rightOverlayData['sel_symptom_arr'];

            if(isset($rightOverlayData['optionidar']) && $rightOverlayData['optionidar'] !='')
                $optionidar = $rightOverlayData['optionidar'];

           // echo '<pre>';print_r($customer_data);
            return View::make('question.rightoverlay')->with(array('sel_symptom'=>$sel_symptom_arr,'customer_data'=>$customer_data,'customer_ans'=>$customer_ans));     
        }
    }
    
    
    public function anyAgegroup(){
        $post_arr           = Input::all();  
        $string = $post_arr['string'];
        return View::make('question.agegroup')->with(array('string'=>$string));
    }
    
    public function anyPdfcasefile(){    

        $post_arr           = Input::all();  
        $customerDetailId = $post_arr['customer_detail_id'];
        $report = (new BaseController)->get_casefile_report($customerDetailId);
        $html =  View::make('question.pdf')->with(array('report' => $report))->render();

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($html);
        $filename = $report['customer_fileno'].'.pdf';
        $pdf->save(base_path().'/pdfreports/'.$filename);
        
        return json_encode(array('error' =>0, 'pdf_name' => $filename)); exit;  
    }
    
    
    public function anyContactus(){   
        
        $data = array();
        $post_arr = Input::all();
        if(isset($post_arr['form-submit']) && $post_arr['form-submit'] =='submit'){
            
            $validator = Validator::make(
                 array(
                    'name'  => $post_arr['name'],
                    'email'  => $post_arr['email'],
                    'subject'  => $post_arr['subject'],
                    'message'  => nl2br($post_arr['message']), 
                 ),
                 array(
                    'name' => 'required',
                    'email' => 'required|email',
                    'subject' => 'required',
                    'message' => 'required', 
                 )
             );
            if ($validator->fails())
            {
                $messages   = $validator->messages();   
                $err_msg  = '';
                foreach ($messages->all() as $msg) {
                        $err_msg .= '<br /><i>'.$msg.'</i>';
                }
                return json_encode(array('error' => 1, 'err_msg' => $err_msg)); exit;

            } 
            
            $templateLocation = "home.mail_template_contactus";

            $thingsToPassTemplate["site_link"] = URL::to('/'); 
            $thingsToPassTemplate["site_start_link"] = URL::to('/')."/home/basic";      
            $thingsToPassTemplate["message_content"] = nl2br($post_arr['message']);
            $thingsToPassTemplate["from_name"] = ucfirst($post_arr['name']);
            $thingsToPassTemplate["from_email"] = $post_arr['email'];
            
            $subject = $post_arr['subject']; 
            $receipents = \Config::get('constants.SITE_CONTACT');



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
            return json_encode(array('error' => 1,'err_msg' => "Mail sending failed")); exit;               
          }  
 
        }
        $data['site_url'] = URL::to('/');
        return View::make('home.contact-us')->with(array('data'=>$data));
        
    }
    //  General Logoout
    public function anyLogout()
    {
        session_destroy();
        session::flush();      
        $msg='';
        return Redirect::to('home');     
    } 
    
    public function anyKeywords(){
        
        // Ajax call
        // Get keywords for  jquery tag-it in questionair filling section
        $post_arr = Input::all();
        $keywordArr = array();
        if(isset($post_arr['q']) && $post_arr['q'] !=''){
            
             $keywordObjs =  DB::table('keywords')->Where('keyword_name', 'like', '%' . $post_arr['q'] . '%')
                            ->Where('keyword_status','=',1)
                            ->get(); 
             foreach($keywordObjs as $keywordObj){
                 $keywordArr[] = $keywordObj->keyword_name;
             }
            
        }
        
        return json_encode($keywordArr); exit;
      
    }
  
}