<?php

/**
 * Password generator is client-side, so we test what we can from PHP:
 * the /p route renders the tool markup, the JS asset ships, and the CSP
 * allows the wordlist fetch origin.
 */

require(__DIR__ . '/bootstrap.php');

// Render the page for tool=p via the runner (index.php needs web context).
$r = http_subprocess('index.php', [], ['tool' => 'p']);

eq('/p renders 200', 200, $r['status']);

$must = [
    'function-gen-password',
    'function-gen-passphrase',
    'pw-length',
    'pw-homoglyphs',
    'pp-separator',
    'pp-count',
    'pp-maxlen',
    'function-save-settings',
];
foreach ($must as $id) {
    check("page contains #$id", strpos($r['raw'], $id) !== false);
}

// CSP must permit fetching the EFF wordlist (connect-src). index.php sends
// the header; assert it mentions eff.org directly in source.
$indexSrc = file_get_contents(__DIR__ . '/../index.php');
check('CSP allows eff.org', strpos($indexSrc, 'https://www.eff.org') !== false);

// The JS asset and view file must ship.
check('password.js exists', file_exists(__DIR__ . '/../assets/js/tools/password.js'));
check('password.php view exists', file_exists(__DIR__ . '/../tools/password.php'));

// And the tool is registered.
require(__DIR__ . '/../config.php');
eq('tool registered', 'password', $tools['p'] ?? null);
