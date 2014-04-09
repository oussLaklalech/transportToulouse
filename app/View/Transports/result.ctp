<style>
.maligne
{
margin-bottom:3px;
border-bottom: solid 2px #336699;
width:100%;
} 
</style>

<form>
<a href="/transportApp/transports/search">Nouvelle recherche</a>
			<div class="maligne" /></div>
<?php
if($choix == "busMetro"){
	if(!empty($ResultBus->departures->stopArea->name)){
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
<div class="maligne" /></div>
<div class="footer">&raquo; <a href="/transportApp/transports/like/1/<?php echo $ResultBus->departures->departure[0]->line->shortName;?>">j'aime (<?php echo $nblike;?>)</a> | <a href="/transportApp/transports/like/2/<?php echo $ResultBus->departures->departure[0]->line->shortName;?>">J'aime pas (<?php echo $nbunlike;?>)</a></div>
<?php } 
		else {
			echo "Aucun passage pour le moment concernant le BUS demandé";
		}
}else if($choix == "velo") {
	if(!empty($stationVelo[0]->name)) {
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
<div class="maligne" /></div>
<div class="footer">&raquo; <a href="/transportApp/transports/like/1/<?php echo "velo";?>">j'aime (<?php echo $nblike;?>)</a> | <a href="/transportApp/transports/like/2/<?php echo "velo";?>">J'aime pas (<?php echo $nbunlike;?>)</a></div>
<?php } else {
			echo "Aucune information disponible pour le moment";
}

}else { 
	if(!empty($nimporte[0]->departures->departure[0]->dateTime)){
	?>
<div class="nimporte form">
	<?php
	for ($j=0; $j <count($nimporte) ; $j++) { 
		if (isset($nimporte[$j]->departures->departure[0]->dateTime)) {
			$ordre[$j]=$nimporte[$j]->departures->departure[0]->dateTime;
		}
	}
		sort($ordre);



	for ($j=0; $j < count($ordre) ; $j++) { 

		for ($i=0; $i <count($nimporte) ; $i++) { 
			if ($ordre[$j]==$nimporte[$i]->departures->departure[0]->dateTime) {
			?>
		<h3>Station : </h3> 
		<p>
			<?php
			if(isset($nimporte[$i]->departures->stop->name))
			 echo $nimporte[$i]->departures->stop->name;
			?>	
		</p>
		<h3>Destination : </h3> 
		<p>
			<?php 
			if(isset($nimporte[$i]->departures->departure[0]->destination[0]->name))
			echo $nimporte[$i]->departures->departure[0]->destination[0]->name;
			?>	
		</p>
		<h3>Numero du Bus : </h3> 
		<p>
			<?php 
			if(isset($nimporte[$i]->departures->departure[0]->line->shortName))
			echo $nimporte[$i]->departures->departure[0]->line->shortName;
			?>	
		</p>

		<h3>Prochains passages : </h3> 
		<p>
			<?php
			if (count($nimporte[$i]->departures->departure)>2) {
				$nombre=2;
			}
			else{
				$nombre=count($nimporte[$i]->departures->departure);
			}

			for ($e=0 ; $e<$nombre ; $e++) {
	   	if(isset($nimporte[$i]->departures->departure[$e]->dateTime))
	   	echo $nimporte[$i]->departures->departure[$e]->dateTime."</br>"; 
		}
		
	   	?>
		</p>
		<br/>
<div class="maligne" /></div> 
<div class="footer">&raquo; <a href="">j'aime</a> | <a href="">J'aime pas</a></div>
		<?php 
		break;
		}
  	}
} ?>
</div>
<?php }else {
		echo "Aucun passage pour le moment concernant la destination choisie";
	}

} ?>

</form>