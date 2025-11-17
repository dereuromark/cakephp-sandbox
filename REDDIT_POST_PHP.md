# Reddit Post for /r/PHP

## Title
Framework-Agnostic File Storage Libraries for Modern PHP (with CakePHP integration example)

## Post Body

I wanted to share some recently released file storage libraries that work with any PHP framework. While the article below focuses on a CakePHP plugin, **the underlying libraries are framework-agnostic** and demonstrate some interesting architectural patterns worth discussing.

### The Core Libraries (Framework-Independent)

Three packages released at stable 1.0.0:

- **php-collective/file-storage** - Storage abstraction built on FlySystem v3
- **php-collective/file-storage-image-processor** - Image processing with Intervention Image v3
- **php-collective/file-storage-factories** - Simplified FlySystem adapter configuration

All work standalone in Symfony, Laravel, Slim, or any PHP 8.1+ project. Zero framework dependencies, PSR-compliant interfaces, full DI support.

### Why This Might Interest /r/PHP

**1. Solves a Universal Problem**

File uploads and storage are a pain point in every framework. Most solutions either lock you into a framework or force you to write the same boilerplate repeatedly. These libraries provide:

- Multi-backend storage (Local, S3, Azure, FTP, etc.) with zero code changes
- Automatic image variant generation with 13+ operations

Possible, as well:
- Metadata tracking and organization via collections
- File versioning support
- Signed URLs for secure, temporary access

**2. Clean Architecture Patterns**

The design is worth studying:

- **Event-driven** - Hook into any file operation for custom logic
- **Separation of concerns** - Storage, processing, and serving are distinct responsibilities
- **Configuration over code** - Switch storage backends by changing config
- **Intentionally unopinionated** - Provides tools, not dictates (e.g., no bundled auth controller—you implement your authorization logic)

**3. Modern PHP Stack**

- PHPStan level 8
- Built on industry-standard libraries (FlySystem, Intervention Image)
- Comprehensive test coverage

**4. Production-Ready**

These aren't new experimental packages—they've been battle-tested for years under different names and have now been modernized and released at stable 1.0.0.

### The CakePHP Plugin Example

The article demonstrates one framework implementation (`dereuromark/cakephp-file-storage`), which wraps these libraries with CakePHP conventions—behaviors, table integration, migrations, etc.

**But here's the interesting part:** Because the core is framework-agnostic, you could build similar wrappers for Laravel, Symfony, or any framework using the same battle-tested storage and image processing logic.

### Article Link

**Blog Post:** [Meet the New FileStorage Plugin - A Modern File Storage Solution for CakePHP](https://sandbox.dereuromark.de/blog/...)

*(The post focuses on CakePHP usage, but scroll to the "Not Just for CakePHP" section for framework-agnostic details)*

### Discussion Points

I'm curious what the PHP community thinks:

1. **Architecture patterns** - Is this event-driven, separation-of-concerns approach appealing for file storage? Or too abstract?

2. **Framework abstraction** - Do you prefer framework-specific packages with deep integration, or framework-agnostic libraries you wrap yourself?

3. **Missing features** - The roadmap includes signed URLs, file versioning, bulk operations, CDN integration, and analytics. What else would you want in a PHP file storage library?

4. **Competition** - How does this compare to other PHP file storage solutions you've used (beyond raw FlySystem)?

### Package Links

- [php-collective/file-storage](https://github.com/php-collective/file-storage) - Core library
- [php-collective/file-storage-image-processor](https://github.com/php-collective/file-storage-image-processor) - Image processing
- [php-collective/file-storage-factories](https://github.com/php-collective/file-storage-factories) - Adapter factories
- [dereuromark/cakephp-file-storage](https://github.com/dereuromark/cakephp-file-storage) - CakePHP integration

---

Would love to hear thoughts, critiques, or questions from the community!
