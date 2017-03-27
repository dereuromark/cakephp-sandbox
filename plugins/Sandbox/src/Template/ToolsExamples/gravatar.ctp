<?php
/**
 * @var \App\View\AppView $this
 */
?>
<h2>Gravatar images</h2>

<h3>Default image for non existend emails</h3>
<?php
echo $this->Gravatar->image('foobar');
?>

<h3>Different sizes (1-512 px)</h3>
<div class="icons">
<?php
echo $this->Gravatar->image('x', ['default' => 'monsterid', 'size' => '16']);
echo $this->Gravatar->image('y', ['default' => 'monsterid', 'size' => '64']);
echo $this->Gravatar->image('foobar', ['default' => 'monsterid', 'size' => '200']);
?>
</div>

<h3>Default image options</h3>
<table>
<?php
$defaults = $this->Gravatar->defaultImages();
foreach ($defaults as $name => $default) {
	echo '<tr>';
	echo '<td>' . $name . '</td>' . '<td>' . $default . '</td>';
	echo '</tr>';
}

?>
</table>


<style>
.icons img {
	margin-left: 10px;
}
table td {
	vertical-align: top;
	padding: 4px;
}
</style>