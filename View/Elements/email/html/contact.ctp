<?php
// contact form to the site admin
?>
	<b>Sender:</b> <?php echo $mail_content['name'];?><br />
	<b>Email:</b> <?php echo $mail_content['email'];?><br />
	<br />
	<b>Message:</b><br />
	<?php echo $mail_content['message'];?><br />
	<br />
	<b>Attachments:</b> <?php echo $mail_content['attachments'];?>
	<?php if (!empty($mail_content['attachments'])) {
		echo '<br />'.$mail_content['attachments'];
	}
	?>