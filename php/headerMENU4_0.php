 <?php
 global $team_creato;
global $C_token;

 //print "ff".$_SESSION['team_creato'];
  if ($page_name == "g-team" or $page_name == "g-home" or $page_name == "g-home-team" or $page_name == "g-admin_team"){
 	print' 
<div id="menu1">
	<div class="call_action_m">
		<div class="call_action_contenuto_m">
			<div class="dx_m_g">
				<ul id="menu-principale" class="menu w_menu_g" >
					<li>'; if(isset($_COOKIE[$C_token])) print' <a href="g-home.php">Home</a>'; else print' <a href="index.php">Home</a>'; print'</li>
					<li><a href="g-home.php?cod=esci">Logout</a></li>
					<li><a href="'; if ($team_creato==true or ($_SESSION['id_competizione']==-1)) print 'g-home-team.php'; else print'g-team_new.php';
					print '">Team</a></li>
					
					<li class="has-sub" ><a href="Regolamento.php">Regolamento</a>
						<ul class="nascondi">
							<li><a href="Regolamento.php#fanta">&nbsp;Fantatletica</a></li>
							<li><a href="Regolamento.php#schedina">&nbsp;Schedina</a></li>
						</ul>
					</li>
					<li><a href="Hall_of_fame.php">Hall of fame</a></li>		
				<!--	<li  > <a href="Premi.php">Premi</a></li> DA AGGIUNGERE A LANCIO COMPLETATO -->							
				</ul>
			</div>	
		</div>
	</div>
</div>';}
 
  
	else{

		print'   
            <div id="menu1">
			<div class="call_action_m">
	<div class="call_action_contenuto_m">';
if(isset($_COOKIE[$C_token]))	print'<div class="dx_m_g">'; else print'<div class="dx_m">';
            print '<ul id="menu-principale" class="';if(isset($_COOKIE[$C_token])) print'w_menu_g';else print'w_menu menu';
			print'" >
            <li >';  if(isset($_COOKIE[$C_token])) print' <a href="g-home.php">Home</a>'; else print' <a href="index.php">Home</a>'; print'</li>';
            if(isset($_COOKIE[$C_token])) print'<li><a href="g-home.php?cod=esci">Logout</a></li>';
			else print'
            <li  ><a href="login.php">Login/registrati</a></li>';
            
         if(isset($_COOKIE[$C_token])) print' <li  ><a href="g-home.php">Gioca</a></li>';
           print' <li class="has-sub" ><a href="Regolamento.php">Regolamento</a>
            		<ul class="nascondi">
            			<li><a href="Regolamento.php#fanta">&nbsp;Fantatletica</a></li>
            			<li><a href="Regolamento.php#schedina">&nbsp;Schedina</a></li>
            		</ul>
				
            	</li>
            	<li><a href="Hall_of_fame.php">Hall of fame</a></li>
          <!--	<li  > <a href="Premi.php">Premi</a></li> DA AGGIUNGERE A LANCIO COMPLETATO -->	
              
            </ul>
            </div>
            
    </div>
    </div>
</div>
 ';}
				
 ?>
 
 
 