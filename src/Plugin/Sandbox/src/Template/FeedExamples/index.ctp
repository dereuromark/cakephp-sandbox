<h2>Feed Plugin</h2>
<a href="https://github.com/dereuromark/cakephp-feed" target="_blank">[Source]</a>

<h3>Example Feed</h3>
<ul>
	<li><?php echo $this->Html->link('I am a RSS Feed', ['action' => 'feed', '_ext' => 'rss']); ?></li>
</ul>

Validation passed using W3Cs validator:
<a href="http://validator.w3.org/feed/check.cgi?url=http%3A//sandbox.dereuromark.de/sandbox/feed_examples/feed.rss"><img src="http://validator.w3.org/feed/images/valid-rss-rogers.png" alt="[Valid RSS]" title="Validated RSS feed" /></a>