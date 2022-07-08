@extends('layouts.questionairelayout')

@section('content')



    <h2>Welcome to <strong>DoctorBuddy!</strong></h2>

    

    <div class="col-lg-12 col-xs-12 col-sm-12" id="flow_notification_heading">

        <div class="col-lg-4 col-sm-4 col-xs-12 tab-1 m-b"><span class="title grey">Basic info</span><div class="vertical-timeline-icon graybg"> 1 </div></div>

        <div class="col-lg-4 col-sm-4 col-xs-12 tab-2 m-b"><span class="title ">symptoms</span><div class="vertical-timeline-icon cir-bg"> 2 </div></div>

        <div class="col-lg-4 col-sm-4 col-xs-12 tab-3 m-b"><span class="title grey">questions</span><div class="vertical-timeline-icon graybg"> 3 </div></div> 



    </div>

                    
    
    <div class="col-lg-12 m-t-xl symptoms-wrap left">
        
    <div id="custom_message_wrapper" class="col-lg-12 no-pad">    

        <div id="messageerr"  class="hide">

            <div id="message-texterr"></div>

        </div>

    </div>
        
        <form  action="" id="qform" name="qform" class="" method="post">

            <div id="qnblk" class="hide_show">

                <div id="old_question"></div>

                <div id="question" class="question">

                    <h4> Let me help you further! </h4>

                    <p>

                    Please tell me more about your illness or concerns? Give us a general idea of what is bothering you.



                    How long has it been affecting you? How has it progressed ? How does it make you feel ? etc

                    </p>

                    <div class="form-group">

                        <div class="col-lg-12 no-pad">

                            <div class="col-lg-11 no-pad" ><textarea class="form-control" rows="2" placeholder="" id="known_disease" name="known_disease"></textarea>

                            

                            <a class="info-icon-n" href="javascript:void(0);"  data-container="body" data-container="body"  data-placement="top" data-toggle="popover"   data-content="Here you can describe the illness or problem, how it started, progresses, it’s present state, and/or what you are looking for. Please add all the details that can help the doctor find the best treatment he can offer.">

                                    <i class="clr-blu fa fa-info-circle" aria-hidden="true" ></i>

                                </a>

                            </div>

                            

                        </div>

                    </div>

                    <div class="col-lg-12 no-pad m-t">
                        <h4>Describe your symptoms</h4>

                        <ul class="d-sympton m-b-lg left">

                                <li>Start typing some keywords like (mind, pain, sleep, anxiety, skin etc.) and choose.</li>

                            <li>Enter the severity by selecting the dots</li>

                            <li>Use text box for additional details. </li>

                        </ul>
                    </div>

                    <div class="col-lg-6 no-pad m-t col-sm-12 col-xs-12">

                        <div class="form-group">

                            <label class="col-lg-12 no-pad ti">Add symptoms</label>

                            <div class="col-lg-11 no-pad">

                                <div class="col-lg-10 no-pad" >

                                    <input id="symptom" name="symptom" value="" class="form-control" type="text" autocomplete="off" >

                                    <a  class="info-icon-n" href="javascript:void(0);"  data-container="body" data-container="body"  data-placement="top" data-toggle="popover"   data-content="Type four letters of your keyword and give a few seconds for the database to load. Then select the most appropriate symptom and select the severity. Please give additional details like frequency, time, duration, associated conditions etc. in the text box. You can see your casefile generating on the right side. Give minute details of your symptoms including behaviour patterns. Add as many symptoms as you want. Even though this symptom checker is one of the largest symptom checkers and is ever-growing your symptom may not be there yet. If so, select “New symptom” and add the required details.  If you type All and wait for a few seconds, all the symptoms will load. ">

                                        <i class="clr-blu fa fa-info-circle" aria-hidden="true" ></i>

                                    </a>

                                    <ul id="parsley-id-3638" class="parsley-errors-list"></ul>                                    

                                </div>

                                <div class="col-lg-2" >

                                    

                                </div>



                            </div>

                        </div>

                        <div class="symptombox" id="symptomboxdiv" style="display:none;">

                            <div id="symptomdiv" ></div>      

                        </div>

                        

                      

                    </div>

                    

                    <div class="col-lg-6 no-pad" id="symptom-outer-area" style="display: none;">

                        <label class="col-lg-12 col-sm-12 col-xs-12 ti no-pad">Your added symptoms</label>

                        <div class="col-lg-12 col-sm-12 col-xs-12 grey-bg added-symptons">

                            <div id="symptom-inner-area"></div>



                        </div>

                        <p role="alert" class="alert alert-info col-lg-12 col-sm-12 col-xs-12 no-pad m-t"  style="border-radius: 15px; padding: 16px;">

                            <strong>Note:</strong> Select next symptom.<br> 

                            Please try to remember and provide all the symptoms here

                        </p>

                    </div>

                    

                    <div class="col-lg-12 col-sm-12 col-xs-12 no-pad m-t-lg">

                        <div class="form-group col-lg-12 no-pad"> 

                          <label class="col-lg-3 col-sm-3 col-xs-3 no-pad up_lab ti" for="exampleInputFile">Upload files</label> 

                          <div class="col-lg-5 col-sm-5 col-xs-5">                              

                               

                                <div id="files_upload_area" class="files">

                                    <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">

                                        <span class="btn  fileinput-button no-pad">

                                        <span  class="btn btn-red fileinput-button">

                                            <label id="uploadbtn">

                                                <i class="glyphicon glyphicon-plus"></i>BROWSE

                                            </label>

                                            <label id="uploadnxtbtn" style="display:none;">Upload Next</label>

                                            <input id="fileupload_document" type="file" name="files"  />

                                        </span>  

                                        </span>

                                    </div>

                                </div>



                                <div id="upfiles_document" class="files"></div>

                                <div id="waiting_div" class="hide"><img src="<?php echo asset('images/loading.gif') ?>"  width="40" height="40"></div>

                                <input type="hidden" name="customer_medicalreport" id="customer_medicalreport" value="">

                               

                              

                          </div>

                          <div class="col-lg-1 col-sm-1 col-xs-1 text-left no-pad m-t">

                                <a class="" href="javascript:void(0);"  data-container="body" data-container="body"  data-placement="top" data-toggle="popover"   data-content="You can upload any file format. Large files can be uploaded by using Dropbox. Upload images of affected area, color and nature of excretions, case files, lab reports, existing prescriptions, videos of movements, speech etc. that may be relevant to the case. Please fold or cover your personal details if you want to anonymous.">

                                    <i class="clr-blu fa fa-info-circle" aria-hidden="true" ></i>

                                </a>                              

                          </div>

                          <div class="col-lg-3 col-sm-3 col-xs-3 text-left no-pad">

                              <p style="font-size:12px;" class="alert alert-info col-lg-12 col-sm-12 col-xs-12 " role="alert">

                            <strong>Max File Size:</strong> 2MB.<br> 



                        </p>

                          </div>

                          

                        </div>
                        <p class="help-block col-lg-12 col-sm-12 col-xs-12 no-pad"><small>Upload images, videos, medical reports, prescriptions etc. Please cover your personal details if you want to incognito. </small></p> 
                        <div class="form-group m-t col-lg-12 drop no-pad">
                            <label class="col-lg-2 no-pad ti">Drop Box</label>
                            <a href="javascript:void(0);" id="btnAdd"><i aria-hidden="true" class="fa fa-plus-circle fa-3"></i></a>
                            <div id="TextBoxContainer">

                            </div>

                        </div> 
                        <p class="help-block col-lg-12 col-sm-12 col-xs-12 no-pad"><small>Paste your Drop box links here. </small></p> 

                    </div>

                    

                    <div class="col-lg-12 col-sm-12 col-xs-12 no-pad m-t-lg">

                        <div class="form-group">

                            <label class="col-lg-6 no-pad ti">Present medication</label>

                            <div class="col-lg-8 no-pad">

                                <div class="col-lg-11 no-pad ">

                                    <input type="text" id="customer_present_medication" name="customer_present_medication"   title="Present Medication" class="form-control">

                                    <a class="info-icon-n" href="javascript:void(0);"  data-container="body" data-container="body"  data-placement="top" data-toggle="popover"   data-content="Please give details of present medication, past medication, history of working with hazardous or extreme situations. Medications or drug habits or problems from your past that may be affecting your health now.">

                                        <i class="clr-blu fa fa-info-circle" aria-hidden="true" ></i>

                                    </a> 

                                </div>

                                                            

                            </div>

                        </div>

                      <div class="form-group">

                        <label class="col-lg-6 no-pad ti">History of past illness</label>

                        <div class="col-lg-8 no-pad">

                            <div class="col-lg-11 no-pad">

                                <input type="text" id="customer_past_illness_history" name="customer_past_illness_history"   title="Past illness History" class="form-control"> 

                                <a class="info-icon-n" href="javascript:void(0);"  data-container="body" data-container="body"  data-placement="top" data-toggle="popover"   data-content="Childhood accidents, smoking, drinking or drug usage, history of surgery, sleeping and behavioural disorders. Please mention the duration and how long ago it occurred.">

                                    <i class="clr-blu fa fa-info-circle" aria-hidden="true" ></i>

                                </a>                                    

                            </div>

                                                     

                        </div>

                      </div>

                      <div class="form-group">

                        <label class="col-lg-6 no-pad ti">History of allergic reactions</label>

                        <div class="col-lg-8 no-pad">

                            <div class="col-lg-11 no-pad">

                                <input type="text" id="customer_allergic_reaction" name="customer_allergic_reaction"   title="Allergic reactions" class="form-control">

                                <a class="info-icon-n" href="javascript:void(0);"  data-container="body" data-container="body"  data-placement="top" data-toggle="popover"   data-toggle="popover" data-placement="top" data-content="Lactose intolerance, allergy to nuts, other foods, medications, insect bites, scent-sensitivity, motion sickness etc. are all relevant information you case file should have.">

                                    <i class="clr-blu fa fa-info-circle" aria-hidden="true" ></i>

                                </a>                                          

                            </div>

                       </div>

                      </div>

                      <div class="form-group">

                        <label class="col-lg-6 no-pad ti">Hereditary diseases ?</label>

                        <div class="col-lg-8 no-pad">

                            <div class="col-lg-11 no-pad">

                                <input type="text" id="customer_hereditary_disease" name="customer_hereditary_disease" title="Hereditary diseases" class="form-control"> 

                                <a class="info-icon-n" href="javascript:void(0);"  data-container="body" data-container="body"  data-placement="top" data-toggle="popover"   data-content="Diabetics, high blood pressure, history of cancer, mental diseases, skin diseases, behaviour pattern and similar diseases for any of the siblings, biological parents, grandparents, or relatives with a blood relation to the client should be added to the file.">

                                    <i class="clr-blu fa fa-info-circle" aria-hidden="true" ></i>

                                </a>                                    

                            </div>

                                                                               

                        </div>

                      </div>

                    </div>

                    

                    

                    <p class="col-lg-12 col-sm-12 col-xs-12 no-pad m-t-lg">The next step is assessment of psychosocial factors that affect your happiness and wellbeing. <br/>
                        Your joy will return for you once you receive fresh insight from our therapists! You may skip the session for now and return later</p>

                    <p class="sub-mit col-lg-12 col-sm-12 col-xs-12 no-pad m-t">

                        <span>I would like to give  <strong>more details. </strong></span> 

