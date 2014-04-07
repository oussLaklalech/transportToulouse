<div class="transports index">
	<h2><?php echo __('Transports'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('like'); ?></th>
			<th><?php echo $this->Paginator->sort('unlike'); ?></th>
			<th><?php echo $this->Paginator->sort('type'); ?></th>
			<th><?php echo $this->Paginator->sort('numero'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($transports as $transport): ?>
	<tr>
		<td><?php echo h($transport['Transport']['id']); ?>&nbsp;</td>
		<td><?php echo h($transport['Transport']['like']); ?>&nbsp;</td>
		<td><?php echo h($transport['Transport']['unlike']); ?>&nbsp;</td>
		<td><?php echo h($transport['Transport']['type']); ?>&nbsp;</td>
		<td><?php echo h($transport['Transport']['numero']); ?>&nbsp;</td>
		<td><?php echo h($transport['Transport']['name']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $transport['Transport']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $transport['Transport']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $transport['Transport']['id']), null, __('Are you sure you want to delete # %s?', $transport['Transport']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Transport'), array('action' => 'add')); ?></li>
	</ul>
</div>
