
$(document).ready(function(){
	$(window).on("scroll", function() {
        if($(window).scrollTop() > 50) {
            $(".navbar").addClass("addBg");
            //$(".navbar").removeClass("rmBg");
        } else {
            //remove the background property so it comes transparent again (defined in your css)
           //$(".navbar").addClass("rmBg");
           $(".navbar").removeClass("addBg");
        }
    });
    // $('.expBtn').click(function() {
    // 	$('html, body').animate({
    //     	scrollTop: $("#packs").offset().top - 100
	   //  }, 1000);
	   //  return false;
    // });
})