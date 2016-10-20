<div class="row">
	<div class="col-xs-12">


<h2>Auth Sandbox</h2>
For <?php echo $this->Html->link('TinyAuth', 'https://github.com/dereuromark/cakephp-tinyauth'); ?> CakePHP authentication and authorization plugin.

<div class="row">
	<div class="col-md-6">

		<h3>Status</h3>
		<?php
		$status = ' a guest';
		if ($this->request->session()->read('Auth.User.id')) {
			$status = ' logged in as <b>' . $this->request->session()->read('Auth.User.username') . '</b>';
		}

		?>
		<p>
			You are <?php echo $status; ?>.
		</p>
		<p>
		<?php if (!$this->request->session()->read('Auth.User.id')) { ?>
			<?php echo $this->Html->link('Log in', ['action' => 'login'], ['class' => 'btn btn-success']); ?>
		<?php } ?>
		<?php if ($this->request->session()->read('Auth.User.id')) { ?>
			<?php echo $this->Html->link('Log out', ['action' => 'logout'], ['class' => 'btn btn-danger']); ?>
		<?php } ?>
		</p>
	</div>
	<div class="col-md-6 well">

		<h3>Roles and access credentials</h3>
		<ul>
			<li>not logged in (no role)</li>
			<li><span class="badge">user</span> username: user, pwd: 123</li>
			<li><span class="badge">mod</span> username: mod, pwd: 123</li>
			<li><span class="badge">admin</span> username: admin, pwd: 123</li>
		</ul>


	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<h3>Access overview</h3>

<p>
    Authentication is provided by an Auth component. It is used for all the "public" actions of this sandbox.
    See the AppController and AuthSandboxController setup, the config/auth_allow.ini file and the TinyAuth documentation.
</p>

<p>
    Authorization is provided by an Authorize adapter and the main demo content here.
</p>
<ul>
    <li><?php echo $this->Html->link('index', ['action' => 'index']); ?>: public</li>
    <li><?php echo $this->Html->link('for-all', ['action' => 'forAll']); ?>: for all who are logged in</li>
    <li><?php echo $this->Html->link('for-mods', ['action' => 'forMods']); ?>: for all moderators</li>
    <li><?php echo $this->Html->link('admin/index', ['prefix' => 'admin', 'action' => 'index']); ?>: for all admins</li>
    <li><?php echo $this->Html->link('admin/my-public-one', ['prefix' => 'admin', 'action' => 'myPublicOne']); ?>: public admin action</li>
</ul>

	</div>
	<div class="col-md-6">
		<h3>Display content/links based on current role</h3>
		<p>
	The following content/links are either hidden or unclickable based on the current access level:
		</p>

		<ul>
			<li>user link:
				<?php if ($this->AuthUser->hasAccess(['action' => 'forAll'])) {
					echo $this->Html->link('for-all', ['action' => 'forAll']);
				} ?>
			</li>
			<li>mod link:
			<?php if ($this->AuthUser->hasAccess(['action' => 'forMods'])) {
				echo $this->Html->link('for-mods', ['action' => 'forMods']);
			} ?>
			</li>
			<li>admin only link:
			<?php if ($this->AuthUser->hasAccess(['prefix' => 'admin', 'action' => 'index'])) {
				echo $this->Html->link('admin/index', ['prefix' => 'admin', 'action' => 'index']);
			} ?>
			</li>
			<li>careful! "my-public-one" admin action is not ACL controlled because public, therefore the link would not show for normal roles:
				<?php
					echo $this->AuthUser->link('admin/my-public-one', ['prefix' => 'admin', 'action' => 'myPublicOne']);
				?>
			</li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="col-md-12">

<h3>Notes</h3>
<ul>
<li>You can easily also use multi-role auth here (to allow users to have multiple roles at once).</li>
</ul>

	</div>
</div>


	</div>
</div>
