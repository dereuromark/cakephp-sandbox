<script type="text/javascript">
$(document).ready(function() {
	// Initialise the table
	$("#table-1").tableDnD();


	$("#table-2").tableDnD({
		onDragClass: "myDragClass",
		onDrop: function(table, row) {
			var rows = table.tBodies[0].rows;
			var debugStr = "Row dropped was "+row.id+". New order: ";
			for (var i=0; i<rows.length; i++) {
				debugStr += rows[i].id+" ";
			}
			$("#debugArea").html(debugStr);
		},
		onDragStart: function(table, row) {
			$("#debugArea").html("Started dragging row "+row.id);
		}
	});



	$('#table-3').tableDnD({
		onDrop: function(table, row) {
			alert("Result of $.tableDnD.serialise() is "+$.tableDnD.serialize());
			$('#AjaxResult').load("/c/telapp/jquery_examples/sortable_ajax/"+$.tableDnD.serialize());
		}
	});



	$('#table-5').tableDnD({
		onDrop: function(table, row) {
			alert($('#table-5').tableDnDSerialize());
		},
		dragHandle: "dragHandle"
	});

	$("#table-5 tr").hover(function() {
		 $(this.cells[0]).addClass('showDragHandle');
	}, function() {
		 $(this.cells[0]).removeClass('showDragHandle');
	});






});

/*
// pre-submit callback
function showRequest() {
	document.getElementById('ajax-loading').style.display = 'block';
	document.getElementById('ajax-loading-alt').style.display = 'block';
	return true;
}

// post-submit callback
function showResponse() {
	document.getElementById('ajax-loading').style.display = 'none';
	document.getElementById('ajax-loading-alt').style.display = 'none';
}

*/
</script>


<div id="ajax-loading"><?php echo $this->Format->icon('loader');?></div>
<div id="ajax-loading-alt"><?php echo $this->Format->icon('loader-alt');?></div>


<h1><?php echo __('Sort(t)able');?></h1>
Finally Sorting Data doesn't have to be time consuming any more.<br />
Notice: For Detailed Instructions see the Original Site: <?php echo $this->Html->link('www.isocra.com/2008/02/table-drag-and-drop-jquery-plugin/','http://www.isocra.com/2008/02/table-drag-and-drop-jquery-plugin/', array('target'=>'_blank'))?>


<?php
$jquery_plugins=array_merge($jquery_plugins, array('sortable'));
$this->Jquery->plugins($jquery_plugins);
?>

<br />


<h2>1 - An easy one to start with</h2>

<?php
$data_print='$(document).ready(function() {
	// Initialise the table
	$("#table-1").tableDnD();
});';
echo $this->Geshi->highlight($data_print,'javascript');
?>
The ID of the table is about everything it is needed. Although there are optional parameters that can be assigned.
<table id="table-1" class="list">
	<tr id="1"><td>1</td><td>One</td><td>some text</td></tr>
	<tr id="2"><td>2</td><td>Two</td><td>more text</td></tr>
	<tr id="3"><td>3</td><td>Three</td><td>yeaa text</td></tr>
	<tr id="4"><td>4</td><td>Four</td><td>huhu text</td></tr>
	<tr id="5"><td>5</td><td>Five</td><td>great text</td></tr>
	<tr id="6"><td>6</td><td>Six</td><td>boring text</td></tr>
</table>
Usually, there would be some sort of button in order to save the updated order into the DB.


<br />
<h2>2 - DraggableHighlight + DebugBox</h2>

<?php
$data_print='$("#table-2").tableDnD({
		onDragClass: "myDragClass",
		onDrop: function(table, row) {
			var rows = table.tBodies[0].rows;
			var debugStr = "Row dropped was "+row.id+". New order: ";
			for (var i=0; i<rows.length; i++) {
				debugStr += rows[i].id+" ";
			}
			$("#debugArea").html(debugStr);
		},
		onDragStart: function(table, row) {
			$("#debugArea").html("Started dragging row "+row.id);
		}
	});';
echo $this->Geshi->highlight($data_print,'javascript');
?>
The debug-content could be saved into a hidden field - to be submitted when finished sorting.
<div id="debugArea" style="float: right; width: 250px; border: 1px solid silver; padding: 4px;">&nbsp;</div>

