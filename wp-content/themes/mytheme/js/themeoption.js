(function($){
	wp.customize("big_title_field", function(value) {
		value.bind(function(newval) {
			$("#big_title_field").html(newval);
		} );
	});
	wp.customize("big_title_desp", function(value) {
		value.bind(function(newval) {
			$("#big_title_desp").html(newval);
		} );
	});
	wp.customize("big_title_but_label", function(value) {
		value.bind(function(newval) {
			$("#big_title_but_label").html(newval);
		} );
	});
	wp.customize("big_title_but_link", function(value) {
		value.bind(function(newval) {
			$("#big_title_but_link").link(newval);
		} );
	});
	wp.customize("big_title_bg", function(value) {
		value.bind(function(newval) {
			$("#big_title_but_link").attr('href',newval);
		} );
	});
	wp.customize("promise1_label", function(value) {
		value.bind(function(newval) {
			$("#promise1_label").html(newval);
		} );
	});
	wp.customize("promise2_label", function(value) {
		value.bind(function(newval) {
			$("#promise2_label").html(newval);
		} );
	});
	wp.customize("promise3_label", function(value) {
		value.bind(function(newval) {
			$("#promise3_label").html(newval);
		} );
	});
	wp.customize("promise1_img", function(value) {
		value.bind(function(newval) {
			console.log(newval);
			$("#promise1_img").attr('src',newval);
		} );
	});
	wp.customize("promise2_img", function(value) {
		value.bind(function(newval) {
			console.log(newval);
			$("#promise2_img").attr('src',newval);
		} );
	});
	wp.customize("promise3_img", function(value) {
		value.bind(function(newval) {
			console.log(newval);
			$("#promise3_img").attr('src',newval);
		} );
	});
	wp.customize("team1", function(value) {
		value.bind(function(newval) {
			console.log(newval);
			$("#team1").html(newval);
		} );
	});
	wp.customize("team2", function(value) {
		value.bind(function(newval) {
			console.log(newval);
			$("#team2").html(newval);
		} );
	});
	wp.customize("team3", function(value) {
		value.bind(function(newval) {
			console.log(newval);
			$("#team3").html(newval);
		} );
	});
	wp.customize("team4", function(value) {
		value.bind(function(newval) {
			console.log(newval);
			$("#team4").html(newval);
		} );
	});
	wp.customize("team5", function(value) {
		value.bind(function(newval) {
			console.log(newval);
			$("#team5").html(newval);
		} );
	});
	wp.customize("team6", function(value) {
		value.bind(function(newval) {
			console.log(newval);
			$("#team6").html(newval);
		} );
	});
	wp.customize("team7", function(value) {
		value.bind(function(newval) {
			console.log(newval);
			$("#team7").html(newval);
		} );
	});
	wp.customize("team8", function(value) {
		value.bind(function(newval) {
			console.log(newval);
			$("#team8").html(newval);
		} );
	});
	
})(jQuery);