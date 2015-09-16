<?php

include "db.inc";
$posizione= array();
$id_comp =$_GET['id'];
function ContaPunti($Puntata,$Risultati){
	$vet_puntata = array();
	$vet_risultati = array();	
	$vet_puntata = explode(",",$Puntata);
	$vet_risultati = explode(",",$Risultati);
	
	$Giocate_vinte=0; // conta pronostici azzeccati
	$Giocate_calcolate=0; //calcola giocate valide
	
	for($i=0;$i<18;$i++){
		
		if ($Giocate_calcolate<13) 	
			   if ($vet_risultati[$i]!='NP'){ // verifica che la giocata sia valida
					$Giocate_calcolate++;	
					if ($vet_puntata[$i]==$vet_risultati[$i])
						$Giocate_vinte++;
				}	
	}
	return $Giocate_vinte; /* ritorna puntate vinete */
}

for ($i=0;$i<14;$i++)
	$posizione[$i]=array();

$q="select Giocate.Puntata,Giocate.Giocatore_Id_giocatore,Schedina.Risultati,Giocatore.Nome_team from Giocate JOIN Schedina on Giocate.Competizione_Id_competizione=Schedina.Competizione_Id_competizione JOIN Giocatore on Giocatore.Id_giocatore=Giocate.Giocatore_Id_giocatore where Giocate.Competizione_Id_competizione='".$id_comp."'";
		
	$t=mysql_query($q,$connessione); 
	while($r=mysql_fetch_object($t)){
		
		print ContaPunti($r->Puntata,$r->Risultati).'<br/>';
		$posizione[ContaPunti($r->Puntata,$r->Risultati)][] = "prova1";
	}


for($i=0;$i<18;$i++){
	for($j=0;$j<count($posizione[$i]);$j++)
		print $posizione[$i][$j].' ';
	print '<br/>';
}
?>