<?php	// verifica che il giocatore sia anche un amministratore (non si considerano i diritti*/

$verificato = false;
$q="select * from Ad_min where Id='".$g_id."'";

$t=mysql_query($q,$connessione); 	
while($r=mysql_fetch_object($t)){
	/*if ($r->Privilegi=="All")*/
	$verificato= true;
}

if (!$verificato) header('Location:login.php');
?>