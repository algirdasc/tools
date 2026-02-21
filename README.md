# Tools

A small set of developer tools for simple string/code manipulation.

**This tool is intended for internal use. It may contain unsanitized input or vulnerabilities—protect it with IP rules or a firewall, and use it at your own risk.**

## Installation

1. Rename [`env.example`](./env.example) to `.env`.
2. Edit `.env` to match your environment.
3. Start the stack:

```sh
docker compose up -d
```

4. Run the database migration script:

- CLI (recommended):

```sh
php update.php
```

- Web (only if you allow it): `https://your-url/update.php`
