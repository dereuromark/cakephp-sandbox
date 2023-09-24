<?php
/**
 * @var \App\View\AppView $this
 * @var \StateMachineSandbox\Model\Entity\Registration[]|\Cake\Collection\CollectionInterface $registrations
 */
?>
<nav class="actions large-3 medium-4 columns col-sm-4 col-xs-12" id="actions-sidebar">
    <ul class="side-nav nav nav-pills flex-column">
        <li class="nav-item heading"><?= __('Actions') ?></li>
        <li class="nav-item">
            <?= $this->Html->link(__('Back'), ['controller' => 'RegistrationDemo', 'action' => 'index'], ['class' => 'nav-link']) ?>
        </li>
    </ul>
</nav>
<div class="registrations index content large-9 medium-8 columns col-sm-8 col-12">

    <h1><?= __('Registrations') ?></h1>

	<p>The (admin) view for each registration also shows the detailed history and logs for each process.</p>

    <div class="">
        <table class="table table-sm table-striped">
            <thead>
                <tr>
                    <th><?= __('User') ?></th>
                    <th><?= __('Status') ?></th>
                    <th><?= __('Created') ?></th>
                    <th><?= __('Modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registrations as $registration): ?>
                <tr>
                    <td><?= h($registration->user->username) ?></td>
                    <td><?= h($registration->status) ?></td>
                    <td><?= $this->Time->nice($registration->created) ?></td>
                    <td><?= $this->Time->nice($registration->modified) ?></td>
                    <td class="actions">
                        <?php echo $this->Html->link($this->Icon->render('view'), ['action' => 'view', $registration->id], ['escapeTitle' => false]); ?>
                        <?php echo $this->Form->postLink($this->Icon->render('delete'), ['action' => 'delete', $registration->id], ['escapeTitle' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $registration->id)]); ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php echo $this->element('Tools.pagination'); ?>
</div>
