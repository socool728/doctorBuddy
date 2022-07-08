<div class="question" id="question">
    
    <div class="item form-group m-b-40">
        <label class="control-label" for="first-name">If you know the disease please enter it with details here.</label>
        <div class="">
            <textarea  data-parsley-id="3637" id="known_disease" name="known_disease" value="" class="form-control"></textarea>
        </div>
    </div>                                 
    
    <div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6">
        <div class="item form-group">
            <label class="control-label" for="first-name">Symptom 
            </label>
            <div class="">

                <input data-parsley-id="3638" id="symptom" name="symptom" value="" class="form-control" type="text">


                <ul id="parsley-id-3638" class="parsley-errors-list"></ul>

            </div>
        </div>
        <div class="symptombox" id="symptomboxdiv" style="display:none;">
            <div id="symptomdiv" ></div>      
        </div>
    </div>
        
    <div class="col-xs-12 col-sm-6 col-md-6">
        
        <div>
    <div class="form-group dvsymp">        

        <div class="added-symptoms" id="seldisp" style="display: none;">
            <h4>Selected Symptom:</h4>
            <div id="selsympt" class="symptsel"></div>            
        </div>
    </div>
    
    <div class="form-group dvsymp"><input name="group_id" type="hidden" value="3" /></div> 

</div>
    
    </div>
    </div>
    
    <div class="nextbt">
<!--    <label class="btn btn-primary" onclick="showresult();">SEARCH</label>-->
        <a class="btn btn-primary" onclick="getqn('1')">NEXT</a>
<!--    <a href="home/finish" class="btn btn-primary btn-lg" role="button">FINISH</a>-->
    </div>
</div>



