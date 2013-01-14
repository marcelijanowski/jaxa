    <div class="storySliderWrap">

        <div class="wrap">
            
            <div class="carousel" id="storyCarousel">
    
            <?php for ($i=0; $i<=9; $i++):?>
            <?php if (
                        ($title = get_option('tz_story_' . $i . '_title')) != '' 
                        &&
                        ($text = get_option('tz_story_' . $i . '_text')) != ''
                        &&
                        ($link = get_option('tz_story_' . $i . '_url')) != ''
                ) : ?>

                    <div class="item post">
                        <div class="number">
                            <?php echo $i; ?>
                        </div>

                        <div class="innerBox">

                            <div class="title">
                                <?php echo $title; ?>
                            </div>

                            <div class="text">
                                <?php echo smart_trim($text, 140); ?>
                            </div>

                            <a class="continue" href="<?php echo $link; ?>" rel="bookmark" title="<?php echo $title; ?>"><?php _e('Read', 'framework') ?></a>

                        </div>
                    </div>
            
            

            <?php endif; ?>
            <?php endfor; ?>
            
            </div>
            
        </div>
        

        <a id="nextStoryLink" class="nextLink nextPrevLinks" href="javascript:void(0);"></a>
        <a id="prevStoryLink" class="prevLink nextPrevLinks" href="javascript:void(0);"></a>
        
    </div>