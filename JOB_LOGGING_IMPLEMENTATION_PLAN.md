# Job Output Capture and Result Logging - Implementation Plan

## Executive Summary

This plan outlines the implementation of comprehensive output capture and result logging for both **Queue jobs** and **scheduled/cron jobs** in the CakePHP Sandbox application.

### Goals
- Capture stdout/stderr output from all job executions
- Log execution results (success, error, warnings)
- Track execution metadata (duration, memory usage, timestamps)
- Provide searchable history and debugging capability
- Support both Queue tasks and scheduled commands
- Integrate with existing DatabaseLog and Queue infrastructure

---

## Current Infrastructure Analysis

### Existing Components
✓ **Queue Plugin** (`dereuromark/cakephp-queue`) - Job queue with worker management
✓ **QueueScheduler Plugin** (`dereuromark/cakephp-queue-scheduler`) - Scheduling admin UI
✓ **DatabaseLog Plugin** (`dereuromark/cakephp-databaselog`) - Database-driven logging
✓ **Custom AuditLog** - Application-specific audit trail

### Current Capabilities
- Queue jobs tracked in `queued_jobs` table (status, attempts, failure_message)
- Scheduled jobs defined in `queue_scheduler_rows` table (last_run, next_run)
- General application logs in `database_logs` table
- Email alerts on errors via DatabaseLog monitoring

### Current Gaps
❌ No stdout/stderr capture from Queue tasks
❌ No detailed execution history/logs for individual job runs
❌ No output capture for scheduled commands (cron)
❌ Limited debugging info (only `failure_message` field in queued_jobs)
❌ No execution time/memory tracking per job
❌ No searchable job output history

---

## Proposed Solution Architecture

### Option A: Extend Queue Plugin Tables (Recommended)

**Pros:**
- Leverages existing Queue infrastructure
- Minimal new tables required
- Natural integration with Queue workflow
- Consistent with Queue plugin patterns

**Cons:**
- Only works for Queue tasks (not standalone cron commands)
- Requires Queue plugin modifications/extensions

### Option B: Standalone Job Logging System

**Pros:**
- Works for any job type (Queue, cron, manual commands)
- Independent of Queue plugin lifecycle
- More flexible for future expansion
- Can log non-Queue scheduled jobs

**Cons:**
- Requires more new infrastructure
- Potential duplication with Queue tables
- More integration points to maintain

### **Recommendation: Hybrid Approach**

Combine both approaches:
1. Extend Queue for Queue-based jobs (Option A)
2. Create standalone logging for scheduled commands (Option B)
3. Share common logging table structure

---

## Database Schema Design

### New Table: `job_execution_logs`

Stores detailed execution logs for all job runs (Queue tasks + scheduled commands).

```sql
CREATE TABLE job_execution_logs (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    -- Job Identification
    job_type VARCHAR(20) NOT NULL,              -- 'queue_task', 'scheduled_command', 'manual_command'
    job_name VARCHAR(255) NOT NULL,             -- Task class name or command name
    job_reference VARCHAR(255) NULL,            -- Optional reference (e.g., entity ID, user ID)
    queued_job_id INT UNSIGNED NULL,            -- FK to queued_jobs (if Queue-based)

    -- Execution Metadata
    started DATETIME NOT NULL,                  -- Job start time
    completed DATETIME NULL,                    -- Job completion time (NULL if still running)
    duration_seconds DECIMAL(10,3) NULL,        -- Execution duration
    status VARCHAR(20) NOT NULL,                -- 'running', 'success', 'error', 'timeout', 'cancelled'
    exit_code INT NULL,                         -- Process exit code (0 = success)

    -- Output Capture
    stdout TEXT NULL,                           -- Standard output (truncated if too large)
    stderr TEXT NULL,                           -- Standard error output
    output_truncated BOOLEAN DEFAULT FALSE,     -- Flag if output was truncated
    output_size_bytes INT UNSIGNED NULL,        -- Original output size

    -- Resource Usage
    memory_peak_mb DECIMAL(10,2) NULL,          -- Peak memory usage
    cpu_time_seconds DECIMAL(10,3) NULL,        -- CPU time consumed

    -- Error Details
    error_message VARCHAR(500) NULL,            -- Short error message
    error_trace TEXT NULL,                      -- Full stack trace

    -- Context
    hostname VARCHAR(255) NULL,                 -- Server that ran the job
    worker_key VARCHAR(255) NULL,               -- Queue worker key (if applicable)
    triggered_by VARCHAR(100) NULL,             -- 'scheduler', 'queue', 'manual', 'api'
    user_id INT UNSIGNED NULL,                  -- User who triggered (if applicable)

    -- Additional Data
    context_data TEXT NULL,                     -- JSON serialized context (job params, env vars, etc.)

    created DATETIME NOT NULL,
    modified DATETIME NOT NULL,

    INDEX idx_job_type_name (job_type, job_name),
    INDEX idx_status (status),
    INDEX idx_started (started),
    INDEX idx_queued_job_id (queued_job_id),
    INDEX idx_job_reference (job_reference),

    FOREIGN KEY (queued_job_id) REFERENCES queued_jobs(id) ON DELETE SET NULL
);
```

