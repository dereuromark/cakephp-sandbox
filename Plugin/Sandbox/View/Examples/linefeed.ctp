<script type="text/javascript">

</script>


<h1>About "New Lines"</h1>
Tip: Read the codesnippet for the CakePHP Reference to this topic.

<br /><br />
Interesting to know: LF, CR and NL are interpreted as "whitespace" in HTML-Code (besides their main function to start a new line in the source code)

<?php
echo TB.'sssfsdf'.LF.TB.TB.'dfsdfdsf'.LF.'dfsdfdsf'.LF.LF.'dfsdfdsf'.LF.TB.'dfsdfdsf'.BR.'dfsdfd';
?>


<br /><br />
<?php
echo 'dfdf'.LF.'dfsdfd';
?>


<br /><br />
<?php
?>


<br />

<h2>nl2br() - str_replace()</h2>
<?php
$string = 'SomeText'.NL.'NewLineStart'.NL.NL.'NewParagrahStart'.LF.'With PHP Linefeed'.CR.'CarriageReturn Tryout';
$data_print='$v=\'SomeText\nNewLineStart\n\nNewParagrahStart\r\nWith PHP Linefeed\rCarriageReturn Tryout\';
// the PHP Linefeed depens on the system...';
echo $this->Geshi->highlightText($data_print,'php');
?>

<b>nl2br():</b>
<div class="example"><?php echo nl2br($string)?></div>

<br />

<b>str_replace():</b><br />
<div class="example"><?php echo str_replace("\n",'<br />', $string);?></div>

<br />

<h2><?__('Resumee')?></h2>
It clearly shows, that it is better to use the PHP function nl2br() for that. It replaces all possible "new line" characters (even CR).
<br /><br />
<b>Notice:</b> for str_replace it is "\n" - and not '\n' (does not work)
<?php
echo $this->Geshi->highlightText('str_replace("\n",\'<br />\', $string);','php');
?>

<br />