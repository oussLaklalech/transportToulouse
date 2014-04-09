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
	public function index() {
		$this->Transport->recursive = 0;
		$this->set('transports', $this->paginate());
	}

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
		$this->layout='layout';
		debug($this->request->data);

		if ($this->request->is('post')) {
			$data = $this->request->data;

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
			$this->set('ResultBus', $ResultBus);
			$this->set('choix',$data['Transport']['Choix']);

			} else if($data['Transport']['Choix'] == "velo") {
					$stationVelo = array();

					$infosVelo = new HttpSocket(array('ssl_allow_self_signed' => true));
					$infosVelo = $infosVelo -> get("https://api.jcdecaux.com/vls/v1/stations?contract=Toulouse&number=100&apiKey=e1201f2e4fb8286c45cd948f996e567e466b01b2"); 
					$infosVelo = json_decode($infosVelo); 

					for ($i=0; $i <count($infosVelo) ; $i++) { 
					if($infosVelo[$i]->number==$data['Transport']['Station']){
						array_push($stationVelo, $infosVelo[$i]);
					//echo "name ".$infosVelo[$i]->name."<br />"; 
					//echo "nombre place libre ".$infosVelo[$i]->available_bike_stands."<br/>"; 
					//echo "nombre de velo dispo ".$infosVelo[$i]->available_bikes."<br/>"; 
					break;
						} 
					}
					$this->set('stationVelo',$stationVelo);
					$this->set('choix',$data['Transport']['Choix']);

			} else {

				$this->set('choix',$data['Transport']['Choix']);
			}
		
			//debug($infosBus2);
		} else {
			$this->redirect(array('action' => 'search'));
		}

	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Transport->exists($id)) {
			throw new NotFoundException(__('Invalid transport'));
		}
		$options = array('conditions' => array('Transport.' . $this->Transport->primaryKey => $id));
		$this->set('transport', $this->Transport->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Transport->create();
			if ($this->Transport->save($this->request->data)) {
				$this->Session->setFlash(__('The transport has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The transport could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Transport->exists($id)) {
			throw new NotFoundException(__('Invalid transport'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Transport->save($this->request->data)) {
				$this->Session->setFlash(__('The transport has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The transport could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Transport.' . $this->Transport->primaryKey => $id));
			$this->request->data = $this->Transport->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Transport->id = $id;
		if (!$this->Transport->exists()) {
			throw new NotFoundException(__('Invalid transport'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Transport->delete()) {
			$this->Session->setFlash(__('Transport deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Transport was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
