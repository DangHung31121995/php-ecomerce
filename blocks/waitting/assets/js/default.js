function showWaitting(){		
	//Get the A tag
	var id = $(this).attr('href');	
	//Get the screen height and width
	var maskHeight = $(document).height();
	var maskWidth = $(window).width();	
	//Set heigth and width to mask to fill up the whole screen
	$('#waitting-mask').css({'width':maskWidth,'height':maskHeight});		
	//transition effect		
	$('#waitting-mask').fadeIn(300);	
	$('#waitting-mask').fadeTo("slow",0.8);		
	//Get the window height and width
	var winH = $(window).height();
	var winW = $(window).width();              
	//Set the popup window to center
	$('#dialog').css('top',  winH/2-$('#dialog').height()/2);
	$('#dialog').css('left', winW/2-$('#dialog').width()/2);	
	//transition effect
	$('#dialog').fadeIn(300); 
}
function hideWaitting(){
    $('#waitting-mask').hide();
	$('.window').hide();
}
$(window).resize(function () {	 
	var box = $('#waitting-boxes .window'); 
    //Get the screen height and width
    var maskHeight = $(document).height();
    var maskWidth = $(window).width();      
    //Set height and width to mask to fill up the whole screen
    $('#waitting-mask').css({'width':maskWidth,'height':maskHeight});               
    //Get the window height and width
    var winH = $(window).height();
    var winW = $(window).width();
    //Set the popup window to center
    box.css('top',  winH/2 - box.height()/2);
    box.css('left', winW/2 - box.width()/2);	 
});