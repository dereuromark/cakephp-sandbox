<?php
/**
 * @var \App\View\AppView $this
 * @var \Sandbox\Dto\Github\PullRequestDto $pullRequestDto
 */

use Cake\Core\Plugin;
use Cake\Error\Debugger;

$dtoFile = Plugin::path('Sandbox') . 'config' . DS . 'dto.xml';
?>

<nav class="actions col-sm-4 col-xs-12">
	<?php echo $this->element('navigation/dto'); ?>
</nav>
<div class="page index col-sm-8 col-xs-12">

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
<pre><?php echo h(file_get_contents($dtoFile)); ?></pre>

	<p>All we now need to do is to convert the raw JSON/array into our nested DTO object:</p>
	<pre>$pullRequestDto = PullRequestDto::create($simulatedDataFromGitHubApi, true, PullRequestDto::TYPE_UNDERSCORED);</pre>

	<p>We use "ignoreMissing" as true as we do not assign all array values, and we also need to tell it to expect an underscored form.</p>


	<h4>dd($pullRequestDto) result</h4>
	<p>Using debug() or dd() we can easily show what the DTO contains:</p>
	<pre><?php
	echo Debugger::exportVar($pullRequestDto, 9);
	?></pre>

	<h4>Now let's use it</h4>
	<p>In the template we now have fully annotated fields and can very quickly type what we want to print out.</p>

<pre><?php echo h(file_get_contents(__DIR__ . DS . 'pr.ctp')); ?></pre>

	<h4>Result</h4>
	<?php echo $this->element('../DtoExamples/pr')?>


</div>
