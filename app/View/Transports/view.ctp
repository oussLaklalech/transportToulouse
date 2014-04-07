<div class="transports view">
<h2><?php echo __('Transport'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($transport['Transport']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Like'); ?></dt>
		<dd>
			<?php echo h($transport['Transport']['like']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Unlike'); ?></dt>
		<dd>
			<?php echo h($transport['Transport']['unlike']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($transport['Transport']['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Numero'); ?></dt>
		<dd>
			<?php echo h($transport['Transport']['numero']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($transport['Transport']['name']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Transport'), array('action' => 'edit', $transport['Transport']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Transport'), array('action' => 'delete', $transport['Transport']['id']), null, __('Are you sure you want to delete # %s?', $transport['Transport']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Transports'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Transport'), array('action' => 'add')); ?> </li>
	</ul>
</div>
