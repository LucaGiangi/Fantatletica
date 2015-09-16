<?php
/* verifica risultati schedina */
function verifica_schedina($id_schedina,$Mail,$Id_giocatore){

	$Risultati = array();
	$Giocata = array();
	/*Recupero informazioni*/
	$q="SELECT Risultati FROM Schedina where (Competizione_Id_competizione='".$id_schedina."')";
	$t=mysql_query($q,$connessione); 	
	while($r=mysql_fetch_object($t))
		$Risultati = explode(",", $r->Risultati);
	
	if ($Mail!="")
		$q="SELECT Puntata FROM Giocate where (Mail='".$Mail."')";
	else
		$q="SELECT Puntata FROM Giocate where (Giocatore_Id_giocatore='".$Id_giocatore."')";
	$t=mysql_query($q,$connessione); 	
	while($r=mysql_fetch_object($t))
		$Giocata = explode(",", $r->Puntata);
	
	/* calcola puntate vinte*/
	$Giocate_calcolate=0; //	conta le partite considerate
	$Giocate_vinte=0;     //	conta le partite vinte
	$i=0;
	
	while ($Giocate_calcolate<=13){
		
		if ($Risultati[$i]!="NP"){ // verifica che la giocata sia valida
			$Giocate_calcolate++;	
			if ($Risultati[$i]==$Giocata[$i])
				$Giocate_vinte++;
		}
		$i++;	
	}
	if ($Giocate_vinte==13)
		return true;
	else
		return false;
}


/**/

$q="SELECT Mail,E_Mail,Id_giocatore from Giocate left join Giocatore on Giocatore.Id_giocatore=Giocate.Giocatore_Id_giocatore where Competizione_Id_competizione='".$id_schedina."'";	
			$t=mysql_query($q,$connessione); 	
			while($r=mysql_fetch_object($t)){
				
				if (verifica_schedina($id_schedina,$r->Mail,$r->Id_giocatore))
					print $r->Mail."	".$r->Id_giocatore;
				
			}

?>