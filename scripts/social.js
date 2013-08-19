// Additional JS functions here

var app = {
	uri:	"//" + window.location.hostname,
	id:		'1404888123068033'
};

// https://developers.facebook.com/docs/facebook-login/getting-started-web/

window.fbAsyncInit = function() {
	FB.init({
		appId      : app.id, // App ID
		channelUrl : app.uri + '/channel.html', // Channel File
		status     : true, // check login status
		cookie     : true, // enable cookies to allow the server to access the session
		xfbml      : true  // parse XFBML
	});
	FB.getLoginStatus(function(response) {
		//console.dir(response);

		var login = document.getElementById("login");
		login.onclick = null;

		if (response.status === 'connected') {
			// the user is logged in and has authenticated your
			// app, and response.authResponse supplies
			// the user's ID, a valid access token, a signed
			// request, and the time the access token
			// and signed request each expire
			// var uid = response.authResponse.userID;
			// var accessToken = response.authResponse.accessToken;
			login.innerHTML = "Connected to Facebook.";
		} else if (response.status === 'not_authorized') {
			// the user is logged in to Facebook,
			// but has not authenticated your app
			login.innerHTML = "Logged in to Facebook.";
		} else {
			// the user isn't logged in to Facebook.
			var link = document.createElement("a");
			link.setAttribute("href", "https://www.facebook.com/dialog/oauth?client_id=" + app.id + "&redirect_uri=" + window.location.protocol + app.uri);
			link.className = "btn btn-primary";
			link.innerHTML = '<i class="icon icon-facebook-sign"></i> Login with Facebook';
			login.className = login.className + " active";
			login.appendChild(link);
		}
	});
};

// Load the SDK asynchronously
(function(d){
	var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
	if (d.getElementById(id)) {return;}
	js = d.createElement('script'); js.id = id; js.async = true;
	js.src = "//connect.facebook.net/en_US/all.js";
	ref.parentNode.insertBefore(js, ref);
}(document));

// Google Analytics
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-1575455-10', 'paulgueller.com');
ga('send', 'pageview');
