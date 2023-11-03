<?php
/**
 * @var \App\View\AppView $this
 * @var \Sandbox\Dto\Github\PullRequestDto $pullRequestDto
 */

use Cake\Core\Plugin;
use Cake\Error\Debugger;

$dtoFile = Plugin::path('Sandbox') . 'config' . DS . 'dto.xml';

?>
<?php $this->append('script'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
<!-- and it's easy to individually load additional languages -->
<script>hljs.highlightAll();</script>
<?php $this->end(); ?>

<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/dto'); ?>
</nav>
<div class="page index col-sm-8 col-12">

	<h3>Github Demo</h3>
	<p>In cases where you pull API data from foreign webservices as JSON, you convert it to array form and use that everywhere. This can get quite messy, with lots of nesting and complexity.</p>
	<p>Using DTOs you simplify it to</p>
	<ul>
		<li>The data that you need.</li>
		<li>Assert the data exists and handle it from there on with the typesafety and autocomplete you are used to from other areas.</li>
	</ul>

	<h4>Lets take a look into a GitHub PR</h4>
	<p>
		We use <a href="https://developer.github.com/v3/pulls/#get-a-single-pull-request">this demo data</a> to simulate a request to GitHub API to get a single PR.
		And we use some simple DTOs here for the fields we need in the template:
	</p>
<?php echo $this->Highlighter->highlight(file_get_contents($dtoFile), ['lang' => 'xml'])?>

	<p>All we now need to do is to convert the raw JSON/array into our nested DTO object:</p>
<?php echo $this->Highlighter->highlight('$pullRequestDto = PullRequestDto::create($gitHubApiData, true, PullRequestDto::TYPE_UNDERSCORED);', ['lang' => 'php']); ?>

	<p>We use "ignoreMissing" as true as we do not assign all array values, and we also need to tell it to expect an underscored form.</p>


	<h4>dd($pullRequestDto) result</h4>
	<p>Using debug() or dd() we can easily show what the DTO contains:</p>
<pre><code><?php echo Debugger::printVar($pullRequestDto, [], false)?></code></pre>

	<h4>Now let's use it</h4>
	<p>In the template we now have fully annotated fields and can very quickly type what we want to print out.</p>

<?php echo $this->Highlighter->highlight(file_get_contents(__DIR__ . DS . 'pr.php'), ['lang' => 'php-template'])?>

	<h4>Resulting output</h4>
	<?php echo $this->element('../DtoExamples/pr')?>

	<hr>


	<p>
		As you can see (and try out):
	</p>
	<ul>
		<li>Typing out the existing fields is super fast and easy (no tedious lookup on the nested array).</li>
		<li>Full return-type-hinting (string, int, bool, object, ...) will let you know if you use sth wrongly without having to run it first (string operation on a non-string etc).</li>
	</ul>


</div>
