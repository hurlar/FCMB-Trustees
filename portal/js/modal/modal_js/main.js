$(window).on("load",function(){
   
    $(".loader-backdrop").fadeOut();               // Open Modal on Load or after delay
        if($(".modal").length && ($(".modal").attr("data-open-onload"))=="true"){
            setTimeout(function(){
                $(".modal").modal();       
            }, $(".modal").attr("data-open-delay"));
    }
});

