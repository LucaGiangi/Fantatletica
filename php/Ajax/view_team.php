<?php


include "../../db.inc";

include "../Function/Read_Race.php";
include "../Create_raceRank.php";
include "../JWT.php";
include "../API_getAvatarByName.php";
$Id=$_GET['id'];
$g_id=$_GET['utente'];


print '<div class="titolo"><hh2>Team</hh2></div>';	
            $q="SELECT * FROM Team 
                    JOIN Iscritti ON Iscritti.Id_iscritti= Team.Iscritti_Id_iscritti
                    JOIN Atleti ON Iscritti.Atleti_id_atleti = Atleti.Id_Atleta where (Team.Giocatore_Id_giocatore='".$g_id."' and Iscritti.Competizione_Id_competizione='".$Id."') order by Capitano";
            $t=mysql_query($q,$connessione); 	
            while($r=mysql_fetch_object($t)){
                getAvatarByName($r->Nome,$r->Cognome);
                $Avatar = $array_avatar[0];
                if ($r->Capitano==0){							
                            print'<div class="ischomeiscritti">';	
							print '<div class="team_name_race">'.$r->Prima_gara.'</div>
							<div class="bandiera" ><img src="images/Flags/'.$r->Nationality.'.png"/></div>
							<img class="lazy" src="images/default_avatar.png" data-original="'.$Avatar.'"  title="Profilo" />
							<div class="team_info">
											<p class="team_nome1">'.$r->Cognome.'</p>
											<p class="team_nome1">'.$r->Nome.'</p>
											<p class="team_tool">Capitano</p>
							</div>';                      	
                        if ($r->Prima_gara==$r->Gara_Gara1 && $r->Risultato_punti!=0) print '<div class="team_name_race">'.($r->Risultato_punti*2).' Punti</div>';
                        if ($r->Prima_gara==$r->Gara_Gara2 && $r->Risultato_classifica!=0) print '<div class="team_name_race">'.($r->Risultato_classifica*2).' Punti</div>';
                        print'</div>';
                }
                else{	
                        print'<div class="ischomeiscritti">';	
							print '<div class="team_name_race">'.$r->Prima_gara.'</div>
							<div class="bandiera" ><img src="images/Flags/'.$r->Nationality.'.png"/></div>
							<img class="lazy" src="images/default_avatar.png" data-original="'.$Avatar.'"  title="Profilo" />
							<div class="team_info">
											<p class="team_nome1">'.$r->Cognome.'</p>
											<p class="team_nome1">'.$r->Nome.'</p>
											<p class="team_tool">i</p>
							</div>';                      	
                        if ($r->Prima_gara==$r->Gara_Gara1 && $r->Risultato_punti!=0) print '<div class="team_name_race">'.$r->Risultato_punti.' Punti</div>';
                        if ($r->Prima_gara==$r->Gara_Gara2 && $r->Risultato_classifica!=0) print '<div class="team_name_race">'.$r->Risultato_classifica.' Punti</div>';
                        print'</div>';
                    }
            }
?>