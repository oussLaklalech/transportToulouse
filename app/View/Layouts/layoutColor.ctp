<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pl" xml:lang="pl">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="author" content="Paweł 'kilab' Balicki - kilab.pl" />
<title>OneClick</title>
<?php   
	echo  $this->Html->css('loginColor');
	echo $this->Html->script('jquery');
	echo $this->Html->script('jquery2');
  echo $this->Html->script('gestionAffichage');
?>

</head>
<body>
	
		<!--<button type="button" class="close" data-dismiss="alert">×</button>-->
	
<div class="wrap">
	<div id="content">
		<div id="main">
			<div class="full_w">
				<p><?php 
                echo $content_for_layout;
         ?>
    			</p>
			</div>
		</div>
	</div>
</div>

</body>
</html>