### Enhanced `queued_jobs` Table

No schema changes needed, but add relationship:
- `hasOne` relationship to `JobExecutionLog` (latest execution)
- `hasMany` relationship to `JobExecutionLog` (all retries/executions)

### Enhanced `queue_scheduler_rows` Table

Add tracking fields (via migration):
```sql
ALTER TABLE queue_scheduler_rows
ADD COLUMN last_execution_log_id INT UNSIGNED NULL,
ADD COLUMN total_runs INT UNSIGNED DEFAULT 0,
ADD COLUMN total_failures INT UNSIGNED DEFAULT 0,
ADD COLUMN avg_duration_seconds DECIMAL(10,3) NULL,
ADD INDEX idx_last_execution_log_id (last_execution_log_id);
```

---

## Implementation Phases

### Phase 1: Core Infrastructure (Week 1)

#### Tasks:
1. **Create migration for `job_execution_logs` table**
   - File: `config/Migrations/YYYYMMDDHHMMSS_CreateJobExecutionLogs.php`
   - Run: `bin/cake migrations create CreateJobExecutionLogs`

2. **Create Model classes**
   - `src/Model/Table/JobExecutionLogsTable.php`
   - `src/Model/Entity/JobExecutionLog.php`
   - `src/Model/Enum/JobExecutionStatus.php` (running, success, error, timeout, cancelled)
   - `src/Model/Enum/JobType.php` (queue_task, scheduled_command, manual_command)

3. **Create base logging trait**
   - `src/Job/JobExecutionLoggerTrait.php`
   - Methods:
     - `startExecutionLog(string $jobName, array $context = []): JobExecutionLog`
     - `updateExecutionLog(JobExecutionLog $log, array $data): void`
     - `completeExecutionLog(JobExecutionLog $log, string $status, array $data = []): void`
     - `captureOutput(callable $callback): array` (captures stdout/stderr)

4. **Add configuration**
   - `config/app_custom.php`:
     ```php
     'JobLogging' => [
         'enabled' => true,
         'captureOutput' => true,
         'maxOutputLength' => 50000,        // Truncate after 50KB
         'trackResources' => true,           // Memory/CPU tracking
         'cleanupAfter' => '-3 months',      // Keep 3 months of logs
         'alertOnFailure' => true,           // Send email on failures
         'alertEmail' => env('ADMIN_EMAIL'),
     ],
     ```

#### Deliverables:
- ✓ Database table created and migrated
- ✓ Model layer complete with enums
- ✓ Reusable logging trait
- ✓ Configuration in place

---

### Phase 2: Queue Task Integration (Week 2)

#### Tasks:
1. **Create Queue Task base class with logging**
   - `src/Queue/Task/LoggableTaskInterface.php` (interface)
   - `src/Queue/Task/LoggableTaskTrait.php` (trait with logging)
   - Methods to override:
     - `executeWithLogging(array $data): bool` (replaces run())
     - `getJobReference(): ?string` (optional reference for grouping)

2. **Create output capture wrapper**
   - `src/Queue/OutputCaptureWrapper.php`
   - Wraps Queue task execution
   - Buffers stdout/stderr using output buffering
   - Measures execution time and memory

3. **Update existing Queue tasks**
   - Convert `MyTaskNameTask` to use new trait
   - Convert `SimulatePaymentResultTask` to use new trait
   - Example:
     ```php
     class SimulatePaymentResultTask implements QueueTaskInterface, LoggableTaskInterface
     {
         use LoggableTaskTrait;

         public function executeWithLogging(array $data): bool
         {
             // Job logic here - output captured automatically
             $this->log("Processing payment {$data['order_id']}");
             return true;
         }

         public function getJobReference(): ?string
         {
             return $this->getData('order_id');
         }
     }
     ```

4. **Hook into Queue lifecycle**
   - Use Queue plugin events (if available) or extend QueuedJobsTable
   - Before job execution: Create `JobExecutionLog` record
   - During execution: Capture output via OutputCaptureWrapper
   - After execution: Update log with results, output, duration

