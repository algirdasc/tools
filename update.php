<?php

require_once 'constants.php';

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
