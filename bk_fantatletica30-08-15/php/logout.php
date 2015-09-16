<?php
// esci dalla sezione riservata
if ($_GET['cod']=="esci"){
	//session_destroy();
	setcookie($C_token,NULL, time()-3600,"/");
	header('Location:index.php');	
}

?>