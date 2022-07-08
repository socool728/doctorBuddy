<?php namespace App\Http\Controllers;
use DB;
use DateTime;
use Mail;
use URL;
class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}
    public function Randompassword() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 3; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        $pass[] ='&';
        return implode($pass); //turn the array into a string
    }
    public function encrypt_decrypt($string) {

        $string_length = strlen($string);
        $encrypted_string = "";
        /**
         * For each character of the given string generate the code
         */
        for ($position = 0; $position < $string_length; $position++) {
            $key = (($string_length + $position) + 1);
            $key = (255 + $key) % 255;
            $get_char_to_be_encrypted = SUBSTR($string, $position, 1);
            $ascii_char = ORD($get_char_to_be_encrypted);
            $xored_char = $ascii_char ^ $key;  //xor operation
            $encrypted_char = CHR($xored_char);
            $encrypted_string .= $encrypted_char;
        }
        /**
         * Return the encrypted/decrypted string
         */
        return $encrypted_string;
    }
    
    public function mail($email,$subject,$body,$attachmentName ='',$attachmentPath =''){
        $configurations = DB::table('configuration')->whereIn('configuration_key', array('SMTP_ACCOUNT','SMTP_PWD','SENDER_NAME'))->get();
        $sender_name ='';
            foreach($configurations as $configuration){
                if($configuration->configuration_key=='SMTP_ACCOUNT')
                $smtp_mail = $configuration->configuration_value;
                elseif($configuration->configuration_key=='SMTP_PWD')
                $smtp_pwd = $this->encrypt_decrypt($configuration->configuration_value);
                elseif($configuration->configuration_key=='SENDER_NAME')
                $sender_name = $configuration->configuration_value;
            }
            include_once('class.phpmailer.php');
            $mail = new \PHPMailer();    
            $mail->IsSMTP();
            $mail->SMTPAuth = true;   
            $mail->SMTPSecure = "tls";
            $mail->Host = "smtp.gmail.com";      
            $mail->Port = "587"; 
            $mail->Username = $smtp_mail;
            $mail->Password = $smtp_pwd;
            $mail->From = $smtp_mail;
            $mail->FromName = $sender_name;

            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->AltBody = "This is text only alternative body."; //Text Body
            $mail->WordWrap = 500; // set word wrap
            
            if($attachmentName !='' && $attachmentPath !='' ){
                $mail->AddAttachment( $attachmentPath, $attachmentName );
            }
            
            $mail->AddAddress($email);
            //        $mail->AddReplyTo($emid, "");
            //$mail->IsHTML(true); // send as HTML
//            $mail->Send();
            if (!$mail->Send()) {
                return "Error sending: " . $mail->ErrorInfo;
            }
            else
            {
                 return true;
            }  
    }
    
    public function getLocationFromIp(){
      
      $locationDetails = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']));
      return $locationDetails;
  
  }
  
   public function get_casefile_report ($customerDetailId){
        
        // Getting a customer detail record and its related informations
        $data = array();
        if($customerDetailId >0){      //ie particular case report
             $customerinfo = DB::table('customer_detail')->leftjoin('customers', 'customer_detail.customer_id', '=', 'customers.customer_id')->leftjoin('country', 'customer_detail.country_id', '=', 'country.country_id')
                    ->select(
                    'customers.customer_email_id',
                    'customers.customer_fname', 
                    'customers.customer_lname',
                    'customer_detail.customer_nickname',
                    'customer_detail.customer_state',
                    'customer_detail.customer_zip',
                    'customer_detail.customer_city',
                    'customer_detail.customer_area',
                    'customer_detail.customer_code',
                    'customer_detail.customer_no',
                    'customer_detail.known_disease',
                    'customer_detail.customer_for_whom',
                    'customer_detail.customer_age',
                    'customer_detail.customer_sex',
                    'customer_detail.customer_past_illness_history',
                    'customer_detail.customer_medicalreport',
                    'customer_detail.customer_hereditary_disease',
                    'customer_detail.customer_present_medication',
                    'customer_detail.customer_allergic_reaction',
                    'customer_detail.customer_height',
                    'customer_detail.customer_height_unit',
                    'customer_detail.customer_weight',
                    'customer_detail.customer_weight_unit',
                    'customer_detail.created_at',
                    'customer_detail.updated_at',
                    'customer_detail.customer_detail_id',
                    'country.countryname')
            ->where('customer_detail.customer_detail_id', '=',$customerDetailId)->first();
            if(count($customerinfo)>0){
            $data['customer_detail_id'] = $customerDetailId;  
            $data['customer_email_id'] = $customerinfo->customer_email_id;
            $data['customer_name'] = $customerinfo->customer_fname." ".$customerinfo->customer_lname;
            $data['customer_nickname'] = $customerinfo->customer_nickname;
            $data['customer_state'] = $customerinfo->customer_state;
            $data['customer_zip'] = $customerinfo->customer_zip;
            $data['customer_city'] = $customerinfo->customer_city;
            $data['customer_area'] = $customerinfo->customer_area;
            $data['customer_country'] = $customerinfo->countryname;
            $data['customer_fileno'] = 'DB'.$customerinfo->customer_code."-".$customerinfo->customer_no;     
            $data['known_disease'] = $customerinfo->known_disease;
            $data['customer_for_whom'] = $customerinfo->customer_for_whom;
            $data['customer_age'] = $customerinfo->customer_age;
            $data['customer_sex'] = $customerinfo->customer_sex;

            $data['customer_past_illness_history'] = $customerinfo->customer_past_illness_history;
            $data['customer_medicalreport'] = $customerinfo->customer_medicalreport;
            $data['customer_hereditary_disease'] = $customerinfo->customer_hereditary_disease;
            $data['customer_present_medication'] = $customerinfo->customer_present_medication;
            $data['customer_allergic_reaction'] = $customerinfo->customer_allergic_reaction;
            $data['customer_height'] = $customerinfo->customer_height;
            $data['customer_height_unit'] = $customerinfo->customer_height_unit;                        
            $data['customer_weight'] = $customerinfo->customer_weight;
            $data['customer_weight_unit'] = $customerinfo->customer_weight_unit;

            $data['created_at']  = $customerinfo->created_at;
            $data['updated_at']  = $customerinfo->updated_at;
            
            /*$datetime = new DateTime();
            $datetime1 = $datetime->createFromFormat('Y-m-d H:i:s', $customerinfo->created_at);
            $data['created_at']  = $datetime1->format('m-d-Y h:i:s A');

            $datetime = new DateTime();
            $datetime2 = $datetime->createFromFormat('Y-m-d H:i:s', $customerinfo->updated_at);
            $data['updated_at']  = $datetime2->format('m-d-Y h:i:s A'); */                                 

            $detail_id = $customerinfo->customer_detail_id;
            }

            $ansdetail = DB::table('customer_answers')->where('detail_id', '=', $detail_id)->get();
            if (count($ansdetail) > 0) {
            foreach ($ansdetail as $ansdata) {
                $data['answers'][] = $ansdata;
            }
            }

            $symptomdetail = DB::table('customer_symptoms')->where('detail_id', '=', $detail_id)->get();
            if (count($symptomdetail) > 0) {
            foreach ($symptomdetail as $symptomdata) {
                $data['symptoms'][] = $symptomdata;
            }
            }


            $symptomHistorys = DB::table('customer_symptoms_his')->where('detail_id', '=', $detail_id)->orderBy('customer_his_id', 'DESC')->get();
            $history = array();
            if (count($symptomHistorys) > 0) {
            $i =0;
            foreach ($symptomHistorys as $symptomHistory) {
                $history[$symptomHistory->symptom_id][$i]['date_added'] = date("d/m/Y",strtotime($symptomHistory->created_date));
                $history[$symptomHistory->symptom_id][$i]['created_date'] = $symptomHistory->created_date;
                $history[$symptomHistory->symptom_id][$i]['symptom_id'] = $symptomHistory->symptom_id;
                $history[$symptomHistory->symptom_id][$i]['symptom_name'] = $symptomHistory->symptom_name;
                $history[$symptomHistory->symptom_id][$i]['symptom_rate'] = $symptomHistory->symptom_rate;
                $history[$symptomHistory->symptom_id][$i]['customer_note'] = $symptomHistory->customer_note;
                $i++;
            }
            }
            $data['symptoms_his'] = $history;
            
            
            $dropboxFiles = DB::table('customerdetail_to_dropbox')->where('customer_detail_id', '=', $detail_id)->orderBy('customerdetail_to_dropbox_id', 'ASC')->get();
            $dropboxFilesArr = array();
            if (count($dropboxFiles) > 0) {                 
                foreach($dropboxFiles as $dropboxFile){
                    $dropboxFilesArr[] = $dropboxFile->file_path;
                }
            }
            $data['dropbox_files'] = $dropboxFilesArr;
            
        }
        return $data;
    }
    
    
     public function send_mail ($templateLocation,$thingsToPassTemplate,$subject,$receipents,$attachments=array()){
         
         $mailInputs["subject"] = $subject;
         $mailInputs["to"]= $receipents;
         $mailInputs["from_address_hidden"]= \Config::get('constants.MAIL_FROM_ADDRESS_HIDDEN');
         $mailInputs["from_address_display"]= \Config::get('constants.MAIL_FROM_ADDRESS_DISPLAY');
         if(count($attachments)>0){
            $mailInputs['attachments'] = $attachments;
         }
   
         
      
         
         $result =Mail::send($templateLocation, $thingsToPassTemplate, function ($message)use($mailInputs) { 
             
                $message->from($mailInputs["from_address_hidden"], $mailInputs["from_address_display"]);
                $message->subject($mailInputs["subject"]);
                $message->to($mailInputs["to"]);
                
                //If any attachments
                if(isset($mailInputs['attachments'])){
                   if(count($mailInputs['attachments'])>0){
                        foreach($mailInputs['attachments'] as $attachments){
                            $message->attach($attachments);
                        }                   
                    } 
                }
                
                
          }); 
          
          return $result;
     }
     
    public function send_customer_registration_mail($customerId,$password){
         
        
        $customerObj = DB::table('customers')->where('customer_id','=',$customerId)->first(); 
        if(is_object($customerObj)){
            
            $customerName = $customerObj->customer_fname." ".$customerObj->customer_lname;
            $email = $customerObj->customer_email_id;
            
            $templateLocation = "customer.mail_template_registration";
            $thingsToPassTemplate["site_link"] = URL::to('/'); 
            $thingsToPassTemplate["site_start_link"] = URL::to('/')."/home/basic";      
            $thingsToPassTemplate["receipent_name"] = $customerName;   
            $thingsToPassTemplate["user_name"] = $email;
            $thingsToPassTemplate["user_password"] = $password;
            $thingsToPassTemplate["login_link"] = URL::to('/')."/customer/login";  

            $subject = "Customer Registration - Success"; 

            $receipents = $email;

            // Send mail
            $result= $this->send_mail(
                    $templateLocation,
                    $thingsToPassTemplate,
                    $subject,
                    $receipents
            ); 
            return $result;
        }else{
            return false;
        }
        
           
     }
     
    public function send_counselor_registration_mail($counselorId,$password){
        
        $counselorObj = DB::table('counselors')->where('counselors_id','=',$counselorId)->first();
        if(is_object($counselorObj)){
            
            $name = $counselorObj->counselors_firstname;
            if($counselorObj->counselors_middlename !=''){
               $name .= " ".$counselorObj->counselors_middlename;
            }
            $name .= " ".$counselorObj->counselors_lastname;           
            $email =$counselorObj->counselors_email_id;
            
            $templateLocation = "counselor.mail_template_registration";

            $thingsToPassTemplate["site_link"] = URL::to('/'); 
            $thingsToPassTemplate["site_start_link"] = URL::to('/')."/home/basic";      
            $thingsToPassTemplate["receipent_name"] = $name;   
            $thingsToPassTemplate["user_name"] = $email;
            $thingsToPassTemplate["user_password"] = $password;      

            $subject = "Counselor Registration - Success"; 

            $receipents = $email;

            // Send mail
            $result= $this->send_mail(
                    $templateLocation,
                    $thingsToPassTemplate,
                    $subject,
                    $receipents
            );
            return $result;
        }else{
            return false;
        }


                
    }
    public function send_hp_registration_mail($hpId,$password){
        
        $hpObj = DB::table('healthcare_professional')->where('healthcare_professional_id','=',$hpId)->first();
        if(is_object($hpObj)){
                       
            // Send Mail  
            $name = $hpObj->healthcare_professional_first_name;   
            if(isset($hpObj->healthcare_professional_middle_name)&& $hpObj->healthcare_professional_middle_name !='')
                $name .= " ".$hpObj->healthcare_professional_middle_name;
            $name .= " ".$hpObj->healthcare_professional_last_name;
            
            $email = $hpObj->healthcare_professional_email_address;

            $templateLocation = "healthcare_professional.mail_template_registration";

            $thingsToPassTemplate["site_link"] = URL::to('/'); 
            $thingsToPassTemplate["site_start_link"] = URL::to('/')."/home/basic";      
            $thingsToPassTemplate["receipent_name"] = $name;   
            $thingsToPassTemplate["user_name"] = $email;
            $thingsToPassTemplate["user_password"] = $password;      

            $subject = "Provider Registration - Success"; 

            $receipents = $email;

            // Send mail
            $result= (new BaseController)->send_mail(
                    $templateLocation,
                    $thingsToPassTemplate,
                    $subject,
                    $receipents
            );   
                        
            return $result;
        }else{
            return false;
        }


                
    }
}
