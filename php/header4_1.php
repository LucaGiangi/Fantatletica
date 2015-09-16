<!--------****************************************  header-->

   <?php include "formatta_data.php"; ?>  
<div id="content" class="snap-content">
	<div id="head">
		<a href="#" id="open-left"></a><a href="#"><h1><img id="logo_img" src="images/logo_m.png"></h1></a><a href="#" id="open-right"></a>         
	</div>


<!--<div id="titolo"></div>	-->
    
	
		<div id="toolbar">
			<div id="menu" >
                <div class="menu-principale-container contenuto">                
                    <?php include "headerMENU4_0.php"; ?>
                    </ul>
                    
                </div>
            </div>
	<div id="expand">
	<a href="#" id="more"></a>
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
print'<div class="spazio_mob"></div>

';	
}
?>
<!---********************************************-->