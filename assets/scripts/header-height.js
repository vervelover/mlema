jQuery(document).ready(function($){

    /**
     * Set page header margin top equal to header
     */
    function setHeaderHeight() {
        var headerHeight = $(".site-header").height();
        $(".site-inner").css("margin-top", headerHeight);
    }
    setHeaderHeight();

    // var wrapWidth = $("#genesis-content").width();
    // $(".no-header-image .page-header").css("width", wrapWidth);

    // $(window).bind('resize', function(e){
    //     window.resizeEvt;
    //     $(window).resize(function(){
    //         clearTimeout(window.resizeEvt);
    //         window.resizeEvt = setTimeout(function(){
    //             setHeaderHeight();
    //         }, 250);
    //     });
    // });
    //

    var resize_timeout;

    $(window).on('resize orientationchange', function(){
        clearTimeout(resize_timeout);

        resize_timeout = setTimeout(function(){
            $(window).trigger('resized');
        }, 250);
    });

    $(window).on('resized', function(){
        setHeaderHeight();
    });


});
