<?php 
// versione 4
//$team_creato=false;
global $team_creato;
global $g_id;

$q="SELECT * FROM Team JOIN Iscritti ON Iscritti.Id_iscritti = Team.Iscritti_Id_iscritti where (Iscritti.Competizione_Id_competizione='".$_SESSION['id_competizione']."' and Team.Giocatore_Id_giocatore='".$g_id/*$_SESSION['g_id']*/."')";
							
$t=mysql_query($q,$connessione); 	
while($r=mysql_fetch_object($t)){$team_creato=true;}
?>