<?php
/**
 * @var \App\View\AppView $this
 * @var \WorkflowSandbox\Model\Entity\Order $order
 * @var array $users
 * @var array $paymentMethods
 */

$this->assign('title', 'New Order');
?>

<h1>New Order</h1>

<div class="row">
	<div class="col-md-6">
		<div class="card">
			<div class="card-body">
				<?= $this->Form->create($order) ?>

				<?= $this->Form->control('user_id', ['options' => $users, 'empty' => '-- Select User --']) ?>
				<?= $this->Form->control('total', ['type' => 'number', 'step' => '0.01', 'min' => '0', 'default' => '99.99']) ?>
				<?= $this->Form->control('payment_method', ['options' => $paymentMethods, 'empty' => '-- Select --']) ?>
				<?= $this->Form->control('shipping_address', ['type' => 'textarea', 'rows' => 2]) ?>

				<div class="mt-3">
					<?= $this->Form->button('Create Order', ['class' => 'btn btn-primary']) ?>
					<?= $this->Html->link('Cancel', ['action' => 'index'], ['class' => 'btn btn-outline-secondary']) ?>
				</div>

				<?= $this->Form->end() ?>
			</div>
		</div>
	</div>
</div>
