<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="plugin-examples">
	<h2>CakePHP Plugin Examples</h2>
	<p class="lead">Explore a comprehensive collection of plugin integrations and real-world examples.</p>

	<div class="row g-4">
		<div class="col-md-8">
			<div class="card h-100">
				<div class="card-header bg-primary text-white">
					<h3 class="h5 mb-0">Own Plugins</h3>
				</div>
				<div class="card-body">
					<div class="plugin-list plugin-list-two-columns">
						<div class="plugin-item">
							<h4 class="h6">
								FileStorage Plugin
								<span class="badge bg-success ms-2">NEW</span>
							</h4>
							<ul class="mb-3">
								<li><?php echo $this->Html->link('File Storage with FlySystem', ['controller' => 'FileStorageExamples', 'action' => 'index']); ?></li>
							</ul>
						</div>

						<div class="plugin-item">
							<h4 class="h6">
								AuditStash Plugin
								<span class="badge bg-success ms-2">NEW</span>
							</h4>
							<ul class="mb-3">
								<li><?php echo $this->Html->link('Database Audit Trail with TablePersister', ['controller' => 'AuditStash', 'action' => 'index']); ?></li>
							</ul>
						</div>

						<div class="plugin-item">
							<h4 class="h6">
								QrCode Plugin
								<span class="badge bg-success ms-2">NEW</span>
							</h4>
							<ul class="mb-3">
								<li><?php echo $this->Html->link('QrCodes and CakePHP', ['controller' => 'QrCodeExamples', 'action' => 'index']); ?></li>
							</ul>
						</div>

						<div class="plugin-item">
							<h4 class="h6">
								Favorites Plugin
								<span class="badge bg-success ms-2">NEW</span>
							</h4>
							<ul class="mb-3">
								<li><?php echo $this->Html->link('Favorites (Star, Like, Reactions)', ['controller' => 'FavoriteExamples', 'action' => 'index']); ?></li>
							</ul>
						</div>

						<div class="plugin-item">
							<h4 class="h6">
								Comments Plugin
								<span class="badge bg-success ms-2">NEW</span>
							</h4>
							<ul class="mb-3">
								<li><?php echo $this->Html->link('Comment everything', ['controller' => 'CommentExamples', 'action' => 'index']); ?></li>
							</ul>
						</div>

						<div class="plugin-item">
							<h4 class="h6">Queue Plugin</h4>
							<ul class="mb-3">
								<li><?php echo $this->Html->link('Queue and CakePHP', ['controller' => 'QueueExamples', 'action' => 'index']); ?></li>
							</ul>
						</div>

						<div class="plugin-item">
							<h4 class="h6">CakeDto Plugin</h4>
							<ul class="mb-3">
								<li><?php echo $this->Html->link('DTOs in CakePHP', ['controller' => 'DtoExamples', 'action' => 'index']); ?></li>
							</ul>
						</div>

						<div class="plugin-item">
							<h4 class="h6">CakeDecimal Plugin</h4>
							<ul class="mb-3">
								<li><?php echo $this->Html->link('Decimals and CakePHP', ['controller' => 'DecimalExamples', 'action' => 'index']); ?></li>
							</ul>
						</div>

						<div class="plugin-item">
							<h4 class="h6">Templating Plugin</h4>
							<ul class="mb-3">
								<li><?php echo $this->Html->link('Templating, (Font) icons and HTML snippets', ['controller' => 'TemplatingExamples', 'action' => 'index']); ?></li>
							</ul>
						</div>

						<div class="plugin-item">
							<h4 class="h6">Tools Plugin</h4>
							<ul class="mb-3">
								<li><?php echo $this->Html->link('Examples', ['controller' => 'ToolsExamples', 'action' => 'index']); ?></li>
							</ul>
						</div>

						<div class="plugin-item">
							<h4 class="h6">Feed Plugin</h4>
							<ul class="mb-3">
								<li><?php echo $this->Html->link('RSS Feeds in CakePHP', ['controller' => 'FeedExamples', 'action' => 'index']); ?></li>
							</ul>
						</div>

						<div class="plugin-item">
							<h4 class="h6">Ajax Plugin</h4>
							<ul class="mb-3">
								<li><?php echo $this->Html->link('AJAX and CakePHP', ['controller' => 'AjaxExamples', 'action' => 'index']); ?></li>
							</ul>
						</div>

						<div class="plugin-item">
							<h4 class="h6">Flash Plugin</h4>
							<ul class="mb-3">
								<li><?php echo $this->Html->link('Flash messages and AJAX integration', ['controller' => 'FlashExamples', 'action' => 'index']); ?></li>
							</ul>
						</div>

						<div class="plugin-item">
							<h4 class="h6">TinyAuth Plugin</h4>
							<ul class="mb-3">
								<li><?php echo $this->Html->link('TinyAuth RBAC authorization adapter', ['plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'index']); ?></li>
							</ul>
						</div>

						<div class="plugin-item">
							<h4 class="h6">Geo Plugin</h4>
							<ul class="mb-3">
								<li><?php echo $this->Html->link('Geocoding and CakePHP', ['controller' => 'GeoExamples', 'action' => 'index']); ?></li>
							</ul>
						</div>

						<div class="plugin-item">
							<h4 class="h6">Cache Plugin</h4>
							<ul class="mb-3">
								<li><?php echo $this->Html->link('CakePHP Cache plugin and view caching', ['controller' => 'CacheExamples', 'action' => 'index']); ?></li>
							</ul>
						</div>

						<div class="plugin-item">
							<h4 class="h6">Calendar Plugin</h4>
							<ul class="mb-3">
								<li><?php echo $this->Html->link('CakePHP Calendar plugin and event calendars', ['controller' => 'Calendar', 'action' => 'index']); ?></li>
							</ul>
						</div>

						<div class="plugin-item">
							<h4 class="h6">Captcha Plugin</h4>
							<ul class="mb-3">
								<li><?php echo $this->Html->link('Captchas in CakePHP', ['controller' => 'Captchas', 'action' => 'index']); ?></li>
							</ul>
						</div>

						<div class="plugin-item">
							<h4 class="h6">Feedback Plugin</h4>
							<ul class="mb-3">
								<li><?php echo $this->Html->link('Feedback', ['controller' => 'FeedbackExamples', 'action' => 'index']); ?></li>
							</ul>
						</div>

						<div class="plugin-item">
							<h4 class="h6">Ratings Plugin</h4>
							<ul class="mb-3">
								<li><?php echo $this->Html->link('(Star) Ratings in CakePHP', ['controller' => 'Ratings', 'action' => 'index']); ?></li>
							</ul>
						</div>

						<div class="plugin-item">
							<h4 class="h6">Tags Plugin</h4>
							<ul class="mb-3">
								<li><?php echo $this->Html->link('Tagging in CakePHP', ['controller' => 'Tags', 'action' => 'index']); ?></li>
							</ul>
						</div>

						<div class="plugin-item">
							<h4 class="h6">Markup Plugin</h4>
							<ul class="mb-3">
								<li><?php echo $this->Html->link('Markup, e.g. syntax highlighting', ['controller' => 'MarkupExamples', 'action' => 'index']); ?></li>
							</ul>
						</div>

						<div class="plugin-item">
							<h4 class="h6">Expose Plugin</h4>
							<ul class="mb-3">
								<li><?php echo $this->Html->link('Expose entities through UUIDs to obfuscate primary key info', ['controller' => 'ExposeExamples', 'action' => 'index']); ?></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="card h-100">
				<div class="card-header bg-secondary text-white">
					<h3 class="h5 mb-0">Community Plugins</h3>
				</div>
				<div class="card-body">
					<div class="plugin-list">
						<div class="plugin-item">
							<h4 class="h6">StateMachine Plugin</h4>
							<ul class="mb-3">
								<li><?php echo $this->Html->link('Workflow Examples using StateMachine', ['plugin' => 'StateMachineSandbox', 'controller' => 'StateMachineSandbox', 'action' => 'index']); ?></li>
							</ul>
						</div>

						<div class="plugin-item">
							<h4 class="h6">TwigView Plugin</h4>
							<ul class="mb-3">
								<li><?php echo $this->Html->link('Twig templating in CakePHP', ['controller' => 'TwigExamples', 'action' => 'index']); ?></li>
							</ul>
						</div>

						<div class="plugin-item">
							<h4 class="h6">CsvView Plugin</h4>
							<ul class="mb-3">
								<li><?php echo $this->Html->link('CSV export and CakePHP', ['controller' => 'Csv', 'action' => 'index']); ?></li>
							</ul>
						</div>

						<div class="plugin-item">
							<h4 class="h6">BootstrapUI Plugin</h4>
							<ul class="mb-3">
								<li><?php echo $this->Html->link('Bootstrap and CakePHP', ['controller' => 'Bootstrap', 'action' => 'index']); ?></li>
							</ul>
						</div>

						<div class="plugin-item">
							<h4 class="h6">Search Plugin</h4>
							<ul class="mb-3">
								<li><?php echo $this->Html->link('Advanced Filtering in CakePHP', ['controller' => 'SearchExamples', 'action' => 'index']); ?></li>
							</ul>
						</div>

						<div class="plugin-item">
							<h4 class="h6">Menu Plugin</h4>
							<ul class="mb-3">
								<li><?php echo $this->Html->link('Menu Building in CakePHP', ['controller' => 'Menu', 'action' => 'index']); ?></li>
							</ul>
						</div>

						<div class="plugin-item">
							<h4 class="h6">CakePdf Plugin</h4>
							<ul class="mb-3">
								<li><?php echo $this->Html->link('PDF rendering in CakePHP', ['controller' => 'Plugins', 'action' => 'cakePdf']); ?></li>
							</ul>
						</div>

						<div class="plugin-item">
							<h4 class="h6">Localized Plugin</h4>
							<ul class="mb-3">
								<li><?php echo $this->Html->link('Localized validation in CakePHP', ['controller' => 'Localized', 'action' => 'index']); ?></li>
							</ul>
						</div>
					</div>

					<div class="mt-4 p-3 bg-light rounded">
						<h4 class="h6">Coming Soon</h4>
						<ul class="mb-0">
							<li>Wysiwyg</li>
							<li>QueueScheduler</li>
							<li>... (see <a href="https://github.com/FriendsOfCake/awesome-cakephp" target="_blank">awesome-cakephp</a>)</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<style>
.plugin-examples .lead {
	margin-bottom: 2rem;
}
.plugin-examples .card {
	border: none;
	box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}
.plugin-examples .card-header {
	border-bottom: 2px solid rgba(255, 255, 255, 0.2);
}
.plugin-examples .plugin-item {
	padding-bottom: 0.5rem;
	margin-bottom: 0.5rem;
	border-bottom: 1px solid #e9ecef;
}
.plugin-examples .plugin-item:last-child {
	border-bottom: none;
}
.plugin-examples .plugin-item h4 {
	margin-bottom: 0.5rem;
	font-weight: 600;
}
.plugin-examples .plugin-item ul {
	margin-bottom: 0;
	padding-left: 1.5rem;
}
.plugin-examples .badge {
	font-size: 0.65rem;
	padding: 0.25rem 0.5rem;
	vertical-align: middle;
}
.plugin-examples .plugin-list-two-columns {
	display: grid;
	grid-template-columns: repeat(2, 1fr);
	gap: 1rem;
	column-gap: 2rem;
}
.plugin-examples .plugin-list-two-columns .plugin-item {
	break-inside: avoid;
}
@media (max-width: 991px) {
	.plugin-examples .plugin-list-two-columns {
		grid-template-columns: 1fr;
	}
}
</style>
