(function() {
    
    var plugin_url = '';
    
    /* COLUMNS */
    
    var columns_2 = function() 
    {
		tinyMCE.activeEditor.execCommand('mceInsertContent', false, '[one_half]Column 1[/one_half][one_half_last]Column 2[/one_half_last]');
	}
    
    var columns_3 = function() 
    {
		tinyMCE.activeEditor.execCommand('mceInsertContent', false, '[one_third]Columns 1[/one_third][one_third]Column 2[/one_third][one_third_last]Column 3[/one_third_last]');
	}
    
    
    tinymce.create('tinymce.plugins.columnsShortcode', {
        init : function(ed, url) {
            plugin_url = url;
			ed.addButton('banesto_columns');
			return plugin_url;
        },
        createControl : function(n, cm) {

            switch (n) {
				case 'banesto_columns':

                    var c = cm.createSplitButton('banesto_columns', {
                        title : 'Add Columns',
                        image: plugin_url + "/icons/column-icon.png",
                        onclick : function(){
                            c.showMenu();
                        }
                    });
                    c.onRenderMenu.add(function(c,m) {
                        m.add({title : 'Insert 2 columns', onclick : columns_2});
                        m.add({title : 'Insert 3 columns', onclick : columns_3});
                    });
                    return c;
            }
        },
        getInfo : function() {
            return {
                longname : "Banesto Shortcodes - columns",
                author : 'Ernests Kečko',
                authorurl : 'http://ernests.info/',
                infourl : 'http://ernests.info/',
                version : "1.0"
            };
        }
    });
    
    
    
 
    tinymce.PluginManager.add('banesto_columns', tinymce.plugins.columnsShortcode);
    
    
    /* BUTTON */
    
    function insertButton(style) 
    {
		tinyMCE.activeEditor.execCommand('mceInsertContent', false, '[button link="#" target="_blank" style="' + style + '" align="left"]Button[/button]');
	}
    
    tinymce.create('tinymce.plugins.buttonShortcode', {
        init : function(ed, url) {
            plugin_url = url;
			ed.addButton('banesto_button');
			return plugin_url;
        },
        createControl : function(n, cm) {

            switch (n) {
				case 'banesto_button':

                    var c = cm.createSplitButton('banesto_button', {
                        title : 'Add Button',
                        image: plugin_url + "/icons/button-icon.png",
                        onclick : function(){
                            c.showMenu();
                        }
                    });
                    c.onRenderMenu.add(function(c,m) {
                        m.add({title : 'Insert button style 1', onclick : function(){ insertButton("style1"); }});
                        m.add({title : 'Insert button style 2', onclick : function(){ insertButton("style2"); }});
                        m.add({title : 'Insert button style 3', onclick : function(){ insertButton("style3"); }});
                    });
                    return c;
            }
        },
        getInfo : function() {
            return {
                longname : "Banesto Shortcodes - buttons",
                author : 'Ernests Kečko',
                authorurl : 'http://ernests.info/',
                infourl : 'http://ernests.info/',
                version : "1.0"
            };
        }
        
    });
 
    tinymce.PluginManager.add('banesto_button', tinymce.plugins.buttonShortcode);
    
    
    
    /* SPACER */
    
    function insertSpacer(style) 
    {
		tinyMCE.activeEditor.execCommand('mceInsertContent', false, '[spacer style="' + style + '"]');
	}
    
    tinymce.create('tinymce.plugins.spacerShortcode', {
        init : function(ed, url) {
            plugin_url = url;
			ed.addButton('banesto_spacer');
			return plugin_url;
        },
        createControl : function(n, cm) {

            switch (n) {
				case 'banesto_spacer':

                    var c = cm.createSplitButton('banesto_spacer', {
                        title : 'Add Button',
                        image: plugin_url + "/icons/spacer-icon.png",
                        onclick : function(){
                            c.showMenu();
                        }
                    });
                    c.onRenderMenu.add(function(c,m) {
                        m.add({title : 'Insert spacer style 1', onclick : function(){ insertSpacer("style1"); }});
                        m.add({title : 'Insert spacer style 2', onclick : function(){ insertSpacer("style2"); }});
                        m.add({title : 'Insert spacer style 3', onclick : function(){ insertSpacer("style3"); }});
                    });
                    return c;
            }
        },
        getInfo : function() {
            return {
                longname : "Banesto Shortcodes - spacers",
                author : 'Ernests Kečko',
                authorurl : 'http://ernests.info/',
                infourl : 'http://ernests.info/',
                version : "1.0"
            };
        }
        
    });
 
    tinymce.PluginManager.add('banesto_spacer', tinymce.plugins.spacerShortcode);
    
    
    
    /* QUOTE */
    
    function insertQuote(style) 
    {
        var input = prompt("Enter the quote", "Please enter the text for quote.");
        if (input != null) {
        
            tinyMCE.activeEditor.execCommand('mceInsertContent', false, '[quote style="' + style + '"]' + input + '[/quote]');
        }
	}
    
    tinymce.create('tinymce.plugins.quoteShortcode', {
        init : function(ed, url) {
            plugin_url = url;
			ed.addButton('banesto_quote');
			return plugin_url;
        },
        createControl : function(n, cm) {

            switch (n) {
				case 'banesto_quote':

                    var c = cm.createSplitButton('banesto_quote', {
                        title : 'Add Quote',
                        image: plugin_url + "/icons/quote-icon.png",
                        onclick : function(){
                            c.showMenu();
                        }
                    });
                    c.onRenderMenu.add(function(c,m) {
                        m.add({title : 'Insert quote style 1', onclick : function(){ insertQuote("style1"); }});
                        m.add({title : 'Insert quote style 2', onclick : function(){ insertQuote("style2"); }});
                    });
                    return c;
            }
        },
        getInfo : function() {
            return {
                longname : "Banesto Shortcodes - quote",
                author : 'Ernests Kečko',
                authorurl : 'http://ernests.info/',
                infourl : 'http://ernests.info/',
                version : "1.0"
            };
        }
        
    });
 
    tinymce.PluginManager.add('banesto_quote', tinymce.plugins.quoteShortcode);
    
    
    
    /* GOOGLE MAP */
    tinymce.create('tinymce.plugins.gmapShortcode', {

        init : function(ed, url){
            ed.addButton('banesto_gmap', {
            title : 'Add Google Map',
                onclick : function() {
                    ed.selection.setContent('[gmap lat="23.344" lng="12.342" zoom="7" height="402"]');
                },
                image: url + "/icons/gmap-icon.png"
            });
        }
    });
 
    tinymce.PluginManager.add('banesto_gmap', tinymce.plugins.gmapShortcode);
    
    
    
    
    /* ACCORDION */
    
    var insertAccordion = function () 
    {
        var input = prompt("Enter number of items", "Number of items in accordion");
        if (input != null) {
			
            var limit = parseInt(input);
            
			if (limit != null && limit != 'undefined')
            {
                var list = '';
                
                for (var li=1; li<=limit; li++)
                {
                    list += '[accordion title="title' + li + '"]content[/accordion]';
                }
                
                tinyMCE.activeEditor.execCommand('mceInsertContent', false, '[accordions]' + list + '[/accordions]');
            }
        }
	}
    
    tinymce.create('tinymce.plugins.accordionShortcode', {
        init : function(ed, url){
            ed.addButton('banesto_accordion', {
            title : 'Add Accordion',
                onclick : insertAccordion,
                image: url + "/icons/accordion-icon.png"
            });
        }
        
    });
 
    tinymce.PluginManager.add('banesto_accordion', tinymce.plugins.accordionShortcode);
    
})();

