<div class="stocks view">
<h2><?php  echo __('Stock'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($stock['Stock']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($stock['Stock']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Comment'); ?></dt>
		<dd>
			<?php echo h($stock['Stock']['comment']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Category'); ?></dt>
		<dd>
			<?php echo $this->Html->link($stock['Category']['name'], array('controller' => 'categories', 'action' => 'view', $stock['Category']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Yesterday'); ?></dt>
		<dd>
			<?php echo h($stock['Stock']['yesterday']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Stock'), array('action' => 'edit', $stock['Stock']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Stock'), array('action' => 'delete', $stock['Stock']['id']), null, __('Are you sure you want to delete # %s?', $stock['Stock']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Stocks'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Stock'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Books'), array('controller' => 'books', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Book'), array('controller' => 'books', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Indices'), array('controller' => 'indices', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Index'), array('controller' => 'indices', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Offers'), array('controller' => 'offers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Offer'), array('controller' => 'offers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Transactions'), array('controller' => 'transactions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Transaction'), array('controller' => 'transactions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Year Variations'), array('controller' => 'year_variations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Year Variation'), array('controller' => 'year_variations', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Books'); ?></h3>
	<?php if (!empty($stock['Book'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Quantity'); ?></th>
		<th><?php echo __('Average Price'); ?></th>
		<th><?php echo __('Profit'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($stock['Book'] as $book): ?>
		<tr>
			<td><?php echo $book['id']; ?></td>
			<td><?php echo $book['user_id']; ?></td>
			<td><?php echo $book['quantity']; ?></td>
			<td><?php echo $book['average_price']; ?></td>
			<td><?php echo $book['profit']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'books', 'action' => 'view', $book['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'books', 'action' => 'edit', $book['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'books', 'action' => 'delete', $book['id']), null, __('Are you sure you want to delete # %s?', $book['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Book'), array('controller' => 'books', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Indices'); ?></h3>
	<?php if (!empty($stock['Index'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Stock Id'); ?></th>
		<th><?php echo __('Category Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($stock['Index'] as $index): ?>
		<tr>
			<td><?php echo $index['id']; ?></td>
			<td><?php echo $index['stock_id']; ?></td>
			<td><?php echo $index['category_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'indices', 'action' => 'view', $index['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'indices', 'action' => 'edit', $index['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'indices', 'action' => 'delete', $index['id']), null, __('Are you sure you want to delete # %s?', $index['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Index'), array('controller' => 'indices', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Offers'); ?></h3>
	<?php if (!empty($stock['Offer'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Quantity'); ?></th>
		<th><?php echo __('Price'); ?></th>
		<th><?php echo __('Type'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Stock Id'); ?></th>
		<th><?php echo __('Date'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($stock['Offer'] as $offer): ?>
		<tr>
			<td><?php echo $offer['id']; ?></td>
			<td><?php echo $offer['quantity']; ?></td>
			<td><?php echo $offer['price']; ?></td>
			<td><?php echo $offer['type']; ?></td>
			<td><?php echo $offer['user_id']; ?></td>
			<td><?php echo $offer['stock_id']; ?></td>
			<td><?php echo $offer['date']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'offers', 'action' => 'view', $offer['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'offers', 'action' => 'edit', $offer['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'offers', 'action' => 'delete', $offer['id']), null, __('Are you sure you want to delete # %s?', $offer['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Offer'), array('controller' => 'offers', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Transactions'); ?></h3>
	<?php if (!empty($stock['Transaction'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Buyer Id'); ?></th>
		<th><?php echo __('Seller Id'); ?></th>
		<th><?php echo __('Stock Id'); ?></th>
		<th><?php echo __('Quantity'); ?></th>
		<th><?php echo __('Value'); ?></th>
		<th><?php echo __('Date'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($stock['Transaction'] as $transaction): ?>
		<tr>
			<td><?php echo $transaction['id']; ?></td>
			<td><?php echo $transaction['buyer_id']; ?></td>
			<td><?php echo $transaction['seller_id']; ?></td>
			<td><?php echo $transaction['stock_id']; ?></td>
			<td><?php echo $transaction['quantity']; ?></td>
			<td><?php echo $transaction['value']; ?></td>
			<td><?php echo $transaction['date']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'transactions', 'action' => 'view', $transaction['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'transactions', 'action' => 'edit', $transaction['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'transactions', 'action' => 'delete', $transaction['id']), null, __('Are you sure you want to delete # %s?', $transaction['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Transaction'), array('controller' => 'transactions', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Year Variations'); ?></h3>
	<?php if (!empty($stock['YearVariation'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Stock Id'); ?></th>
		<th><?php echo __('Stock Name'); ?></th>
		<th><?php echo __('Value'); ?></th>
		<th><?php echo __('Date'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($stock['YearVariation'] as $yearVariation): ?>
		<tr>
			<td><?php echo $yearVariation['id']; ?></td>
			<td><?php echo $yearVariation['stock_id']; ?></td>
			<td><?php echo $yearVariation['stock_name']; ?></td>
			<td><?php echo $yearVariation['value']; ?></td>
			<td><?php echo $yearVariation['date']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'year_variations', 'action' => 'view', $yearVariation['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'year_variations', 'action' => 'edit', $yearVariation['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'year_variations', 'action' => 'delete', $yearVariation['id']), null, __('Are you sure you want to delete # %s?', $yearVariation['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Year Variation'), array('controller' => 'year_variations', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
