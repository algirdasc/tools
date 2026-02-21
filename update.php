<?php

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit('Forbidden');
}

require_once 'config.php';
require_once 'lib.php';

$migrationFiles = [
    'snippets' => __DIR__ . '/sql/snippets.sql',
];

$mysql = mysql();

foreach ($migrationFiles as $table => $script) {
    if (!file_exists($script)) {
        continue;
    }

    try {
        $mysql->query("DESCRIBE `$table`");
    } catch (Exception $exception) {
        if ($exception->getCode() !== 1146) {
            throw $exception;
        }

        $mysql->multi_query(file_get_contents($script));
    }

    @unlink($script);
}
