<style>
.maligne
{
margin-bottom:3px;
border-bottom: solid 2px #336699;
width:100%;
} 
</style>

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

<?php echo $this->Form->create('Transports', array('action' => 'result','type' => 'get'));?>
<div class="transports form">
<div>
<input type= "radio" name="data[Transport][Choix]" value="velo" onclick="$('.ok').show('medium');$('div.divStation').show('medium');$('div.divDestination').hide(100);$('div.divNumBus').hide(100);$('div.divInfos').hide(100);"> Velô

<input type= "radio" name="data[Transport][Choix]" value="busMetro" onclick="$('.ok').show('medium');$('div.divStation').hide(100);$('div.divDestination').show('medium');$('div.divNumBus').show('medium');$('div.divInfos').hide(100);maFonction()" style="margin-left : 15px"> Bus / Metro

<input type= "radio" name="data[Transport][Choix]" value="peuImporte" onclick="$('.ok').show('medium');$('div.divStation').hide(100);$('div.divDestination').show('medium');$('div.divNumBus').hide(100);$('div.divInfos').hide(100);" style="margin-left : 15px"> Peu importe

<input type= "radio" name="data[Transport][Choix]" value="info" onclick="$('.ok').hide(100);$('div.divStation').hide(100);$('div.divDestination').hide(100);$('div.divNumBus').hide(100);$('div.divInfos').show('medium');" style="margin-left : 15px"> infos
</div>
<br/><br/>
<!--*******************************div Station ************************************-->
<div class="divStation" style="display:none;">
<label>Station : </label> 
<select name="data[Transport][Station]">
  <?php
    foreach ($stationVelo as $value) {
      echo '<option value = "'.$value.'">'.$value.'</option>';
    }
  ?>
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
<label>Numero du BUS / ligne Metro : </label>


<select name="data[Transport][numBus]" id="selectNumBus">
<?php

?>
</select>
</div>

<!--*********************************div infos ************************************-->
<div class="divInfos" style="display:none;">
<p><?php 

for ($i=0; $i <count($rupture) ; $i++) { 
  ?>
<h3> numero bus : </h3>  
<?php
  echo $rupture[$i]->shortname;
?>
<h3> message : </h3>
<?php
echo $rupture[$i]->disturbMessage->content ;
?>
<br/>
<div class="maligne" /></div> 

<?php
}
?></p>

</div>
<br/>
<!--*********************************div infos ************************************-->

<br/>
<button type="submit" class="ok">Chercher</button> 
</form>
</div>