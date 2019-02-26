jQuery(document).ready(function($){
    function resizeGlryCont(){
        if (enoughCont == false){return;}
        var windowW = window.innerWidth;
        var galleryContain = $('#gallery-cont');
        galleryContain.css('height', 'auto');//Set height to default
        var currentHeight = galleryContain.height();
        if (windowW >= 992){
            galleryContain.css('height', String(currentHeight * (1/3) ));
        }else if (windowW >= 768){
            galleryContain.css('height', String(currentHeight * (2.15/4) ));
        }
    }
    $(window).load(function(){
        resizeGlryCont();
    });
    $(window).resize(function(){
        resizeGlryCont();
    });
});