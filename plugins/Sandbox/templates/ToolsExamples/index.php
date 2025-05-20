<?php
/**
 * @var \App\View\AppView $this
 */
?>

<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/tools'); ?>
</nav>
<div class="page index col-sm-8 col-12">

	<p>The plugin ships with quite a battery of useful additions.</p>

	<h3>Useful defaults</h3>
	<ul>
		<li>Auto-trim on POST (to make - especially notEmpty/notBlank - validation working properly).</li>
		<li>Default settings for Paginator, ... can be set using Configure.</li>
		<li>URL array defaults for helper calls (plugin/prefix) incl. `linkReset()` and `linkComplete()`</li>
		<li>Typography resets</li>
	</ul>

	<h3>Validation</h3>
	<ul>
		<li>`validateUniqueExt()` to allow validating with multiple scoped fields with NULL values.</li>
		<li>`validateIdentical()`</li>
		<li>`validateUrl()` with auto-complete/deep</li>
		<li>`validateDateTime()` with before/after</li>
		<li>`validateDate()` with before/after</li>
		<li>`validateTime()` with before/after</li>
	</ul>

	<h3>Improved Password handling</h3>
	<p>Including improved security for all user related actions using Passwordable behavior.</p>

	<h3>Useful table behaviors</h3>
	<ul>
		<li>Slugged</li>
		<li>Bitmasked</li>
		<li>Confirmable: Checkbox toggling</li>
		<li>String: Input (and output) transformation and cleanup</li>
		<li>Toggle: Quickly allow boolean toggles</li>
	</ul>
	<p>and more.</p>

	<h3>Tree structures</h3>
	<p>The Tree helper for outputting tree structures</p>

	<h3>I18n language switching</h3>
	<p>Allows a quick language switch for your app</p>

</div>
