<?php 
      $json = json_encode ( $destinationLigne, JSON_FORCE_OBJECT );

?>

<script type="text/javascript">

    function maFonction(){

    var json_obj = <?php echo $json;?>;
    var indicateur=0;
    $('#selectNumBus').empty();
    for (var i = 0; i < Object.keys(json_obj).length; i++) {
      if(json_obj[i][$('#selectDestination').val()]){
               $('#selectNumBus').append('<option value="'+json_obj[i][$("#selectDestination").val()]+'">'+json_obj[i][$('#selectDestination').val()]+'</option>');
            }
    }
  }
</script>
<div class="transports form">
<form>
<input type= "radio" name="moyen" value="velo" onclick="$('div.divStation').show('medium');$('div.divDestination').hide(100);$('div.divNumBus').hide(100);"> Velô
<input type= "radio" name="moyen" value="bus" onclick="$('div.divStation').hide(100);$('div.divDestination').show('medium');$('div.divNumBus').show('medium');maFonction()"> Bus
<input type= "radio" name="moyen" value="metro" onclick=""> Metro
<input type= "radio" name="moyen" value="peuimporte" onclick="$('div.divStation').hide(100);$('div.divDestination').show('medium');$('div.divNumBus').hide(100);"> Peu importe
</form>

<?php echo $this->Form->create('Transports', array('action' => 'result'));?>

<!--*******************************div Station ************************************-->
<div class="divStation" style="display:none;">
<label>Station : </label> 
<select name="data[Transport][Station]">
  <option value="volvo">Volvo</option>
  <option value="saab">Saab</option>
  <option value="mercedes">Mercedes</option>
  <option value="audi">Audi</option>
</select>
</div>

<!--*******************************div Destination ************************************-->
<div class="divDestination" style="display:none;">
<label>Destination : </label> 
<!--<select name="data[Transport][Destination]" onchange="$('#ici').append($(this).val())">-->
<select name="data[Transport][Destination]" id="selectDestination" onchange="maFonction()">
  <?php
 for ($j=1; $j <count($DestinationsBus->physicalStop) ; $j++) { 
      echo '<option value="'.$DestinationsBus->physicalStop[$j]->destinations[0]->name.'" > '.$DestinationsBus->physicalStop[$j]->destinations[0]->name.'</option>';
    }
?> 
</select>
</div>

<!--*********************************div num bus ************************************-->
<div class="divNumBus" style="display:none;">
<label>Numero du BUS : </label>


<select name="data[Transport][numBus]" id="selectNumBus">
<?php

?>
</select>
</div>

<button type="submit" class="ok">Chercher</button> 
</form>
</div>