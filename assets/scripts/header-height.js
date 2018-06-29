jQuery(document).ready(function($){

    /**
     * Set page header margin top equal to header
     */

    var headerHeight = $(".site-header").height();
    $(".site-inner").css("margin-top", headerHeight);

    // var wrapWidth = $("#genesis-content").width();
    // $(".no-header-image .page-header").css("width", wrapWidth);

    $( window ).resize(function() {
        var headerHeight = $(".site-header").height();
        $(".site-inner").css("margin-top", headerHeight);
        // var wrapWidth = $("#genesis-content").width();
        // $(".no-header-image .page-header").css("width", wrapWidth);
    });

});
