<?php
/**
 * @var \App\View\AppView $this
 */
?>

<nav class="actions col-sm-4 col-xs-12">
	<?php echo $this->element('navigation/tools'); ?>
</nav>
<div class="page index col-sm-8 col-xs-12">

<h2>Tree structures - Tree behavior and helper</h2>

<h3>Simple Example</h3>
<p>Using `find(threaded)` on some demo categories.</p>
<?php
	echo $this->Tree->generate($tree);
?>


<h3>Only generate 2 levels</h3>

<?php
echo $this->Tree->generate($tree, ['maxDepth' => 1]); // 0 based
?>

<h3>Using a callback to style</h3>
<p>
	And passing in "authPath" for the helper to know the currently active element and the path to it.
</p>
<?php
// Helper function to find the depth of a tree branch
function arrayDepth($row) {
	$max_depth = 1;
	$depth = 1;

	if ($row instanceof \Cake\ORM\Entity) {
		$row = $row->toArray();
	}

	if (!empty($row['children'])) {
		foreach ($row['children'] as $child) {
			$depth += arrayDepth($child);

			if ($depth > $max_depth) {
				$max_depth = $depth;
			}
		}
	}

	return $max_depth;
}

// Select the deepest record as active element for demo purposes
function arrayPath($array, $dept = 0) {
	$path = [];
	$currentDepth = 0;

	foreach ($array as $row) {
		if ($row instanceof \Cake\ORM\Entity) {
			$row = $row->toArray();
		}

		$deptOfPath = arrayDepth($row);
		if ($deptOfPath < $currentDepth) {
			continue;
		}
		$currentDepth = $deptOfPath;

		$path = [$row['lft'], $row['rght']];

		if (!empty($row['children'])) {
			$path = arrayPath($row['children'], $dept + 1, $deptOfPath);
			continue;
		}
	}

	return $path;
}

// Just for demo purposes [lft, right] is auto-selected
$autoPath = arrayPath($tree);

// Style using a callable
$callback = function($params) {
	$data = $params['data'];
	$name = $data['name'];

	if ($params['activePathElement']) {
		$name = '<b>' . $name . '</b>';
	}
	return $name;
};

echo $this->Tree->generate($tree, ['callback' => $callback, 'autoPath' => $autoPath]);
?>

</div>
