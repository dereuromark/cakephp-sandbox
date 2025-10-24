<?php
/**
 * @var \App\View\AppView $this
 */
?>

<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/bootstrap'); ?>
</nav>
<div class="page breadcrumbs col-sm-8 col-12">

<h3>BreadcrumbsHelper</h3>
<p>Bootstrap-styled breadcrumb navigation for hierarchical site structure.</p>

<h4>Basic Breadcrumbs</h4>
<div class="card mb-3">
	<div class="card-body">
		<?php
		$this->Breadcrumbs->add('Home', '/');
		$this->Breadcrumbs->add('Library', '/');
		$this->Breadcrumbs->add('Data', '/');
		echo $this->Breadcrumbs->render();
		?>
	</div>
	<div class="card-footer">
		<code>
			$this->Breadcrumbs->add('Home', '/');<br>
			$this->Breadcrumbs->add('Library', '/library');<br>
			$this->Breadcrumbs->add('Data');<br>
			echo $this->Breadcrumbs->render();
		</code>
	</div>
</div>

<h4>With Array URLs</h4>
<p>Use CakePHP routing arrays for breadcrumb links.</p>
<div class="card mb-3">
	<div class="card-body">
		<?php
		$this->Breadcrumbs->reset();
		$this->Breadcrumbs->add('Home', ['plugin' => false, 'controller' => 'Overview', 'action' => 'index']);
		$this->Breadcrumbs->add('Bootstrap Examples', ['controller' => 'Bootstrap', 'action' => 'index']);
		$this->Breadcrumbs->add('Breadcrumbs');
		echo $this->Breadcrumbs->render();
		?>
	</div>
	<div class="card-footer">
		<code>
			$this->Breadcrumbs->add('Home', [<br>
			&nbsp;&nbsp;'controller' => 'Overview',<br>
			&nbsp;&nbsp;'action' => 'index',<br>
			]);<br>
			$this->Breadcrumbs->add('Bootstrap Examples', [<br>
			&nbsp;&nbsp;'controller' => 'Bootstrap',<br>
			&nbsp;&nbsp;'action' => 'index'<br>
			]);
		</code>
	</div>
</div>

<h4>Prepending Items</h4>
<p>Add items to the beginning of the breadcrumb trail.</p>
<div class="card mb-3">
	<div class="card-body">
		<?php
		$this->Breadcrumbs->reset();
		$this->Breadcrumbs->add('Current Page');
		$this->Breadcrumbs->prepend('Home', '/');
		$this->Breadcrumbs->prepend('Dashboard', '/');
		echo $this->Breadcrumbs->render();
		?>
	</div>
	<div class="card-footer">
		<code>
			$this->Breadcrumbs->add('Current Page');<br>
			$this->Breadcrumbs->prepend('Home', '/');<br>
			$this->Breadcrumbs->prepend('Dashboard', '/dashboard');
		</code>
	</div>
</div>

<h4>Inserting at Specific Position</h4>
<p>Insert breadcrumb items at a specific index.</p>
<div class="card mb-3">
	<div class="card-body">
		<?php
		$this->Breadcrumbs->reset();
		$this->Breadcrumbs->add('Home', '/');
		$this->Breadcrumbs->add('Final Page');
		$this->Breadcrumbs->insertAt(1, 'Middle Section', '/');
		echo $this->Breadcrumbs->render();
		?>
	</div>
	<div class="card-footer">
		<code>
			$this->Breadcrumbs->add('Home', '/');<br>
			$this->Breadcrumbs->add('Final Page');<br>
			$this->Breadcrumbs->insertAt(1, 'Middle Section', '/middle');
		</code>
	</div>
</div>

