<?php
//verifica che chi stia accedendo sia un admin coi privilegi richiesti dalla pagina

function Check_privilegi_admin($_id,$_privilegi){
	include '../db.inc';
	$array=explode(",",$_privilegi);	
	$q="SELECT * FROM Ad_min where Id='".$_id."'";	
	$t=mysql_query($q,$connessione); 	
	while($r=mysql_fetch_object($t)){
		for ($i=0;$i<count($array)-1;$i++)
			if ($array[$i]== $r->Privilegi)
				return true;		
	}
	return false;
}

?>