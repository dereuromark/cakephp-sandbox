# CakePHP Boost - Project Plan

## Overview
A development tool to enhance AI-assisted coding within CakePHP projects by providing essential context, structure, and introspection capabilities that AI needs to generate high-quality, CakePHP-specific code.

## Target
- **Package Type**: CakePHP Plugin (composer package)
- **Installation**: `composer require dereuromark/cakephp-boost --dev`
- **Compatibility**: CakePHP 5.x only
- **AI Support**: Claude Code, Cursor, VS Code, PhpStorm

---

## Critical Key Functionality

### 1. Documentation API with Semantic Search

**Priority: CRITICAL - #1 PRIORITY**

This is the core value proposition - providing AI with instant access to CakePHP knowledge.

**CakePHP-Specific Knowledge Base:**
- **CakePHP 5.x API documentation** - All classes, methods, properties with full context
- **CakePHP Book content** - Complete cookbook, guides, tutorials
- **Plugin documentation** - Popular plugins (Tools, Shim, Authentication, Authorization, Migrations, Bake)
- **Migration guides** - Upgrade paths, deprecations, new features
- **Common patterns** - Real-world examples, best practices
- **Anti-patterns** - What to avoid and why

**Semantic Search Features:**
- Embeddings-based search for context-aware results
- Natural language queries: "How do I add a belongsToMany association?"
- Code example search: "Show me a controller test with authentication"
- Convention lookup: "What's the table name for ArticleCategories?"
- Error message explanations: "What does 'Unknown column' mean in CakePHP?"
- Pattern matching: "Find examples of custom finders"

**Implementation:**
- Parse CakePHP API docs (PHPDoc + source code)
- Extract and index CakePHP Book (Sphinx/RST content)
- Generate embeddings using OpenAI API or local models
- Store in SQLite or vector database
- Provide fast semantic search via console command or MCP tool
- Cache results for performance
- Update index via `bin/cake boost index` command

**Why This Matters:**
AI assistants like Claude Code need **context** to generate correct code. Without access to CakePHP-specific documentation, they might:
- Use Laravel patterns instead of CakePHP conventions
- Generate deprecated code
- Miss important security considerations
- Not follow CakePHP coding standards

With searchable docs, the AI can instantly find "How does CakePHP handle database transactions?" or "What's the correct way to validate email fields in CakePHP 5?"

---

### 2. MCP Server with CakePHP-Specific Tools

**Priority: MEDIUM**

**Note:** Many of these features already exist via CakePHP console commands (`bin/cake routes`, `bin/cake schema_cache`, etc.). The MCP server provides:
1. **Structured, parseable output** for AI consumption (not human-readable text)
2. **Filtering and context** - e.g., "show routes for Admin prefix" or "tables with created column"
3. **Combined queries** - e.g., "show route + controller code + related tests"
4. **Real-time introspection** - current application state, not static analysis

**Tools to Provide:**

- **Database Schema Tool** (supplements `bin/cake schema_cache`)
  - Returns JSON with tables, associations, validation rules
  - AI can ask: "What fields does the users table have?"
  - Includes behavior info, custom finders, scopes

- **Configuration Tool** (supplements `Configure::read()`)
  - Safe access to config values (sanitized secrets)
  - AI can check: "What cache engine is configured?"

- **Error Log Tool**
  - Parse recent errors with full context
  - AI can debug: "What errors happened in the last hour?"

- **Application State Tool**
  - Show loaded plugins, middleware, components
  - AI can verify: "Is DebugKit loaded?"

**Why Not Just Use Console Commands?**
- Console commands output human-readable text, not structured data
- MCP provides programmatic access with filtering/searching
- AI can combine multiple queries efficiently
- But yes, this is **lower priority** than documentation!

---

### 3. AI Guidelines & Best Practices

**Priority: HIGH**

Composable guidelines for CakePHP ecosystem:

**Core Framework Guidelines:**
- CakePHP 5.x conventions and patterns
- Database conventions (table naming, foreign keys, associations)
- Controller/Model/View patterns
- Component/Behavior/Helper usage
- Request/Response handling
- Middleware patterns
- Authentication/Authorization patterns
- Form creation and validation
- Query builder patterns

