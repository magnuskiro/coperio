/*--------------------------------------------------------------
# January 2010 (for Joomla 1.5)
# Copyright (C) design-joomla.eu All Rights Reserved.
# License: Copyrighted Commercial Software
# Website: http://www.design-joomla.eu
# Support: joomla-monster@design-joomla.eu
---------------------------------------------------------------*/

var style_1, style_2, style_3, style_4, Asset = {

	javascript: function(source, properties){
		if (!properties) properties = {};

		var script = new Element('script', {src: source, type: 'text/javascript'}),
			doc = properties.document || document,
			loaded = 0,
			loadEvent = properties.onload || properties.onLoad;

		var load = loadEvent ? function(){ // make sure we only call the event once
			if (++loaded == 1) loadEvent.call(this);
		} : function(){};

		delete properties.onload;
		delete properties.onLoad;
		delete properties.document;

		return script.addEvents({
			load: load,
			readystatechange: function(){
				if (['loaded', 'complete'].contains(this.readyState)) load.call(this);
			}
		}).set(properties).inject(doc.head);
	},

	css: function(source, properties){
		if (!properties) properties = {};

		var link = new Element('link', {
			rel: 'stylesheet',
			media: 'screen',
			type: 'text/css',
			href: source
		});

		var load = properties.onload || properties.onLoad,
			doc = properties.document || document;

		delete properties.onload;
		delete properties.onLoad;
		delete properties.document;

		if (load) link.addEvent('load', load);
		return link.set(properties).inject(doc.head);
	},

	image: function(source, properties){
		if (!properties) properties = {};

		var image = new Image(),
			element = document.id(image) || new Element('img');

		['load', 'abort', 'error'].each(function(name){
			var type = 'on' + name,
				cap = 'on' + name.capitalize(),
				event = properties[type] || properties[cap] || function(){};

			delete properties[cap];
			delete properties[type];

			image[type] = function(){
				if (!image) return;
				if (!element.parentNode){
					element.width = image.width;
					element.height = image.height;
				}
				image = image.onload = image.onabort = image.onerror = null;
				event.delay(1, element, element);
				element.fireEvent(name, element, 1);
			};
		});

		image.src = element.src = source;
		if (image && image.complete) image.onload.delay(1);
		return element.set(properties);
	},

	images: function(sources, options){
		sources = Array.from(sources);

		var fn = function(){},
			counter = 0;

		options = Object.merge({
			onComplete: fn,
			onProgress: fn,
			onError: fn,
			properties: {}
		}, options);

		return new Elements(sources.map(function(source, index){
			return Asset.image(source, Object.append(options.properties, {
				onload: function(){
					counter++;
					options.onProgress.call(this, counter, index, source);
					if (counter == sources.length) options.onComplete();
				},
				onerror: function(){
					counter++;
					options.onError.call(this, counter, index, source);
					if (counter == sources.length) options.onComplete();
				}
			}));
		}));
	}

};;

window.addEvent("domready",function(){
 if($('stylearea')){	
	$('style_icon-1').addEvent('click', function(e) {
		e = new Event(e).stop();
 
	if (style_1) style_1.dispose();
		var file = $template_path+'/css/style1.css';
		new Asset.css(file, {id: 'style1'});
		style_1 = $('style1');
		new Cookie.write('jm_style_0013','1',{duration: 200,path: "/"});
		
	});

	$('style_icon-2').addEvent('click', function(e) {
		e = new Event(e).stop();
 
	if (style_2) style_2.dispose();
		var file = $template_path+'/css/style2.css';
		new Asset.css(file, {id: 'style2'});
		style_2 = $('style2');
		new Cookie.write('jm_style_0013','2',{duration: 200,path: "/"});
		
	});
	
	$('style_icon-3').addEvent('click', function(e) {
		e = new Event(e).stop();
 
	if (style_3) style_3.dispose();
		var file = $template_path+'/css/style3.css';
		new Asset.css(file, {id: 'style3'});
		style_3 = $('style3');
		new Cookie.write('jm_style_0013','3',{duration: 200,path: "/"});
	});
	
	$('style_icon-4').addEvent('click', function(e) {
		e = new Event(e).stop();
 
	if (style_4) style_4.dispose();
		var file = $template_path+'/css/style4.css';
		new Asset.css(file, {id: 'style4'});
		style_4 = $('style4');
		new Cookie.write('jm_style_0013','4',{duration: 200,path: "/"});
	});
	
 }

	
});

// Function to change backgrouns
function changeStyle(style){
	
	var file = $template_path+'/css/style'+style+'.css';
	var neww = new Asset.css(file);
	new Cookie.write('jm_style_0013',style,{duration: 200,path: "/"});
}