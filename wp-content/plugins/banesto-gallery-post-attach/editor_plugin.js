(function() {
		  
	var plugin_url = '';
	
	var insert_gallery = function(postId, type){
		tinyMCE.activeEditor.execCommand('mceInsertContent', 0, "[post-gallery id=" + postId + " type=" + type + "]");
	}
	
	var select_post = function() {
		var content = jQuery('<div><h3>Select gallery</h3>\
		<p>Click "Select" next to the gallery you wish to insert into this page/post.</p>\
		<div class="modal-scroller">\
		<table class="widefat" cellspacing="0" cellpadding="0">\
			<thead>\
				<tr>\
					<th scope="col">ID</th>\
					<th scope="col">Gallery Title</th>\
					<th scope="col" width="30%" class="actions">Insert</th>\
				</tr>\
			</thead>\
			<tbody>\
			</tbody>\
		</table>\
		</div>\
		</div>');
		
		console.log(post_list);
		
		for (index in post_list) {
		
			// STRANGE WAY TO ACCOMPLISH THIS
			if (post_list[index].ID != undefined) {
				
				var alt = 'alternate ' == alt ? '' : 'alternate ';
				var row = jQuery('<tr class="' + alt + 'author-self status-publish" valign="top">\
					<td class="id">' + post_list[index].ID + '</td>\
					<td class="name">' + post_list[index].post_title + '</td>\
					<td class="actions">\
						<a href="#" class="use" id="slideshow" title="Insert Slideshow">Slideshow</a>\
						<a href="#" class="use" id="thumbnails" title="Insert Thumbnail block">Thumbnails</a>\
					</td>\
				</tr>');
				row.appendTo(content.find('tbody'));
			}
		}
		content.find('table').attr('id', 'slidepress-select-gallery');
		
		jQuery.facebox(content.html());
        
		jQuery('#slidepress-select-gallery').find('.use').click(function(e){
			e.preventDefault();
			// call shortcode insertion function
			insert_gallery(jQuery(this).parent().siblings('.id').text(), jQuery(this).attr('id'));
			jQuery(document).trigger('close.facebox');
		});
        
		
	}
		  
		  
    tinymce.create('tinymce.plugins.galleryPost', {
        init : function(ed, url) {
			plugin_url = url;
            ed.addButton('gallery_post', {
                title : 'Insert Gallery',
                image : plugin_url+'/shortcode-icon.png',
                onclick : select_post
            });
			return plugin_url;
        },
        createControl : function(n, cm) {
			return null;
        },
        getInfo : function() {
            return {
                longname : "Banesto Gallery Post Attatch",
                author : 'Ernests Kecko',
                authorurl : 'http://ernests.info/',
                infourl : 'http://ernests.info/',
                version : "1.0"
            };
        }
    });
    tinymce.PluginManager.add('gallery_post', tinymce.plugins.galleryPost);
    
})();
