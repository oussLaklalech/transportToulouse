<style>
.maligne
{
margin-bottom:3px;
border-bottom: solid 2px #336699;
width:100%;
} 
</style>

<form>

<div class="transports form">
		<h3>Station : </h3> 
		<p>
			<?php
			if(isset($ResultBus->departures->stopArea->name))
			 echo $ResultBus->departures->stopArea->name;?>	
		</p>

		<h3>Destination : </h3> 
		<p>
			<?php 
			if(isset($ResultBus->departures->departure[0]->destination[0]->name))
			echo $ResultBus->departures->departure[0]->destination[0]->name;?>	
		</p>

		<h3>Numero du Bus : </h3> 
		<p>
			<?php 
			if(isset($ResultBus->departures->departure[0]->line->shortName))
			echo $ResultBus->departures->departure[0]->line->shortName;?>	
		</p>

		<h3>Prochains passages :</h3>
		<p>
	   <?php
	   debug($ResultBus);
	   for ($i=0; $i <count($ResultBus->departures->departure) ; $i++) {
	   	if(isset($ResultBus->departures->departure[$i]->dateTime))
	   	echo $ResultBus->departures->departure[$i]->dateTime."</br>"; 
	   	}
	   ?>
	   </p>

</div>
</form>
<div class="maligne" /></div> 
<div class="footer">&raquo; <a href="">j'aime</a> | <a href="">J'aime pas</a></div>