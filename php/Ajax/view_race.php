<?php


include "../../db.inc";

include "../Function/Read_Race.php";
include "../Create_raceRank.php";
include "../JWT.php";


function id_by_nome_utente($nome){
	global $connessione;
	$q="SELECT Id_giocatore from Giocatore where Nome_team='".$nome."'";
	$t=mysql_query($q,$connessione);
	while($r=mysql_fetch_object($t)){	
		return $r->Id_giocatore;
	}	
}

$id_view_gara=$_GET['id'];
$g_nome=$_GET['utente'];

if ($_GET['lega']!="")
	$id_league=$_GET['lega']; // classifica di una lega
else
    $id_league=NULL; // classifica generale
	        
print'<div class="gara">';
		
	$Race=Read_race($id_view_gara);
	$json_o=json_decode($Race,true); /* decodifico json */
	$i=0;
	foreach($json_o as $r){
		for (;$i< sizeof($r[Races]);$i++){
			print '<div class="sx_4col" style="background-color:transparent;"><img class="logo_gara" style="padding-right:20px; padding-bottom:20px;" src="../images/header_gare/'.$r[Races][$i][Header_link].'">
	</div><div class="dx_4col"><h2><articolo>'.$r[Races][$i][Nome].'</articolo></h2>
	<h3>Stato:'.$r[Races][$i][Stato_classifica].'</h3></div>';
		}	
	}
	print'
		<br/>
</div>

	<table id="rank" class="table">
		<thead><tr><th class="chart-rank">Rank<br></th><th>Nickname<br>NomeTeam</th><th class="chart-info">Punti<br></th><th class="chart-pos">Costo team<br></th><th class="chart-prev">Numero team<br></th></tr></thead>
		<tbody data-page="0">';
			
			$stringa_rank=Rank($id_league,$id_view_gara); // leggi punteggi atleti
			$json_o=json_decode($stringa_rank,true); /* decodifico json */
			foreach($json_o as $p){
				
				$punt=0;
				for ($i=0;$i< sizeof($p[Rank]);$i++)
					if ($g_nome==$p[Rank][$i][Nome]){$punt=$i; break;}
				
				$start=$punt-2;
				$end=3;
				
				if ($punt<2){$start=0;$end=(5-$punt);}
				
				if ($punt>sizeof($p[Rank])-3){$end=(sizeof($p[Rank])-$punt);$start=sizeof($p[Rank])-5;}
				
				
				for ($i=$start;$i< $end+$punt;$i++){
					$riga=!$riga;		
					if ($g_nome==$p[Rank][$i][Nome])/*$_SESSION['g_user']*/
						{print '<tr class="evidenzia">';}
					else
						print '<tr>';
						
						//print ($p[$i][username]);
					print '<td style="text-align:center">';
					if ($i==0) print '<img width="30px"  class="gold" src="images/gold.png">'; 
					if ($i==1) print '<img  width="27px" class="silver" src="images/silver.png">';
					if ($i==2) print '<img  width="24px" class="bronze" src="images/bronze.png">';
					
					if ($i>2) print ($i+1)."&deg;"; 
					print'</td><td><div class="title">';
					if ($id_league!=NULL) print '<a href="#team" onclick="view_team('.$id_view_gara.','.id_by_nome_utente($p[Rank][$i][Nome]).')">';
					print $p[Rank][$i][Nome];
					if ($id_league!=NULL) print '</a>';
					print '</div><div class="subtitle"></div></td>';
					print '<td style="text-align:center">'.$p[Rank][$i][Punti].'</td>';
					print '<td style="text-align:center">'.$p[Rank][$i][Costo].'</td>';
					print '<td style="text-align:center">'.$p[Rank][$i][Numero].'</td>';
					print'</tr>';	
					//$i++;	
				}
			}


		print'</tbody>
	</table>';
print'<a href="raceRank.php?id='.$id_view_gara.'"><span class="budget">Classifica completa</span></a>';
print'</div> 
</div>';
?>