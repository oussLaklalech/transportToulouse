<div class="transports form">
<?php echo $this->Form->create('Transport'); ?>
	<fieldset>
		<legend><?php echo __('Add Transport'); ?></legend>
	<?php
		echo $this->Form->input('like');
		echo $this->Form->input('unlike');
		echo $this->Form->input('type');
		echo $this->Form->input('numero');
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Transports'), array('action' => 'index')); ?></li>
	</ul>
</div>
