<?php
$page_name = "admin_giocatori";
//versione 3.0

session_start();
include "db.inc";
include "php/invio_mail.php";
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
	
	$notifiche="0";
	if ($_POST['notifiche']!="") $notifiche="1";
	if ($_POST['id']=="")
	$q="INSERT into Giocatore values (null,'".$_POST['nick']."','".$_POST['pass']."','".$_POST['avatar']."','".$_POST['email']."','".$notifiche."','".$_POST['nome']."','".$_POST['cognome']."')";
	else
	$q="UPDATE Giocatore SET Nome='".$_POST['nome']."',Cognome='".$_POST['cognome']."',Nickname='".$_POST['nick']."',Password='".$_POST['password']."',E_mail='".$_POST['email']."',Notifiche='".$notifiche."' where Id_giocatore='".$_POST['id']."'"; 
	

	if(!mysql_query($q,$connessione)) 
		$Errore = "Errore di inserimento/modifica";
	else{
		if ($_POST['id']==""){
			$mex = "messaggio fede";
			Invio($_POST['email'],$mex,"Lo staff di atletipercaso.net - il gioco ti da il benvenuto! ");}
	}
}
//elimina admin
if ($_POST['Elimina']=="Si"){
	$q ="DELETE FROM Ad_min where Id='".$_POST['id']."'";
	if(!mysql_query($q,$connessione)) 
	$Errore = "Errore di eliminazione";
}

//visualizza dati amministratore (variabili definite qui)
$M_profile_nome = "";
$M_profile_cognome = "";
$M_profile_nickname= "";
$M_profile_avatar= "";
$M_profile_email= "";
$M_profile_notifiche= "0";
$M_profile_password= "";
if ($_GET['id']!=""){
	$q="select * from Giocatore where (Id_giocatore='".$_GET['id']."')";
	$t=mysql_query($q,$connessione); 	
	while($r=mysql_fetch_object($t)){
		$M_profile_nome = $r->Nome;
		$M_profile_cognome = $r->Cognome;
		$M_profile_nickname= $r->Nickname;
		$M_profile_avatar= $r->Avatar;
		$M_profile_email= $r->E_mail;
		$M_profile_notifiche= $r->Notifiche;
		$M_profile_password = $r->Password;
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
     
   
        <div class="parziale">       
     
          <h2><img src="images/Edit.png" />Gestione giocatori</h2>
         
                      <form action="#" method="post">
      <input type="hidden" name="id" value="<?php print $_GET['id'];  ?>"/> 


                
                          <table >
                            <tr><td><label>User</label></td><td > <input type="text" name="nick" <?php if ($M_profile_nickname!="") print'value="'.$M_profile_nickname.'"';  ?> /></td></tr>
                            <tr><td><label>Password</label></td><td > <input type="password" name="pass" <?php if ($M_profile_nome!="") print'value="'.$M_profile_password.'"';  ?> /></td></tr>      
                            <tr><td><label>E-mail</label></td><td > <input type="email" name="email" <?php if ($M_profile_email!="") print'value="'.$M_profile_email.'"';  ?> /></td></tr>
                            <tr><td><label>Avatar</label></td><td > <input type="file" name="avatar" <?php if ($M_profile_avatar!="") print'value="'.$M_profile_avatar.'"';  ?> /></td></tr>
                            <tr><td><label>Notifiche</label></td><td > <input type="checkbox" name="notifiche" <?php if ($M_profile_notifiche=="1") print'checked="checked"';  ?>  /></td></tr>
            
            <tr><td><label>Nome </label></td><td> <input type="text" name="nome" <?php if ($M_profile_nome!="") print'value="'.$M_profile_nome.'"';  ?> required="required"  /></td></tr>
                 <tr><td><label>Cognome</label></td><td> <input type="text" name="cognome"<?php if ($M_profile_cognome!="") print'value="'.$M_profile_cognome.'"';  ?> required="required"  /></td></tr>
                            <tr><td><input type="submit" value="Conferma" name="Conferma" /></td><td> <input type="submit" value="Elimina" name="conferma" /></td></tr>
                            
                             
                           </table>
                        </form>

           <!-- **** -->    
       <!-- ** -->
        </div> <!-- parte di sinistra --> 
        
          
        <div class="parziale1">
     		<?php include 'php/admin-menu3_0.php';?>
            
             <h2>Utenti registrati</h2>
                                  <span class="budget">
                                   <?php
                                   $q="select count(*) as numero from Giocatore";
                                   $t=mysql_query($q,$connessione); 	
                                   while($r=mysql_fetch_object($t)){
                                      print $r->numero;}
                                   ?>
     <img src="images/suri_1a.png"  />
        </div>  <!-- fine parde destra-->
        <br />
        <div>
         <h1>Elenco iscritti</h1> 
                        <table width="100%" class="tab_el">
                            <tbody><tr>
                                            <th width="10%">Tool</th>
                                            <th width="10%">Avatar</th>
                                            
                                            <th width="10%">User</th>
                                            <th width="10%">Cognome</th>
                                            
                                            <th width="30%">Nome</th>
											<th width="30%">E-mail</th>
                                            <th width="20%">Notifiche</th>
                                        </tr>
                                
                <?php
                $riga = false;
                $q="select * from  Giocatore order by Nickname desc";
                $t=mysql_query($q,$connessione); 	
                while($r=mysql_fetch_object($t)){		   
                    if ($riga){print '<tr class="pari">';} else {print '<tr class="dispari">';}	
                    print'<td><a href="admin_giocatori.php?id='.$r->Id_giocatore.'"><img src="images/Edit.png" width="30" ></td></a>';	
                
				if ($r->Avatar=="") 
					print '<td><img src="images/profilo.jpg" width="30" /></td>';
				else
					{print'<td><img src="images/avatar/';print $r->Avatar; print '" width="30" /></td>';}
					print'<td>'; print $r->Nickname; print '</td>';
					print'<td>'; print $r->Cognome; print '</td>';
					print'<td>'; print $r->Nome; print '</td>';
					print'<td>'; print $r->E_mail; print '</td>';
					print'<td><input type="checkbox"'; if ($r->Notifiche=="1") print'checked="checked"'; print'/> </td>';
                    print'</tr>';
                    $riga = !$riga;
                }
                ?>	
                        </tbody>
                        </table>
      </div>
      
        
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