<?php
/*
DESCRIPTION:
crea una nuova lega con admin l'utente che richiama la funzione
modulo richiamato via ajax

AUTHOR:
Giangravè L.

VERSION:
V 1.0 -> 07/09/15

*/



$UPLOAD_DIR = "../images/header_gare/";   
	if(isset($_FILES['file']))  { 
		$file = $_FILES['file']; 
		if($file['error'] == UPLOAD_ERR_OK and is_uploaded_file($file['tmp_name'])){ 
			if ($file["size"] > 0) { 
 				if (move_uploaded_file($file['tmp_name'], $UPLOAD_DIR.$file['name']))  
 					$inserimento_file=true;
				else
                $Errore = "Errore di inserimento file";
 			} else
         		$Errore = "Errore di inserimento file"; 
		}   
	} 		
	
include "../../db.inc";

include "../Function/Tool_leghe.php";

include "../JWT.php";

$id_utente=$_GET['id'];
$id_lega=$_GET['lega'];
$val=$_GET['val'];

if ($val==1 or $val==2){
	$Leagues=Conform_request($id_lega,$id_utente,$val);
	$json_o=json_decode($Leagues,true); 
	$i=0;
	foreach($json_o as $r){
		for (;$i< sizeof($r[Result]);$i++)
			 print '<div class="confirm_request">'.$r[Result][$i][Status].'</div>';
	}
}
?>