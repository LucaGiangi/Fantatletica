<?php
$page_name = "Parsing";
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

/* parsing iscrizioni iaaf */
$html = file_get_contents($_GET['link']); //get the html returned from the following url

$pokemon_doc = new DOMDocument();

libxml_use_internal_errors(TRUE); //disable libxml errors

if(!empty($html)){ //if any html is actually returned

    $pokemon_doc->loadHTML($html);
    libxml_clear_errors(); //remove errors for yucky html

    $pokemon_xpath = new DOMXPath($pokemon_doc);

	
	
    //get all the h2's with an id
   // $pokemon_row = $pokemon_xpath->query('//div[@id="results"]');
	  $pokemon_row = $pokemon_xpath->query('//td');
	 
	$CMAX=200;
	$CMIN=50;
	$RM=0;
	$PDM=0;
	$P=0;
	$Prezzo=0;

    if($pokemon_row->length > 0){
		
		/* leggi tutti i dati e formattali dentro una stringa */
		foreach($pokemon_row as $row)		
			if (!strstr($row->nodeValue, "$"))		
            	$stringa=$stringa.trim($row->nodeValue).",";

		
		$lista=explode(",",$stringa);
		// calcolo prestazione migliore e peggiore
		$RM=$lista[4]; /*4*/
		$PDM=$lista[4];/*4*/
		for ($i=10;$i<count($lista)-1;$i+=6){ /*$i=11   $i+=7*/
			if ("DNS" != $lista[$i]){
				if ($RM<$lista[$i]) $RM=$lista[$i];
				if ($PDM>$lista[$i]) $PDM=$lista[$i];
			}
		}
		print $RM."\n";
		print $PDM."\n";
		
		$i=1;	
        foreach($pokemon_row as $row){			
			if (!strstr($row->nodeValue, "$")){
			
				if (($i+1)%6==0){ /*$i+3)%8==0*/
					$P=trim($row->nodeValue);
					if ($P!="DNS" && $P!=""){
						$Sigma= 1-(($P-$RM)/($PDM-$RM));
						$Prezzo=round($Sigma*($CMAX-$CMIN)+$CMIN,0);
					}else $Prezzo=50;
				}
				
            	print 	trim($row->nodeValue).",";
			}
			if ($i%6==0) print $Prezzo.",\n";/*$i%8==0*/
			$i++;
        }
		print ",";
		
    }	
}

    
?>