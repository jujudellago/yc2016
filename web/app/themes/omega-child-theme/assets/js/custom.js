jQuery.noConflict()(function($){
	$(document).ready(function(){
		var wrap = $(document);
		//	wrap.addClass("")
		var pricebox=$(".with_floating_price .ezfc-element.price-box");
		setPriceHeight(wrap);
		wrap.on("scroll", function(e) {
			 //console.log("scroll: "+wrap.scrollTop());
			setPriceHeight(wrap);
		

		});
		$('.ezfc-form input').on("click",function(e){
			console.log("total value is "+$(".total_hidden").val());
		});

		$("a[rel='external'], a.external").each(function(){
			this.target="_blank";
	   	});
		// 
// $('.ezfc-element-price').each(function(e){
	// 	var txt=$(this).html();
	// //	console.log("elem txt="+txt);
	// 	if (txt=="(Chf0)"){
		// 		$(this).html("");
		// 	}
		// 	
		// });
	//	console.log("no you not crazy");

		$('.ezfc-element-price').each(function(){
			var txt=$(this).html();
	//		console.log("elem txt="+txt);
			if (txt=="(Chf0)"){
				$(this).html("");
			}
			else{
				var newtxt=txt.replace("(","").replace(")","").replace("Chf","Chf ");
				$(this).html(newtxt);
			}
        
		});




	});

	function setPriceHeight(wrap){
			if (wrap.scrollTop() > 450) {
				$(".ezfc-element.price-box").addClass("fix-price-box");
				var newtop=wrap.scrollTop()-390;
				$(".with_floating_price .ezfc-element.price-box").css("top",newtop+"px" );
			} else {
				$(".ezfc-element.price-box").removeClass("fix-price-box");
				$(".with_floating_price .ezfc-element.price-box").css("top","50px");				
			}
	}
});
