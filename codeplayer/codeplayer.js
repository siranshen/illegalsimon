function sizeCodeSections() {
	$(".code_container").height($(window).height() - $("#menu_bar").height() + "px");
}

window.onload = function init() {
	sizeCodeSections();
	$(window).resize(sizeCodeSections);
	
	$("#navigation_btns li").click(function() {
		if ($(this).toggleClass("selected"));
		$("#"+this.id.replace('_btn', '')).toggle();
		
		var displayedDivs = $(".code_container").filter(function() {
			return $(this).css("display") != "none";
		}).length;
		
		$(".code_container").width(100/displayedDivs + '%');
	});
	
	$("#run_btn").click(function() {
		$("iframe").contents().find("html")
			.html("<style>" + $("#css_code").val() + "</style>" + $("#html_code").val());
			
		//document.getElementById("result_frame").contentWindow.eval($("#js_code").val()); // eval() is liable to security issues!!
		if ($("#js_code").val() != "")
			alert("Sorry, the Javascript section has been disabled due to security issues. Leave it blank to avoid alerts.");
	});
}