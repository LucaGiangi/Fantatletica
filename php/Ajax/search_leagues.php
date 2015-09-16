<?php
/*
DESCRIPTION:
restituisce lelenco delle leghe il cui nome contiene $nome 
modulo richiamato via ajax

AUTHOR:
Giangravè L.

VERSION:
V 1.0 -> 06/09/15

*/
include "../../db.inc";
include "../Function/Tool_leghe.php";
include "../JWT.php";

$nome=$_GET['name'];

$Leagues=search($nome);

$json_o=json_decode($Leagues,true); /* decodifico json */
$i=0;
foreach($json_o as $r){
	for (;$i< sizeof($r[Leghe]);$i++){
		print'<div onclick="confirm_request('.$r[Leghe][$i][Id].');" class="lega" >
				<img class="lazy" src="images/default_league.png" data-original="'.$Avatar.'"  title="Profilo" />
				<div class="lega_info">
					<p class="lega_nome1">'.$r[Leghe][$i][Nome].'</p>
					<p class="lega_tool"><i>Invia richiesta</i></p>			
				</div>
				<div class="confirm_request" id="'.$r[Leghe][$i][Id].'"></div>
			</div>';
	}
}
if ($i==0)	print '<span>Nessuna corrispondenza trovata</span>';     
?>