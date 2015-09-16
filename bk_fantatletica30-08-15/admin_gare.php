<?php
$page_name = "admin_gare";
//versione 3.0

session_start();
include "db.inc";

$Errore ="";
// esci dalla sezione admin
if ($_GET['cod']=="esci"){
	session_destroy();
	header('Location:index.php');	
}

include 'php/verifica_accesso.php';
include 'php/fun.php';
//**************************
// gestione gare
	//inserisci-modifica
if ($_POST['Conferma']=="Conferma"){

	if ($_POST['id']=="")
	$q="INSERT into Competizione values (null,'".$_POST['nome']."','".$_POST['luogo']."','".$_POST['data']."','".$_POST['data']."','".$_POST['inizio']."','".$_POST['fine']."','".$_POST['link']."','','".$_POST['budget']."','0',default)";
	else
	$q="UPDATE Competizione SET Nome='".$_POST['nome']."',Sede='".$_POST['luogo']."',Data_inizio='".$_POST['data']."',Inizio_formazione='".$_POST['inizio']."',Termine_formazione='".$_POST['fine']."',Budget='".$_POST['budget']."',Link_sito_1='".$_POST['link']."' where Id_competizione='".$_POST['id']."'"; ////  da modificare
	

	if(!mysql_query($q,$connessione)) 
	$Errore = "Errore di inserimento/modifica";
}
//elimina gare
if ($_POST['Elimina']=="Si"){
	$q ="DELETE FROM Competizione where Id_competizione='".$_POST['id']."'";
	if(!mysql_query($q,$connessione)) 
	$Errore = "Errore di eliminazione";
}

