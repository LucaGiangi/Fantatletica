<body style="background-color:#FFF;">
        <div id="head" style="left:0px;">
                    <a href="../index.php"><h1><img alt="menu_dx" id="logo_img" src="../images/logo_m.png"></h1></a> 
                </div>
            
                <div style="height:70px; width:100%;"></div>
            
                <div style="margin:0 auto; width:95%;">
            
                    <div id='cssmenu'>
                        <ul>
                        	<li><a href='../Admin/Admin_home.php'>Home</a></li> 
							<li><a href='Analytics.php'>Giocatori</a></li>        
							<li><a href='#'>Track Action</a>
                            	<ul>
         							<li><a href='#'>Composizione&nbsp;team</a> </li>
                                    <li><a href='Track_schedina.php'>Composizione&nbsp;schedina</a> </li>
                                </ul>
                            </li>
						
                        </ul>
                </div>
                <?php global $g_nome; print '<color_arancio><h5 style="margin-top: 0px;">Ultimo aggiornamento: '.formatta_data(date("Y-m-d G:i:s")).' Admin: '.$g_nome.'</h5></color_arancio>'; ?>