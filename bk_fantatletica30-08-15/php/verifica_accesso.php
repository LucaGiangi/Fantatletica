<?php	//verifica accesso pagine riservate

$verificato = false;
$q="select * from Ad_min where Id='".$g_id."'";
print $q;
$t=mysql_query($q,$connessione); 	
while($r=mysql_fetch_object($t)){
	if ($r->Privilegi=="All")
		$verificato= true;
}

if (!$verificato) header('Location:login.php');
?>