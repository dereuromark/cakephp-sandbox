<h2>Beginner Tips</h2>
CakePHP doesn't always have the best "beginner settings" preconfigured. It is often just optimized for speed by default.
IMO that is not too clever, as beginners easily trip over that, whereas advanced users could easily "deactivate" it.
<br/>
So at the beginning it should just work, and optimization should come later.
<br/><br/>
To sum a few things up, this should help getting you started:

<h3>Enable Quote Identifiers</h3>
Set it to true in your app.php config so any field names that could be reserverd SQL keywords are properly quoted:
<pre><code>'quoteIdentifiers' => true
</code></pre>

<h3>Use Linux or Vagrant/Docker</h3>
Don't try to work on Windows. There could be too many small pitfalls.
Best to use a Vagrant Box or just a docker image to run your CakePHP app inside a Linux environment.
<br><br>
This way you have less bugs/side-effects that you will have a hard time with to decide whether they are framework related or not.
<br><br>
As a positive addition: Such an environment is then also case sensitive and therefore closer to production env.