//visualizza dati competizione (variabili definite qui)
$Nome = "";
$Sede = "";
$Data_inizio= "";
$Data_fine= "";
$Inizio_formazione= "";
$Termine_formazione= "";
$Link_sito_1 = "";
$Budget = "";
if ($_GET['id']!=""){
	$q="select * from Competizione where (Id_competizione='".$_GET['id']."')";
	$t=mysql_query($q,$connessione); 	
	while($r=mysql_fetch_object($t)){
		$Nome = $r->Nome;
		$Sede = $r->Sede;
		$Data_inizio= $r->Data_inizio;
		$Data_fine= $r->Data_fine;
		$Inizio_formazione= $r->Inizio_formazione;
		$Termine_formazione= $r->Termine_formazione;
		$Link_sito_1 = $r->Link_sito_1;
		$Budget = $r->Budget;
	}
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Atletipercaso.net -Il Gioco</title>

<meta name="author" CONTENT="Luca Giangravè, Federica Chiappori"/>
<meta name="robots" content="noindex"/>
   <link rel="stylesheet" href="css/menu.css" type="text/css" media="screen" /> 
<link rel="stylesheet" href="css/default/default.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/nivo-slider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/input.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/tabelle.css" type="text/css" media="screen" />
         <link rel="stylesheet" href="css/atleti.css" type="text/css" media="screen" />  
         
      
<link rel="shortcut icon" href="images/Tool/ico.ico"/>
</head>

<body>


<?php include 'php/header3_0.php';?>   


<div class="newcorpo">
    <div class="contenuto">
    
    <!--       *****  --->
    <h1>Manifestazioni in programma</h1>
                <table width="100%" class="tab_el">  
                                            <tbody><tr>
                                                <th width="10%">Tool</th>
                                                <th width="40%">Nome</th>
                                                <th width="30%">Luogo</th>
                                                <th width="20%">Data</th>
                                            </tr>   
            
                    <?php
                    $riga = false;
                    $q="select * from Competizione";
                    $t=mysql_query($q,$connessione); 	
                    while($r=mysql_fetch_object($t)){		   
                        if ($riga){print '<tr class="pari">';} else {print '<tr class="dispari">';}	
                        print'<td><a href="admin_gare.php?id='.$r->Id_competizione.'"><img src="images/Edit.png" width="30" ></a></td>';	  
                        print'<td>'; print $r->Nome; print '</td>';
                        print'<td>'; print $r->Sede; print '</td>';
                        print'<td>'; print $r->Data_inizio; print '</td>';
                        print'</tr>';
                        $riga = !$riga;
                    }
                    ?>	
                    
                    </tbody>
                    </table>   
                 
    <br />
    
    <!-- *********** -->
        <div class="parziale">

           <!-- **** -->
           <h2><img src="images/Edit.png" />Gestione manifestazione</h2>    

                            <form action="admin_gare.php" method="post">
                            <input type="hidden" name="id" value="<?php print $_GET['id'];  ?>"/> 
                            <table>
                        <tr><td><label>Data</label></td><td> <input type="date" name="data" <?php if ($Data_inizio!="") print'value="'.$Data_inizio.'"';  ?>  /></td> </tr>
                        <tr><td><label>Luogo</label></td><td><input type="text" name="luogo" required="required" <?php if ($Sede=="") print'placeholder="Luogo manifestazione"'; else print'value="'.$Sede.'"';     ?> /> </td></tr>
                        <tr><td><label>Nome</label></td><td ><input type="text" name="nome" required="required"<?php if ($Nome=="") print'placeholder="nome manifestazione"'; else print'value="'.$Nome.'"';     ?> /> </td></tr>
                        <tr><td><label>Inizio</label></td><td><input type="date" name="inizio" <?php if ($Inizio_formazione!="") print'value="'.$Inizio_formazione.'"';  ?>   /></td></tr>
                        <tr><td><label>Fine</label></td><td><input type="date" name="fine" <?php if ($Termine_formazione!="") print'value="'.$Termine_formazione.'"';  ?>  /></td></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr><td><label>Budget disponibile</label></td><td> <input type="number" <?php if ($Budget=="") print'placeholder="Budget disponibile"'; else print'value="'.$Budget.'"';     ?> required="required" name="budget" /></td></tr>
                         
                        <tr><td> <label>Link</label> </td><td><input type="url" name="link" <?php if ($Link_sito_1=="") print'placeholder="Link utile"'; else print'value="'.$Link_sito_1.'"';     ?>  /></td></tr>
                                    
                        <tr id="ad_chiedi">
                        <td> <input type="submit" value="Conferma" name="Conferma" /></td><td> <input type="button" onclick="javascript:mostra()" value="Elimina" name="elimina" /></td>
                        </tr>
                        
                        <tr id="ad_conferma" style="display:none;">
                        <td><span class="budget">Confermi?</span><input type="submit" value="Si" name="Elimina" />
                        <input type="submit" value="Annulla" onclick="javascript:nascondi()" name="Elimina" /></td>
                        </tr>
                        </table>
                        </form>

           <!-- **** -->    
       <!-- ** -->
        </div> <!-- parte di sinistra --> 
        
          
        <div class="parziale1">
     		<?php include 'php/admin-menu3_0.php';?>
            
               <h2>News</h2>
  			<span>Lo staff di atletipercaso.net - il gioco ti augura buon divertimento!</span>
            
      <!-- **** -->
       <h2>Admin</h2>
                    <table class="tab_el">
                        <tbody>
                        <tr>
                            <th width="15%">Tool</th>
                            <th width="45%">Nome</th>
                            <th width="15%">Privilegi</th>
                        </tr>
                                            
                    <?php
                    $riga = false;
                    $q="select * from Ad_min";
                    $t=mysql_query($q,$connessione); 	
                    while($r=mysql_fetch_object($t)){	
                    
                        if ($riga){print '<tr class="pari">';} else {print '<tr class="dispari">';}
                        print'<td><a href="admin_home.php?id='.$r->Id.'"><img src="images/Edit.png" width="30" ></a></td>';
                        print'<td>'.$r->Nome.' <strong> '.$r->Cognome.'</strong></td>';
                        print'<td>'.$r->Privilegi.'</td>';
                        print'</tr>';
                        $riga = !$riga;
                    }
                    ?>			              	                
                      </tbody>
                  </table>
          <!-- **** -->
             <h2>Utenti registrati</h2>
                                  <span class="budget">
                                   <?php
                                   $q="select count(*) as numero from Giocatore";
                                   $t=mysql_query($q,$connessione); 	
                                   while($r=mysql_fetch_object($t)){
                                      print $r->numero;}
                                   ?>
                                   </span> 
                                  <a href="admin_giocatori.php">[ Gestisci ]</a>
           
            <br />
           
       <br />
     <div class="barra_grigia">   SPONSOR</div>
     <br />
           <a href="#">  <img src="images/footworks.jpg" /></a>
          <div class="info">
        <img src="images/spons.jpg" />
          </div>
           <div class="info">
        <img src="images/spons.jpg" />
          </div>
           <div class="info">
        <img src="images/spons.jpg" />
          </div>
          
          
        </div>  <!-- fine parde destra-->
    </div>
    
</div>



<?php include 'php/footer3_0.php';?> 



      <!--     
                
                <?php
				/*	$prima = true;
					$n_for_riga = 4;
					$n_messi = 2;
					$n_righe = 0;
					$q="SELECT * FROM Team 
					JOIN Iscritti ON Iscritti.Id_iscritti= Team.Iscritti_Id_iscritti
					JOIN Atleti ON Iscritti.Atleti_id_atleti = Atleti.Id_Atleta where Team.Giocatore_Id_giocatore='".$_SESSION['g_id']."' order by Capitano";
						$t=mysql_query($q,$connessione); 	
						while($r=mysql_fetch_object($t)){
							
						if ($r->Avatar=="") 
							$Avatar = "images/profilo.jpg";
						  else
							$Avatar = "images/atleti/".$r->Avatar;
						
						if ($prima){
							print '<table width="51%" >		                
										<tbody>                               
									 <tr>  <td colspan="2" rowspan="2">
										<div class="atleti_capitano">
										<h3>'.$r->Cognome.'<br />'.$r->Nome.'</h3>
										<p><img src="'.$Avatar.'" width="30"/></p>
										<p>CAPITANO</p>
										</div> 
										<a href="g-admin_team.php?change=true">Modifica capitano</a>
										</td>';
								$prima= false;	
						}
						else{
						
							if ($n_messi==0) print '<tr class="dispari">';
							print '<td>';
							
										
							print'<div class="atleti"><h3>'.$r->Cognome.' '.$r->Nome.'</h3><p><img src="'.$Avatar.'" width="30"/></p></div>';
							print '</td>';	
							$n_messi++;
							if ($n_messi== $n_for_riga){print '</tr>'; $n_righe++; if ($n_righe==2) $n_messi=0; else $n_messi=2;}
						}
						}//while
						
						if (!$prima) print'   </tbody></table>';   
			*/	?>
               
      
	<a href="g-admin_team.php?change=team">Modifica team</a>

-->
</body>
</html>