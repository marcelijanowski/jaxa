		<!--BEGIN #sidebar .aside-->
		<div id="sidebar" class="aside">
			
            
            <?php if (is_front_page()) : ?>
            
                <?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Home Sidebar') ) ?>
            
            <?php elseif (is_category( $tz_blog_category ) || is_category_parent($tz_blog_category)) : ?>
            
                <?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Blog Category Sidebar') ) ?>
            
            <?php elseif (is_single()) : ?>
            
                <?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Single Post Sidebar') ) ?>
            
            <?php elseif (is_page()) : ?>
            
                <?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Page Sidebar') ) ?>
            
            <?php else : ?>
            
                <?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar() ) ?>
			
            <?php endif; ?>
            
		<!--END #sidebar .aside-->
		</div>