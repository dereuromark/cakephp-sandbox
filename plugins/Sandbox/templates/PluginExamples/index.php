<?php
/**
 * @var \App\View\AppView $this
 */
?>
<h2>CakePHP Plugin Examples</h2>


<div class="row">
	<div class="col-6">
		<h3>Own plugins</h3>

		<h4>CakeDecimal plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('Decimals and CakePHP', ['controller' => 'DecimalExamples', 'action' => 'index']); ?></li>
		</ul>

		<h4>Templating plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('Templating, (Font) icons and HTML snippets', ['controller' => 'TemplatingExamples', 'action' => 'index']); ?></li>
		</ul>

		<h4>QrCode plugin <i>(NEW)</i></h4>
		<ul>
			<li><?php echo $this->Html->link('QrCodes and CakePHP', ['controller' => 'QrCodeExamples', 'action' => 'index']); ?></li>
		</ul>

		<h4>Favorites plugin <i>(NEW)</i></h4>
		<ul>
			<li><?php echo $this->Html->link('Favorites (Star, Like, Reactions)', ['controller' => 'FavoriteExamples', 'action' => 'index']); ?></li>
		</ul>

		<h4>Comments plugin <i>(NEW)</i></h4>
		<ul>
			<li><?php echo $this->Html->link('Comment everything', ['controller' => 'CommentExamples', 'action' => 'index']); ?></li>
		</ul>

		<h4>Queue plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('Queue and CakePHP', ['controller' => 'QueueExamples', 'action' => 'index']); ?></li>
		</ul>

		<h4>CakeDto Plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('DTOs in CakePHP', ['controller' => 'DtoExamples', 'action' => 'index']); ?></li>
		</ul>

		<h4>Tools plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('Examples', ['controller' => 'ToolsExamples', 'action' => 'index']); ?></li>
		</ul>

		<h4>Feed plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('RSS Feeds in CakePHP', ['controller' => 'FeedExamples', 'action' => 'index']); ?></li>
		</ul>

		<h4>Ajax plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('AJAX and CakePHP', ['controller' => 'AjaxExamples', 'action' => 'index']); ?></li>
		</ul>

		<h4>TinyAuth plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('TinyAuth RBAC authorization adapter', ['plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'index']); ?></li>
		</ul>

		<h4>Geo plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('Geocoding and CakePHP', ['controller' => 'GeoExamples', 'action' => 'index']); ?></li>
		</ul>

		<h4>Cache plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('CakePHP Cache plugin and view caching', ['controller' => 'CacheExamples', 'action' => 'index']); ?></li>
		</ul>

		<h4>Calendar plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('CakePHP Calendar plugin and event calendars', ['controller' => 'Calendar', 'action' => 'index']); ?></li>
		</ul>

		<h4>Captcha plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('Captchas in CakePHP', ['controller' => 'Captchas', 'action' => 'index']); ?></li>
		</ul>

		<h4>Feedback plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('Feedback', ['controller' => 'FeedbackExamples', 'action' => 'index']); ?></li>
		</ul>

		<h4>Ratings plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('(Star) Ratings in CakePHP', ['controller' => 'Ratings', 'action' => 'index']); ?></li>
		</ul>

		<h4>Tags plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('Tagging in CakePHP', ['controller' => 'Tags', 'action' => 'index']); ?></li>
		</ul>

		<h4>Markup plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('Markup, e.g. syntax highlighting', ['controller' => 'MarkupExamples', 'action' => 'index']); ?></li>
		</ul>

		<h4>Expose Plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('Expose entities through UUIDs to obfuscate primary key info', ['controller' => 'ExposeExamples', 'action' => 'index']); ?></li>
		</ul>

	</div>
	<div class="col-6">
		<h3>Other plugins</h3>

		<h4>AuditStash plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('Database Audit Trail with TablePersister', ['controller' => 'AuditStash', 'action' => 'index']); ?></li>
		</ul>

		<h4>StateMachine plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('Workflow Examples using StateMachine', ['plugin' => 'StateMachineSandbox', 'controller' => 'StateMachineSandbox', 'action' => 'index']); ?></li>
		</ul>

		<h4>TwigView plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('Twig templating in CakePHP', ['controller' => 'TwigExamples', 'action' => 'index']); ?></li>
		</ul>

		<h4>CsvView plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('CSV export and CakePHP', ['controller' => 'Csv', 'action' => 'index']); ?></li>
		</ul>

		<h4>BootstrapUI plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('Bootstrap and CakePHP', ['controller' => 'Bootstrap', 'action' => 'index']); ?></li>
		</ul>

		<h4>Search plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('Advanced Filtering in CakePHP', ['controller' => 'SearchExamples', 'action' => 'index']); ?></li>
		</ul>

		<h4>Menu plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('Menu Building in CakePHP', ['controller' => 'Menu', 'action' => 'index']); ?></li>
		</ul>

		<h4>CakePdf plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('PDF rendering in CakePHP', ['controller' => 'Plugins', 'action' => 'cakePdf']); ?></li>
		</ul>

		<h4>Localized plugin</h4>
		<ul>
			<li><?php echo $this->Html->link('Localized validation in CakePHP', ['controller' => 'Localized', 'action' => 'index']); ?></li>
		</ul>

		<h3>TODO</h3>
		<ul>
			<li>Wysiwyg</li>
			<li>QueueScheduler</li>
			<li>... (see <a href="https://github.com/FriendsOfCake/awesome-cakephp" target="blank">awesome-cakephp</a>)</li>
		</ul>

	</div>
</div>
