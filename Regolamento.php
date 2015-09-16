<?php
$page_name = "regolamento";
//versione 4.0 responsitive
// 20/05/15 -> MODIFICATA PER ESSERE VISIBILI SOLO AGLI LOGGATI (ABILITATI)

session_start();

$data = date ("Y-m-d");
include "db.inc";
include 'php/Gestione_token.php';

include 'php/verifica_accesso_g.php';
include "php/logout.php";
 
?>
<!doctype html>
<html lang="it-IT">
<head>
<meta charset="utf-8">

 <meta http-equiv="x-ua-compatible" content="IE=edge" />
        <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-touch-fullscreen" content="yes">

 <script src="script/jquery-1.11.1.min.js"></script>
	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon"/>
	<link rel="icon" href="images/favicon.ico" type="image/x-icon"/>
    
<link type="text/css" media="all" href="css/style.css" rel="stylesheet" />
<link type="text/css" media="all" href="css/new_mobile.css" rel="stylesheet" />

<title>Regolamento - Fantatletica</title>
</head>

 <?php include 'php/header4_0.php';?>  

<!--  body info -->
<div class="body_info">
	<div class="call_action_contenuto">
    
     <articolo1>      
                <h1>Fantatletica by atletipercaso.net</h1>
                <p>
                Hai sempre visto i tuoi amici giocare al "fantacalcio" e sognavi un passatempo simile? La soluzione &egrave; arrivata! Con <a href="index.php"><color_arancio>Atletipercaso.net - Il gioco</color_arancio></a> potrai creare la tua squadra in pochi semplici passi, sfidare i tuoi amici e vincere premi.</p>
                <p>Il gioco &egrave; completamente GRATUITO.</p>
                
                <div class="sx_2col">        
                    <p><span class="nascondi1">Per giocare devi registrarti al sito atletipercaso.net.
                     E' facile e richiede poco tempo.<br /></span>
                  
                 	<a href="registrati.php"><div class="button1" >Registrati</div></a>
				</div>
                
				<div class="dx_2col">
                	<p><span class="nascondi1">Una volta registrato al sito ti baster&agrave; accedere con le tue credenziali per iniziare a giocare.<br/></span>
						<a href="login.php"><div class="button1" >Login</div></a>
           				<div class="centro">    </div>
                	</p>
                </div>

                
               <a name="fanta"></a> 
               <h1>&nbsp;</h1>
 
               <h1>Regolamento</h1>
                <p>
                Come per ogni gioco esiste un regolamento, e come per ogni regolamento che si rispetti, non va letto! Non stiamo scherzando: &egrave; pi&ugrave; facile capirlo giocando piuttosto che leggerlo!</p>
                <p> Per i pi&ugrave; temerari ecco qui le regole del gioco. Il primo passo &egrave;: CREARE LA TUA SQUADRA.</p>
                
                <div onclick="Espandi('uno')">
                  <h1><img src="images/1.png" class="noconi" /> 1&deg;PASSO&nbsp;<img class="espandi" src="images/freccia_1.png"></h1></div>
                  <div class="nascondi_testo" id="uno">
                <p>Per ogni manifestazione in programma e visibile nella pagina del <color_arancio>tuo profilo</color_arancio>, una volta effettuato il login, &egrave; <color_arancio>necessario fare la propria squadra</color_arancio> al quale potrete dare un nome. Una scelta di un <color_arancio>numero variabile</color_arancio> di atleti (da 8 a 10 in base all&lsquo;ampiezza del programma gare) da effettuare tra quelli presenti nella lista iscrizioni. Tra questi dovrete scegliere <color_arancio>il capitano</color_arancio>, molto importante, in quanto <color_arancio>raddoppier&agrave; i suoi punti</color_arancio>. La scelta del team sar&agrave; <color_arancio>vincolata</color_arancio> alla disponibilit&agrave; di un <color_arancio>budget</color_arancio>. Ad ogni atleta verr&agrave; attribuito un valore monetario e le vostre scelte dovranno essere fatte rispettando un tetto massimo di spesa.</p>
                </div>
                <div onclick="Espandi('due')">
                  <h1><img src="images/2.png" class="noconi" /> 2&deg; PASSO&nbsp;<img class="espandi" src="images/freccia_1.png"></h1></div>
                  <div class="nascondi_testo" id="due">
                <p>Una volta creata la squadra dovrete aspettare che si <color_arancio>disputi la gara</color_arancio>. In base al risultato conseguito dai vostri atleti acquisirete dei punti secondo queste regole:</p>
                
              <table>
              <tr><td>
                	<span class="nascondi1"><img src="images/freccia.png"  ></span></td><td>
                    
                    <ul>
                        <li>1&deg; Classificato: 18 punti.</li>
                        <li>2&deg; Classificato: 15 punti.</li>
                        <li>3&deg; Classificato: 12 punti.</li>
                      	<li>4&deg; Classificato: 10 punti.</li>
                      	<li>5&deg; Classificato: 8 punti.</li>
                      	<li>6&deg; Classificato: 6 punti.</li>
                      	<li>7&deg; Classificato: 4 punti.</li>
                      	<li>8&deg; Classificato: 3 punti.</li>
                        <li>9&deg; Classificato: 2 punti.</li>
                        <li>10&deg; Classificato: 1 punti.</li>
                    </ul>
               </td></tr></table>
				<p>In caso di manifestazioni internazionali i punti attribuiti saranno invece:</p>
                <table>
              <tr><td>
                	<span class="nascondi1"><img src="images/freccia.png"  ></span></td><td>
                    
                    <ul>
                        <li>1&deg; Classificato: 25 punti.</li>
                        <li>2&deg; Classificato: 22 punti.</li>
                        <li>3&deg; Classificato: 19 punti.</li>
                     	 <li>4&deg; Classificato: 16 punti.</li>
                      	<li>5&deg; Classificato: 13 punti.</li>
                      	<li>6&deg; Classificato: 11 punti.</li>
                     	<li>7&deg; Classificato: 10 punti.</li>
                      	<li>8&deg; Classificato: 9 punti.</li>
                        <li>9&deg; Classificato: 8 punti.</li>
                        <li>10&deg; Classificato: 7 punti.</li>
                        <li>11&deg; Classificato: 6 punti.</li>
                        <li>12&deg; Classificato: 5 punti.</li>
                        <li>13&deg; Classificato: 4 punti.</li>
                        <li>14&deg; Classificato: 3 punti.</li>
                        <li>15&deg; Classificato: 2 punti.</li>
                        <li>16&deg; Classificato: 1 punti.</li>       
                    </ul>
               </td></tr></table>
                
                   
             
                <p>Sommeremo ai precedenti punteggi i seguenti <color_arancio>punti aggiuntivi</color_arancio>: </p>
                
                        <table>
              <tr><td>
                	<span class="nascondi1"><img src="images/freccia.png"  ></span></td><td>
                <ul>
                <li>NR* &ndash; Record Nazionale: 10 punti</li>
                <li>AR &ndash; Record continentle: 15 punti</li>
                <li>WR &ndash; Record Mondiale: 30 punti</li>
                </ul>
               </td></tr></table>
               
                <p>* I punti verranno assegnati al tuo atleta solo se il record nazionale è della categoria cui si riferisce la manifestazione. Non verranno dati quindi i punti per un NR di categoria in una manifestazione assoluta o se si tratta di una gara della categoria superiore.</p>
                <p><span class="budget">La somma dei punti dei vostri atleti darà il vostro punteggio.</span></p>
               
       </div>
                <div onclick="Espandi('tre')">
                  <h1><img src="images/3.png" class="noconi" /> 3&deg; PASSO&nbsp;<img class="espandi" src="images/freccia_1.png"></h1></div>
                <div class="nascondi_testo" id="tre">
                <p>Verrà redatta <color_arancio>una classifica</color_arancio> per ogni singola manifestazione, dal dal punteggio pi&ugrave; alto a quello pi&ugrave; basso. A parit&agrave; di punteggio tra due o pi&ugrave; partecipanti verranno applicate le seguenti regole. Vedremo:</p>
               