**Popular Plugin Guidelines:**
- **dereuromark/cakephp-tools** - Common helpers and utilities
- **dereuromark/cakephp-shim** - Useful shimming functionality
- **cakephp/authentication** - Official auth plugin
- **cakephp/authorization** - Official authorization
- **cakephp/migrations** - Database migrations
- **cakephp/bake** - Code generation

**Testing Guidelines:**
- PHPUnit integration test patterns
- Fixture factories usage (dereuromark/cakephp-test-helper)
- Controller test conventions
- Model test patterns
- Mocking and stubbing

**Code Quality Guidelines:**
- PHPStan level 8 patterns
- IdeHelper annotation patterns
- PSR-2R coding standards

---

### 4. Application Introspection

**Priority: HIGH**

**Database Introspection:**
- Execute queries for debugging
- Show slow query log
- Display connection status
- Migration status check

**Error Log Access:**
- Read CakePHP error logs
- Parse and categorize errors
- Show recent errors with context
- Filter by severity/date

**Environment Variables:**
- Display .env variables (sanitized)
- Show Configure::read() values
- Database connection info
- Debug mode status

**Application State:**
- Show loaded plugins
- Display middleware stack
- List components/behaviors in use
- Cache engine status
- Session configuration

**Model/Table Introspection:**
- List all table classes
- Show table behaviors and associations
- Display validation rules
- Show finder methods

**Controller Analysis:**
- List all controllers and actions
- Show components loaded
- Display middleware per route
- Authorization rules (ACL)

---

### 5. Claude Code Integration (.claude directory)

**Priority: MEDIUM**

**Auto-Generated Context Files:**

`/.claude/boost_context.md` - Automatically generated with:
- Application overview
- Database schema summary
- Route summary
- Key configuration values
- Installed plugins list
- Common patterns used in the app

**Command Integration:**
- `/boost-schema` - Show database schema
- `/boost-routes` - List all routes
- `/boost-config [key]` - Show configuration
- `/boost-errors` - Recent error log
- `/boost-table [name]` - Table class details

---

### 6. Code Generation Assistance

**Priority: MEDIUM**

**Smart Bake Templates:**
- Context-aware templates based on project patterns
- Automatically detect and use:
  - Existing component patterns
  - Authorization setup (TinyAuth, AuthComponent)
  - Form helper usage patterns
  - Test setup patterns

**Code Snippet Library:**
- Common CakePHP patterns
- Authentication setup
- Authorization rules
- Query examples
- Form creation
- Test scaffolds


---

## Technical Architecture

### Package Structure
```
cakephp-boost/
├── src/
│   ├── Command/
│   │   ├── BoostContextCommand.php       # Generate context files
│   │   ├── BoostSchemaCommand.php        # Schema introspection
│   │   └── BoostIndexCommand.php         # Index documentation
│   ├── Shell/Helper/
│   │   └── BoostHelper.php               # CLI output helper
│   ├── Introspection/
│   │   ├── SchemaInspector.php
│   │   ├── RouteInspector.php
│   │   ├── ConfigInspector.php
│   │   ├── ErrorLogReader.php
│   │   └── TableInspector.php
│   ├── Mcp/
│   │   ├── McpServer.php                 # MCP server implementation
│   │   └── Tools/                        # Individual MCP tools
│   ├── Documentation/
│   │   ├── DocumentationIndexer.php
│   │   ├── SemanticSearch.php
│   │   └── EmbeddingGenerator.php
│   └── Guidelines/
│       ├── GuidelineLoader.php
│       └── guidelines/                   # Markdown guidelines
├── config/
│   ├── boost.php                         # Plugin configuration
│   └── guidelines.php                    # Guideline mappings
├── guidelines/
│   ├── cakephp-5.md
│   ├── cakephp-4.md
│   ├── authentication.md
│   ├── authorization.md
│   ├── testing.md
│   └── plugins/
│       ├── tools.md
│       ├── tinyauth.md
│       └── queue.md
└── .claude/
    └── commands/
        ├── boost-schema.md
        ├── boost-routes.md
        └── boost-config.md
```

### MCP Server Implementation
- Node.js server (TypeScript) or PHP-based
- WebSocket/HTTP communication
- Tool registration and discovery
- Request/response handling
- Error handling and logging

