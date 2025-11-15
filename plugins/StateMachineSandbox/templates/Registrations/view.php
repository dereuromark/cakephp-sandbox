<?php
/**
 * @var \App\View\AppView $this
 * @var \StateMachineSandbox\Model\Entity\Registration $registration
 * @var array<\StateMachine\Model\Entity\StateMachineItemStateLog> $history
 * @var array<\StateMachine\Model\Entity\StateMachineTransitionLog> $logs
 */
?>
<div class="row">
    <aside class="column actions large-3 medium-4 col-sm-4 col-xs-12">
        <ul class="side-nav nav nav-pills flex-column">
            <li class="nav-item heading"><?= __('Actions') ?></li>
            <li class="nav-item"><?= $this->Form->postLink(__('Delete {0}', __('Registration')), ['action' => 'delete', $registration->id], ['confirm' => __('Are you sure you want to delete # {0}?', $registration->id), 'class' => 'side-nav-item']) ?></li>
            <li class="nav-item"><?= $this->Html->link(__('List {0}', __('Registrations')), ['action' => 'index'], ['class' => 'side-nav-item']) ?></li>
        </ul>
    </aside>
    <div class="column-responsive column-80 content large-9 medium-8 col-sm-8 col-xs-12">
        <div class="registrations view content">
			<h1><?= __('Registrations') ?></h1>

            <table class="table table-striped">
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= h($registration->user->username) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($registration->status) ?></td>
                </tr>
				<tr>
					<th><?= __('Registration state') ?></th>
					<td><?= h($registration->registration_state->state) ?></td>
				</tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= $this->Time->nice($registration->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= $this->Time->nice($registration->modified) ?></td>
                </tr>
            </table>

			<h3>History</h3>
			<table class="table">
				<thead>
				<tr>
					<th>Time</th>
					<th>State</th>
					<th>Process</th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($history as $log) { ?>
					<tr>
						<td>
							<?= $this->Time->nice($log->created) ?>
						</td>
						<td>
							<?= h($log->state_machine_item_state->name) ?>
						</td>
						<td>
							<?= h($log->state_machine_item_state->state_machine_process->name) ?>
						</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>

			<h3>Logs</h3>

			<table class="table">
				<thead>
				<tr>
					<th>Time</th>
					<th>Event</th>
					<th>Command/Condition</th>
					<th>Details</th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($logs as $log) { ?>
					<tr>
						<td>
							<?= $this->Time->nice($log->created) ?>
						</td>
						<td>
							<?php echo h($log->event); ?>
							<div><small><?php echo h($log->source_state); ?> ... <?php echo h($log->target_state); ?></small></div>
						</td>
						<td>
							<div><?php echo h($log->command); ?></div>
							<div><?php echo h($log->condition); ?></div>
						</td>
						<td>
							<?php if ($log->is_error) { ?>
								<div class="inline-message error">
									Error: <?php echo h($this->Text->truncate($log->error_message, 500)) ?>
								</div>
							<?php } ?>
						</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>

			<h3>Graph</h3>

			<?php
			$stateMachine = \StateMachineSandbox\StateMachine\RegistrationStateMachineHandler::NAME;
			$process = \StateMachineSandbox\StateMachine\RegistrationStateMachineHandler::NAME . '01';
			$url = ['prefix' => 'Admin', 'plugin' => 'StateMachine', 'controller' => 'Graph', 'action' => 'draw', '?' => ['state-machine' => $stateMachine, 'process' => $process, 'highlight-state' => $registration->registration_state->state]];
			$image = $this->Html->image($url);
			echo $image;
			//echo $this->Html->link($image, $url, ['escape' => false, 'target' => '_blank']);
			?>


		</div>
    </div>
</div>
