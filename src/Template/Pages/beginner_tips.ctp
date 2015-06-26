<h2>Beginner Tips</h2>
CakePHP 3 doesn't always have the best "beginner settings" preconfigured. It is often just optimized for speed by default.
IMO that is not too clever, as beginners easily trip over that, whereas advanced users could easily "deactivate" it.
<br/>
So at the beginnning it should just work, and optimization should come later.
<br/><br/>
To sum a few things up, this should help getting you started:

<h3>Enable Quote Identifiers</h3>
Set it to true in your app.php config so any field names that could be reserverd SQL keywords are properly quoted:
<pre><code>'quoteIdentifiers' => true
</code></pre>

<h3>Routing</h3>
Use DashedRoute class as default for new CakePHP 3 apps. See <a href="/pages/best-practices#routing">here</a>.
<br>
It is going to be the default in 3.1+ anyway.

