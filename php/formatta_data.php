<?php
function formatta_data($data_letta){

list ($data,$orario)=explode(' ',$data_letta);
list($anno,$mese,$giorno) = explode('-',$data);
list ($ora,$minuti) = explode(':',$orario);
$mese=(int)$mese;

if ($mese==1)  $stringa = $giorno." "."Gennaio";
if ($mese==2)  $stringa =  $giorno." "."Febbraio";
if ($mese==3)  $stringa = $giorno." "."Marzo";
if ($mese==4)  $stringa =  $giorno." "."Aprile";
if ($mese==5)  $stringa = $giorno." "."Maggio";
if ($mese==6)  $stringa = $giorno." "."Giugno";
if ($mese==7)  $stringa =  $giorno." "."Luglio";
if ($mese==8)  $stringa =  $giorno." "."Agosto";
if ($mese==9)  $stringa =  $giorno." "."Settembre";
if ($mese==10)  $stringa =  $giorno." "."Ottobre";
if ($mese==11)  $stringa =  $giorno." "."Novembre";
if ($mese==12)  $stringa =  $giorno." "."Dicembre";

if ($orario!="")
	return $stringa." alle ".$ora.":".$minuti;
else
	return $stringa;
}



?>