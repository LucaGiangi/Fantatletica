<?php

if ($page_name=="profile" || $page_name=="leagues" || $page_name=="regolamento") 
	print '<body class="body_sfondo1">'; 
else 
	print'<body>';

?>
<script type="text/javascript">
(function(e){if(!!e.cookieChoices){return e.cookieChoices}var t=e.document;var n="textContent"in t.body;var r=function(){function s(e,n,i,s){var o="position:fixed;width:100%;;background-color:rgb(255, 203, 5);"+"margin:0; left:0; bottom:0;padding:15px 0px 15px;z-index:1000;text-align:center;";var u=t.createElement("div");u.id=r;u.style.cssText=o;u.appendChild(a(e));if(!!i&&!!s){u.appendChild(l(i,s))}u.appendChild(f(n));return u}function o(e,n,i,s){var o="position:fixed;width:100%;height:100%;z-index:999;"+"bottom:0;left:0;opacity:0.5;filter:alpha(opacity=50);"+"background-color:#ccc;";var u="z-index:1000;position:fixed;left:50%;top:50%";var c="position:relative;left:-50%;margin-top:-25%;"+"background-color:#fff;padding:20px;box-shadow:4px 4px 25px #888;";var h=t.createElement("div");h.id=r;var p=t.createElement("div");p.style.cssText=o;var d=t.createElement("div");d.style.cssText=c;var v=t.createElement("div");v.style.cssText=u;var m=f(n);m.style.display="block";m.style.textAlign="right";m.style.marginTop="8px";d.appendChild(a(e));if(!!i&&!!s){d.appendChild(l(i,s))}d.appendChild(m);v.appendChild(d);h.appendChild(p);h.appendChild(v);return h}function u(e,t){if(n){e.textContent=t}else{e.innerText=t}}function a(e){var n="font:normal normal normal 16px/1.4em 'Roboto', 'Roboto grande', sans-serif;color: #000;line-height:30px; ";var r=t.createElement("span");r.style.cssText=n;u(r,e);return r}function f(e){var n="text-decoration:none;font-size:15px;font-weight:bold;font-family:Arial, Helvetica, sans-serif;color: #fff;background-color: #5cb85c;border:#4cae4c solid 1px;padding:10px;border-radius:15px;";var r=t.createElement("a");r.style.cssText=n;u(r,e);r.style.cssText=n;r.id=i;r.href="#";r.style.marginLeft="24px";return r}function l(e,n){var r="text-decoration:none;fon-size:15px;font-weight:bold;font-family:Arial, Helvetica, sans-serif;color: #fff;background-color: #d9534f;border:#d43f3a solid 1px;padding:10px;border-radius:15px;";var i=t.createElement("a");i.style.cssText=r;u(i,e);i.href=n;i.target="_blank";i.style.marginLeft="8px";return i}function c(){m();v();return false}function h(e,n,r,u,a){if(g()){v();var f=a?o(e,n,r,u):s(e,n,r,u);var l=t.createDocumentFragment();l.appendChild(f);t.body.appendChild(l.cloneNode(true));t.getElementById(i).onclick=c}}function p(e,t,n,r){h(e,t,n,r,false)}function d(e,t,n,r){h(e,t,n,r,true)}function v(){var e=t.getElementById(r);if(e!=null){e.parentNode.removeChild(e)}}function m(){var n=new Date;n.setFullYear(n.getFullYear()+1);t.cookie=e+"=y; expires="+n.toGMTString()}function g(){return!t.cookie.match(new RegExp(e+"=([^;]+)"))}var e="displayCookieConsent";var r="cookieChoiceInfo";var i="cookieChoiceDismiss";var y={};y.showCookieConsentBar=p;y.showCookieConsentDialog=d;return y}();e.cookieChoices=r;return r})(this);document.addEventListener("DOMContentLoaded",function(e){cookieChoices.showCookieConsentBar("Questo sito utilizza cookie tecnici per consentire la fruizione ottimale del sito. Se vuoi saperne di più o negare il consenso all'installazione di qualsiasi cookie clicca su Info. Chiudendo questo banner acconsenti all'uso dei cookie.","Accetto","Info","http://fantatletica.it/informativa.html")})
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script>$(document).ready(function(){$(".btn-responsive-menu").click(function() {$("#mainmenu").toggleClass("show");}); });</script>
<?php 
global $page_name;
global $team_creato;
global $C_token;
global $g_avatar;
?>

