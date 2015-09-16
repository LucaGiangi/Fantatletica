  // controlla se connesso per auto-login   parte in modo asincrono al caricamento dal modulo
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
	  //document.getElementById('fb-login').style.display = "none" ;
	  //document.getElementById('message').style.display = "none" ;
	  FB.api('/me', function(response) {
		  FB.api('/me', function(response) {
		  //$('#sinistra').load('/wp-content/themes/Iris/profile.php', {FBid: response.id , FBemail: response.email , action: 'facebook' });
		  // se sei loggato vai alla pagina giocatore
		  response.setHeader("Location", "fantatletica.html");
  	  });
  	  });
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
	  document.getElementById('fb-login').style.display = "block" ; /*tasti fb */
	  document.getElementById('message').style.display = "block" ;
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      document.getElementById('fb-login').style.display = "block" ;
	  document.getElementById('message').style.display = "block" ;
    }
  }
  
  // Post connessione 
  function newUser(response) {
    console.log('newUser');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
	  alert("Connessione con Facebook avvenuta con successo");
	  FB.api('/me', function(response) {
		//  $('#prova').load('www.atletipercaso.net/API/v1/createUser.php', {facebookID: response.id , email: response.email, firstname: response.first_name, lastname: response.last_name , birthday: response.birthday});
		 var refer=document.getElementById("nickname").value;
		 $('#prova').load('registrati.php', {facebookID: response.id , email: response.email, firstname: response.first_name, lastname: response.last_name , birthday: response.birthday,referral:refer, action:'facebook'}); 
  	  });
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      alert("Ci sono stati errori nella connessione, riprova.");
	  //$('#sinistra').load('/wp-content/themes/Iris/login.php')
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      alert("Loggati a Facebook per effettuare la connessione");
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
  	FB.getLoginStatus(function(response) {
  		newUser(response);
  	});
  }

  window.fbAsyncInit = function() {
    FB.init({
      appId      : '862884257090915',
      cookie     : true,  // enable cookies to allow the server to access 
                          // the session
      xfbml      : true,  // parse social plugins on this page
      version    : 'v2.1' // use version 2.1
    });

    // Now that we've initialized the JavaScript SDK, we call 
    // FB.getLoginStatus().  This function gets the state of the
    // person visiting this page and can return one of three states to
    // the callback you provide.  They can be:
    //
    // 1. Logged into your app ('connected')
    // 2. Logged into Facebook, but not your app ('not_authorized')
    // 3. Not logged into Facebook and can't tell if they are logged into
    //    your app or not.
    //
    // These three cases are handled in the callback function.

    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });

  };


  function fb_login(){
    FB.login(function(response) {
      FB.getLoginStatus(function(response) {
        newUser(response);
      });
    } , 
    {
        scope: 'public_profile,email,user_friends,user_birthday'
    });
  }

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/it_IT/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));