<!--BEGIN #searchform-->
<form method="get" id="searchform" action="<?php echo home_url(); ?>/">
	<div class="search-container">
		<div class="search-inner clearfix">

			<input type="submit" id="searchsubmit" class="searchsubmit" value="" />
            
            <div class="input">
                <input type="text" name="s" class="search-input" id="s" placeholder="<?php _e('Search for', 'framework'); ?>" />
            </div>
            
		</div>
	</div>
<!--END #searchform-->
</form>