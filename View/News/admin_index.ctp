<table>
        <tr>
            <th>ID</th>
            <th>Text</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    <?php foreach ($news as $nw){ ?>
        <tr>
            <td><?php echo $nw['News']['id']; ?></td>
            <td><?php echo $nw['News']['text']; ?></td>
            <td><?php echo $nw['News']['created']; ?></td>
            <td><?php echo $this->Form->postLink(
                    __('Delete'), 
                    array('action' => 'delete', $nw['News']['id']),
                    null, 
                    __('Are you sure you want to delete # %s?', $nw['News']['id'])
                    ); ?>
            </td>
        </tr>
    <?php } ?>
</table>

<div>
<?php echo $this->Form->create('News', array('action' => 'grab')); ?>
	<fieldset>
		<legend><?php echo __('Admin Add News'); ?></legend>
	    <?php echo $this->Form->input('number'); ?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>