### Console Commands
```bash
# Generate .claude context files
bin/cake boost context

# Show database schema
bin/cake boost schema [table]

# List routes
bin/cake boost routes [filter]

# Index documentation
bin/cake boost index

# Show configuration
bin/cake boost config [key]

# Analyze application
bin/cake boost analyze
```

---

## Implementation Phases

### Phase 1: Documentation API (MVP) - **PRIORITY #1**
**Timeline: 3-4 weeks**

- [ ] Basic plugin structure
- [ ] Parse CakePHP 5.x API documentation
- [ ] Extract CakePHP Book content
- [ ] Create documentation index (SQLite)
- [ ] Implement basic search (keyword-based)
- [ ] Console command: `bin/cake boost search "query"`
- [ ] Test with common queries
- [ ] Documentation and examples

### Phase 2: Semantic Search
**Timeline: 2-3 weeks**

- [ ] Generate embeddings for all docs
- [ ] Implement vector similarity search
- [ ] Add OpenAI API integration (optional)
- [ ] Add local embedding support (fallback)
- [ ] Improve search relevance
- [ ] Add context-aware results
- [ ] Performance optimization

### Phase 3: Guidelines & .claude Integration
**Timeline: 2 weeks**

- [ ] Write CakePHP 5.x guidelines (markdown)
- [ ] Popular plugin guidelines
- [ ] Testing guidelines
- [ ] Code quality guidelines
- [ ] Auto-generate .claude/boost_context.md
- [ ] Create custom slash commands
- [ ] Documentation

### Phase 4: MCP Server (Optional)
**Timeline: 3-4 weeks**

- [ ] MCP server implementation
- [ ] Documentation search tool
- [ ] Database schema tool
- [ ] Configuration tool
- [ ] Error log tool
- [ ] Testing and documentation

### Phase 5: Advanced Features
**Timeline: 2-3 weeks**

- [ ] Code generation templates
- [ ] Custom guideline support
- [ ] Plugin documentation indexing
- [ ] Comprehensive testing
- [ ] Performance optimization

---

## Success Metrics

1. **Adoption**: 500+ installations in first 6 months
2. **AI Code Quality**: Measurable reduction in CakePHP convention errors
3. **Developer Productivity**: Faster code generation with AI
4. **Community Feedback**: Positive reviews and contributions
5. **Documentation Coverage**: 90%+ of common CakePHP patterns covered

---

## Open Questions

1. **Documentation Source**: Parse from official repo or use existing API? (Recommendation: Parse from cakephp/docs repo)
2. **Embeddings**: Use external API (OpenAI) or local models? (Recommendation: Support both, OpenAI optional)
3. **Index Storage**: SQLite, JSON files, or vector DB? (Recommendation: Start with SQLite for simplicity)
4. **License**: MIT or custom? (Recommendation: MIT)
5. **Maintenance**: Who will maintain long-term? (Recommendation: Community-driven)
6. **Update Frequency**: How often to update docs index? (Recommendation: On major CakePHP releases + manual `boost index` command)

---

## Dependencies

### Required
- `cakephp/cakephp: ^5.0`
- `cakephp/plugin-installer: ^2.0`

### Optional
- Vector search library (for semantic search)
- OpenAI PHP client (for embeddings)
- Symfony process component (for command execution)

### Development
- `cakephp/bake: ^3.0`
- `phpunit/phpunit: ^10.0`
- `phpstan/phpstan: ^1.10`

---

## Next Steps

1. **Community Validation**: Share plan with CakePHP community
2. **Repository Setup**: Create GitHub repository
3. **Phase 1 Implementation**: Start with core introspection
4. **Documentation**: Write comprehensive docs
5. **Testing**: Ensure high test coverage
6. **Beta Release**: Release to early adopters
7. **Feedback Loop**: Iterate based on feedback
8. **Stable Release**: v1.0.0 release

---

## Resources

- **Laravel Boost**: https://github.com/laravel/boost (inspiration)
- **MCP Specification**: https://modelcontextprotocol.io/
- **CakePHP Documentation**: https://book.cakephp.org/
- **Claude Code**: https://docs.claude.com/claude-code
