## Meet the New FileStorage Plugin

A Modern File Storage Solution for CakePHP.

Remember when handling file uploads in PHP meant wrestling with `$_FILES`, manually moving uploaded files, hardcoding paths throughout your application, and hoping nothing breaks when you need to move files to S3? We've all been there.

For years, CakePHP developers have cobbled together various solutions—some rolled their own upload handlers, others patched together different libraries, and the brave ones tried to keep legacy plugins alive across framework versions.
But let's face it: file management is harder than it looks. You need thumbnails? Add another library. Want to store in the cloud? Rewrite your code. Need to track metadata? Better add more database columns everywhere.

**Those days are over.**

## Enter: The Modern FileStorage Plugin

There's a new player on the CakePHP block, and it's bringing modern architecture, clean abstractions, and production-ready code to solve file management once and for all.
Built from the ground up for CakePHP 5.x with PHP 8.1+, the FileStorage plugin isn't just another upload library—it's a complete storage solution that finally gets file handling right.

Think of it as the file management system you wish you'd had on your last three projects.

## What Makes It Different?

### Store Anywhere (Seriously, Anywhere)

Here's where it gets interesting. The plugin is built on FlySystem v3, which means your files can live anywhere—and I mean *anywhere*. Local disk today, AWS S3 tomorrow, Azure next month? Just change your config. Your application code? Stays exactly the same.

Start developing locally, deploy to S3 in production, switch to Azure when the business changes cloud providers next year. The plugin doesn't care, and neither does your code. That's the power of proper abstraction.

Supported out of the box:
- Local filesystem (the classic)
- Amazon S3 (the popular choice)
- Azure Blob Storage (the enterprise favorite)
- FTP/SFTP (for that legacy server)
- Dropbox (why not?)
- In-memory storage (perfect for testing)
- Any other backend via FlySystem adapters

One interface. Any storage. Zero refactoring.

### Set It and Forget It

Remember writing upload handling code in every controller action? Yeah, me too. Not anymore.

Attach the `FileStorageBehavior` to your model, and watch the magic happen. Files upload when you save. Files delete when you remove entities. It just works, like it should have from the beginning:

```php
// In your Table class - that's it!
public function initialize(array $config): void
{
    parent::initialize($config);

    $this->addBehavior('FileStorage.FileStorage', [
        'fields' => ['file' => 'file'],
    ]);
}
```

Your controllers stay clean. Your code stays simple. Your future self says thank you.

### Smart Architecture: One Table to Rule Them All

Here's something clever: instead of adding `avatar_path`, `document_path`, and `thumbnail_path` columns to every table in your database (we've all done it), the plugin uses a single `file_storage` table for all file metadata.

Think about it. Your `users` table doesn't need file paths. Your `products` table doesn't need file paths. They just have relationships to the `FileStorage` model, like any other association in CakePHP.

**What you get:**
- **Clean schema** - No path strings cluttering your business data
- **Easy migrations** - Move files around without touching your core tables
- **Perfect audit trail** - Every upload tracked with metadata, hashes, timestamps
- **Duplicate detection** - File hashes catch duplicate uploads automatically
- **Flexible relationships** - One file, many owners? No problem.

It's the architecture you'd design if you had time to think it through properly. Good news: someone already did.

### Image Processing That Actually Works

"Just generate a thumbnail" said the client, as if it's simple. Except now you need three sizes. And they want them optimized. And cropped to exact dimensions. And...

Stop. Take a breath. The plugin's got you covered.

With the optional `php-collective/file-storage-image-processor` package (powered by Intervention Image v3), you can generate any variant you need with a fluent, chainable API that actually makes sense:

```php
$variants = ImageVariantCollection::create()
    ->addNew('thumbnail')
        ->scale(300, 300)
        ->optimize()
    ->addNew('medium')
        ->scale(800, 600)
        ->sharpen(10)
        ->optimize()
    ->addNew('profile')
        ->cover(150, 150)
        ->optimize();

$imageProcessor->process($file, $variants);
```

Upload one image, get four versions (original + three variants), all optimized, all stored, all tracked. One line of code to process them all.

**The full toolkit:**
- **scale** - Maintain aspect ratio (the one you actually want most of the time)
- **resize** - Exact dimensions (when you really mean it)
- **cover** - Smart zoom-crop (perfect for profile pics)
- **crop** - Surgical precision extracts
- **rotate** - Because users upload sideways photos
- **flip** operations - Mirror, mirror on the wall
- **sharpen** - Make those photos pop
- **optimize** - Smaller files, same quality
- **callback** - Your custom wizardry

Chain them, combine them, go wild. The API won't judge.

## The Details That Matter

### Organized Storage, Your Way

The path builder keeps things tidy automatically:

```php
// Generated paths like:
{model}/{uuid}/original.jpg
{model}/{uuid}/{variant}/thumbnail.jpg
```

Organize by model, by date, by user, by moon phase—whatever makes sense for your app. The plugin handles the patterns.

### Validation Built In

Because nobody wants 500MB BMPs crashing their server:

- File type and extension checks
- Size limits that actually work
- MIME type validation
- Image dimension constraints
- Full PSR-7 support

