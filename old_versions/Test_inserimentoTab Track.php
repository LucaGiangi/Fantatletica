<?php

include "db.inc";


$q="INSERT into Track_actions values ('1','3','".(date("Y/m/d G:i:s"))."','I')";
			if(!mysql_query($q,$connessione)) 
				print  "Errore di inserimento";
			else
				print "ok";

print $q;
print "ciao pippo"

?>