<?php 

$slides = array();

for ($i=0; $i<=5; $i++)
{
    if (($show = get_option('tz_big_slider_' . $i . '_show')))
    {
        $slides[get_option('tz_big_slider_' . $i . '_order')] = $i;   
    }
} 

ksort($slides);
?>

        <?php if (count($slides)>0) : ?>

        <div class="mainHomeWrapper">
            <div class="bigSliderContainer">
                <div class="bigSliderWrap" id="bigSliderWrap">
                    
                    

                    <?php foreach ($slides as $i):?>
                    <?php if (($img = get_option('tz_big_slider_' . $i . '_image_url')) != '') : ?>

                        <?php if (($link = get_option('tz_big_slider_' . $i . '_url')) != '') : ?>
                            <a href="<?php echo $link; ?>" title="">
                        <?php endif; ?>
                                
                        <?php 
                        $position_x = get_option('tz_big_slider_' . $i . '_image_position');
                        $position = 'background-position: ' . $position_x . ' center;' ;
                        ?>

                        <div class="item" style="background-image: url('<?php echo get_option('tz_big_slider_' . $i . '_image_url'); ?>');<?php echo $position; ?>">
                            
                            <?php if (($slider_text = get_option('tz_big_slider_' . $i . '_text')) != '') : ?>
                            <div class="text">
                                <?php echo nl2br(stripslashes($slider_text)); ?>
                                <?php if (($link = get_option('tz_big_slider_' . $i . '_url')) != '') : ?>
                                    <span class="more-big"></span>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                            
                        </div>

                        <?php if ($link != '') : ?></a><?php endif; ?>
                            
                    <?php endif; ?>
                    <?php endforeach; ?>

                </div>
            </div>

            <div class="navWrap">
                <div class="navContainer">
                    <div class="nextPrevBlock">
                        <a id="nextBigLink" class="nextLink" href="javascript:void(0);"></a>
                        <a id="prevBigLink" class="prevLink" href="javascript:void(0);"></a>
                    </div>
                </div>
            </div>
        </div>

<?php endif; ?>