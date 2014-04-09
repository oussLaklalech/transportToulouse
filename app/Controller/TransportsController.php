<?php
App::uses('AppController', 'Controller');
App::uses('HttpSocket','Network/Http');
/**
 * Transports Controller
 *
 * @property Transport $Transport
 */
class TransportsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function search() {
			$this->layout='layout';
			$infosBus = new HttpSocket(array('ssl_allow_self_signed' => true)); // Retourne les numeros de BUS
			$infosBus = $infosBus -> get("http://pt.data.tisseo.fr/stopAreasList?displayLines=1&lineId=1970324837185012&format=json&key=a03561f2fd10641d96fb8188d209414d8");
			$infosBus = json_decode($infosBus); // retourne toute les lignes des arret de l université paul sabatier

			//$result=getInfoLigne(2,3,4);

			//$this->Transport->recursive = 0;
			$this->set('LignesBus', $infosBus->stopAreas);
			//debug($infosBus1);
			$infosBus4 = new HttpSocket(array('ssl_allow_self_signed' => true));//Retourne les destinations + LignesBus
			$infosBus4 = $infosBus4 -> get("http://pt.data.tisseo.fr/stopPointsList?format=json&lineShortName=54&stopAreaId=1970324837185012&displayLines=1&key=a03561f2fd10641d96fb8188d209414d8");
			$infosBus4 = json_decode($infosBus4);
			$this->set('DestinationsBus', $infosBus4->physicalStops);
			$ligneDestinations=$infosBus4->physicalStops;
			$arrayDestinationLignes= array();
			// construction de la table de correspondance
			for($j=0;$j<count($ligneDestinations->physicalStop);$j++){ 
				for ($e=0; $e <count($ligneDestinations->physicalStop[$j]->destinations) ; $e++){
					for ($i=0; $i <count($ligneDestinations->physicalStop[$j]->destinations[$e]->line) ; $i++) { 
						array_push($arrayDestinationLignes, array($ligneDestinations->physicalStop[$j]->destinations[$e]->name => $ligneDestinations->physicalStop[$j]->destinations[$e]->line[$i]->shortName));
				 }
			}
     	}	

		$this->set('destinationLigne', $arrayDestinationLignes);

