<?php

class HomeController extends BaseController {

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
        
        public function anyDashboard(){
            return View::make('question.dashboard');
	}
        
	public function anyQuestion(){
            $question_id = 1; $output = ''; $questions = array(); $options = array();
            
            //session update
            Session::put('questions',[0 => $question_id]); 
            
            //question & option
            $question = Question::where('question_id',$question_id)->first();
            $options = Option::where('question_id',$question_id)->get();
            
            //get options in output format
            $output = CommonFunctions::getOptionOutput($options);
            //add options to question
            $optionquestion = CommonFunctions::optionInQuestion($output,$question);

            return View::make('question.question')->with(array('question'=>$optionquestion,'question_id'=>$question_id));
	}
        
        public function anyNextQuestion(){
            //getting current question and answer
            $options = json_decode($_POST['option'],true);
            $oldtemp = Session::get('questions');
            $questionid = array_shift($oldtemp);
            Session::put('questions',$oldtemp);
            
            if(Session::has('answers')){
                $answerlist = Session::get('answers');
                $c = count($answerlist);
                $answerlist[$c]['question'] = $questionid;
                $answerlist[$c]['answer'] = $options;
            }
            else {
                $answerlist[0]['question'] = $questionid;
                $answerlist[0]['answer'] = $options;
            }
            Session::put('answers',$answerlist);
            
            //displaying old question
            $current_question = Question::where('question_id',$questionid)->pluck('question');
            foreach($options as $key => $value){
                $option_name = '';
                $optionType = Option::where('option_key',$key)->pluck('option_type');
                
                if($optionType == 'text'){
                    $option_name = $value[0];
                }
                else{
                    for($i=0; $i<count($value); $i++){
                        if($i==0)
                            $option_name .= Option::where('option_id',$value[$i])->pluck('option_name');
                        else
                            $option_name .= ', '.Option::where('option_id',$value[$i])->pluck('option_name');
                    }
                }
                
                $current_question = str_replace($key, '<span class="iopt">'.$option_name.'</span>', $current_question);
            }
            //getting next questions
            $newtemp = Session::get('questions');
            foreach($options as $key => $value){
                for($i=0; $i<count($value); $i++){
                    $next = 0;
                    $optionType = Option::where('option_key',$key)->pluck('option_type');
                    
                    if($optionType == 'text'){
                        $next = Option::where('question_id',$questionid)->where('option_key',$key)->pluck('next_question_id');
                    }
                    else{
                        $next = Option::where('question_id',$questionid)->where('option_id',$value[$i])->pluck('next_question_id');
                    }
                    
                    if($next > 0){                    
                        if(!in_array($next, $newtemp)){                        
                            array_unshift($newtemp, $next);
                        }
                    }
                }
            }
            Session::put('questions',$newtemp);
            
            //displaying next question            
            $tempquestion = Session::get('questions.'. 0);
            $question = Question::where('question_id',$tempquestion)->first();
            $options = Option::where('question_id',$tempquestion)->get();
            $nextID = Option::where('question_id',$tempquestion)->first();
            
            //get options in output format
            $output = CommonFunctions::getOptionOutput($options);
            
            //add options to question
            $optionquestion = CommonFunctions::optionInQuestion($output,$question);
            
            //create old question string
            if(Session::has('oldquestions')){
                $current_string = Session::pull('oldquestions')."<br/>".$current_question;
                Session::put('oldquestions',$current_string);
            }
            else{
                Session::put('oldquestions',$current_question);
            }
                        
            $temp = array("oldquestion" => $current_question, "optionquestion" => $optionquestion, "nextquestion" => $nextID['next_question_id']);
            echo json_encode($temp);
        }
        
        public function anyFinishQuestion(){
            $pdf_dir = Config::get('constants.PDF_DIR');
            if (!is_dir($pdf_dir)){
                mkdir($pdf_dir, 0777, true);
            }
            $outputName = str_random(10);
            $pdfPath = $pdf_dir.'/'.$outputName.'.pdf';
            PDF::loadView('template.pdf')->save($pdfPath);
            Session::forget('oldquestions');
            
            DB::table('mind_answers')->insert(array(
                array(
                    'session_id' => Session::getId(), 
                    'answers' => json_encode(Session::get('answers')),
                    'filepath' => $outputName.'.pdf',
                    'created_date' => date('Y-m-d H:i:s'),
                    'modified_date' => date('Y-m-d H:i:s')
                    )
            )); 
            
            return View::make('question.finish');
        }
        
        public function anyVideo(){
            return View::make('video.video');
        }
}
