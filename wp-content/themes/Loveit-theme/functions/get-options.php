<?php
//allows the theme to get info from the theme options page
global $options;
foreach ($options as $value)
{
    if (isset($value['id']))
    {
        if (get_option( $value['id'] ) === FALSE) 
        { 
            if (isset($value['std']))
            {
                $$value['id'] = $value['std']; 
            }
        }
            else 
        { 
            $$value['id'] = get_option( $value['id'] ); 
        }
    }
}
?>