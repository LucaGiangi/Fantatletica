<!--------****************************************  header-->



<div id="titolo">
    <div class="sx">
  <a href="index.php">  	<img src="images/logo2.png" title="Atletipercaso.net il gioco" ></a><br/> 
    </div>
    <!--
    <div class="sx1">     
        <div id="wrapper">
            <div class="slider-wrapper theme-default">   
                <div id="slider" class="nivoSlider">
                
                <img src="images/slider/a1.png" title="Hai sempre visto i tuoi amici giocare al “fantacalcio” e sognavi un passatempo simile? La soluzione è arrivata!" />  
                <img src="images/slider/a2.png"  title="Crea la tua squadra, sfida i tuoi amici, vinci fantastici premi" /> 
                <img src="images/slider/a3.png" title="Il primo &quot;fantatletica&quot; d'Italia, il gioco facile e veloce di atletipercaso.net" data-transition="slideInLeft" />
                
                </div>
            
            	<div id="htmlcaption" class="nivo-html-caption"></div>
            </div>
        </div> 
    </div> -->  
</div>
<div id="menu" >
<div class="contenuto">
 
<?php include "headerMENU3_0.php"; ?>
 <?php include "formatta_data.php"; ?>  		
</div>
</div>
<?php
if ($page_name == "index"){
	
	print'<div class="div_gara"><div class="div_gara_centro"><h1>Programma gare</h1>';
	
	$q="SELECT * FROM Competizione order by Data_inizio LIMIT 0,7";
	$t=mysql_query($q,$connessione); 	
	while($r=mysql_fetch_object($t)){
		
		if ($r->Schedina==1) print '<div class="ischome_schedina">';else
		print '<div class="ischome">';
		print'
		<div class="evidenzia_gara1">
		<h3>'.$r->Nome.'</h3>
		</div>
		Data:<br/>'.formatta_data($r->Data_inizio).'<br/>
		</div>';
	}
	print'</div></div>';
}
else{
print'

';	
}
?>
<!---********************************************-->