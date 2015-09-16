<body style="background-color:#FFF;">

        <div id="head" style="left:0px;">
                    <a href="../index.php"><h1><img alt="menu_dx" id="logo_img" src="../images/logo_m.png"></h1></a> 
                </div>
            
                <div style="height:70px; width:100%;"></div>
            
                <div style="margin:0 auto; width:95%;">
            
                    <div id='cssmenu'>
                        <ul>
                        	<li><a href='Admin_home.php'>Home</a></li> 
							<li><a href='../Analytics/Analytics.php'>Analytics</a>
                            	<ul>
                                	<li><a href='../Analytics/Analytics.php'>Fantatletica</a></li>
                                    <li><a href='http://www.atletipercaso.net/API/v1/analytics.php' target="new">AtletiPerCaso</a></li>
                            	</ul>
                            </li>        
							<li><a href='Admin_schedina.php'>Schedina</a>
                            	<ul>
                                	<li><a href='Admin_schedina.php'>Inserisci/modifica/risultati</a></li>
                                	<li><a href='Admin_view_schedina.php'>Guarda puntate</a></li>   
                            	</ul>
                            </li>
                            <li><a href='*'>Fantatletica</a>
                            	<ul>
                                	<li><a href='*'>Inserisci/modifica</a></li>
                                	<li><a href='Admin_view_fanta_results.php'>Controlla.iscritti/punti</a></li>
                                    <li><a href='Admin_insert_entry.php'>Inserisci iscrizioni</a></li>  
                            	</ul>
                            </li>
                            
                        </ul>
                </div>
                <?php global $g_nome; print '<color_arancio><h5 style="margin-top: 0px;">Ultimo aggiornamento: '.formatta_data(date("Y-m-d G:i:s")).' Admin: '.$g_nome.'</h5></color_arancio>'; ?>