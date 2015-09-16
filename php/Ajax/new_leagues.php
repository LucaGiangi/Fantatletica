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

include "../../db.inc";
include "../Function/Tool_leghe.php";
include "../JWT.php";

$nome=$_GET['name'];
$id=$_GET['id'];

/*
come immagine della lega scelgo sempre prima l'immagine selezionata dall'elenco.
se non è stata selezionata alcuna foto verifico se è stato scelto un file esterno.
se nessuna delle due opzioni è stata scelta imposto la foto di default.

il nuovo file viene rinominato col nome della lega. i nomi delle leghe sono unici quindi non ci sono conflitti di nome nemmno sui file

*/
//if ($_GET['select_file']!="") $file=$_GET['select_file'];// file già presente
//else if ($_GET['nome_file']!="") $file=$nome; // l'immagine da inserire è nuova quindi il nome del file prende il nome della lega
//	else
	
$file="Ico_league"; // carico il file di dafualt


$status=Add_leghe($id,$nome,$file);
$json_o=json_decode($status,true); /* decodifico json */
$i=0;

foreach($json_o as $r){
	for (;$i< sizeof($r[Result]);$i++)
		if ($r[Result][$i][Cod]==0){
			 print "La lega è stata creata";
		}
		else if ($r[Result][$i][Cod]==-2) print "Il nome non è disponibile";
			else print "Errore";
}
?>