<?php // menu mobile 
print '
<div id="content" class="snap-content">
	<div id="head">
        <div class="btn-responsive-menu">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </div>';    
    
if(isset($_COOKIE[$C_token])){// mostra il menu solo se l'utente è loggato
	print '
		<div id="mainmenu" class="">
	 		<ul>
				<li><a href="profile.php">Home</a></li>
				<li><a href="profile.php?cod=esci">Logout</a></li>
				<li><a href="g-team_new.php">Gioca</a></li>			
				<li class="has-sub" ><a href="Regolamento.php">Regolamento</a>
					<ul class="nascondi">
						<li><a href="Regolamento.php#fanta">&nbsp;Fantatletica</a></li>
						<li><a href="Regolamento.php#schedina">&nbsp;Schedina</a></li>
					</ul>
				</li>
				<li><a href="Hall_of_fame.php">Hall of fame</a></li>	
			 </ul> 
		</div>';
}
			?>
       
		<a href="index.php"><h1>Fantatletica</h1></a>
	</div>

?>
<div class="header_utente">

	 <?php
	switch ($page_name){
		case "profile":
			print '<div style=" background:url(images/corsa.jpg);background-size:100%;background-position: center center;" class="copertina">';
			break;
		case "leagues":	
			print '<div style=" background:url(images/corsa.jpg);background-size:100%;background-position: center center;" class="copertina">';
			break;
		case "hall_of_fame":	
			print '<div style=" background:url(images/halloffame.jpg);background-size:100%;background-position: center center;" class="copertina">';
			break;
	}
    if ($page_name=="profile") print '<h2 class="name_level1">'.$g_nome.'</h2><h3>livello:1</h3>';
	?>
    </div>
    
    <?php
	if ($page_name=="profile")
		print'
			<div class="notifiche">
				<div class="call_action_contenuto" style="text-align:center;">
					<h2 class="name_level">'.$g_nome.'</h2><h3>livello:1<br/></h3>
				</div>
			</div>';
    ?>
    
    <div class="header_m">
    	 <?php 
	
	print '<div id="toolbar">
		<div id="menu" >
        	<div class="menu-principale-container contenuto">';          
                // stampa il menu desktop
			if(isset($_COOKIE[$C_token])){
				print '
					<div id="menu1"><div class="call_action_m">
						<div class="call_action_contenuto_m">
							<div class="dx_m_g">
            					<ul id="menu-principale" class="w_menu_g" >
									<li><a href="profile.php">Home</a></li>
									<li><a href="profile.php?cod=esci">Logout</a></li>
									<li><a href="g-team_new.php">Gioca</a></li>			
									<li class="has-sub" ><a href="Regolamento.php">Regolamento</a>
										<ul class="nascondi">
											<li><a href="Regolamento.php#fanta">&nbsp;Fantatletica</a></li>
											<li><a href="Regolamento.php#schedina">&nbsp;Schedina</a></li>
										</ul>
									</li>
									<li><a href="Hall_of_fame.php">Hall of fame</a></li>	
				 				</ul> 
							</div></div>       
						</div>
					</div>';}
				//include "php/headerMENU4_0.php"; 
                  
			print' </div>
         </div>
		<div id="expand">
			<a href="#" id="more"></a>
		</div>
	</div>';
	print '</div>';
	?> 
        
    <?php
	if ($page_name=="profile")// mostra avatar
		print '<div class="call_action_contenuto"><div style="background:url('.$g_avatar.') no-repeat;background-size:100% 100%;" class="avatar" ></div></div>';
	
    switch ($page_name){
		case "leagues":
			print '<div class="page_title"><h1>Leghe</h1></div>';
			break;
		case "regolamento":
			print '<div class="page_title"><h1>Regolamento</h1></div>';
			break;
		case "hall_of_fame":
			print '';
			break;		
	} 
    ?>
</div>