Set your rules once, enforce them everywhere.

### Built on Solid Foundations

This isn't a weekend hackathon project. The plugin is architected with production in mind:

**Event-driven design** means you can hook into any file operation—send notifications, trigger processing, update CDNs, whatever you need.

**Dependency injection** throughout makes testing actually pleasant and customization straightforward.

**Standards-based** on FlySystem, Intervention Image, PSR-7, and CakePHP best practices. No weird custom abstractions to learn.

**Quality assured** with PHPStan level 8, comprehensive tests, and active maintenance.

## What Can You Build?

### E-Commerce Done Right

Your client uploads one massive 5000x5000px product photo. The plugin generates thumbnail, gallery, and zoom versions, optimizes them all, and stores them wherever you want:

```php
$variants = ImageVariantCollection::create()
    ->addNew('thumbnail')->scale(150, 150)->optimize()
    ->addNew('gallery')->scale(600, 600)->optimize()
    ->addNew('zoom')->scale(1200, 1200)->optimize();
```

Your customers get fast page loads. Your S3 bill stays reasonable. Everybody wins.

### Social Platforms with Style

User avatars that actually look good everywhere—navbar, profile page, comment sections, notification icons:

```php
$variants = ImageVariantCollection::create()
    ->addNew('avatar')->cover(200, 200)->optimize()
    ->addNew('avatar_small')->cover(50, 50)->optimize();
```

Smart cropping means faces stay centered. Automatic optimization means your CDN costs don't explode.

### Document Management That Scales

PDFs with thumbnail previews. File metadata tracked perfectly. Full audit trails. Version history. And when your startup grows up and needs to move everything to cloud storage? Update the config. Done.

### Multi-Tenant Applications

Different storage backend per customer? Different path structures per tenant? Clean data separation? The plugin's architecture makes it straightforward instead of scary.

## Beyond the Basics: Extension Points

Here's where it gets exciting. The plugin's architecture isn't just solid—it's designed for extension. The event-driven design, flexible metadata system, and clean abstractions mean you can build some impressive features on top.

### Already Possible (Right Now)

**Secure File Serving with Authorization**
Here's something most upload plugins ignore: access control. The FileStorage plugin doesn't just store files—it provides utilities for serving them securely.

The plugin gives you URL generation and signed URL helpers, but intentionally doesn't include a one-size-fits-all serving controller. Why? Because your authorization logic is yours. The plugin provides the tools; you implement the rules that make sense for your application.

```php
// Generate time-limited signed URL (no auth required if signature valid)
$signedUrl = $this->FileStorage->generateSignedUrl($file, '+1 hour');

// Or implement your own serving controller with custom authorization:
// - Ownership-based (only file owner can access)
// - Role-based (admins see everything, users see their department)
// - Related entity access (file visible if parent album is visible)
// - Time-based (files available only during business hours)
// - Combination of above
```

