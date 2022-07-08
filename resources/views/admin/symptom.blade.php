@extends('layouts.adminlayout')
@section('content')

<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Admin Staff</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    
                    <h3 class="pagehd">Symptoms</h3>
                    <h2 class="pagehdbtn"><a href="../admin/add-symptom">Add Symptom</a> </h2>
                    <div class="clearfix">  </div>
                    
                </div>
                <div class="x_content">
                    <table id="example" class="table table-striped responsive-utilities jambo_table">
                        <thead>
                            <tr class="headings">
                                <th>SL No.</th>       
                                 <th>Symptom Id</th>
                                <th>Symptom Name</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php 
                            $i = 0;
                            foreach($symptoms as $symptom){ 
                            ?>

                                <tr class="even pointer">
                                    <td class=" ">{{++$i}}</td>
                                    <td class=" ">{{$symptom->symptom_id}}</td>
                                    <td class=" ">{{$symptom->symptom_name}}</td>
                                   
                                    <td><a href="../admin/edit-symptom/{{$symptom->symptom_id}}"><button type="button" class="btn btn-primary">Edit</button></a></td>
                                    <td>
                                        <?php if($symptom->parentcnt ==0 ){ ?>
                                    <a href="../admin/del-symptom/{{$symptom->symptom_id}}" onclick="return confirm('Are you sure to delete this Symptom?')"><button type="button" class="btn btn-delete">Delete</button></a>
                                        <?php }?>
                                    </td>
                                </tr>   
                            <?php } ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

        <br />
        <br />
        <br />

    </div>
</div>

@stop