<!--                        <input type="image" src="<?php echo asset('images/go-btn.png') ?>" onclick="getqn('0','1')">-->

                        <input type="hidden" name="currord" id="currord" value="0" >

                        <input type="hidden" name="divid" id="divid" value="" >

                        <!-- Below hidden field added for neglect current page questions in right overlay.-->

                        <input type="hidden" name="gpid" id="gpid" value="0" >

                        

                       <a href="javascript:void(0);" onclick="getqn('0','1')"><img src="<?php echo asset('images/go-btn.png') ?>"></a>

                    </p>

                    <p class="sub-mit col-lg-12  col-sm-12 col-xs-12 no-pad m-t">

                        <span>I <strong>am done</strong>, please send it to doctors now!</span> 

                        <input type="hidden" name="send_file_doctor" value="">

                        <a href="javascript:void(0);" onclick="getqn('0','f')"><img src="<?php echo asset('images/go-btn.png') ?>"></a>

                    </p>



                    <p class="col-lg-12 col-sm-12 col-xs-12 no-pad info-i">

                        <i><img alt="info-icon" src="<?php echo asset('images/info-icon.png') ?>"></i><span>* Once you finish the questions, our specialists will be responding to your issues.

                    You can either access from mail or logging in to your doctorbuddy account.</span></p>                    

                </div>    

                

            </div>

            

            <div id="qndiv" class="hide_show clear_content"></div>

            <div id="qndiv_1" class="hide_show clear_content"></div>

            <div id="qndiv_2" class="hide_show clear_content"></div>

            <div id="qndiv_3" class="hide_show clear_content"></div>

            <div id="qndiv_4" class="hide_show clear_content"></div>

            <div id="qndiv_5" class="hide_show clear_content"></div>

            <div id="qndiv_6" class="hide_show clear_content"></div>

            <div id="qndiv_7" class="hide_show clear_content"></div>

            <div id="qndiv_8" class="hide_show clear_content"></div>

            <div id="qndiv_9" class="hide_show clear_content"></div>  

        </form>

    </div>



<script>

 var SITE_URL = "<?php echo $data['site_url'] ?>";

</script>



<!-- Ajax file uploader-->

<link rel="stylesheet" href="<?php echo asset('css/jquery.fileupload.css');?>" />

<script src="<?php echo asset('js/vendor/jquery.ui.widget.js');?>"></script>

<script src="<?php echo asset('js/jquery.iframe-transport.js');?>"></script>

<script src="<?php echo asset('js/jquery.fileupload.js');?>"></script>

<script src="<?php echo asset('js/questionjs.js'); ?>"></script>


@stop



