<h2>CakePHP Plugin Examples</h2>



<div class="row">
	<div class="col-xs-6">
		<h3>Own plugins</h3>

		<h4>Tools plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('Examples', ['controller' => 'tools_examples', 'action' => 'index']); ?></li>
		</ul>

		<h4>Feed Plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('RSS Feeds in CakePHP', ['controller' => 'feed_examples', 'action' => 'index']); ?></li>
		</ul>

		<h4>Ajax Plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('AJAX and CakePHP', ['controller' => 'ajax_examples', 'action' => 'index']); ?></li>
		</ul>

		<h4>TinyAuth Plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('TinyAuth RBAC authentication adapter', ['plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'index']); ?></li>
		</ul>

		<h4>Geo Plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('Geocoding and CakePHP', ['controller' => 'GeoExamples', 'action' => 'index']); ?></li>
		</ul>
	</div>
	<div class="col-xs-6">
		<h3>Other plugins</h3>

		<h4>AssetCompress Plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('AssetCompress and CakePHP', ['controller' => 'asset_compress_examples', 'action' => 'index']); ?></li>
		</ul>

		<h4>BootstrapUI Plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('Bootstrap and CakePHP', ['controller' => 'bootstrap', 'action' => 'index']); ?></li>
		</ul>

		<h4>Search Plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('Advanced Filtering in CakePHP', ['controller' => 'search_examples', 'action' => 'index']); ?></li>
		</ul>


	</div>
</div>


<h3>TODO</h3>
<ul>
	<li>CakePdf</li>
	<li>Crud</li>
	<li>Wysiwyg</li>
	<li>MenuBuilder</li>
	<li>Like / Rating / Favorite</li>
	<li>... (see <a href="https://github.com/FriendsOfCake/awesome-cakephp" target="blank">awesome-cakephp</a>)</li>
</ul>
