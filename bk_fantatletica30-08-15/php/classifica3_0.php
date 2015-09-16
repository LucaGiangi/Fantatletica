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

$struttura_supporto=array();
$indice=0;

$riga = false; 
$trovato=false;
$posizione=1;
$atleti_inseriti=0;
$atleti_dainserire=2;

$posizione_me=0; /* contiene la posizione del giocatore corrente*/
$q="SELECT Id_giocatore,Punti,Nome_team FROM Giocatore where status='1'  order by Punti desc,Costo_team,N_team";//where Stringa!=''
/* 20/05/15  tolto where Stringa!='';
nel caso di nessuna giocata la tabella sarebbe vuota ; (mostrarla con tutti a zero non è considerato scorretto)
nel caso della gara è giusto mostrare l'utente a zero puni se non ha giocato 
DA VEDERE MEGLIO
*/
$t=mysql_query($q,$connessione); 
while($r=mysql_fetch_object($t) ){	

if(($r->Id_giocatore==$g_id)){//if(($r->Id_giocatore==$_SESSION['g_id'])){//
	$trovato=true;	
}

	if ($atleti_inseriti<5){
		$struttura_supporto[$indice]="";//$r->Avatar;
		$struttura_supporto[$indice+1]=$posizione;
		$struttura_supporto[$indice+2]=$r->Nome_team;
		$struttura_supporto[$indice+3]=$r->Punti;	
		$indice +=4;
		$atleti_inseriti++;	
		$posizione++;	
		if ($trovato) $atleti_dainserire=5-$atleti_inseriti;
	}else

 {
	$base=0;
	$base_due=$base+4;
	$struttura_supporto[$base]=$struttura_supporto[$base_due];
	$struttura_supporto[$base+1]=$struttura_supporto[$base_due+1];
	$struttura_supporto[$base+2]=$struttura_supporto[$base_due+2];
	$struttura_supporto[$base+3]=$struttura_supporto[$base_due+3];
    $base=4;
	$base_due=$base+4;
	$struttura_supporto[$base]=$struttura_supporto[$base_due];
	$struttura_supporto[$base+1]=$struttura_supporto[$base_due+1];
	$struttura_supporto[$base+2]=$struttura_supporto[$base_due+2];
	$struttura_supporto[$base+3]=$struttura_supporto[$base_due+3];
	$base=8;
	$base_due=$base+4;
	$struttura_supporto[$base]=$struttura_supporto[$base_due];
	$struttura_supporto[$base+1]=$struttura_supporto[$base_due+1];
	$struttura_supporto[$base+2]=$struttura_supporto[$base_due+2];
	$struttura_supporto[$base+3]=$struttura_supporto[$base_due+3];
	$base=12;
	$base_due=$base+4;
	$struttura_supporto[$base]=$struttura_supporto[$base_due];
	$struttura_supporto[$base+1]=$struttura_supporto[$base_due+1];
	$struttura_supporto[$base+2]=$struttura_supporto[$base_due+2];
	$struttura_supporto[$base+3]=$struttura_supporto[$base_due+3];
	
	$base=16;
	$struttura_supporto[$base]="";//$r->Avatar;
	$struttura_supporto[$base+1]=$posizione;
	$struttura_supporto[$base+2]=$r->Nome_team;
	$struttura_supporto[$base+3]=$r->Punti;	
	
	$posizione++;
	$atleti_inseriti++;	
	if ($trovato)$atleti_dainserire--;
 }
	if ($atleti_dainserire==0) break;
}

for($i=0;$i<20;$i=$i+4){
	
	if ($g_nome==$struttura_supporto[$i+2])/*$_SESSION['g_user']*/
	{print '<tr class="evidenzia">';}
	else
if ($riga){print '<tr class="pari">';} else {print '<tr class="dispari">';} 

/*if ($struttura_supporto[$i]=="") 
$Avatar = "images/profilo.jpg";
else
$Avatar = "images/atleti/".$struttura_supporto[$i];*/

//print'<td><img src="'.$Avatar.'" width="30" title="Profilo" /></td>';
print'<td style="text-align:center;">'.$struttura_supporto[$i+1].'</td>';
print'<td>'.$struttura_supporto[$i+2].'</td>';
print'<td style="text-align:center;">'.$struttura_supporto[$i+3].'</td>';

$riga = !$riga;	
}

print'</tbody>
</table>';
?> 