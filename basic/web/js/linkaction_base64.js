$(document).ready(function(){
	
	$(".base64-link").click(function(e){
		
		e.preventDefault();
		var lnk = $(e.target).closest('a')[0];
		var url = $(lnk).attr('data-href');
		//alert("encoded url="+url);
		url = Base64.decode(url);
		//alert("decoded url="+url);
		var target = $(lnk).attr('target');
		//alert("target=["+target+"]");
		if (target !== undefined) {
			window.open(url, target);
		} else {
			window.location = url;
		}
	});
});