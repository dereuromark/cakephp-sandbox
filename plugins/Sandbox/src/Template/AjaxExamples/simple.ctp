<?php
/**
 * @var \App\View\AppView $this
 */
?>
<script type="text/javascript">
$(function() {
	$('#button').click(function() {
		var targeturl = $(this).data('rel');
		$.ajax({
			type: 'get',
			url: targeturl,
			beforeSend: function(xhr) {
				xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			},
			success: function(response) {
				if (response.result) {
					var result = response.result;
					$('#result').html(result.now);
				}
			},
			error: function(e) {
				alert("An error occurred: " + e.responseText.message);
				console.log(e);
			}
		});
	});

});
</script>

<div class="page index">
<h2><?php echo __('Countries');?> and AJAX Pagination</h2>

<p>
In this simple example we request something via JSON GET request.
The response will be an object and its content is accessable via `response.result`. The result itself can contain multiple data keys.
We just need our `result.now` date value.
</p>

<button id="button" data-rel="<?php echo $this->Url->build(['_ext' => 'json']); ?>">Click me</button>

<h3>Result</h3>
<div id="result">
<i>n/a</i>
</div>

</div>
