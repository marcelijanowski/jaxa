jQuery(document).ready(function($){ 

    for (var key in accordion_shorcodes) 
    {
        $("#" + key).accordion(accordion_shorcodes[key]);
    }

}); 