<?php
/* CLASSIFICA A 5 RIGHE
VER 3_0;

PER MOSTRARE LE 5 RICHE SI USA UNA FINESTRA SU UN ARRAY CHE CONTIENE 4 COMPONENTI PER GIOCATORE

PER IL CORRETTO FUNZIONAMENTO BISOGNA RESETTARE IL CAMPO 'Stringa' del giocatore
*/
global $g_id;
global $g_nome;

print'<table class="tab_el"> 
<tbody>
<tr>
<!--<th width="10%">Avatar</th>-->
<th width="7%">Posizione</th>
<th width="55%">Nome team</th>
<th width="8%">Punti</th>
</tr>';

$stringa_rank=Rank(NULL,21); // leggi punteggi atleti

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
			if ($riga){print '<tr class="pari">';} else {print '<tr class="dispari">';}
			//print ($p[$i][username]);
		print '<td style="text-align:center">';
		if ($i==0) print '<img width="15px"  class="gold" src="images/gold.png">'; 
		if ($i==1) print '<img  width="15px" class="silver" src="images/silver.png">';
		if ($i==2)  print '<img width="15px" class="silver" src="images/bronze.png">';// print '<img  class="bronze" src="images/bronze.png">';
		
		if ($i>2) print ($i+1)."&deg;"; 
		print'</td><td>'.$p[Rank][$i][Nome].'</td>';
		print '<td style="text-align:center">'.$p[Rank][$i][Punti].'</td>';
		print'</tr>';	
		//$i++;	
	}
}



print'</tbody>
</table>';
?> 