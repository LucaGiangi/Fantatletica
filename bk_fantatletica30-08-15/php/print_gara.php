<?php 
/*
stampa le iscrizioni per la gara passata come parametro
PARAM: variabile get 'gara'

il modulo è richiamato tramite ajax
*/
session_start();
include "../db.inc";
include 'API_getAvatarByName.php';

$n_letti="";
$c_letti="";
/* ripulisci nome gara da caratteri speciali */
$gara=str_replace("’","&rsquo;",$_GET['gara']);

$id_comp =$_SESSION['id_competizione'];
if ($_GET['id']!="") 
	$id_comp=$_GET['id'];

$q="SELECT * FROM Iscritti JOIN Atleti ON Iscritti.Atleti_id_atleti = Atleti.Id_Atleta where (Competizione_Id_competizione='".$id_comp."' and (Gara_Gara1='".$gara."' or Gara_Gara2='".$gara."')) ORDER BY Atleti.Cognome";

/* da modificare quando si ha tempo e voglia. creare stringhe per API di lettura avart */
	$t=mysql_query($q,$connessione); 	
				while($r=mysql_fetch_object($t)){
					
					
					$nn_letto=str_replace("&rsquo;","'",$r->Nome);
					$cc_letto=str_replace("&rsquo;","'",$r->Cognome);
					
					$n_letti=$n_letti.ucwords(strtolower($nn_letto)).",";
					$c_letti=$c_letti.ucwords(strtolower($cc_letto)).",";
				}
				$n_letti=substr($n_letti,0,strlen($n_letti)-1);
				$c_letti=substr($c_letti,0,strlen($c_letti)-1);
				/*print $n_letti;
				print "<br/>".$c_letti;*/
				
				
				
				//getAvatarByName($n_letti,$c_letti);   tolto per partita dei mondiali 16/08/15
				
				
				
	//	for ($i=0;$i< sizeof($array_avatar);$i++)
	//print '<img src="'.$array_avatar[$i].'"/>';	
/* ****** */
	print '<table class="tab_el" id="0"><tbody><tr><th width="13%">Naz.</th><th width="55%">Nome atleta</th><th width="10%">Costo</th><th width="20%">2°Gara</th></tr> ';	
							
								$i=0; // contatore array avatar
								$t=mysql_query($q,$connessione); 	
								while($r=mysql_fetch_object($t)){
									
									  if ($riga){print '<tr class="pari">';} else {print '<tr class="dispari">';}	
											//print'<td><!--<img src="images/Flags/'.$r->Nationality.'.png" title="'.$r->Nationality.'" alt="'.$r->Nationality.'"/>--></td>';	
									  
									  $Avatar =$array_avatar[$i]; //getAvatarByName($r->Nome,$r->Cognome);//"images/default_avatar.png";//
									  $i++;
									  print'<td><!--<img   src="'.$Avatar.'"   title="Profilo" />--><img src="images/Flags/'.$r->Nationality.'.png" title="'.$r->Nationality.'" alt="'.$r->Nationality.'"/></td>';
									  print'<td class="ath_name"><a href="javascript:void(0)" onclick="accoda(';print "'";print $r->Cognome." ".$r->Nome;
									  print "',"; print "'";
									  
									  if ($gara==$r->Gara_Gara1){/* crea evento a seconda della gara */
									  		//print $r->Costo_gara1;print "',";print "'"; print $Avatar; print "',"; print "'";
											print $r->Costo_gara1;print "',";print "'images/Flags/".$r->Nationality.".png',"; print "'";  
									  		print $r->Gara_Gara1;print "',"; print "'";	print $r->Id_iscritti; print "'";}
									  else{
											//print $r->Costo_gara2;print "',";print "'"; print $Avatar; print "',"; print "'"; 
									  		print $r->Costo_gara2;print "',";print "'images/Flags/".$r->Nationality.".png',"; print "'"; 
											
											print $r->Gara_Gara2;print "',"; print "'";	print $r->Id_iscritti; print "'"; 	  
									  }
									print')"><strong>'.$r->Cognome.'</strong> '.$r->Nome.'</a></td>';   //termina riga
									
									/* stampa la seconda gara */
									if ($gara==$r->Gara_Gara1){
										print'<td style="text-align:right;">'.$r->Costo_gara1.'</td>';
										print '<td>'.$r->Gara_Gara2.'</td>';
									}else{
										print'<td style="text-align:right;">'.$r->Costo_gara2.'</td>';
										print '<td>'.$r->Gara_Gara1.'</td>';
									}
									print'</tr>';

							$riga = !$riga;}							
?>