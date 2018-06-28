jQuery(document).ready(function($){

    /**
     * Set page header margin top equal to header
     */

    var headerHeight = $(".site-header").height();
    $("#page-header").css("margin-top", headerHeight);

    var wrapWidth = $(".content-sidebar-wrap").width();
    $(".page-header .wrap").css("width", wrapWidth);

    $( window ).resize(function() {
        var headerHeight = $(".site-header").height();
        $("#page-header").css("margin-top", headerHeight);
        var wrapWidth = $(".content-sidebar-wrap").width();
        $(".page-header .wrap").css("width", wrapWidth);
    });

});
