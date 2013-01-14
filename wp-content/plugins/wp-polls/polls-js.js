var poll_id=0,poll_answer_id="",is_being_voted=!1;
pollsL10n.show_loading=parseInt(pollsL10n.show_loading);
pollsL10n.show_fading=parseInt(pollsL10n.show_fading);
function poll_vote(a){
    is_being_voted?alert(pollsL10n.text_wait):(set_is_being_voted(!0),poll_id=a,poll_answer_id="",poll_multiple_ans_count=poll_multiple_ans=0,jQuery("#poll_multiple_ans_"+poll_id).length&&(poll_multiple_ans=parseInt(jQuery("#poll_multiple_ans_"+poll_id).val())),jQuery("#polls_form_"+poll_id+" input:checkbox, #polls_form_"+poll_id+" input:radio").each(function(){
        jQuery(this).is(":checked")&&(0<poll_multiple_ans?(poll_answer_id=jQuery(this).val()+","+poll_answer_id,poll_multiple_ans_count++):
            poll_answer_id=parseInt(jQuery(this).val()))
        }),0<poll_multiple_ans?0<poll_multiple_ans_count&&poll_multiple_ans_count<=poll_multiple_ans?(poll_answer_id=poll_answer_id.substring(0,poll_answer_id.length-1),poll_process()):0==poll_multiple_ans_count?(set_is_being_voted(!1),alert(pollsL10n.text_valid)):(set_is_being_voted(!1),alert(pollsL10n.text_multiple+" "+poll_multiple_ans)):0<poll_answer_id?poll_process():(set_is_being_voted(!1),alert(pollsL10n.text_valid)))
    }
function poll_process(){
    poll_nonce=jQuery("#poll_"+poll_id+"_nonce").val();
    pollsL10n.show_fading?jQuery("#polls-"+poll_id).fadeTo("def",0,function(){
        pollsL10n.show_loading&&jQuery("#polls-"+poll_id+"-loading").show();
        jQuery.ajax({
            type:"POST",
            url:pollsL10n.ajax_url,
            data:"action=polls&view=process&poll_id="+poll_id+"&poll_"+poll_id+"="+poll_answer_id+"&poll_"+poll_id+"_nonce="+poll_nonce,
            cache:!1,
            success:poll_process_success
        })
        }):(pollsL10n.show_loading&&jQuery("#polls-"+poll_id+"-loading").show(),jQuery.ajax({
        type:"POST",
        url:pollsL10n.ajax_url,
        data:"action=polls&view=process&poll_id="+poll_id+"&poll_"+poll_id+"="+poll_answer_id+"&poll_"+poll_id+"_nonce="+poll_nonce,
        cache:!1,
        success:poll_process_success
    }))
    }
function poll_result(a){
    is_being_voted?alert(pollsL10n.text_wait):(set_is_being_voted(!0),poll_id=a,poll_nonce=jQuery("#poll_"+poll_id+"_nonce").val(),pollsL10n.show_fading?jQuery("#polls-"+poll_id).fadeTo("def",0,function(){
        pollsL10n.show_loading&&jQuery("#polls-"+poll_id+"-loading").show();
        jQuery.ajax({
            type:"GET",
            url:pollsL10n.ajax_url,
            data:"action=polls&view=result&poll_id="+poll_id+"&poll_"+poll_id+"_nonce="+poll_nonce,
            cache:!1,
            success:poll_process_success
        })
        }):(pollsL10n.show_loading&&jQuery("#polls-"+
        poll_id+"-loading").show(),jQuery.ajax({
        type:"GET",
        url:pollsL10n.ajax_url,
        data:"action=polls&view=result&poll_id="+poll_id+"&poll_"+poll_id+"_nonce="+poll_nonce,
        cache:!1,
        success:poll_process_success
    })))
    }
function poll_booth(a){
    is_being_voted?alert(pollsL10n.text_wait):(set_is_being_voted(!0),poll_id=a,poll_nonce=jQuery("#poll_"+poll_id+"_nonce").val(),pollsL10n.show_fading?jQuery("#polls-"+poll_id).fadeTo("def",0,function(){
        pollsL10n.show_loading&&jQuery("#polls-"+poll_id+"-loading").show();
        jQuery.ajax({
            type:"GET",
            url:pollsL10n.ajax_url,
            data:"action=polls&view=booth&poll_id="+poll_id+"&poll_"+poll_id+"_nonce="+poll_nonce,
            cache:!1,
            success:poll_process_success
        })
        }):(pollsL10n.show_loading&&jQuery("#polls-"+
        poll_id+"-loading").show(),jQuery.ajax({
        type:"GET",
        url:pollsL10n.ajax_url,
        data:"action=polls&view=booth&poll_id="+poll_id+"&poll_"+poll_id+"_nonce="+poll_nonce,
        cache:!1,
        success:poll_process_success
    })))
    }
    function poll_process_success(a){
    jQuery("#polls-"+poll_id).replaceWith(a);
    pollsL10n.show_loading&&jQuery("#polls-"+poll_id+"-loading").hide();
    pollsL10n.show_fading?jQuery("#polls-"+poll_id).fadeTo("def",1,function(){
        set_is_being_voted(!1)
        }):set_is_being_voted(!1)
    }
function set_is_being_voted(a){
    is_being_voted=a
    };



jQuery(document).ready(function($) {

    $('#sidebar').on('click', 'button.vote-bullet', function()
    {
        var 
            $this = $(this),
            $parent = $this.parent(),
            $allOptions = $this.closest('.wp-polls-ul').find('li'),
            $li = $this.closest('li'),
            $input = $parent.find('input[type=radio]')
        ;
        
        $allOptions.removeClass('active');
        
        if (!$input.is(':checked'))
        {
            $input.attr('checked', true);
            $li.addClass('active');
        }
        
        return false;
    });
    
    $('#sidebar').find('.wp-polls-ul').on('click', 'input[type=radio]', function()
    { 
        var
            $this = $(this),
            $allOptions = $this.closest('.wp-polls-ul').find('li'),
            $li = $this.closest('li')
        ;
            
        $allOptions.removeClass('active');
        $li.addClass('active');
    });
    
    


});