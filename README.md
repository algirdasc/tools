# Tools

A small set of developer tools for simple string/code manipulation.

**This tool is intended for internal use. It may contain unsanitized input or vulnerabilities—protect it with IP rules or a firewall, and use it at your own risk.**

## Features

- **Formatter (`/f`)** — code formatting/prettifying with snippet sharing
- **Diff (`/d`)** — side-by-side code comparison
- **Hashes (`/h`)** — hashing, Base64, gzinflate/gzuncompress helpers
- **Misc (`/m`)** — string length, time-to-seconds calculators
- **Secrets (`/s`)** — end-to-end encrypted secret sharing
- **Password generator (`/p`)** — random passwords & diceware-style passphrases, generated in the browser (Web Crypto) with optional homoglyph exclusion; settings persist locally

### Secret sharing

Secrets are encrypted in the browser with AES-256-GCM (Web Crypto API). The server only ever stores ciphertext — the encryption key lives solely in the URL fragment (`/s/{hash}#key`), which browsers never send to the server.

Secrets are **fragile by design**:

- Default: **burns after a single view**, expires after **4 hours** (configurable up to 10 views / 7 days)
- Burned or expired secrets are deleted immediately and are unrecoverable
- Anyone with the full link can read the secret — share links over a trusted channel
- Losing the `#fragment` means the secret can never be decrypted

## Installation

1. Rename [`env.example`](./env.example) to `.env`.
2. Edit `.env` to match your environment.
3. Start the stack:

```sh
docker compose up -d
```

4. Run the database migration script (CLI only):

```sh
php update.php
```

## Tests

An integration test suite (`tests/`) covers lib functions and every HTTP endpoint against a real MySQL instance, including the secrets burn/expiry lifecycle and the audit regression cases (decompression bombs, XXE, XSS round-trips, path traversal).

Run it against the dev stack:

```sh
docker compose up -d
docker compose exec tools php tests/run.php
```

It also runs in CI on every push and pull request.
