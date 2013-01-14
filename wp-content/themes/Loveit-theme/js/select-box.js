function check_status(id){

	
	if(jQuery('#'+id).val() == 1){
			jQuery('#'+id).parent().parent().children('#type-custom-text').hide();
			jQuery('#'+id).parent().parent().children('#type-image').show();
		} else {
			jQuery('#'+id).parent().parent().children('#type-image').hide();
			jQuery('#'+id).parent().parent().children('#type-custom-text').show();
		}
}

