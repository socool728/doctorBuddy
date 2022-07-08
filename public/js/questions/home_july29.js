function home_sumit()
{   
    if (!validator.checkAll($('form'))) {   
        $("#message-texterr").html('<div class="error-alert-messages"><i class="fa-fw fa fa-times"></i><strong>Error! Please enter missing data as mentioned above</strong></div>');             
        $("#messageerr").removeClass('hide success-alert');
        $("#messageerr").addClass('error-alert');  
        return false;
    }else{
        $('button').prop('disabled', true);
        $.ajax({
        type: "POST",    
        data: $("#home_form").serialize(),
        dataType: "json",
        url :SITE_URL+"/home/basic",
        success : function(response) { 
            if(response.error == 1){
                $("#message-text").html('<div class="error-alert-messages"><i class="fa-fw fa fa-times"></i><strong>Error!</strong><br>'+ response.err_msg+'</div>');               
                $("#message").removeClass('hide success-alert');
                $("#message").addClass('alert alert-danger');  
        
                $('button').prop('disabled', false);
                $("#message").attr('tabindex',-1);
                $("#message").focus();                 
            }else{
                window.location = SITE_URL+"/home/launch";
            }
            
        },
        error : function(){
            $('button').prop('disabled', false);
            
            $("#message-text").html('<i class="fa-fw fa fa-times"></i><strong>Error!</strong> Something went wrong, please try again.');
            $("#message-text").show();
        },
        });  
     
    }
}


// Modify the age group
$(document).ready(function(){
    
$('input:radio[name="customer_for_whom"]').change(
      
    function(){        
        $.ajax({
        type: "POST",    
        data: "string="+this.value,
        url :SITE_URL+"/home/agegroup",
        success : function(option) { 
            $("#customer_age").removeClass('required');
            $("#customer_age").html("");
            $("#customer_age").append(option);
            $("#customer_age").addClass('required');
            
        },
        error : function(){
            alert("some error happend.Please try after some time")
        },
        });  
        

    });    
});


$( function()
{
    var targets = $( '[rel~=tooltip]' ),
        target  = false,
        tooltip = false,
        title   = false;
 
    targets.bind( 'mouseenter', function()
    {
        target  = $( this );
        tip     = target.attr( 'title' );
        tooltip = $( '<div id="tooltip"></div>' );
 
        if( !tip || tip == '' )
            return false;
 
        target.removeAttr( 'title' );
        tooltip.css( 'opacity', 0 )
               .html( tip )
               .appendTo( 'body' );
 
        var init_tooltip = function()
        {
            if( $( window ).width() < tooltip.outerWidth() * 1.5 )
                tooltip.css( 'max-width', $( window ).width() / 2 );
            else
                tooltip.css( 'max-width', 340 );
 
            var pos_left = target.offset().left + ( target.outerWidth() / 2 ) - ( tooltip.outerWidth() / 2 ),
                pos_top  = target.offset().top - tooltip.outerHeight() - 20;
 
            if( pos_left < 0 )
            {
                pos_left = target.offset().left + target.outerWidth() / 2 - 20;
                tooltip.addClass( 'left' );
            }
            else
                tooltip.removeClass( 'left' );
 
            if( pos_left + tooltip.outerWidth() > $( window ).width() )
            {
                pos_left = target.offset().left - tooltip.outerWidth() + target.outerWidth() / 2 + 20;
                tooltip.addClass( 'right' );
            }
            else
                tooltip.removeClass( 'right' );
 
            if( pos_top < 0 )
            {
                var pos_top  = target.offset().top + target.outerHeight();
                tooltip.addClass( 'top' );
            }
            else
                tooltip.removeClass( 'top' );
 
            tooltip.css( { left: pos_left, top: pos_top } )
                   .animate( { top: '+=10', opacity: 1 }, 50 );
        };
 
        init_tooltip();
        $( window ).resize( init_tooltip );
 
        var remove_tooltip = function()
        {
            tooltip.animate( { top: '-=10', opacity: 0 }, 50, function()
            {
                $( this ).remove();
            });
 
            target.attr( 'title', tip );
        };
 
        target.bind( 'mouseleave', remove_tooltip );
        tooltip.bind( 'click', remove_tooltip );
    });
});