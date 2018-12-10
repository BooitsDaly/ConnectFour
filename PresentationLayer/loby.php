<?php
session_start();
if(isset($_SESSION['authenticated']) && $_SESSION['authenticated'] == 'true'){
    require_once ("./outline.php");
    addHeader();
    echo '<h2 class="page-header">Lobby</h2>
<p>Connect Four</p>
<div id=\'loggedIn\' class="row">
	<div class="col-md-12 col-s-12 col-lg-8">
        <div id="game-board"></div>
	</div>


<!-- Tab links -->
<div id="tabsDiv" class="col-md-12 col-s-12 col-lg-4">
<div class="tab">
  <button class="tablinks" onclick="toggleTabs(event,\'Chat\')">Chat</button>
  <button class="tablinks" onclick="toggleTabs(event, \'Users\')">Users</button>
</div>

<!-- Tab content -->
<div id="Chat" class="tabcontent">
  <div id="chatlog" class="box"></div>
				<div>
						<span id="status">Message:</span>
						<input type="text" id="message"  />
						<input id="sendMessage" type="button" value="send" class="btn btn-primary"/>
				</div>
</div>

<div id="Users" class="tabcontent">
  
   
</div>
</div>
		</div>      
	</div>		
</div>';
    addFooter();
}else{
    header('Location: '.'./../index.php');
    die();
}
