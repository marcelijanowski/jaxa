/* 
 * init gallery slideshow id - inserted gallery post id
 */

gallery_init();

function gallery_init()
{
    if (gallery_slideshow.length > 0)
    {
        for(i=0; i<gallery_slideshow.length ;i++)
        {
            gallery_load(gallery_slideshow[i]);
        }
    }
}



function gallery_load(id)
{
    var $parent = jQuery('#postGallerySlideshow_' + id);
    var $wrap = $parent.find('.imageWrap');
    var $image = $wrap.find('img');

    // when first image is loaded - correct parent container height
    $image.load(function(){
        $wrap.css('height', $image.height());
    });
    
    
    jQuery(window).load(function() {
        
        $wrap.cycle({ 
            fx:         'fade', 
            prev:       '#prevBigLink_' + id,
            next:       '#nextBigLink_' + id,
            after:      onAfter
        });
    });
        
};

function onAfter(curr, next, opts)
{
    var 
        $wrap = opts.$cont,
        $parent = $wrap.closest('.postGallerySlideshow'),
        title = this.alt,
        $title = $parent.find('.imageTitle')
    ;
    
    $title.html(title);
}

