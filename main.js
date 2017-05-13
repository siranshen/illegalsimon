(function () {
var initialBgColor = $(".navbar-inverse").css("background-color"),
	initialBorder = $(".navbar-inverse").css("border"),
	navBarHeight = $(".nav").height(),
	marginTopOffset,
	navBarOptions,
	containerOffsets;

function setNavBar(bgColor, border, ifFadeIn) {
	$(".navbar-inverse").css({
		"background-color": bgColor,
		"border": border
	});
	
	if (ifFadeIn)
		$("#navbar form").fadeIn();
	else
		$("#navbar form").fadeOut();
}

function removeNavSelected() {
	$("#navbar li").each(function() {
		if ($(this).hasClass("selected"))
			$(this).removeClass("selected");
	});
}

function setMarginTopOffset() {
	if ($(window).width() < 768)
		marginTopOffset = 45;
	else
		marginTopOffset = 140;
}

function setContainerOffsets() {
	navBarOptions = [];
	containerOffsets = [];
	$("#navbar li a").each(function(i) {
		navBarOptions.push($(this).parent());
		if (i > 0)
			containerOffsets.push($($(this).attr("href")).offset().top - navBarHeight);
	});
}

function windowScroll() {
	var Y = window.scrollY;
	if (Y > marginTopOffset)
		setNavBar(initialBgColor, initialBorder, true);
	else
		setNavBar("transparent", "none", false);
	
	removeNavSelected();
	if (Y <= containerOffsets[0])
		navBarOptions[0].addClass("selected");
	else if (Y <= containerOffsets[1])
		navBarOptions[1].addClass("selected");
	else if (Y <= containerOffsets[2])
		navBarOptions[2].addClass("selected");
	else
		navBarOptions[3].addClass("selected");
	
    var windowTop = $(window).scrollTop();
    var windowBottom = windowTop + $(window).height();
    
	if (windowBottom > $(document).height() - 10) {
		removeNavSelected();
		navBarOptions[3].addClass("selected");
	}
    
    $(".media").each(function() {
        self = $(this);
        var top = self.offset().top;
        if (top >= windowTop && top + self.outerHeight() - 30 <= windowBottom) {
            self.animate({opacity: 1}, {duration: 400, queue: false});
        } else {
            self.animate({opacity: 0.4}, {duration: 400, queue: false});
        }
    })
}

function windowResize() {
	$("#home").animate(
		{"height": $(window).height()}, 
		function(){setContainerOffsets();}
	);
	setMarginTopOffset();
	setContainerOffsets();
}

function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(emailAddress);
};

function saveEmail(name, email, comment, btn) {
	$("#confirmBtn1, #confirmBtn2").attr("disabled", "disabled");
	$.ajax({
		method:"GET",
		url:"subscribe_php.php",
		data:"name="+name+"&email="+email+"&comment="+comment,
		dataType:"text"
	})
		.fail(function() {
			alert("Error!");
		})
		.done(function(data) {
			$("#confirmBtn1, #confirmBtn2").removeAttr("disabled");
			var result;
			switch (data) {
				case '1':
					result = null;
					break;
				case '2':
					result = "No good email...";
					break;
				case '3':
					result = "Already subscribed! Thanks!";
					break;
				case '4':
					result = "Sorry, failed to send the email.";
					break;
				case '5':
					result = "My database failed, sorry...";
					break;
				default:
					result = "PHP error!";
					break;
			}
			
			if (!btn) {
				if (!result)
					$("#alertEmail2").fadeIn();
				else
					$("#alertEmail1").text(result).fadeIn();
			} else {
				var popoverContent = $(btn).data('bs.popover').tip().find('.popover-content');
				if (!result)
					popoverContent.text("Success! Thank you!");
				else
					popoverContent.text(result);
			}
		});
}

window.onload = function() {
	$("#loader-wrapper").fadeOut();
	windowResize();
	windowScroll();
	setNavBar("transparent", "none");	
	window.onscroll = windowScroll;	
	window.onresize = windowResize;
	window.onrefresh = windowScroll;
	$('#confirmBtn2').popover();
	$('#wechat').tooltip();
	
	$("#navbar li").click(function() {
		removeNavSelected();
		$(this).addClass("selected");
		$("#navbar").collapse("hide");
	});
	
	$("#navbar li a").click(function() {
		var dest = $($(this).attr("href")).offset().top;
		$("html, body").animate({scrollTop:dest});
		return false;
	});
	
	$("#navbarBtn").click(function() {
		var bgc = $(".navbar-inverse").css("background-color");
		if ($(".navbar-inverse").css("background-color") != initialBgColor)
			setNavBar(initialBgColor, initialBorder, true);
	});
	
	$(".media-object").hover(
		function() {
			$(this).finish().animate({width: "+=3", height: "+=3"});
		},
		function() {
			$(this).finish().animate({width: "-=3", height: "-=3"});
		}
	);
    
    $(".contacts-image").hover(
        function() {
			$(this).finish().animate({width: "+=3", height: "+=3"});
		},
		function() {
			$(this).finish().animate({width: "-=3", height: "-=3"});
		}
    )
	
	$("#confirmBtn1").click(function() {
		var name = $("#subscriberName").val();
		var email = $("#subscriberEmail1").val();
		var comment = $("#subscriberComment").val();
		if (!isValidEmailAddress(email)) {
			$("#alertEmail2").hide();
			$("#alertEmail1").fadeIn();
			return;
		}
		
		$("#alertEmail1").hide();
		saveEmail(name, email, comment, null);
	});
	
	$("#confirmBtn1-h").click(function(e) {
		e.preventDefault();
		$("#confirmBtn1").click();
	});
	
	$("#closeAlertEmail1, #closeAlertEmail2").click(function() {
		$(this).parent().fadeOut();
	});
	
	$("#confirmBtn2").on("show.bs.popover", function() {
		var email = $("#subscriberEmail2").val();
		if (!isValidEmailAddress(email)) {
			$(this).attr("data-content", "Is this email right?");
			return;
		}
		
		saveEmail('', email, '', this);	
		$(this).attr("data-content", "Sending request...");
	});
};
}());