The [FileServing documentation](https://github.com/dereuromark/cakephp-file-storage/blob/master/docs/Documentation/FileServing.md) provides complete examples for each pattern. You get the security infrastructure without the opinionated authorization that never quite fits your needs.

**Custom Metadata & Advanced Search**
The centralized storage table includes metadata fields you can extend. Add tags, categories, descriptions, or any custom data. Then search, filter, and organize files however your application needs:

```php
$entity = $fileStorage->newEntity([
    'file' => $uploadedFile,
    'metadata' => [
        'tags' => ['product', 'winter-2024'],
        'department' => 'Marketing',
        'project_code' => 'PRJ-123',
    ],
]);
```

**File Versioning**
Want to track file versions? The architecture supports it naturally. Store multiple versions with relationships, track upload timestamps, and let users restore previous versions. The collections system makes it clean:

```php
// Store new version, link to original
$newVersion = $fileStorage->newEntity([
    'file' => $newFile,
    'collection' => 'versions',
    'parent_id' => $originalFile->id,
    'version' => 2,
]);
```

### Community-Driven Roadmap

The plugin has an active [roadmap](https://github.com/dereuromark/cakephp-file-storage/issues/13) shaped by real-world usage. Here's what's being discussed and built:

**Smart Image Optimization** - Auto-format selection (WebP when supported), responsive image sets for different screen sizes, automatic quality adjustment based on file size targets.

**Bulk Operations** - Select and process multiple files at once. Batch tagging, bulk downloads as ZIP, mass deletions, metadata updates across hundreds of files.

**Storage Analytics** - Dashboard showing storage usage by type, upload trends, file age distribution, and storage costs. Great for resource planning and quota management.

**CDN Integration Helpers** - Simplified configuration for CloudFront, CloudFlare, and other CDNs. Automatic cache invalidation, signed URL generation, geo-routing support.

**Advanced Transformations** - Watermarking pipelines, image filter presets (vintage, black-and-white, etc.), format conversion workflows, PDF thumbnail generation.

**Access Control Layers** - Permission checks before downloads, user-specific file visibility, role-based access to collections, audit logging for compliance.

**Client-Side Widgets** - Drop-in components for drag-and-drop uploads with progress bars, inline image cropping, preview before upload, chunked uploads for large files.

### What This Means for You

You're not locked into version 4.0's feature set. The architecture is built to grow with your needs:

- **Start simple** - Basic uploads and storage
- **Add complexity gradually** - Implement versioning when you need it
- **Customize freely** - The event system lets you hook into everything
- **Stay updated** - Active development means new features land regularly

The plugin isn't just solving today's file storage problems—it's built to handle tomorrow's requirements too.

## Getting Started (It's Easier Than You Think)

### Install It

```bash
composer require dereuromark/cakephp-file-storage
```

Want image processing too?

```bash
composer require php-collective/file-storage-image-processor
```

### Configure It

Load the plugin:

```php
// src/Application.php
public function bootstrap(): void
{
    parent::bootstrap();
    $this->addPlugin('FileStorage');
}
```

Run migrations (creates the file_storage table):

```bash
bin/cake migrations migrate -p FileStorage
```

Point it at your storage (for demo same filesystem):

```php
// config/app_local.php
'FileStorage' => [
    'adapter' => [
        'class' => 'Local',
        'root' => WWW_ROOT . 'files',
    ],
],
```

### Use It

```php
// In your controller - that's the whole thing
public function upload()
{
    if ($this->request->is('post')) {
        $file = $this->request->getData('file');

        $fileStorage = $this->fetchTable('FileStorage.FileStorage');
        $entity = $fileStorage->newEntity([
            'file' => $file,
            'model' => 'Products',
            'foreign_key' => $product->id,
        ]);

        if ($fileStorage->save($entity)) {
            $this->Flash->success('File uploaded successfully');
        }
    }
}
```

That's it. No hidden steps. No weird gotchas. It just works.

## Why This Plugin Exists

Let's be honest: file management is one of those problems that sounds simple until you actually try to solve it properly. Then it becomes a mess of edge cases, path handling, storage migrations, and "we need thumbnails now" feature requests.

The FileStorage plugin exists because developers kept solving the same problems over and over, poorly, under deadline pressure. Someone finally said "enough" and built the solution we all wish we'd had from the start.
Burzum (Florian) started this project, and I just happened to finish it up, test it with real apps, and publish it for everyone to use.

### What You Get

**Production-grade code** - PHPStan level 8, comprehensive tests, real-world battle-testing. This isn't beta software.

**Flexible from day one** - Start local, scale to cloud, switch providers. The architecture doesn't care where your files live.

**Time back in your life** - Stop reinventing uploads. Stop debugging path concatenation. Stop explaining to clients why migrating storage is hard.

**Community-proven** - Built by CakePHP veterans, used in production apps, improved by real-world feedback.

## The Modern Stack: Version 4.0.0

This isn't a dusty old plugin getting by on legacy code. Version 4.0 brings modern everything:

- **CakePHP 5.x native** - Built for the latest framework
- **FlySystem v3** - The best storage abstraction available
- **Intervention Image v3** - Latest image processing with improved performance

Fresh code. Modern patterns. Zero compromises.

## See It In Action

Words are cheap. Code is proof.

The live demo shows real uploads, real image processing, real variant generation. Upload a file, watch it generate thumbnails, see how the API works. No registration, no signup forms, just working code you can play with.

**Try the live demo:** [https://sandbox.dereuromark.de/sandbox/file-storage-examples](https://sandbox.dereuromark.de/sandbox/file-storage-examples)

Want the technical details, changelog, and upgrade notes?

**Release notes:** [https://github.com/dereuromark/cakephp-file-storage/releases/tag/4.0.0](https://github.com/dereuromark/cakephp-file-storage/releases/tag/4.0.0)

---

## Not Just for CakePHP

Here's a bonus: the core libraries powering this plugin aren't tied to CakePHP. They're framework-agnostic PHP packages that work in any project.

The plugin itself (`dereuromark/cakephp-file-storage`) is a convenient CakePHP wrapper that adds behaviors, helpers, and framework integration. But under the hood, it's built on:

- **`php-collective/file-storage`** - The core storage abstraction and file management
- **`php-collective/file-storage-factories`** - Simplified FlySystem adapter configuration
- **`php-collective/file-storage-image-processor`** - Image processing and variant generation

All three packages work standalone in any framework, or plain PHP projects.
They use standard PSR interfaces, Dependency Injection, and have zero framework dependencies.

**What this means:**

If you're building a **CakePHP application**, use the plugin. You get behaviors, table integration, migrations, and everything configured to work with CakePHP conventions out of the box.

If you're working with **another framework**, use the underlying libraries directly. Same powerful file storage and image processing, just without the CakePHP sugar coating.

If you're **migrating between frameworks**, your file storage logic can stay the same. Only the wrapper layer changes.

The architecture is portable. The investment is protected. Build once, use anywhere.

---

## The Bottom Line

File storage is a solved problem now. You don't need to solve it again.

Whether you're building a simple blog with avatars, a document management system, an e-commerce platform, or the next big SaaS app—the FileStorage plugin gives you production-ready file handling that actually scales.

Install it. Configure it. Forget about it. Move on to building features that actually matter.

Welcome to modern file storage for CakePHP.