<h4>With Icons</h4>
<p>Combine breadcrumbs with Bootstrap Icons.</p>
<div class="card mb-3">
	<div class="card-body">
		<?php
		$this->Breadcrumbs->reset();
		$this->Breadcrumbs->add(
			$this->Icon->render('house-fill') . ' Home',
			'/',
			['escape' => false]
		);
		$this->Breadcrumbs->add(
			$this->Icon->render('folder-fill') . ' Documents',
			'/',
			['escape' => false]
		);
		$this->Breadcrumbs->add(
			$this->Icon->render('file-text-fill') . ' Current File',
			null,
			['escape' => false]
		);
		echo $this->Breadcrumbs->render();
		?>
	</div>
	<div class="card-footer">
		<code>
			$this->Breadcrumbs->add(<br>
			&nbsp;&nbsp;$this->Icon->render('house-fill') . ' Home',<br>
			&nbsp;&nbsp;'/',<br>
			&nbsp;&nbsp;['escape' => false]<br>
			);
		</code>
	</div>
</div>

<h4>E-commerce Example</h4>
<p>Typical product browsing breadcrumb trail.</p>
<div class="card mb-3">
	<div class="card-body">
		<?php
		$this->Breadcrumbs->reset();
		$this->Breadcrumbs->add('Home', '/');
		$this->Breadcrumbs->add('Electronics', '/');
		$this->Breadcrumbs->add('Laptops', '/');
		$this->Breadcrumbs->add('Gaming Laptops', '/');
		$this->Breadcrumbs->add('ASUS ROG Strix G15');
		echo $this->Breadcrumbs->render();
		?>
	</div>
	<div class="card-footer">
		<small class="text-muted">
			Typical e-commerce breadcrumb showing category hierarchy
		</small>
	</div>
</div>

<h4>Documentation Example</h4>
<p>Documentation site navigation pattern.</p>
<div class="card mb-3">
	<div class="card-body">
		<?php
		$this->Breadcrumbs->reset();
		$this->Breadcrumbs->add('Docs', '/');
		$this->Breadcrumbs->add('CakePHP', '/');
		$this->Breadcrumbs->add('Plugins', '/');
		$this->Breadcrumbs->add('Bootstrap UI', '/');
		$this->Breadcrumbs->add('Helpers');
		echo $this->Breadcrumbs->render();
		?>
	</div>
	<div class="card-footer">
		<small class="text-muted">
			Documentation breadcrumb showing nested topics
		</small>
	</div>
</div>

<h4>Breadcrumb Templates</h4>
<p>Breadcrumbs automatically use Bootstrap 5 structure:</p>
<div class="card mb-3">
	<div class="card-body">
		<pre><code>&lt;nav aria-label="breadcrumb"&gt;
  &lt;ol class="breadcrumb"&gt;
    &lt;li class="breadcrumb-item"&gt;
      &lt;a href="/"&gt;Home&lt;/a&gt;
    &lt;/li&gt;
    &lt;li class="breadcrumb-item"&gt;
      &lt;a href="/library"&gt;Library&lt;/a&gt;
    &lt;/li&gt;
    &lt;li class="breadcrumb-item active" aria-current="page"&gt;
      Data
    &lt;/li&gt;
  &lt;/ol&gt;
&lt;/nav&gt;</code></pre>
	</div>
</div>

<div class="alert alert-info">
	<strong>Accessibility:</strong> Breadcrumbs automatically include proper ARIA labels and the active item
	has <code>aria-current="page"</code> for screen reader support.
</div>

<div class="alert alert-secondary">
	<h5>Common Methods</h5>
	<ul class="mb-0">
		<li><code>add($title, $url, $options)</code> - Add item to end</li>
		<li><code>prepend($title, $url, $options)</code> - Add item to beginning</li>
		<li><code>insertAt($index, $title, $url, $options)</code> - Insert at position</li>
		<li><code>insertBefore($target, $title, $url, $options)</code> - Insert before item</li>
		<li><code>insertAfter($target, $title, $url, $options)</code> - Insert after item</li>
		<li><code>reset()</code> - Clear all breadcrumbs</li>
		<li><code>render($options)</code> - Output the breadcrumb HTML</li>
	</ul>
</div>

</div>
</div>
