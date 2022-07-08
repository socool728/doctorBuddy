@extends('layouts.questionairelayout')

@section('content')





    <h2>Welcome to <strong>DoctorBuddy!</strong></h2>

    <div class="col-lg-12 col-xs-12 col-sm-12">

        <div class="col-lg-4 col-sm-4 col-xs-12 tab-1 m-b"><span class="title">Basic info</span><div class="vertical-timeline-icon cir-bg"> 1 </div></div>

        <div class="col-lg-4 col-sm-4 col-xs-12 tab-2 m-b"><span class="title grey">symptoms</span><div class="vertical-timeline-icon graybg"> 2 </div></div>

        <div class="col-lg-4 col-sm-4 col-xs-12 tab-3 m-b"><span class="title grey">questions</span><div class="vertical-timeline-icon graybg"> 3 </div></div> 



    </div>

    <div class="col-lg-12 m-t-xl">

        <form  action="javascript:void(0);" id="home_form" name="home_form" method="post"  class="form-horizontal">

                              

            <div class="col-lg-12 col-sm-12 col-xs-12 no-pad">    

                <div id="message"  class="hide">

                    <div id="message-text"></div>

                </div>

            </div>

            

            <div class="form-group">

              <label class="col-lg-4 ti">Name </label>

              <div class="col-lg-8 no-pad">

                  <div class="col-lg-11  item">

                      <input type="text" title="the name of patient" required="required" name="customer_nickname" id="customer_nickname" class="form-control">

                      <a class="info-icon" href="javascript:void(0);"  data-container="body" data-container="body"  data-placement="top" data-toggle="popover"   data-content="Your privacy matters to us. You and your health is more important to us than your personal details. Once you finalize your doctor and treatment plan you have to disclose your name to them. For insurance verification, you may also have to disclose your name. Please use the same nickname, as you did originally, for the chat so that we can add the chat history to your file as well. Even if you are an existing customer with an email registered with us, you can still create another case file with a new nickname for your clients, dependents etc. under the same email">

                        <i class="clr-blu fa fa-info-circle" aria-hidden="true" ></i>

                    </a>

                  </div>

              </div>

            </div>

            <p>

                <small>This service is for the use of people 18 years or older. 

                    If you are here for a dependent/student/client, please enter their age and complete the file from their perspective.</small>

            </p>



            <div class="form-group m-t">

            <label class="col-lg-4 ti">I am here for </label>

            <div class="col-lg-8 here_lab">

                <div class="col-lg-11 no-pad">

                    <label class="radio-inline">

                    <input type="radio" name="customer_for_whom"  id="customer_for_whom_1" checked="true" value="Myself"> Myself 

                    </label>

                    <label class="radio-inline">

                    <input type="radio" name="customer_for_whom" id="customer_for_whom_2" value="My Dependent"> My Dependent

                    </label>

                    <label class="radio-inline">

                    <input type="radio" name="customer_for_whom" id="customer_for_whom_3" value="My Student"> My Student

                    </label>

                    <label class="radio-inline">

                    <input type="radio" name="customer_for_whom" id="customer_for_whom_4" value="My Client"> My Client

                    </label>  
					
                    <!--<a tabindex="0" class="btn btn-lg btn-danger" role="button"  data-placement="top" data-toggle="popover"  title="Dismissible popover" data-content="And here's some amazing content. It's very engaging. Right?">Dismissible popover</a>-->
                    
                    <a class="info-icon" href="javascript:void(0);" data-container="body"  data-placement="top" data-toggle="popover"   data-content="You can create case files for your family members or dependents. Healthcare professionals and school counselors can create case files for their clients or students. You can view, update and forward files to a new doctor any time in the future after logging in.">

                        <i class="clr-blu fa fa-info-circle" aria-hidden="true" ></i>

                    </a>                    

                </div>

            </div>

            </div>

            <div class="form-group m-t">



                <label class="col-lg-4 ti">Gender(Sex) </label>

                <div class="col-lg-8">

                    <label class="radio-inline">

                              <input type="radio" value="male" id="customer_sex_1" name="customer_sex" checked="true"> Male 

                    </label>

                    <label class="radio-inline">

                    <input type="radio" value="female" id="customer_sex_2" name="customer_sex">Female

                    </label>

                    <label class="radio-inline">

                    <input type="radio" value="transgender" id="customer_sex_3" name="customer_sex"> Transgender

                    </label>

                </div>

            </div>

            <div class="form-group m-t">

              <label class="col-lg-4 ti">Age Group</label>

              <div class="col-lg-8 item">

               <select title="Age" name="customer_age"  id="customer_age" class="required form-control">

                    <option value="">Select</option>  

                    <option value="18-29 years (young Adult)">18-29 years (young Adult)</option>

                    <option value="30-39 years (adult)">30-39 years (adult)</option>

                    <option value="40-49 years (adult)">40-49 years (adult)</option>

                    <option value="50-64 years (adult)">50-64 years (adult)</option>

                    <option value="65 years plus (senior)">65 years plus (senior)</option>

               </select>

              </div>

            </div>

            <div class="form-group m-t">

              <label class="col-lg-4 ti">Height</label>

              <div class="col-lg-4 item"><input type="text" placeholder="Height" id="customer_height" name="customer_height" class="form-control" title="Height" required="required"></div>

              <div class="col-lg-4"><label class="radio-inline">

            <input id="customer_height_unit_1" name="customer_height_unit" title="Height unit"  type="radio" value="cm" checked="checked">cms 

            </label>

            <label class="radio-inline">

            <input type="radio" value="option2" id="customer_height_unit_2" name="customer_height_unit" value="inch">inches

            </label>

            </div>

            </div>

            <div class="form-group m-t">

              <label class="col-lg-4 ti">Weight</label>

              <div class="col-lg-4 item"><input type="text" placeholder="Weight" id="customer_weight" name="customer_weight" class="form-control" title="Weight" required="required"></div>

              <div class="col-lg-4"><label class="radio-inline">

                      <input type="radio" value="Kg" id="customer_weight_unit_1" name="customer_weight_unit" checked="true">Kgs 

            </label>

            <label class="radio-inline">

            <input type="radio" value="Lb" id="customer_weight_unit_2" name="customer_weight_unit">Lbs

            </label>

            </div>

            </div>

            <p class="sub-mit">

                <span>

                Please go to <strong>symptoms</strong> and add details 

                </span>

                <a href="javascript:void(0);" onclick="return home_sumit();"><img src="<?php echo asset('images/go-btn.png') ?>"></a>

<!--                <input type="image" src="<?php echo asset('images/go-btn.png') ?>" onclick="return home_sumit();">-->

                <input type="hidden" name="form_submit" value="save">

            </p>

    </form>

    </div>





<script>

 var SITE_URL = "<?php echo $data['site_url'] ?>";

</script>

<script src="<?php echo asset('js/questions/home.js'); ?>"></script>



@stop