5. **Update QueuedJobsTable**
   - Add `hasMany` association to `JobExecutionLogs`
   - Add method: `getExecutionHistory(int $queuedJobId): array`
   - Add method: `getLatestExecution(int $queuedJobId): ?JobExecutionLog`

#### Deliverables:
- ✓ Queue tasks automatically log all executions
- ✓ Output captured for all Queue jobs
- ✓ Backward compatible with existing Queue tasks
- ✓ Example task implementations updated

---

### Phase 3: Scheduled Command Integration (Week 3)

#### Tasks:
1. **Create loggable command base class**
   - `src/Command/LoggableCommand.php` (extends Cake\Console\Command)
   - Auto-wraps `execute()` with logging
   - Captures output via output buffering
   - Example:
     ```php
     class MyScheduledCommand extends LoggableCommand
     {
         protected string $jobName = 'MyScheduledCommand';

         public function execute(Arguments $args, ConsoleIo $io): int
         {
             // Command logic - automatically logged
             $io->out("Processing batch job...");
             return static::CODE_SUCCESS;
         }
     }
     ```

2. **Create scheduler trigger command**
   - `src/Command/SchedulerRunCommand.php`
   - Reads `queue_scheduler_rows` for due jobs
   - Queues jobs via Queue plugin (for Queue-based schedules)
   - Directly executes commands (for command-based schedules)
   - Logs all executions to `job_execution_logs`
   - Updates `last_run`, `next_run` in scheduler table

3. **Add system cron integration**
   - Documentation: `docs/SCHEDULED_JOBS.md`
   - Crontab example:
     ```cron
     * * * * * cd /path/to/app && bin/cake scheduler_run >> /dev/null 2>&1
     ```
   - Alternative: Use `supercronic` or `cron` package

4. **Update QueueScheduler integration**
   - After scheduler creates Queue job: Link to execution log
   - Update scheduler stats after job completion
   - Display execution history in scheduler admin UI

#### Deliverables:
- ✓ Scheduled commands automatically logged
- ✓ Scheduler trigger mechanism in place
- ✓ Cron integration documented
- ✓ Scheduler UI enhanced with execution history

---

### Phase 4: Admin UI and Reporting (Week 4)

#### Tasks:
1. **Create Admin controller**
   - `src/Controller/Admin/JobExecutionLogsController.php`
   - Actions:
     - `index()` - Paginated list with filters (job_type, status, date range, job_name)
     - `view($id)` - Detailed view with full output, context, stack trace
     - `cleanup()` - Manual cleanup action
     - `stats()` - Dashboard with success rate, avg duration, failure trends

2. **Create Admin templates**
   - `templates/Admin/JobExecutionLogs/index.php`
     - Filterable table with: Job Name, Type, Status, Duration, Started, Actions
     - Status badges with color coding
     - Quick filters: Failed Today, Running Now, Slow Jobs (>60s)
   - `templates/Admin/JobExecutionLogs/view.php`
     - Full job details with tabs: Overview, Output, Context, Error Details
     - Syntax-highlighted stack traces
     - Resource usage charts (if available)
   - `templates/Admin/JobExecutionLogs/stats.php`
     - Success rate chart (last 30 days)
     - Top 10 failing jobs
     - Average duration by job type
     - Resource usage trends

3. **Add to admin navigation**
   - Update admin menu to include "Job Logs" section
   - Badge showing count of failed jobs today

4. **Create CLI query command**
   - `src/Command/JobLogsCommand.php`
   - Usage: `bin/cake job_logs list --status=error --limit=10`
   - Actions: list, view, cleanup, stats
   - Useful for SSH access and debugging

5. **Add search functionality**
   - Full-text search in output (stdout/stderr)
   - Search by job reference
   - Filter by date range, status, job type

#### Deliverables:
- ✓ Admin UI for browsing and searching job logs
- ✓ Detailed view with full output and context
- ✓ Statistics dashboard
- ✓ CLI command for server-side debugging

---

### Phase 5: Cleanup and Maintenance (Week 5)

#### Tasks:
1. **Create cleanup command**
   - `src/Command/JobLogsCleanupCommand.php`
   - Deletes logs older than configured threshold
   - Options:
     - `--dry-run` - Show what would be deleted
     - `--keep-failures` - Preserve error logs longer
     - `--before=DATE` - Delete before specific date
   - Archives old logs to file (optional)

2. **Schedule automatic cleanup**
   - Add to QueueScheduler admin UI
   - Schedule: Daily at 2 AM
   - Queue task: `JobLogsCleanupTask`

