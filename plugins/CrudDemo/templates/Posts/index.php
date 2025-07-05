<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\Cake\Datasource\EntityInterface> $posts
 */
?>
<div class="row">
    <nav class="actions large-3 medium-4 columns col-sm-4 col-xs-12" id="actions-sidebar">
        <ul class="side-nav nav nav-pills flex-column">
            <li class="nav-item heading"><?= __('Actions') ?></li>
            <li class="nav-item">
                <?= $this->Html->link(__('New {0}', __('Sandbox Post')), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
            </li>
        </ul>
    </nav>
    <div class="sandboxPosts index col-sm-8 col-12">

    <h2><?= __('Sandbox Posts') ?></h2>

    <div class="">
        <table class="table table-sm table-striped">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('title') ?></th>
                    <th><?= $this->Paginator->sort('rating_count') ?></th>
                    <th><?= $this->Paginator->sort('rating_sum') ?></th>
                    <th><?= $this->Paginator->sort('created', null, ['direction' => 'desc']) ?></th>
                    <th><?= $this->Paginator->sort('modified', null, ['direction' => 'desc']) ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post): ?>
                <tr>
                    <td><?= h($post->title) ?></td>
                    <td><?= $this->Number->format($post->rating_count) ?></td>
                    <td><?= $this->Number->format($post->rating_sum) ?></td>
                    <td><?= $this->Time->nice($post->created) ?></td>
                    <td><?= $this->Time->nice($post->modified) ?></td>
                    <td class="actions">
                        <?php echo $this->Html->link($this->Icon->render('view'), ['action' => 'view', $post->id], ['escapeTitle' => false]); ?>
                        <?php echo $this->Html->link($this->Icon->render('edit'), ['action' => 'edit', $post->id], ['escapeTitle' => false]); ?>
                        <?php echo $this->Form->postLink($this->Icon->render('delete'), ['action' => 'delete', $post->id], ['escapeTitle' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $post->id)]); ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php echo $this->element('Tools.pagination'); ?>
    </div>
</div>
