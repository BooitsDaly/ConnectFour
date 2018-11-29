<?php
require_once ("./outline.php");
addHeader();
echo '<h2 class="page-header">Loby</h2>
<p>Connect Four</p>
<div id=\'loggedIn\' class="row">
	<div class="col-md-12 col-s-12 col-lg-8">
			<div id="game-board">
				<div class="column" id="column-0" data-x="0">
					<svg height="100" width="100" class="row-5">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
					<svg height="100" width="100" class="row-4">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
					<svg height="100" width="100" class="row-3">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
					<svg height="100" width="100" class="row-2">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
					<svg height="100" width="100" class="row-1">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
					<svg height="100" width="100" class="row-0">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
				</div>
				<div class="column"  id="column-1" data-x="1">
					<svg height="100" width="100" class="row-5">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
					<svg height="100" width="100" class="row-4">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
					<svg height="100" width="100" class="row-3">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
					<svg height="100" width="100" class="row-2">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
					<svg height="100" width="100" class="row-1">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
					<svg height="100" width="100" class="row-0">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
				</div>
				<div class="column" id="column-2" data-x="2">
					<svg height="100" width="100" class="row-5">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
					<svg height="100" width="100" class="row-4">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
					<svg height="100" width="100" class="row-3">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
					<svg height="100" width="100" class="row-2">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
					<svg height="100" width="100" class="row-1">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
					<svg height="100" width="100" class="row-0">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
				</div>
				<div class="column" id="column-3" data-x="3">
					<svg height="100" width="100" class="row-5">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
					<svg height="100" width="100" class="row-4">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
					<svg height="100" width="100" class="row-3">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
					<svg height="100" width="100" class="row-2">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
					<svg height="100" width="100" class="row-1">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
					<svg height="100" width="100" class="row-0">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
				</div>
				<div class="column" id="column-4" data-x="4">
					<svg height="100" width="100" class="row-5">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
					<svg height="100" width="100" class="row-4">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
					<svg height="100" width="100" class="row-3">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
					<svg height="100" width="100" class="row-2">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
					<svg height="100" width="100" class="row-1">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
					<svg height="100" width="100" class="row-0">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
				</div>
				<div class="column" id="column-5" data-x="5">
					<svg height="100" width="100" class="row-5">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
					<svg height="100" width="100" class="row-4">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
					<svg height="100" width="100" class="row-3">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
					<svg height="100" width="100" class="row-2">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
					<svg height="100" width="100" class="row-1">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
					<svg height="100" width="100" class="row-0">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
				</div>
				<div class="column" id="column-6" data-x="6">
					<svg height="100" width="100" class="row-5">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
					<svg height="100" width="100" class="row-4">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
					<svg height="100" width="100" class="row-3">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
					<svg height="100" width="100" class="row-2">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
					<svg height="100" width="100" class="row-1">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
					</svg> 
					<svg height="100" width="100" class="row-0">
						<circle cx="50" cy="50" r="40" stroke="#0B4E72" stroke-width="3" class="free" />
				</svg> 
			</div>
		</div>
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
						<input type="button" value="send" class="btn btn-primary"/>
				</div>
</div>

<div id="Users" class="tabcontent">
  
   
</div>
</div>
		</div>      
	</div>		
</div>';
addFooter();