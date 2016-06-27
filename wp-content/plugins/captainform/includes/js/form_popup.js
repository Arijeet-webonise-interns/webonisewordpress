
function captainform_popup_default(){
	
	var popup_params={
		popup_url: '',
		popup_w: 500,
		popup_h: 250,
		popup_title: '',
		pupup_body: '',
		popup_buttons: [],
		action_name:'',
		action_params: []
	}
	return popup_params;
	
}


function captainform_create_form_popup(msg) {
	jQuery('#captainform_popup').remove();
	url = msg.url;
	w = msg.popup_w;
	
	document.documentElement.style.overflow = 'hidden';  // firefox, chrome
	document.body.scroll = "no"; // ie only
	style_ios = '';
	if (captainform_is_ios())
	{
		style_ios = ' style="-webkit-overflow-scrolling: touch"';
	}

	htm = '';
	htm += '<div id="captainform_popup" onclick="close_popup()" class="captainform_popup_bg_form">';
		htm += '<div id="cfloader" class="captainform_loader_form"></div>';
		htm += '<div id="popup_box" class="captainform_popup_box_form">';
			htm += '<div class="close_cnt"><div id="xclose" class="captainform_popup_close_form" onclick="close_popup()"></div></div>';
			htm += '<div id="popup_body" class="captainform_popup_body_form"' + style_ios + '><iframe  id="ppiframe" src="' + url + '" class="popup_iframe_form" scrolling="no"></iframe></div>';
		htm += '</div>';;
	htm += '</div>';
	ppi = document.getElementById('ppiframe');

	jQuery('body').append(htm);
	jQuery('#popup_box').width(w);
	jQuery('#popup_box').height(0);
	jQuery('#captainform_popup').show();
	
	jQuery("#ppiframe").on("load", function () {
		jQuery('#popup_box').show();
		resize_popup_iframe();
	});	
	jQuery("#popup_box").on("click", function (e) {
		e.preventDefault();
		return false;
	});	

	element1 = document.getElementById('ppiframe');

	var isOldIE = (navigator.userAgent.indexOf("MSIE") !== -1); // Detect IE10 and below

	iFrameResize({
		log: false,
		scrolling: false,
		enablePublicMethods: true,
		checkOrigin: false,
		heightCalculationMethod: isOldIE ? 'max' : 'documentElementOffset', // old wy max e obligatoriu pt ie8
		resizedCallback: function (messageData) {
			hh = messageData.height;
			hhf = parseInt(hh) - 0;
			iframe_height = hhf;
			jQuery('#popup_box').height(hhf);
			resize_popup_iframe();
			jQuery('#cfloader').remove();
		},
		scrollCallback: function () {
				
		},
		messageCallback: function (messageData) { // Callback fn when message is received

		}
	}, element1);

}

function resize_popup_iframe() {
	if (jQuery('#ppiframe').length == 0) {
		return false;
	}

	max_h = jQuery(window).height() - 50;
	jQuery('#popup_box').css('max-height', max_h + 'px');
	max_w = jQuery(window).width() - 50;
	jQuery('#popup_box').css('max-width', max_w + 'px');

	jQuery('#popup_body').css('max-height', jQuery('#popup_box').height() + 'px');
	diff = jQuery('#ppiframe').outerHeight() - jQuery('#popup_box').outerHeight();
}

function captainform_is_ios() {
	var iDevices = [ 'iPad Simulator', 'iPhone Simulator', 'iPod Simulator', 'iPad', 'iPhone', 'iPod' ];
	if (!!navigator.platform) {
		while (iDevices.length) {
			if (navigator.platform === iDevices.pop()){ return true; }
		}
	}
	return false;
}
function close_popup() {
	jQuery('#captainform_popup').remove();
	jQuery("window").css("overflow", "auto");
    document.documentElement.style.overflow = 'auto';  // firefox, chrome
    document.body.scroll = "yes"; // ie only
}

window.onresize = function(event) {
    resize_popup_iframe();
};
window.addEventListener('message', function(e){
	msg_pp = e.data;	
	w=parseInt(msg_pp.fwidth);
	if ( jQuery('#popup_box').length && msg_pp.hasOwnProperty('fwidth') ) {
		//jQuery('html, body').on('scroll touchmove mousewheel', function(e){
		//  e.preventDefault();
		//  e.stopPropagation();
		//  return false;
		//})
		jQuery('#popup_box').css('width',w+'px')
		jQuery('#popup_body').off('scrollTo').scrollTo(jQuery('#ppiframe'), 300);			
	}
});
jQuery.fn.scrollTo = function(elem, speed) {
    jQuery(this).animate({
        scrollTop:  jQuery(this).scrollTop() - jQuery(this).offset().top + jQuery(elem).offset().top
    }, speed == undefined ? 500 : speed);
    return this;
};
