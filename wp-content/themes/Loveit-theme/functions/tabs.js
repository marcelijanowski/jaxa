function getUrlVars() {
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

jQuery(function() {
    
    
    jQuery(".tab").accordion({
        collapsible : true,
        active : false,
        header : 'h3.hndle',
        autoHeight : false
    });
    
	jQuery("#tabs").tabs({
        
        load: function(event, ui){

            console.log(jQuery.ui.version);
            console.log(ui.panel);
            jQuery(ui.panel).accordion("refresh");
        }
        
    });
    
    
    
    
	var ctab = getUrlVars()["tab"];
	//alert(ctab);
	if (ctab != undefined){
		var $tabs = jQuery('#tabs').tabs({
        
        load: function(event, ui){

            console.log(jQuery.ui.version);
            console.log(ui.panel);
            jQuery(ui.panel).accordion("refresh");
        }
        
    });
    	$tabs.tabs('select', ctab);
	}
	
	jQuery("ul#tab-items li a").click(function(event){
		var url = this;
		var hid = document.getElementById("tz_selectedtab");
		hid.value = url;
	});
	
    
    // dependable fields
    
	if (jQuery('#tz_captcha_select').is(':checked'))
    {
		jQuery("#tz_public_key, #tz_private_key, #tz_captcha_theme").parent().parent().show();
	}
    else 
    {
		jQuery("#tz_public_key, #tz_private_key, #tz_captcha_theme").parent().parent().hide();
	}
	
	jQuery('#tz_captcha_select').click(function(){
		jQuery("#tz_public_key, #tz_private_key, #tz_captcha_theme").parent().parent().toggle();
	});
    
    
	if (jQuery('#tz_recent_manual').is(':checked'))
    {
		jQuery("#tz_recent_1, #tz_recent_2, #tz_recent_3").parent().parent().show();
		jQuery("#tz_recent_cats").parent().parent().hide();
	}
    else 
    {
		jQuery("#tz_recent_1, #tz_recent_2, #tz_recent_3").parent().parent().hide();
		jQuery("#tz_recent_cats").parent().parent().show();
	}
	
	jQuery('#tz_recent_manual').click(function(){
		jQuery("#tz_recent_1, #tz_recent_2, #tz_recent_3, #tz_recent_cats").parent().parent().toggle();
	});
});