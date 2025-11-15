<?php
/**
 * @var \App\View\AppView $this
 * @var \Comments\Model\Entity\Comment $comment
 * @var array $commentsData
 * @var int|null $ownerId
 * @var bool $adminMode
 */
?>
<div class="comments">

	<?php $this->append('script');?>
<script>
jQuery(document).ready(function() {
	jQuery('#displayCommentForm').click(function() {
		jQuery('#pollCommenting').slideToggle(500);
	});
});
</script>
	<?php $this->end();?>

<?php
	if (!isset($adminMode)) {
		//$adminMode = $this->AuthUser->hasRole(ROLE_ADMIN);
	}
?>

	<div style="float: right" class="pull-end pull-right">
		<?php echo $this->Html->link($this->Icon->render('add') . ' ' . __('Add {0}', __('Comment')), 'javascript:void(0)', ['escape' => false, 'title' => __('Add {0}', __('Comment')), 'id' => 'displayCommentForm'])?>
	</div>
<h5> (<?php echo count($commentsData); ?>)</h5>



<div style="display:<?php echo ($this->request->getData('comment') !== null ? 'block' : 'none');?>" id="pollCommenting">

<?php echo $this->Form->create(null, ['id' => 'commentForm', 'url' => $this->request->getUri()->getPath()]);?>
	<fieldset>
		<legend><?php echo __('Add');?></legend>
	<?php

	echo $this->Form->control('comment', ['type' => 'textarea', 'id' => 'comment']);
    if (!$this->AuthUser->id()) {
        echo $this->Form->control('name', ['id' => 'comment-name']);
		echo $this->Form->control('email', ['id' => 'comment-email']);
    }
	echo $this->Form->hidden('Comment.id', ['value' => '']);
	//echo $this->Form->error('comment');

	//$this->Captcha = TableRegistry::get('Captcha', 'Helper');
	//if (!$this->AuthUser->id() && isset($this->Captcha)) {
		//echo $this->Captcha->input('Comment');
	//}

	?>
	</fieldset>
<?php echo $this->Form->submit(__('Submit')); echo $this->Form->end();?>
<?php echo $this->Form->end() ?>
<br/>
</div>


	<div class="card-footer card-comments">

	<?php
		foreach ($commentsData as $count => $comment) {
			$name = $comment->name;
			if (!$name) {
				$name = 'n/a';
			}

			if (empty($comment->user_id)) {
				$name = h($name) . ' [Gast]';
			} elseif ($comment->user) {
				$name = '<b>' . h($comment->user->username) . '</b>';
			} else {
				$name = '<b>' . h($name) . '</b>';
			}

			$isOwnerComment = false;
			if (!empty($ownerId) && $comment->user_id == $ownerId) {
				$isOwnerComment = true;
			}

			$cActions = '';

			if (!empty($adminMode)) {
				//$cActions = BR . $this->Format->icon('delete', [], ['class' => 'deleteComment pointer', 'rel' => $comment->id]);
				$cActions = '<br>' . '<span class="admin-area">' . $this->Html->link($this->Icon->render('edit'), ['prefix' => 'Admin', 'plugin' => 'Comments', 'controller' => 'Comments', 'action' => 'edit', $comment->id], ['escapeTitle' => false]) . '</span>';

			} else {
				if ($isOwnerComment) {

					//$cActions .= BR . $this->Format->cIcon(ICON_OWNER, ['title' => 'Ersteller dieses Threads'], ['class' => 'help']);
				} elseif (count($commentsData) == ($count + 1) && !empty($comment->user_id) && $comment->user_id === $this->AuthUser->id()) {
					//$cActions = BR.$this->Format->icon('edit');
				}
			}
		?>
		<div class="card-comment<?php echo ($isOwnerComment ? ' owner' : ''); ?>" id="comment_<?php echo $comment->id ?>">
			<div class="comment-text">
				<span class="username">
					<?php echo $name; ?>
					<span class="text-muted float-right">
						<?php echo $this->Html->link($this->Time->niceDate($comment->created), $this->request->getUri()->getPath() . '#comment_' . $comment->id, ['title' => __('Permalink')]); ?> (#<?php echo ($count + 1); ?>)
						<br><?php echo $cActions; ?>
					</span>
				</span>
				<?php echo $this->Text->autoParagraph(nl2br($comment->content)); ?>
			</div>
		</div>
	<?php
		}
	?>
	</div>

</div>
