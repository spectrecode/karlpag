$(document).ready(function() {
	$("#menu-co").click(function(){
        var estado = $("header nav").css("display");
        if(estado=="none"){
            $("header nav").show();
        }else{
            $("header nav").hide();
        }
    });
});