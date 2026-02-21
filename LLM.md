# Tools - Developer Utilities Web Application

## Project Purpose

**Tools** is a developer-focused web application providing simple string/code manipulation utilities. It functions as a pastebin and code tool service with sharing capabilities.

> ⚠️ **Security Notice**: This tool is intended for internal use. Protect it with IP rules or a firewall.

## Technology Stack

| Layer | Technology |
|-------|-------------|
| Backend | PHP 8.x (procedural) |
| Frontend | HTML5, CSS3, JavaScript (ES6+) |
| UI Library | Bootstrap 5 |
| Code Editor | CodeMirror 5 |
| JS Library | Zepto.js (jQuery-compatible) |
| Database | MySQL 8 |
| Containerization | Docker + Docker Compose |

## Directory Structure

```
tools/
├── assets/           # Static assets
│   ├── css/         # Stylesheets, themes
│   ├── js/          # JavaScript, CodeMirror modes
│   └── img/         # Images
├── sql/             # Database schema
├── tools/           # PHP view templates (formatter, diff, hashes, misc)
├── config.php       # Configuration
├── lib.php          # Core library functions
├── index.php        # Main entry point
├── share.php        # Snippet sharing endpoint
├── autoformat.php   # Code formatting endpoint
└── docker-compose.yaml
```

## Main Features

### 1. Formatter (`/f`)
- Code formatting/prettifying for multiple languages (CSS, JavaScript, JSON, PHP, Python, SQL, XML, etc.)
- Auto-format, share snippets, word wrap, JSON cleanup
- Diff view between two snippets
- Line highlighting via URL (e.g., `/f/hash/1-10`)

### 2. Diff (`/d`)
- Side-by-side code comparison using CodeMirror MergeView

### 3. Hashes (`/h`)
- Hash generation: MD5, SHA1, SHA256, SHA512, RIPEMD-160
- Base64 encoding/decoding
- gzinflate/gzuncompress decompression

### 4. Misc (`/m`)
- String length calculator
- Time to seconds converter

## Coding Style

### PHP
- Procedural, function-based (no classes)
- Global functions: `mysql()`, `getSnippet()`, `saveSnippet()`, `snippetHash()`, `dbSafeSnippet()`, `htmlSafeSnippet()`, `crc64()`, `response()`, `error()`
- Mixed HTML/PHP templates
- Simple variable naming (`$mysqli`, `$stmt`, `$hash`, `$snippet`)

### JavaScript
- Vanilla JS with Zepto.js
- Event handling: `$('#button').on('click', function () { ... })`
- CodeMirror API for editor functionality

### Database Schema (snippets table)
- `hash` (VARCHAR 32, PK) - CRC64-based hash
- `title` (VARCHAR 255)
- `snippetLeft` (MEDIUMTEXT) - gzcompressed + base64 encoded
- `snippetRight` (MEDIUMTEXT) - For diffs
- `format` (VARCHAR 255)
- `created_at` (TIMESTAMP)

## Key Files

| File | Purpose |
|------|---------|
| `lib.php` | Database functions, helpers |
| `tools/formatter.php` | Formatter view template |
| `tools/diff.php` | Diff view template |
| `tools/hashes.php` | Hashes view template |
| `tools/misc.php` | Misc utilities view |
| `assets/js/tools/*.js` | Frontend logic |

## Configuration

Environment variables (see `env.example`):
- `APP_TITLE`, `APP_BASE_URL`
- `MYSQL_HOST`, `MYSQL_USER`, `MYSQL_PASSWORD`, `MYSQL_DATABASE`
