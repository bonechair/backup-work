

/***
 *  Check if a mandatory field is filled or not
 ***/
function checkFieldInput(obj, skip){
    if (window.$ === window.jQuery){ //jQuery specific
        _JQcheckFieldInput(obj, skip);
    }else{
        if(!skip){
            var fail = false;
            var emailRegEx = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if(($(obj).id == 'inputMail' && !$(obj).value.match(emailRegEx)) || $(obj).value.blank()){
                $(obj).up().addClassName('fieldCross');
                $(obj).up().removeClassName('fieldTick');
                fail = true;
            }else{
                $(obj).up().addClassName('fieldTick');
                $(obj).up().removeClassName('fieldCross');
            }
        }
    
        if(!$('inputName').value.blank() && !$('inputMail').value.blank() && !$('inputMessage').value.blank() && !fail){
            $('submitButton').disabled = false;
        }else{
            $('submitButton').disabled = true;
        }
    }
}


/***
 *  Sends the Contact form to the Server
 ***/
function sendContactForm(){
    if (window.$ === window.jQuery){ //jQuery specific
        _JQsendContactForm();
    }else{
     
        new Ajax.Request('php/cont_form.php', {
              method: 'post',
              parameters: {
                  from: encodeURIComponent($('inputMail').value),
                  name: encodeURIComponent($('inputName').value),
                  phon: encodeURIComponent($('inputPhone').value),
                  mess: encodeURIComponent($('inputMessage').value)
              },
    
            onSuccess: function(data) {
                $('allFields').hide();
                $('confirm').show();
            }
        });
    }
}



/***
 *  Check if a mandatory field is filled or not
 ***/
function _JQcheckFieldInput(obj, skip){
    
    if(!skip){
        var fail = false;
        var emailRegEx = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if((obj.id == 'inputMail' && !obj.value.match(emailRegEx)) || obj.value == ''){
            $(obj).parent().addClass('fieldCross');
            $(obj).parent().removeClass('fieldTick');
            fail = true;
        }else{
            $(obj).parent().addClass('fieldTick');
            $(obj).parent().removeClass('fieldCross');
        }
    }

    if($('#inputName').val() && $('#inputMail').val() && $('#inputMessage').val() && !fail){
        $('#submitButton').removeAttr('disabled');
    }else{
        $('#submitButton').attr('disabled','true');
    }
}


/***
 *  Sends the Contact form to the Server
 ***/
function _JQsendContactForm(){
    $.post(
        "php/cont_form.php", {
            from: encodeURIComponent($('#inputMail').val()),
            name: encodeURIComponent($('#inputName').val()),
            phon: encodeURIComponent($('#inputPhone').val()),
            mess: encodeURIComponent($('#inputMessage').val())
        },
        
        function(data){
            $('#allFields').hide();
            $('#confirm').fadeIn();
        });
}