<style>
.maligne
{
margin-bottom:3px;
border-bottom: solid 2px #336699;
width:100%;
} 
</style>

<form>

<?php
if($choix == "busMetro"){
?>
<div class="busMetro form">
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
	  // debug($ResultBus);
	   for ($i=0; $i <count($ResultBus->departures->departure) ; $i++) {
	   	if(isset($ResultBus->departures->departure[$i]->dateTime))
	   	echo $ResultBus->departures->departure[$i]->dateTime."</br>"; 
	   	}
	   ?>
	   </p>

</div>
<?php } else if($choix == "velo") {
?>
<div class="velo form">
		<h3>Station : </h3> 
		<p>
			<?php
			if(isset($stationVelo[0]->name))
			 echo $stationVelo[0]->name;?>	
		</p>

		<h3>Nombre de vélos diponible : </h3> 
		<p>
			<?php 
			if(isset($stationVelo[0]->available_bikes))
			echo $stationVelo[0]->available_bikes;?>	
		</p>

		<h3>Nombre de places vides : </h3> 
		<p>
			<?php 
			if(isset($stationVelo[0]->available_bike_stands))
			echo $stationVelo[0]->available_bike_stands;?>	
		</p>
</div>
<?php } ?>

</form>
<div class="maligne" /></div> 
<div class="footer">&raquo; <a href="">j'aime</a> | <a href="">J'aime pas</a></div>