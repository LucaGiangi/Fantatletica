<?php
$page_name = "Read_schedina";
//versione 4.1 responsitive

//($_SESSION['id_competizione']!=-1)  usato per verificare la possibilità di modificare la squadra
session_start();

/*$data = date ("Y-m-d");*/
$data = date("Y/m/d G:i:s");
$data_1 = date("Y/m/d");

include "../../db.inc";
include "../../php/formatta_data.php"; 

include '../../php/Gestione_token.php';
include '../../php/verifica_accesso_g.php';
include "../../php/logout.php";

include '../../php/check_admin.php'; // verifica admin



//print $_GET['id'];
/* leggi dati schedina */
	$array_giocate = array();
	$array_risulati = array();
	$q="SELECT * FROM Schedina where Competizione_Id_competizione='".$_GET['id']."'";
	$t=mysql_query($q,$connessione); 	
	while($r=mysql_fetch_object($t)){		
		$array_giocate[1]=$r->Giocata1;
		$array_giocate[2]=$r->Giocata2;
		$array_giocate[3]=$r->Giocata3;
		$array_giocate[4]=$r->Giocata4;
		$array_giocate[5]=$r->Giocata5;
		$array_giocate[6]=$r->Giocata6;
		$array_giocate[7]=$r->Giocata7;
		$array_giocate[8]=$r->Giocata8;
		$array_giocate[9]=$r->Giocata9;
		$array_giocate[10]=$r->Giocata10;
		$array_giocate[11]=$r->Giocata11;
		$array_giocate[12]=$r->Giocata12;
		$array_giocate[13]=$r->Giocata13;
		$array_giocate[14]=$r->Giocata14;
		$array_giocate[15]=$r->Giocata15;
		$array_giocate[16]=$r->Giocata16;
		$array_giocate[17]=$r->Giocata17;
		$array_giocate[18]=$r->Giocata18;
		$array_risulati= explode(",",$r->Risultati);		
		}
		
		
		print'<h3>Compila</h3>
        <h5>3-4) Inserisci le giocate e inserisci i risultati</h5>';
		print '<h5>NOTA:Lo scontro deve essere nel formato Gara: Nome1 Vs Nome2</h5>';
		print'<form action="Admin_schedina.php"  style="max-width:2000px;width:100%;" method="post">';
		print'<table class="tab_el img_schedina" >
				<tr><th width="10%"></th><th width="60%">Scontro</th><th width="30%" colspan="4" >Giocata</th></tr>';
		$riga=false;
		for($i=1;$i<19;$i++){
			if ($i==14)
				print'</table><h3>Riserve</h3><table class="tab_el schedina">
            			<tr><th width="10%"></th><th width="60%">Scontro</th><th width="30%" colspan="4" >Giocata</th></tr>';
			
			
			if ($riga){print '<tr class="pari">';} else {print '<tr class="dispari">';}
			print'<td>'.$i.'</td>
					<td>
						<input style="width:100%;" id="input'.$i.'" value="'.$array_giocate[$i].'" name="input'.$i.'" type="text"/>
					</td>
					<td>
						<input  type="radio" id="radio-'.$i.'-1" name="radio-'.$i.'-set" value="1" '; if ($array_risulati[$i-1]=='1') print 'checked'; print' class="regular-radio big-radio" />
						<label for="radio-'.$i.'-1">1</label>
					</td>
					<td>
						<input type="radio" id="radio-'.$i.'-2" name="radio-'.$i.'-set" value="X" '; if ($array_risulati[$i-1]=='X') print 'checked'; print' class="regular-radio big-radio" />
						<label for="radio-'.$i.'-2">X</label>
					</td>
					<td>
						<input type="radio" id="radio-'.$i.'-3" name="radio-'.$i.'-set" value="2" '; if ($array_risulati[$i-1]=='2') print 'checked'; print ' class="regular-radio big-radio" />
						<label for="radio-'.$i.'-3">2</label>
					</td>
					<td>
						<input type="radio" id="radio-'.$i.'-4" name="radio-'.$i.'-set" value="NP" '; if ($array_risulati[$i-1]=='NP') print 'checked';print ' class="regular-radio big-radio" />
						<label for="radio-'.$i.'-4">Np</label>
					</td>
           		</tr>';		
			$riga=!$riga;	   
		}
		print'</table>';
		 
		print'<input type="hidden" name="Id_competizione" value="'.$_GET['id'].'"/><input type="hidden" name="conferma" value="ok"/>';
      	print'<input type="submit"  name="Invia" value="Invia" />';
		print'</form>';
    
?>