<p>1)<color_arancio> Il budget speso</color_arancio>: chi ha speso di meno sar&agrave; pi&ugrave; alto in classifica rispetto a chi ha speso di pi&ugrave;.</p>
<p>2)<color_arancio> Nel caso di ulteriore parit&agrave, considereremo il numero di atleti schierati</color_arancio>: chi ha schierato meno atleti sar&agrave pi&ugrave; alto in classifica rispetto a chi ne ha schierati di pi&ugrave;.
In caso di ulteriore parit&agrave verr&agrave assegnato il pari merito tra i partecipanti.</p>

<p>
Sar&agrave stilata e continuamente aggiornata la classifica totale che racchiude tutti i punti accumulati nella stagione corrente. A parit&agrave di punteggio,<color_arancio> sar&agrave pi&ugrave; alto in classifica chi ha partecipato a pi&ugrave; manifestazioni durante l&lsquo;anno.</color_arancio></p>
<p>
Qualora il punteggio assegnato ai componenti della tua squadra non sia corretto sei invitato a segnalarci l’errore entro e non oltre i 2 giorni dall’uscita della <color_arancio>classifica ufficiosa</color_arancio>. Noi apporteremo le dovute modifiche e aggiorneremo la classifica con i punteggi corretti. Oltre tale termine la classifica diventerà <color_arancio>ufficiale</color_arancio> e non verranno corretti ulteriori punteggi.
Buon divertimento!</p>
</p> 
 </div>
 
 <a name="schedina"></a>
 <div class="div_schedina">
  <br/><br/>
  <h1> Atletipercaso.net - la schedina</h1><br/> 
				
				
				 <p>Unica regola per vincere la schedina: fare <span class="budget"> 13!</span> </p>
               
          <p>Per ognuno dei 13 pronostici devi scegliere 1, 2, o X. Se scegli l&acute;opzione 1 prevedi che il primo nome indicato sia il vincitore della gara. Se giochi 2 prevedi che &egrave; il secondo nome quello vincente. Se giochi X prevedi che a vincere la gara non sarà nessuno dei due atleti previsti dalla schedina.  Ad esempio:</p>
          
          <p><strong>Delmas Obou</strong> Vs <strong>Michael Tumi</strong>: <strong>1</strong> (vittoria per Obou), <strong>2</strong> (vittoria per Tumi), <strong>X</strong> (non vince nessuno dei due).</p>
		  
          <p>Come facciamo nel caso in cui un&acute;atleta non partisse nella gara in cui &egrave; iscritto? Poich&egrave; abbiamo pensato a tutto, qualora uno degli <color_arancio>scontri previsti non abbia luogo la schedina sarà comunque valida</color_arancio>. Infatti, compilerai altri 5 pronostici in modo che, nel caso in cui non avvenga uno scontro, verrà ripescato il 14&deg; pronostico. Se non ne avverranno due, verranno ripescati il 14&deg; e il 15&deg; e cos&igrave; via fino ad un massimo di 18.</p>
<p>E se un&acute;atleta si ritira durante la gara? Verrà considerato come partito e quindi classificato all&acute;ultimo posto della classifica. </p>
<p>E se un&acute;atleta si qualifica per una finale e poi non la disputa? In quel caso invece si considera come non avvenuto lo scontro e quindi verrà scartato quel pronostico.</p>
</div>

      		</articolo1>
    </div>
</div>


  <?php include 'php/footer4_0.php';?>  
<!--  <script type="text/javascript" src="http://www.atletipercaso.net/wp-content/themes/Iris/scripts/snap.min.js"></script>-->

<script>
function Espandi(div){	

	if (document.getElementById(div).style.display=='block'){
		document.getElementById(div).style.display='none';	}
	else{
		document.getElementById(div).style.display='block';}
}
</script>
