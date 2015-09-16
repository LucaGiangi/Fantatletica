<div class="snap-drawers">
    <div class="snap-drawer snap-drawer-left">
    	<div id="sinistra">
    		<form id="login" >
    			<input type="text" name="username" id="username" placeholder="Username...">
    			<input type="password" name="password" id="password" placeholder="Password...">
    			<input style="display:none" type="email" name="email" id="email" placeholder="Email...">
    		</form>
    		<div id="login-buttons">
    		<div id="loginbutton" class="login-button" style="border-right:1px solid #404040">Accedi</div>
    		<div id="registerbutton" class="login-button">Registrati</div>
    	</div>
    <!--<div id="fb-login"><fb:login-button scope="public_profile,email,user_friends, publish_stream" data-size="xlarge" data-show-faces="false" onlogin="checkLoginState();"></fb:login-button></div>-->
    <a class="fb" href="#" onclick="fb_login();"><div id="fb-login">Registrati con Facebook</div></a>
    <script>
    $(document).ready(function()
    {
    $( "#loginbutton" ).click(function() {
    var username = $( "#username" ).val();
    var password = $( "#password" ).val();
    $('#sinistra').load('http://www.atletipercaso.net/wp-content/themes/Iris/profile.php' , {username: username , password: password , action: 'login' }); 
    }); 
    
    var regvar = 0 ;
    
    $( "#registerbutton" ).click(function() {
    regvar = regvar + 1 ;
    if (regvar == 2) {
    var username = $( "#username" ).val();
    var password = $( "#password" ).val();
    var email = $( "#email" ).val();
    $('#sinistra').load('http://www.atletipercaso.net/wp-content/themes/Iris/profile.php' , {username: username , password: password , email: email , action: 'register'}); 
    } else {
    $( "#email" ).show( "slow");
    }
    
    }); 
    });
    </script>
    </div>
</div>

    
<div class="snap-drawer snap-drawer-right">
    <div id="latest-entries">
   		<h1>Programma gare</h1>
    
    <?php
   include 'formatta_data.php';   
	$q="SELECT * FROM Competizione order by Data_inizio LIMIT 0,7";
	$t=mysql_query($q,$connessione); 	
	while($r=mysql_fetch_object($t)){
		
		if ($r->Schedina==1) print '<div class="ischome_schedina">';else
		print '<div class="ischome">';
		print'
		<div class="evidenzia_gara1">
		<h3>'.$r->Nome.'</h3>
		</div>
		<span style="color:#000;">Data:<br/>'.formatta_data($r->Data_inizio).'<br/></span>
		</div>';
	}
	
    	?>
        
    </div>            
</div>