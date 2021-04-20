var agent=navigator.userAgent.toLowerCase();
var is_iphone = ((agent.indexOf('iphone')!=-1);
if (is_iphone) { conditional code goes here }


/*

if((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i))) {
	 if (document.cookie.indexOf("iphone_redirect=false") == -1) window.location = "http://m.espn.go.com/wireless/?iphone&i=COMR";
}

*/.



