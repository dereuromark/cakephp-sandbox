<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $post
 */
?>
<div class="row">
    <aside class="column actions large-3 medium-4 col-sm-4 col-xs-12">
        <ul class="side-nav nav nav-pills flex-column">
            <li class="nav-item heading"><?= __('Actions') ?></li>
            <li class="nav-item"><?= $this->Html->link(__('Edit {0}', __('Sandbox Post')), ['action' => 'edit', $post->id], ['class' => 'side-nav-item']) ?></li>
            <li class="nav-item"><?= $this->Form->postLink(__('Delete {0}', __('Sandbox Post')), ['action' => 'delete', $post->id], ['confirm' => __('Are you sure you want to delete # {0}?', $post->id), 'class' => 'side-nav-item']) ?></li>
            <li class="nav-item"><?= $this->Html->link(__('List {0}', __('Sandbox Posts')), ['action' => 'index'], ['class' => 'side-nav-item']) ?></li>
        </ul>
    </aside>
    <div class="column-responsive column-80 large-9 medium-8 col-sm-8 col-xs-12">
        <div class="sandboxPosts view">
            <h2><?= h($post->title) ?></h2>

            <table class="table table-striped">
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($post->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Rating Count') ?></th>
                    <td><?= $this->Number->format($post->rating_count) ?></td>
                </tr>
                <tr>
                    <th><?= __('Rating Sum') ?></th>
                    <td><?= $this->Number->format($post->rating_sum) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= $this->Time->nice($post->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= $this->Time->nice($post->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Content') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($post->content)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
