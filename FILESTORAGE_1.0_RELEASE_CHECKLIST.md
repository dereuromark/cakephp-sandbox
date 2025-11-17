# FileStorage Plugin 1.0.0 Release Checklist

## Critical Issues (Must Fix Before 1.0.0)

### 1. **Upstream Library Bugs** ⚠️ BLOCKER
These bugs were discovered and fixed locally in vendor code but need to be submitted upstream:

**php-collective/file-storage-image-processor:**
- `src/ImageVariant.php:240` - cover() method stores operation as 'fit' instead of 'cover'
  ```php
  // Current (WRONG):
  $this->operations['fit'] = [...];

  // Should be:
  $this->operations['cover'] = [...];
  ```

- `src/Operations.php:281` - callback() method uses wrong array key
  ```php
  // Current (WRONG):
  $arguments['callable']($this->image, $arguments);

  // Should be:
  $arguments['callback']($this->image, $arguments);
  ```

**dereuromark/cakephp-file-storage:**
- `src/Model/Behavior/FileStorageBehavior.php` - FlySystem v3 compatibility issue
  ```php
  // Current (WRONG):
  use League\Flysystem\AdapterInterface;
  public function getStorageAdapter(string $configName): AdapterInterface

  // Should be:
  use League\Flysystem\FilesystemAdapter;
  public function getStorageAdapter(string $configName): FilesystemAdapter
  ```

**Action Required:**
- Submit PRs to php-collective/file-storage-image-processor
- Submit PR to dereuromark/cakephp-file-storage
- Wait for releases with fixes before tagging 1.0.0

### 2. **Test Failures** ⚠️ BLOCKER
Status: 5 failures, 1 error (7 tests total)

**Root Cause:** CakePHP's file validation rules don't work properly in integration tests
- `uploadedFile` rule uses `is_uploaded_file()` which only works for actual HTTP uploads
- `fileSize`, `extension`, `mimeType` rules expect UploadedFileInterface objects

**Current Solution Attempt:** Skip `uploadedFile` validation in CLI (PHP_SAPI check)
**Result:** Still failing - other validation rules also don't work with test file arrays

**Possible Solutions:**
1. Create a test-specific validator that skips file validation rules
2. Use a different approach for file uploads in tests (mock UploadedFileInterface)
3. Move validation to Table layer where CakePHP handles it better
4. Accept that file upload tests require functional/browser tests, not integration tests

**Recommendation:** Option 2 - Create proper UploadedFile mocks for tests

### 3. **Documentation** ⚠️ NEEDS REVIEW
- README exists at `plugins/Sandbox/FILE_STORAGE_README.md`
- Needs review for completeness
- Should include:
  - Installation instructions
  - Configuration examples
  - Usage patterns
  - Known limitations

## Minor Issues (Nice to Have)

### 4. **Code Quality**
- ✅ PHPStan compliance - needs verification
- ✅ Coding standards - needs verification
- ✅ Property declarations - FIXED (added protected $FileStorage)
- ✅ Auto-cleanup refactored to beforeFilter() - FIXED

### 5. **Test Coverage**
Current coverage:
- ✅ Image upload
- ✅ PDF upload with thumbnails
- ✅ File validation (images, PDFs)
- ✅ Max count limits
- ✅ File deletion
- ❌ Variant generation (failing)
- ❌ General file uploads (no test)

### 6. **Security Considerations**
- ✅ File type validation
- ✅ File size limits
- ✅ Upload validation (uploadedFile rule)
- ⚠️ Path traversal protection - verify PathBuilder handles this
- ⚠️ MIME type verification - relies on browser-provided type

## Package Dependencies

All currently on `dev-master`:
```json
{
    "php-collective/file-storage": "dev-master",
    "php-collective/file-storage-image-processor": "dev-master",
    "dereuromark/cakephp-file-storage": "dev-master",
    "spatie/pdf-to-image": "^1.2"  // Already stable
}
```

**For 1.0.0 Release:**
1. Get bug fixes merged upstream
2. Tag stable releases of dependencies:
   - php-collective/file-storage: suggest 1.0.0
   - php-collective/file-storage-image-processor: suggest 1.0.0
   - dereuromark/cakephp-file-storage: suggest 1.0.0
3. Update composer.json to use ^1.0 constraints

## Recommended Release Timeline

**Phase 1 - Fix Blockers (1-2 weeks)**
1. Submit PRs for library bugs
2. Fix test failures
3. Verify all tests pass

**Phase 2 - Quality & Documentation (3-5 days)**
1. Run PHPStan and fix any issues
2. Run CS fixer
3. Review and update documentation
4. Add any missing tests

**Phase 3 - Coordinate Releases (1 week)**
1. Wait for upstream PRs to be merged
2. Coordinate version tags across all 3 packages
3. Update composer.json dependencies
4. Create release notes

**Total Estimated Time: 2-3 weeks**

## Immediate Next Steps

1. Create GitHub issues for the 3 library bugs
2. Submit PRs with fixes
3. Fix file upload test issues (create UploadedFile mocks)
4. Run test suite until all green

## Questions to Resolve

1. Should uploadedFile validation be required in production?
   - Pro: Ensures files came from actual HTTP upload
   - Con: Can't test properly, could block legitimate use cases

2. Should we add functional tests in addition to integration tests?
   - Would allow true file upload testing
   - Requires browser automation

3. What's the minimum PHP version target?
   - Currently using PHP 8.4 features
   - Should we support 8.1+?

4. What's the migration path for users on older versions?
   - Any breaking changes from dev-master to 1.0.0?

## Summary

**Can we release 1.0.0 now?** ❌ **NO**

**Why not:**
1. Critical bugs in vendor libraries (not yet fixed upstream)
2. Test suite not passing
3. Dependencies still on dev-master

**What's needed:**
1. Fix and release upstream library bugs
2. Get tests passing
3. Coordinate version tags

**Realistic timeline:** 2-3 weeks minimum