<table id="table-2" class="list">
	<tr id="1"><td>1</td><td>One</td><td>some text</td></tr>
	<tr id="2"><td>2</td><td>Two</td><td>more text</td></tr>
	<tr id="3"><td>3</td><td>Three</td><td>yeaa text</td></tr>
	<tr id="4"><td>4</td><td>Four</td><td>huhu text</td></tr>
	<tr id="5"><td>5</td><td>Five</td><td>great text</td></tr>
</table>



<br />
<h2>3 - NoDraggable + Ajax Save etc.</h2>

<?php
$data_print='$(\'#table-3\').tableDnD({
		onDrop: function(table, row) {
			alert("Result of $.tableDnD.serialise() is "+$.tableDnD.serialize());
			$(\'#AjaxResult\').load("/jquery_examples/sortable_ajax/"+$.tableDnD.serialize());
		}
	});';
echo $this->Geshi->highlight($data_print,'javascript');
?>
<div id="AjaxResult" style="float: right; width: 250px; border: 1px solid silver; padding: 4px;"></div>

<table id="table-3" class="list">
<tr id="3.1">
<td>1</td>
<td>One</td>

<td>
<input type="text" name="one" value="one"/></td>
</tr>
<tr id="3.2">
<td>2</td>
<td>Two</td>
<td>
<input type="text" name="two" value="two"/></td>
</tr>
<tr id="3.3">
<td>3</td>
<td>Three</td>

<td>
<input type="text" name="three" value="three"/></td>
</tr>
<tr id="3.4">
<td>4</td>
<td>Four</td>
<td>
<input type="text" name="four" value="four"/></td>
</tr>
<tr id="3.5" class="nodrag">
<td>5</td>
<td>Five (Can&#8217;t drag this row)</td>

<td>
<input type="text" name="five" value="five"/></td>
</tr>
<tr id="3.6">
<td>6</td>
<td>Six</td>
<td>
<input type="text" name="six" value="six"/></td>
</tr>
</table>




<br />
<h2>4 - Drag Handle</h2>

<?php
$data_print='$(\'#table-5\').tableDnD({
		onDrop: function(table, row) {
			alert($(\'#table-5\').tableDnDSerialize());
		},
		dragHandle: "dragHandle"
	});

	$("#table-5 tr").hover(function() {
		 $(this.cells[0]).addClass(\'showDragHandle\');
	}, function() {
		 $(this.cells[0]).removeClass(\'showDragHandle\');
	});';
echo $this->Geshi->highlight($data_print,'javascript');
?>

<table id="table-5" class="list">
<tr id="table5-row-1">
<td class="dragHandle">&nbsp;</td>

<td>1</td>
<td>One</td>
<td>some text</td>
</tr>
<tr id="table5-row-2">
<td class="dragHandle">&nbsp;</td>
<td>2</td>
<td>Two</td>
<td>some text</td>
</tr>
<tr id="table5-row-3">

<td class="dragHandle">&nbsp;</td>
<td>3</td>
<td>Three</td>
<td>some text</td>
</tr>
<tr id="table5-row-4">
<td class="dragHandle">&nbsp;</td>
<td>4</td>
<td>Four</td>
<td>some text</td>
</tr>

<tr id="table5-row-5">
<td class="dragHandle">&nbsp;</td>
<td>5</td>
<td>Five</td>
<td>some text</td>
</tr>
<tr id="table5-row-6">
<td class="dragHandle">&nbsp;</td>
<td>6</td>
<td>Six</td>
<td>some text</td>

</tr>
</table>


<br />
<h2>Notes</h2>
<ul>
<li>Necessary Plugin: jquery.tablednd_0_5.js (see original site) [besides the main jquery 1.2x]</li>
<li>Should not be used together with Paginator.. This is mainly for some easy and fast sorting issues - where pagination (and ASC/DESC-SortingTables) doesn't matter, i guess. Correct me if i'm wrong.</li>
</ul>

<br />
<h2>ToDo</h2>
<ul>
<li>POST instead of GET</li>
<li>writing a helper that does all the needed things automatically, like:<br />$this->Jquery->sortable($data,optionsarray('type'=>'draggable2','update'=>'someajax_function'));</li>
</ul>