3. **Add log rotation for large outputs**
   - Truncate output longer than `maxOutputLength`
   - Set `output_truncated` flag
   - Store original size in `output_size_bytes`
   - Optionally save full output to file storage

4. **Create maintenance dashboard**
   - Table size monitoring
   - Cleanup status
   - Alert if table grows too large (>1M records)

#### Deliverables:
- ✓ Automatic cleanup prevents unbounded growth
- ✓ Configurable retention policies
- ✓ Large output handling
- ✓ Maintenance monitoring

---

### Phase 6: Monitoring and Alerts (Week 6)

#### Tasks:
1. **Create failure alert system**
   - `src/Mailer/JobFailureMailer.php`
   - Email template for job failures
   - Include: Job name, error message, stack trace, recent history
   - Throttling: Max 1 email per job per hour

2. **Add Slack/webhook integration (optional)**
   - `src/Job/NotificationHandler.php`
   - POST to webhook URL on failures
   - Configurable notification channels

3. **Create health check endpoint**
   - `src/Controller/HealthController.php::jobStatus()`
   - Returns JSON with:
     - Jobs failed in last hour
     - Jobs currently running
     - Queue worker status
     - Scheduler health
   - Use for external monitoring (UptimeRobot, Pingdom, etc.)

4. **Add real-time monitoring**
   - `templates/Admin/JobExecutionLogs/monitor.php`
   - Auto-refreshing page showing running jobs
   - Live tail of job output (if job is running)
   - WebSocket or polling-based updates

#### Deliverables:
- ✓ Automated alerts on job failures
- ✓ Optional webhook integrations
- ✓ Health check API for monitoring tools
- ✓ Real-time monitoring UI

---

## Testing Strategy

### Unit Tests
- `JobExecutionLogsTableTest` - Model methods and associations
- `JobExecutionLoggerTraitTest` - Output capture and logging methods
- `OutputCaptureWrapperTest` - stdout/stderr capture accuracy

### Integration Tests
- `LoggableTaskTest` - Queue task execution with logging
- `LoggableCommandTest` - Command execution with logging
- `SchedulerRunCommandTest` - Scheduler trigger creates logs
- `JobLogsCleanupCommandTest` - Cleanup deletes old records

### Test Fixtures
- Use FixtureFactories pattern (already in use)
- `JobExecutionLogFactory` with states: success, error, running, timeout

### Manual Testing
- Execute Queue task: Verify log created with output
- Execute scheduled command: Verify log created
- Trigger job failure: Verify error captured with stack trace
- Large output job: Verify truncation works
- Cleanup command: Verify old logs deleted

---

## Migration Strategy

### Backward Compatibility
- Existing Queue tasks continue to work without changes
- Logging is opt-in via trait/interface
- No breaking changes to Queue or QueueScheduler tables

### Gradual Rollout
1. Deploy Phase 1-2: Queue task logging only
2. Test with existing tasks
3. Deploy Phase 3: Scheduled command support
4. Deploy Phase 4-6: UI and monitoring

### Data Migration
- No migration needed (new feature)
- Existing `queued_jobs` records not affected
- Future jobs automatically logged

---

## Performance Considerations

### Database Impact
- **Index strategy**: Indexes on `job_type`, `status`, `started`, `job_reference`
- **Query optimization**: Pagination for admin UI, limit to recent records
- **Cleanup**: Automated deletion prevents unbounded growth

### Storage Estimates
- Average log size: ~5-10 KB (with truncated output)
- 1000 jobs/day = ~5-10 MB/day = ~150-300 MB/month
- 3-month retention = ~450-900 MB total

### Output Capture Overhead
- Output buffering: Minimal overhead (<1ms for most jobs)
- Memory impact: Buffered output limited by `maxOutputLength`
- CPU impact: Negligible for text buffering

### Scaling Recommendations
- For high-volume jobs (>10k/day): Consider separate logging database
- For very large outputs: Store in file system, reference path in DB
- For real-time monitoring: Use message queue (Redis) instead of polling

---

## Configuration Reference

### App Configuration (`config/app_custom.php`)

