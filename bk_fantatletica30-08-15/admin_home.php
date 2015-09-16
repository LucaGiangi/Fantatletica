<?php
$page_name = "admin_home";
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
//**************************
// gestione admin
	//inserisci-modifica
if ($_POST['Conferma']=="Conferma"){
	if ($_POST['id']=="")
	$q="INSERT into Ad_min values (null,'".$_POST['Nome']."','".$_POST['Cognome']."','".$_POST['UserName']."','".$_POST['Password']."','".$_POST['E_mail']."','".$_POST['Privilegi']."')";
	else
	$q="UPDATE Ad_min SET Nome='".$_POST['Nome']."',Cognome='".$_POST['Cognome']."',Username='".$_POST['UserName']."',Password='".$_POST['Password']."',E_mail='".$_POST['E_mail']."',Privilegi='".$_POST['Privilegi']."' where Id='".$_POST['id']."'"; ////  da modificare
	
	if(!mysql_query($q,$connessione)) 
	$Errore = "Errore di inserimento/modifica";
}
//elimina admin
if ($_POST['Elimina']=="Si"){
	$q ="DELETE FROM Ad_min where Id='".$_POST['id']."'";
	if(!mysql_query($q,$connessione)) 
	$Errore = "Errore di eliminazione";
}

//visualizza dati amministratore (variabili definite qui)
$M_ad_nome = "";
$M_ad_cognome = "";
$M_ad_Username= "";
$M_ad_Password= "";
$M_ad_E_mail= "";
$M_ad_Privilegi= "";
if ($_GET['id']!=""){
	$q="select * from Ad_min where (Id='".$_GET['id']."')";
	$t=mysql_query($q,$connessione); 	
	while($r=mysql_fetch_object($t)){
		$M_ad_nome = $r->Nome;
		$M_ad_cognome = $r->Cognome;
		$M_ad_Username= $r->Username;
		$M_ad_Password= $r->Password;
		$M_ad_E_mail= $r->E_mail;
		$M_ad_Privilegi= $r->Privilegi;
	}
}

//**************************
//gestione slider
if ($_POST['Slider_aggiungi']=="Aggiungi"){
	$visibile="0";
	if ($_POST['slider_visibile']!="") $visibile="1";
		$q="INSERT into Slider values ('".$visibile."','".$_POST['slider_path']."','".$_POST['slider_testo']."')";
		if(!mysql_query($q,$connessione)) 
		$Errore = "Errore gestione slider";
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
       <h1>Ciao&nbsp; <?php print $_SESSION['ad_nome'];?></h1>  
    <!-- ************ -->
    <h2>Gestione slider</h2> 
                        <table width="100%" class="tab_el">
                            <tbody>
                                <tr>
                                <th width="10%">Tool</th>
                                <th width="5%">Visibile</th>
                                <th width="10%">Anteprima</th>
                                <th width="40%">Foto</th>
                                <th width="35%">Testo</th>
                                </tr> 
                                
                          <form action="admin_home.php" method="post">
                                <tr class="pari">
                                <td><input type="submit" name="Slider_aggiungi" value="Aggiungi"></td>
                                <td><input type="checkbox" checked="checked" name="slider_visibile"/> </td>
                                <td>&nbsp;</td>
                                <td> <input type="file" name="slider_path" > </td>
                                <td> <input type="text" name="slider_testo" placeholder="Inserisci un testo"/></td>
                                </tr>
                          </form>
                <?php
                $riga = false;
                $q="select * from Slider";
                $t=mysql_query($q,$connessione); 	
                while($r=mysql_fetch_object($t)){		   
                    if ($riga){print '<tr class="pari">';} else {print '<tr class="dispari">';}	
                    print'<td><a href="admin_home.php?id='.$r->Id.'"><img src="images/Edit.png" width="30" ></td></a>';	
                    print'<td><input type="checkbox"'; if ($r->Visibile=="1") print'checked="checked"'; print'/> </td>';
                    print'<td><img src="images/slider/';print $r->Path; print '" width="30" ></td>';
                    print'<td>'; print $r->Path; print '</td>';
                    print'<td><textarea>'; print $r->Testo; print'</textarea></td>';
                    print'</tr>';
                    $riga = !$riga;
                }
                ?>	
                        </tbody>
                        </table>
    
    <!-- ************ -->
    
    
        <div class="parziale">       
     
           <!-- **** -->
           <h2><img src="images/Edit.png" />Gestione amministratori</h2>    
                        <form action="admin_home.php" method="post">    
                        <input type="hidden" name="id" value="<?php print $_GET['id'];  ?>"/> 
                        <table>
                        <tr><td><label>Nome</label></td><td><input type="text" name="Nome" required="required" <?php if ($M_ad_nome=="") print'placeholder="Nome"'; else print'value="'.$M_ad_nome.'"';     ?> /></td></tr>
                        <tr><td><label>Cognome</label></td><td> <input type="text" required="required" name="Cognome" <?php if ($M_ad_cognome=="") print'placeholder="Cognome"'; else print'value="'.$M_ad_cognome.'"';     ?> /></td></tr>
                        <tr><td><label>UserName</label></td><td> <input type="text" required="required" name="UserName" <?php if ($M_ad_Username=="") print'placeholder="UserName"'; else print'value="'.$M_ad_Username.'"';     ?> /></td></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr><td> <label>Password</label></td><td><input required="required" type="password"  <?php if ($M_ad_Password=="") print'placeholder="Password"'; else print'value="'.$M_ad_Password.'"';     ?> name="Password"  /></td></tr>    
                        <tr><td> <label>Conferma</label> </td><td><input required="required" type="password"  <?php if ($M_ad_Password=="") print'placeholder="Password"'; else print'value="'.$M_ad_Password.'"';     ?> name="Conf_Password"  /></td></tr>
                        <tr><td> <label>E_mail</label> </td><td><input required="required" type="email" name="E_mail"  <?php if ($M_ad_E_mail=="") print'placeholder="E_mail"'; else print'value="'.$M_ad_E_mail.'"';     ?>  /></td></tr>
                        <tr><td> <label>Privilegi</label> </td><td><select name="Privilegi"> <option value="Tutti">Tutti</option> </select></td></tr>
                      
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