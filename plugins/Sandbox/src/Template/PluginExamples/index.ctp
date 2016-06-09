<h2>CakePHP Plugin Examples</h2>



<div class="row">
	<div class="col-xs-6">
		<h3>Own plugins</h3>

		<h4>Tools plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('Examples', ['controller' => 'ToolsExamples', 'action' => 'index']); ?></li>
		</ul>

		<h4>Feed Plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('RSS Feeds in CakePHP', ['controller' => 'FeedExamples', 'action' => 'index']); ?></li>
		</ul>

		<h4>Ajax Plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('AJAX and CakePHP', ['controller' => 'AjaxExamples', 'action' => 'index']); ?></li>
		</ul>

		<h4>TinyAuth Plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('TinyAuth RBAC authentication adapter', ['plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'index']); ?></li>
		</ul>

		<h4>Geo Plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('Geocoding and CakePHP', ['controller' => 'GeoExamples', 'action' => 'index']); ?></li>
		</ul>

		<h4>Hashid Plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('Hashids and CakePHP', ['controller' => 'Hashids', 'action' => 'index']); ?></li>
		</ul>

		<?php if (false) { ?>
		<h4>Captcha Plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('Captchas and CakePHP', ['controller' => 'Captchas', 'action' => 'index']); ?></li>
		</ul>
		<?php } ?>

		<h4>Ratings Plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('(Star) Ratings in CakePHP', ['controller' => 'Ratings', 'action' => 'index']); ?></li>
		</ul>
	</div>
	<div class="col-xs-6">
		<h3>Other plugins</h3>

		<h4>CsvView Plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('CSV export and CakePHP', ['controller' => 'Csv', 'action' => 'index']); ?></li>
		</ul>

		<h4>AssetCompress Plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('AssetCompress and CakePHP', ['controller' => 'AssetCompressExamples', 'action' => 'index']); ?></li>
		</ul>

		<h4>Markup Plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('Markup, e.g. syntax highlighting', ['controller' => 'Examples', 'action' => 'markup']); ?></li>
		</ul>

		<h4>SocialShare Plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('SocialShare and CakePHP', ['controller' => 'SocialShare', 'action' => 'index']); ?></li>
		</ul>

		<h4>BootstrapUI Plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('Bootstrap and CakePHP', ['controller' => 'Bootstrap', 'action' => 'index']); ?></li>
		</ul>

		<h4>Search Plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('Advanced Filtering in CakePHP', ['controller' => 'SearchExamples', 'action' => 'index']); ?></li>
		</ul>

		<h4>KnpMenu Plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('Menu Building in CakePHP', ['controller' => 'Menu', 'action' => 'index']); ?></li>
		</ul>
	</div>
</div>


<h3>TODO</h3>
<ul>
	<li>CakePdf</li>
	<li>Crud</li>
	<li>Wysiwyg</li>
	<li>Like / Rating / Favorite</li>
	<li>... (see <a href="https://github.com/FriendsOfCake/awesome-cakephp" target="blank">awesome-cakephp</a>)</li>
</ul>