		$stationVelo=array();
		$infosVelo = new HttpSocket(array('ssl_allow_self_signed' => true));
		$infosVelo = $infosVelo -> get("https://api.jcdecaux.com/vls/v1/stations?contract=Toulouse&number=100&apiKey=e1201f2e4fb8286c45cd948f996e567e466b01b2"); 
		$infosVelo = json_decode($infosVelo); 
		for ($i=0; $i <count($infosVelo) ; $i++) { 
			if($infosVelo[$i]->number=="227" || $infosVelo[$i]->number=="233" || $infosVelo[$i]->number=="231" || $infosVelo[$i]->number=="232"){ 
			array_push($stationVelo, $infosVelo[$i]->name);
		}
		$this->set('stationVelo',$stationVelo);
	}
}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function result() {
		$this->layout='layoutColor';
		//debug($this->request->data);

		if ($this->request->is('get')) {
			$data = $this->request->query['data'];

			//*********************************************************************************************
			//************** le cas d'un bus/metro******************************************************
			//********************************************************************************************
			
			if($data['Transport']['Choix'] == "busMetro"){
				$infosBus4 = new HttpSocket(array('ssl_allow_self_signed' => true));//Retourne les destinations + LignesBus
			$infosBus4 = $infosBus4 -> get("http://pt.data.tisseo.fr/stopPointsList?format=json&lineShortName=54&stopAreaId=1970324837185012&displayLines=1&key=a03561f2fd10641d96fb8188d209414d8");
			$infosBus4 = json_decode($infosBus4);

			//debug($infosBus4);


				for($j=0;$j<count($infosBus4->physicalStops->physicalStop);$j=$j+1){ 
					for ($e=0; $e <count($infosBus4->physicalStops->physicalStop[$j]->destinations) ; $e++){ 
						for ($i=0; $i <count($infosBus4->physicalStops->physicalStop[$j]->destinations[$e]->line) ; $i++) { 
							if (strcmp($infosBus4->physicalStops->physicalStop[$j]->destinations[$e]->name,$data['Transport']['Destination'])==0 && $infosBus4->physicalStops->physicalStop[$j]->destinations[$e]->line[$i]->shortName==$data['Transport']['numBus']){ 
									$valeur=$infosBus4->physicalStops->physicalStop[$j]->operatorCodes[0]->operatorCode->value; 
									$Idline=$infosBus4->physicalStops->physicalStop[$j]->destinations[$e]->line[0]->id;
									break; 
									}
							}
						}
					 }



			$ResultBus = new HttpSocket(array('ssl_allow_self_signed' => true));
			$ResultBus = $ResultBus -> get("http://pt.data.tisseo.fr/departureBoard?lineId=".$Idline."&operatorCode=".$valeur."&format=json&key=a03561f2fd10641d96fb8188d209414d8");
			$ResultBus = json_decode($ResultBus);

			//***********************************************
			//ajouter le transport a la BDD s'il nexiste pas
			//***********************************************
			$id_api=$data['Transport']['numBus'];
			if(isset($id_api))
				$resultQuery = $this->Transport->query("SELECT * FROM transports WHERE transports.id_api = '$id_api';");
			
		//Si le moyen de transport n'a jamais été ajouté à la BDD
		if(empty($resultQuery) && isset($id_api)) {
			$success=$this->Transport->save(array(
				'like' => 0,
				'unlike' => 0,
				'id_api' => "$id_api"
				));
			$nblike=0;
			$nbunlike=0;
		} else {
			$nblike=$resultQuery[0]['transports']['like'];
			$nbunlike=$resultQuery[0]['transports']['unlike'];
		}

			$this->set('nblike',$nblike);
			$this->set('nbunlike',$nbunlike);
			$this->set('ResultBus', $ResultBus);
			$this->set('choix',$data['Transport']['Choix']);

			//*********************************************************************************************
			//************** le cas d'un velo******************************************************
			//********************************************************************************************
			} else if($data['Transport']['Choix'] == "velo") {
					$stationVelo = array();

					$infosVelo = new HttpSocket(array('ssl_allow_self_signed' => true));
					$infosVelo = $infosVelo -> get("https://api.jcdecaux.com/vls/v1/stations?contract=Toulouse&number=100&apiKey=e1201f2e4fb8286c45cd948f996e567e466b01b2"); 
					$infosVelo = json_decode($infosVelo); 

					for ($i=0; $i <count($infosVelo) ; $i++) { 
					if($infosVelo[$i]->number==$data['Transport']['Station']){
						array_push($stationVelo, $infosVelo[$i]);
					break;
						} 
					}
					//***********************************************
					//ajouter le transport a la BDD s'il nexiste pas
					//***********************************************
					$id_api="velo";
				$resultQuery = $this->Transport->query("SELECT * FROM transports WHERE transports.id_api = '$id_api';");
					
				//Si le moyen de transport n'a jamais été ajouté à la BDD
				if(empty($resultQuery) && isset($id_api)) {
					$success=$this->Transport->save(array(
						'like' => 0,
						'unlike' => 0,
						'id_api' => "$id_api"
						));
					$nblike=0;
					$nbunlike=0;
				} else {
					$nblike=$resultQuery[0]['transports']['like'];
					$nbunlike=$resultQuery[0]['transports']['unlike'];
				}

					$this->set('nblike',$nblike);
					$this->set('nbunlike',$nbunlike);
					$this->set('stationVelo',$stationVelo);
					$this->set('choix',$data['Transport']['Choix']);

			//*********************************************************************************************
			//************** le cas d'un choix n'importe******************************************************
			//********************************************************************************************
			} else {

			$infosBus4 = new HttpSocket(array('ssl_allow_self_signed' => true));//Retourne les destinations + LignesBus
			$infosBus4 = $infosBus4 -> get("http://pt.data.tisseo.fr/stopPointsList?format=json&lineShortName=54&stopAreaId=1970324837185012&displayLines=1&key=a03561f2fd10641d96fb8188d209414d8");
			$infosBus4 = json_decode($infosBus4);

			//debug($infosBus4);
			$valeur=array();
			$Idline=array();

				for($j=0;$j<count($infosBus4->physicalStops->physicalStop);$j=$j+1){ 
					for ($e=0; $e <count($infosBus4->physicalStops->physicalStop[$j]->destinations) ; $e++){ 
						for ($i=0; $i <count($infosBus4->physicalStops->physicalStop[$j]->destinations[$e]->line) ; $i++) { 
							if (strcmp($infosBus4->physicalStops->physicalStop[$j]->destinations[$e]->name,$data['Transport']['Destination'])==0){ 
									array_push($valeur,$infosBus4->physicalStops->physicalStop[$j]->operatorCodes[0]->operatorCode->value); 
									array_push($Idline,$infosBus4->physicalStops->physicalStop[$j]->destinations[$e]->line[0]->id);
								echo $i."  ";
									break; 
									}
							}
						}
					 }

			for ($i=0; $i <count($valeur) ; $i++) { 
				$ResultBus[$i] = new HttpSocket(array('ssl_allow_self_signed' => true));
				$ResultBus[$i] = $ResultBus[$i] -> get("http://pt.data.tisseo.fr/departureBoard?lineId=".$Idline[$i]."&operatorCode=".$valeur[$i]."&format=json&key=a03561f2fd10641d96fb8188d209414d8");
				$ResultBus[$i] = json_decode($ResultBus[$i]);	
				}
			
				$this->set('nimporte',$ResultBus);
				$this->set('choix',$data['Transport']['Choix']);
			}
		
			//debug($infosBus2);
		} else {
			$this->redirect(array('action' => 'search'));
		}

	}

	/**
 * like method
 *
 * @param string $id
 * @return void
 */
	public function like($type = null, $id = null) {
		//$this->Transport->id_api = $id;

		$resultQuery = $this->Transport->query("SELECT * FROM transports WHERE id_api = '$id';");
		
		//Si le moyen de transport n'a jamais été ajouté à la BDD
		if(!empty($resultQuery)) {
			$ident = $resultQuery[0]['transports']['id'];
			$like = $resultQuery[0]['transports']['like'];
			$unlike = $resultQuery[0]['transports']['unlike'];
			$id_api = $resultQuery[0]['transports']['id_api'];

			if($type == 1){
			$success=$this->Transport->save(array(
				'id' => $ident,
				'like' => $like+1,
				'unlike' => $unlike,
				'id_api' => "$id"
				));
			} else {
				$success=$this->Transport->save(array(
				'id' => $ident,
				'like' => $like,
				'unlike' => $unlike+1,
				'id_api' => "$id"
				));
			}
		}
		 $this->redirect($this->referer());
		//$this->redirect(array('action' => 'result'));

	}


}
