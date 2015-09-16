<?php
/* restituisce la classficia dei giocatori */
/* versione 1.0 09/07/2015 */
function insertionSort(array $array) {
	$length=count($array);
	for ($i=1;$i<$length;$i++) {
		$element=$array[$i];
		$j=$i;
		while($j>0 && compare1($array[$j-1],$element)) {
			//move value to right and key to previous smaller index
			
			$array[$j]=$array[$j-1];
			$j=$j-1;
			}
		//put the element at index $j
		$array[$j]=$element;
		}
	return $array;
}
function compare1($v1,$v2){
	if ($v1['Punti']<=$v2['Punti'])
		if($v1['Punti']==$v2['Punti'])
			if ($v1['Costo']<=$v2['Costo'])
				if ($v1['Costo']==$v2['Costo'])
					return $v1['Numero']>=$v2['Numero'];
				else
					return false;
			else
				return true;
		else
			return true;
	else
		return false;
	
}
	
function Rank($Id_lega,$Id_gara){
	//include "db.inc";
	//include "JWT.php";
	global $connessione;
	$Array_giocatore=array();
	
	if ($Id_lega==NULL)
		$q="SELECT Id_giocatore from Competizione 
join Iscritti on Iscritti.Competizione_Id_competizione=Competizione.Id_competizione 
join Team on Iscritti.Id_iscritti=Team.Iscritti_id_iscritti
join Giocatore on Giocatore.Id_giocatore=Team.Giocatore_Id_giocatore
where Competizione.Id_competizione='".$Id_gara."' group by Team.Giocatore_Id_giocatore order by Nome_team"; /* classifica completa */
	else
	{$q="SELECT Giocatore.Id_giocatore from Competizione 
join Iscritti on Iscritti.Competizione_Id_competizione=Competizione.Id_competizione 
join Team on Iscritti.Id_iscritti=Team.Iscritti_id_iscritti
join Giocatore on Giocatore.Id_giocatore=Team.Giocatore_Id_giocatore
join Lega_memb on Lega_memb.Id_giocatore=Giocatore.Id_giocatore
where (Competizione.Id_competizione='".$Id_gara."' and Lega_memb.Lega_Id_lega='".$Id_lega."') group by Team.Giocatore_Id_giocatore order by Nome_team";		
		}

	$t=mysql_query($q,$connessione); 		
	while($r=mysql_fetch_object($t)){	
		$Array_giocatore[]=$r->Id_giocatore;
	}
	//	$Array_giocatore[] contiene tutti gli id che ci interessano
	$Array_Rank=array();
	
	for($i=0;$i<count($Array_giocatore);$i++){
		
		$q="CALL Count_PointForPlayer (".$Array_giocatore[$i].",".$Id_gara.",@Punti,@N_team,@Costo_team,@Nome);";
		$t=mysql_query($q,$connessione); 	
		$q=" SELECT @Punti as Punti,@N_team as Numero,@Costo_team as Costo,@Nome as Nome";
		$t=mysql_query($q,$connessione);
		while($r=mysql_fetch_object($t)){	
			$Array_Rank[]= array('Nome' => $r->Nome , 'Punti' => $r->Punti, 'Costo'=>$r->Costo, 'Numero' => $r->Numero);	
		}		
	}

	$Array_Rank=insertionSort($Array_Rank);
	
	$Array_Rank1[] =array('Rank' => $Array_Rank );	
	$json=json_encode($Array_Rank1,true);

	return $json;
	//print $json;
}

//echo Rank(NULL,17);


?>