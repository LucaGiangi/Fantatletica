<?php
require_once("../../wp-load.php");

$pw = $_POST['pw'];

if ($pw == "Fantatletica2015") {

    $subject = $_POST['subject'];
    $website = $_POST['website'];
    $target = $_POST['target'];
    $mainText = $_POST['main-text'];

    if ( $target == "Test" ) { $IDlist[0] = 1; $IDlist[1] = 257; }
    if ( $target == "Vincitori") {
        $IDlist = $wpdb->get_results("
            SELECT  referral, COUNT(*) totalCount
            FROM    referral
            GROUP   BY referral
            ORDER BY totalCount DESC
            LIMIT 50
            ", ARRAY_A);
    }
    if ( $target == "Abilitati") {

        $IDlist = array( 
            0   =>  1    ,  //  mikylucky
            1   =>  8    ,  //  Francesco Fortunato
            2   =>  62   ,  //  joao bussotti neves
            3   =>  166  ,  //  Martino
            4   =>  172  ,  //  Filippo Scorteccia
            5   =>  178  ,  //  Alex BB
            6   =>  206  ,  //  davide.re
            7   =>  219  ,  //  Vicio97
            8   =>  257  ,  //  luca
            9   =>  276  ,  //  Vallista96
            10  =>  444  ,  //  Desog
            11  =>  657  ,  //  FedericaC
            12  =>  882  ,  //  Federico Gusberti
            13  =>  1133 ,  //  mastro
            14  =>  1207 ,  //  Diego Pettorossi
            15  =>  1242 ,  //  Alessandro Xilo
            16  =>  1315 ,  //  riccardomercatili
            17  =>  1460 ,  //  valdrin98
            18  =>  1478 ,  //  orlcast
            19  =>  1485 ,  //  steone88
            20  =>  1501 ,  //  Jacopo Peron
            21  =>  1513 ,  //  Carlotta
            22  =>  1517 ,  //  LorePila
            23  =>  1527 ,  //  asia1209
            24  =>  1532 ,  //  mattejumper91
            25  =>  1543 ,  //  d.cortesi
            26  =>  1544 ,  //  annylise
            27  =>  1548 ,  //  tommi447
            28  =>  1563 ,  //  Simone72
            29  =>  1570 ,  //  Mr.Win
            30  =>  1586 ,  //  mattiapawaa
            31  =>  1594 ,  //  Tjr
            32  =>  1690 ,  //  Rickyserra
            33  =>  1695 ,  //  jeanpaulperret
            34  =>  1700 ,  //  rocco-c
            35  =>  1725 ,  //  Illy
            36  =>  1740 ,  //  fraress
            37  =>  1765 ,  //  Simoforte
            38  =>  1771 ,  //  Christian bapou
            39  =>  1783 ,  //  7mancato
            40  =>  1845 ,  //  Greg_2496
            41  =>  1864 ,  //  Greta
            42  =>  1878 ,  //  Piet95
            43  =>  1895 ,  //  Emmanuel.Ihemeje
            44  =>  1909 ,  //  vladi
            45  =>  1917 ,  //  elibortoli
            46  =>  1920 ,  //  Giofilippi
            47  =>  1944 ,  //  fermati97
            48  =>  1946 ,  //  valvola
            49  =>  1953 ,  //  Matteo_Masetti
            50  =>  1966 ,  //  Selli
            51  =>  1979 ,  //  Javelinthrower123
            52  =>  1987 ,  //  dodo98
            53  =>  2021 ,  //  LorenzoCalise
            54  =>  2080 ,  //  Parentsteeplechase
            55  =>  2093 ,  //  Giulia Raiano
            56  =>  2176 ,  //  lp
            57  =>  2201 ,  //  elipawaa
            58  =>  2242 ,  //  LeonardoMarangon
            59  =>  80   ,  //  GiuseppeB23
            60  =>  2262 ,  //  stefano marta
            61  =>  2318 ,  //  sofiadepoli
            62  =>  2342 ,  //  Elenamanc
            63  =>  2353 ,  //  Aleferra
            64  =>  2394 ,  //  alefo
            65  =>  2407 ,  //  burnedo
            66  =>  2469 ,  //  simo206
            67  =>  2477 ,  //  Zeno_Zuliani
            68  =>  1971 ,  //  davide.rossi
            69  =>  2540 ,  //  Fedebaldi
            70  =>  1826 ,  //  Alex95
            71  =>  680  ,  //  gnagnobekele34
            72  =>  2320 ,  //  EdoardoBaretta
            73  =>  2459 ,  //  MatteoIachini
            74  =>  2624 ,  //  Vittograndis
            75  =>  1890 ,  //  Lavitto84
            76  =>  2621 ,  //  antonix
            77  =>  1680 ,  //  Federico Cesati
            78  =>  2141 ,  //  natan
            79  =>  1037 ,  //  Elisa Ferrari
            80  =>  1208 ,  //  Filippo Fragnito
            81  =>  1482 ,  //  bufalo223
            82  =>  1603 ,  //  Armatone
            83  =>  1627 ,  //  NicholasF97
            84  =>  1660 ,  //  eliastanlio
            85  =>  2022 ,  //  Nicolacalise
            86  =>  2489 ,  //  Simone Grandi Venturi
            87  =>  2502 ,  //  atletapazzo93
            88  =>  2577 ,  //  Ale zoghlami
        );

    }

    if ( $target == "Pre-Registrati") {
        $IDlist = $wpdb->get_results("
            SELECT  email, COUNT(*) totalCount
	    FROM    fantatletica_test1
            GROUP   BY email
            ");
    }

    if ( $target == "Perdenti Assoluti") {
        $IDlist = $wpdb->get_results("
            SELECT  *
            FROM    Invio_Mail
            ");
    }

	var_dump($IDlist);

    foreach ($IDlist as $ID) {

    	if ($target == "Perdenti Assoluti") {

    	    $email = $ID->Mail;

    	} else if ($target == "Pre-Registrati") {

    	    $email = $ID->email;

        } else {

	        $user = get_user_by( 'id', $ID );
	        $username = $user->user_login;
	        $email = $user->user_email;

    	}

        //content email
        $message = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
        $message .= "<html xmlns=\"http://www.w3.org/1999/xhtml\">\n";
        $message .= "<head>\n";
        $message .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
        $message .= "<meta name=\"viewport\" content=\"initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no\">\n";
        $message .= "<style type=\"text/css\">\n";
        $message .= "@font-face {\n";
        $message .= "font-family: 'Antipasto';\n";
        $message .= "src: url('http://www.atletipercaso.net/mobile/font/Antipasto_extralight.otf');\n";
        $message .= "font-weight: normal;\n";
        $message .= "font-style: normal;\n";
        $message .= "}\n";
        $message .= "body {\n";
        $message .= "font-family: 'Antipasto';\n";
        $message .= "}\n";
        $message .= "@media only screen and (min-device-width : 600px) {\n";
        $message .= "#desc {width: 100%; }\n"; 
        $message .= "}\n";
        $message .= "</style>\n";
        $message .= "<title>{$website}!</title>\n";
        $message .= "</head>\n";
        $message .= "<body>\n";
        $message .= "<div style=\"width:100%;background:url('http://www.atletipercaso.net/mobile/images/menubg.jpg')center0px;background-size:100%auto\">\n";
        $message .= "<div style=\" margin-right: 50px; margin-top: 33px; text-align: right; display: inline-block; vertical-align:middle; float: left\"><img src=\"http://www.atletipercaso.net/mobile/images/apc.png\" height=\"45px\"/></div>\n";
        $message .= "<div style=\"margin: 40px 0px 40px 10px; font-size: 28px; display: inline-block; vertical-align:middle; color: #f4aa00;\">".$website."</div>\n";
        $message .= "</div>\n";
        $message .= "<div style=\"margin:10px\">\n";
        $message .= "<div style=\"font-size: 35px; margin-top: 10px; margin-bottom: 10px\">Ciao, ".$username."!</div>\n\n";
        $message .= "<div style=\"font-size: 25px; margin-bottom:10px; margin-top:10px\">".$mainText."</div>\n";
        $message .= "</div>\n";
        $message .= "</body>\n";

        /* send email */
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $mail = wp_mail( $email, $subject, $message, $headers );

	//$mail = mail($email, $subject, $message, $headers .
     //"From: italia@trackarena.com\r\n" .
     //"Reply-To: italia@trackarena.com\r\n" .
     //"X-Mailer: PHP/" . phpversion());

	echo $email;	

	var_dump( $mail) ;

	echo "\n\n";

    }


} else { ?>

    <form action="http://www.trackarena.com/API/v1/sendEmail.php" method="POST">
        Password: <input id="pw" name="pw" type="text"/></br>
        Oggetto: <input id="subject" name="subject" type="text"/></br>
        Messaggio principale: <input id="main-text" name="main-text" type="text"/></br>
        Website: <input id="website" name="website" type="text"/></br>
        Destinatari: <select id="target" name="target">
            <option value="Test" selected>Test</option>
            <option value="Vincitori" >Vincitori</option>
            <option value="Abilitati" >Abilitati</option>
            <option value="Perdenti Assoluti">Perdenti Assoluti</option>
	    <option value="Pre-Registrati">Pre-Registrati</option>
        </select></br>
        <input type="submit" value="Submit">
    </form>

<? }

?>