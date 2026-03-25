<?php
/**
 * @var \App\View\AppView $this
 */

echo $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github.min.css');
echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js');
echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/toml.min.js');

$examples = [
	'Basic Key/Values' => [
		'description' => 'Simple string, integer, float, and boolean values.',
		'code' => <<<'TOML'
# Basic key/value pairs
title = "TOML Example"
author = "Tom Preston-Werner"
version = 1
pi = 3.14159
enabled = true
TOML,
	],
	'Strings' => [
		'description' => 'Basic strings, literal strings, and multiline strings.',
		'code' => <<<'TOML'
# Basic string (escapes allowed)
basic = "Hello\nWorld"

# Literal string (no escapes)
literal = 'C:\Users\admin'

# Multiline basic string
multiline_basic = """
Roses are red
Violets are blue"""

# Multiline literal string
multiline_literal = '''
The first newline is
trimmed in raw strings.
All other content is preserved.'''
TOML,
	],
	'Numbers' => [
		'description' => 'Integers in various formats and floating point numbers.',
		'code' => <<<'TOML'
# Integers
int1 = 42
int2 = +99
int3 = -17

# Hexadecimal, octal, binary
hex = 0xDEADBEEF
oct = 0o755
bin = 0b11010110

# Floats
float1 = 3.14
float2 = -0.01
float3 = 5e+22
float4 = 1e06

# Special floats
inf = inf
neg_inf = -inf
nan = nan
TOML,
	],
	'Dates and Times' => [
		'description' => 'Offset datetime, local datetime, local date, and local time.',
		'code' => <<<'TOML'
# Offset Date-Time (RFC 3339)
odt1 = 1979-05-27T07:32:00Z
odt2 = 1979-05-27T00:32:00-07:00
odt3 = 1979-05-27T00:32:00.999999-07:00

# Local Date-Time (no timezone)
ldt1 = 1979-05-27T07:32:00
ldt2 = 1979-05-27T00:32:00.999999

# Local Date
ld1 = 1979-05-27

# Local Time
lt1 = 07:32:00
lt2 = 00:32:00.999999
TOML,
	],
	'Arrays' => [
		'description' => 'Arrays of various types including mixed and nested arrays.',
		'code' => <<<'TOML'
# Simple arrays
integers = [1, 2, 3]
colors = ["red", "yellow", "green"]
nested = [[1, 2], [3, 4, 5]]

# Mixed type arrays (TOML 1.0)
mixed = [1, "two", 3.0]

# Multiline arrays
hosts = [
    "alpha",
    "omega",
]
TOML,
	],
	'Tables' => [
		'description' => 'Standard tables and nested tables.',
		'code' => <<<'TOML'
# Standard table
[server]
host = "localhost"
port = 8080

# Nested tables
[database]
enabled = true

[database.connection]
host = "127.0.0.1"
port = 5432

[database.connection.pool]
max = 10
min = 2
TOML,
	],
	'Inline Tables' => [
		'description' => 'Compact single-line table syntax.',
		'code' => <<<'TOML'
# Inline tables
point = { x = 1, y = 2 }
animal = { type.name = "pug" }

# Equivalent to:
# [point]
# x = 1
# y = 2

[player]
name = "John"
position = { x = 100, y = 200 }
TOML,
	],
	'Array of Tables' => [
		'description' => 'Define arrays containing table entries.',
		'code' => <<<'TOML'
# Array of tables
[[products]]
name = "Hammer"
sku = 738594937

[[products]]
name = "Nail"
sku = 284758393
color = "gray"

# Nested array of tables
[[fruits]]
name = "apple"

[[fruits.varieties]]
name = "red delicious"

[[fruits.varieties]]
name = "granny smith"

[[fruits]]
name = "banana"

[[fruits.varieties]]
name = "plantain"
TOML,
	],
	'Dotted Keys' => [
		'description' => 'Use dots to define nested keys without explicit tables.',
		'code' => <<<'TOML'
# Dotted keys
name = "Orange"
physical.color = "orange"
physical.shape = "round"
site."google.com" = true

# Equivalent explicit form:
# [physical]
# color = "orange"
# shape = "round"
TOML,
	],
	'Real-World Config' => [
		'description' => 'A realistic application configuration file.',
		'code' => <<<'TOML'
[app]
name = "MyApp"
version = "1.0.0"
debug = false

[app.server]
host = "0.0.0.0"
port = 8080
workers = 4

[database]
driver = "mysql"
host = "localhost"
port = 3306
name = "myapp"
user = "root"
password = ""

[database.pool]
min_connections = 5
max_connections = 20
timeout = 30

[cache]
driver = "redis"
host = "localhost"
port = 6379
prefix = "myapp:"

[[routes]]
path = "/"
handler = "HomeController@index"

[[routes]]
path = "/api/users"
handler = "UserController@list"
methods = ["GET", "POST"]

[logging]
level = "info"
format = "json"
outputs = ["stdout", "file"]

[logging.file]
path = "/var/log/myapp.log"
max_size = "100MB"
max_files = 5
TOML,
	],
];

/**
 * Encode TOML for URL sharing
 */
function encodeToml(string $toml): string {
	return base64_encode($toml);
}
?>

<nav class="actions col-md-2 col-sm-3 col-12">
	<?= $this->element('navigation/toml') ?>
</nav>
<div class="col-md-10 col-sm-9 col-12">

<h2>TOML Examples</h2>
<p>
	Explore TOML syntax with these examples.
	Click "Try it" to open each example in the playground.
</p>

<div class="row">
<?php foreach ($examples as $title => $example) { ?>
<div class="col-md-6 mb-3">
	<div class="card h-100">
		<div class="card-header d-flex justify-content-between align-items-center py-2">
			<strong><?= h($title) ?></strong>
			<?= $this->Html->link(
				'<i class="bi bi-play-circle"></i> Try',
				['action' => 'index', '?' => ['d' => encodeToml($example['code'])]],
				['class' => 'btn btn-sm btn-outline-primary', 'escape' => false],
			) ?>
		</div>
		<div class="card-body py-2">
			<p class="text-muted small mb-2"><?= h($example['description']) ?></p>
			<pre class="bg-light p-2 border rounded mb-0" style="max-height: 200px; overflow-y: auto;"><code class="language-toml"><?= h($example['code']) ?></code></pre>
		</div>
	</div>
</div>
<?php } ?>
</div>

</div>

<?php $this->Html->scriptStart(['block' => true]); ?>
document.querySelectorAll('code.language-toml').forEach(el => {
	hljs.highlightElement(el);
});
<?php $this->Html->scriptEnd(); ?>
