<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\Country[] $countries
 */
?>
<nav class="actions col-sm-4 col-xs-12">
	<?php echo $this->element('navigation/ajax'); ?>
</nav>
<div class="page index col-sm-8 col-xs-12">

<div class="ajax-form">
<h2>AJAX Buttons: Deleting in tables</h2>

	<p>Click on the Delete button and see the row disappear if successful.</p>

<div class="form-container">

	<table class="table list" width="100%">
		<tr>
			<th><?php echo $this->Paginator->sort('sort', $this->Format->icon('filter'), ['escape' => false]);?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('iso2');?></th>
			<th><?php echo __('Actions'); ?></th>
		</tr>
		<?php
		foreach ($countries as $country):
			?>
			<tr>
				<td>
					<?php echo $this->Data->countryIcon($country['iso2']); ?>
				</td>
				<td>
					<?php echo h($country['name']); ?>
				</td>
				<td>
					<?php echo h($country['iso2']); ?>
				</td>
				<td class="actions">
					<?php echo $this->Form->postLink($this->Format->icon('delete') . ' ' . __('Delete'), ['action' => 'tableDelete', $country['id']], ['class' => 'btn btn-default ajax-delete', 'escapeTitle' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $country['name'])]); ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>

	<?php echo $this->element('Tools.pagination'); ?>


</div>

</div>


	<p>All this needs is basically</p>
	<ul>
		<li>A "post link" with e.g. a <code>ajax-delete</code> class added to signal this should be ajax-deletable.</li>
		<li>A small JS snippet (see source code)</li>
	</ul>

</div>

<script>
    $(document).ready(function() {
        $('table.list a.ajax-delete').removeAttr('onclick').click(function(e) {
            e.preventDefault();

            var alert = $(this).data('confirm');
            if (alert && !confirm(alert)) {
                return false;
            }
            var form = $(this).prev();
            var url = $(form).attr("action");
            var tr = $(this).closest('tr');
            url = url + '.json';
            $.post(url).success(function(res) {
                if (res.error) {
                    alert(res.error);
                    return false;
                }
                tr.fadeOut(200);
            }).error(function() {
                alert("Error");
            });
            return false;
        });
    });
</script>

