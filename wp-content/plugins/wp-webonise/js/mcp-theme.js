/* latest parties */
jQuery(window).load(zerif_home_latest_parties);
jQuery(window).resize(zerif_home_latest_parties);
function zerif_home_latest_parties(){
    if( jQuery( '#carousel-homepage-latestparties').length > 0 ) {
        jQuery( '#carousel-homepage-latestparties div.item' ).height('auto');
        if( isMobile.any() || (!isMobile.any() && jQuery('.container').outerWidth()>768) ) {

            if( jQuery( '#carousel-homepage-latestparties div.item' ).length < 2 ) {
                jQuery( '#carousel-homepage-latestparties > a' ).css('display','none');
            }
            var maxheight = 0;
            jQuery( '#carousel-homepage-latestparties div.item' ).each(function(){
                if( jQuery(this).height() > maxheight ) {
                    maxheight = jQuery(this).height();
                }
            });
            jQuery( '#carousel-homepage-latestparties div.item' ).height(maxheight);
        }
    }
}