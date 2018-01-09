<?php
/**
 * @var \App\View\AppView $this
 */
?>
Sandbox - Contact Form submission

Subject: <?php echo $subject; ?>


Message:
<?php echo $message; ?>


- - - - - - - - - - - - - - - - - - - - - - - -

User infos:
<?php echo "\t"; ?>Name: <?php echo "\t"; ?><?php echo $fromName;?>

<?php echo "\t"; ?>Email: <?php echo "\t"; ?><?php echo $fromEmail;