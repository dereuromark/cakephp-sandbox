<?php
/**
 * A highlighted code block with the shared language pill and copy button.
 *
 * @var \App\View\AppView $this
 * @var string $code
 * @var string $lang
 */
?>
<div class="carve-rendered"><?php echo $this->Highlighter->highlight($code, ['lang' => $lang, 'prefix' => 'language-']); ?></div>