```php
'JobLogging' => [
    // Enable/disable job logging globally
    'enabled' => true,

    // Capture stdout/stderr output
    'captureOutput' => true,

    // Maximum output length before truncation (bytes)
    'maxOutputLength' => 50000,

    // Track memory and CPU usage
    'trackResources' => true,

    // Cleanup logs older than this interval
    'cleanupAfter' => '-3 months',

    // Keep failure logs longer
    'keepFailuresFor' => '-6 months',

    // Send email alerts on failures
    'alertOnFailure' => true,

    // Alert email address
    'alertEmail' => env('ADMIN_EMAIL', 'admin@example.com'),

    // Throttle alerts (seconds between emails per job)
    'alertThrottle' => 3600,

    // Optional: Webhook URL for notifications
    'webhookUrl' => env('JOB_WEBHOOK_URL'),

    // Store large outputs to file system
    'useFi storageForLargeOutputs' => false,
    'outputStoragePath' => LOGS . 'job_outputs' . DS,
],
```

### Cron Configuration

```bash
# Run scheduler every minute (checks for due jobs)
* * * * * cd /var/www/sandbox && bin/cake scheduler_run >> /dev/null 2>&1

# Cleanup old job logs daily at 2 AM
0 2 * * * cd /var/www/sandbox && bin/cake job_logs cleanup >> /dev/null 2>&1
```

---

## Security Considerations

### Output Sanitization
- Redact sensitive data (passwords, API keys) from logs
- Configurable redaction patterns in `JobLoggingConfig`
- Example: Replace `password=xxx` with `password=***`

### Access Control
- Admin UI requires TinyAuth role_id = 1 (admin)
- API endpoints protected by authentication
- Job context data may contain sensitive info - restrict access

### Log Retention
- Comply with data retention policies
- PII in job context should be redacted or excluded
- Option to disable logging for specific sensitive jobs

---

## Future Enhancements

### Phase 7+ (Post-MVP)
- **Retry with backoff**: Exponential backoff for failed jobs
- **Job dependencies**: Define job chains with dependency tracking
- **Distributed tracing**: OpenTelemetry integration
- **Grafana dashboards**: Export metrics for visualization
- **Job comparison**: Compare current run with historical avg
- **Anomaly detection**: Alert on unusual duration or failure rate
- **Job templates**: Create reusable job configurations
- **Approval workflow**: Require approval for sensitive scheduled jobs

---

## Success Metrics

### KPIs to Track
- **Coverage**: % of Queue tasks using LoggableTaskTrait
- **Reliability**: Job success rate over time
- **Performance**: Average job duration by type
- **Debugging efficiency**: Time to diagnose failures (before/after)
- **Storage efficiency**: DB size vs. job volume

### Acceptance Criteria
✓ All Queue tasks have execution logs with output
✓ Scheduled commands automatically logged
✓ Admin UI allows searching last 90 days of logs
✓ Failed jobs trigger email alerts within 5 minutes
✓ Cleanup job prevents unbounded table growth
✓ No performance degradation (job overhead <2%)

---

## Resources Required

### Development Time
- Phase 1 (Infrastructure): 8 hours
- Phase 2 (Queue Integration): 12 hours
- Phase 3 (Scheduler Integration): 10 hours
- Phase 4 (Admin UI): 16 hours
- Phase 5 (Cleanup): 6 hours
- Phase 6 (Monitoring): 8 hours
- **Total**: ~60 hours (~1.5 sprint)

### Dependencies
- Existing Queue plugin: `dereuromark/cakephp-queue`
- Existing QueueScheduler plugin: `dereuromark/cakephp-queue-scheduler`
- No new external dependencies required

### Infrastructure
- Database storage: ~1 GB for 3-month retention (estimated)
- No additional servers required
- Optional: Redis for real-time updates (Phase 6)

---

## Risks and Mitigations

| Risk | Impact | Mitigation |
|------|--------|------------|
| Large output overflow DB | High | Truncate output, store large files separately |
| High-volume jobs slow DB | Medium | Add indexes, partition table, separate DB |
| Missed job failures | High | Multiple notification channels, health checks |
| PII in logs | High | Output redaction, access controls, retention policy |
| Output capture breaks jobs | Medium | Make logging optional, extensive testing |
| Queue plugin updates break integration | Medium | Pin version, add integration tests |

---

## Conclusion

This plan provides a comprehensive, phased approach to implementing job logging and output capture for the CakePHP Sandbox application.

### Key Benefits
✓ **Visibility**: Complete execution history for debugging
✓ **Reliability**: Automated alerts and monitoring
✓ **Performance**: Minimal overhead with smart truncation
✓ **Scalability**: Designed for high-volume jobs
✓ **Maintainability**: Automatic cleanup and retention

### Next Steps
1. Review and approve plan
2. Create GitHub issues for each phase
3. Begin Phase 1 implementation
4. Iterate based on feedback

---

**Document Version**: 1.0
**Created**: 2025-11-08
**Author**: Claude Code
**Status**: Proposal - Awaiting Approval
