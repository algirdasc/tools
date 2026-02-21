<?php

$title = getenv('APP_TITLE') . ' Tools';
$base_url = "https://{$_SERVER['SERVER_NAME']}";
$current_url = "https://{$_SERVER['SERVER_NAME']}{$_SERVER['REQUEST_URI']}";

$mysqli = null;

$tools = [
    'f' => 'formatter',
    'd' => 'diff',
    'h' => 'hashes',
    'm' => 'misc',
];

$js = [
    'formatter' => [
        '//unpkg.com/jsonlint@1.6.3/web/jsonlint.js',
        '/assets/js/addons/selection/active-line.js',
        '/assets/js/addons/selection/mark-selection.js',
        '/assets/js/addons/lint/lint.js',
        '/assets/js/addons/lint/json-lint.js',
        '/assets/js/addons/edit/trailingspace.js',
    ],
    'diff' => [
        '/assets/js/addons/merge/merge.js',
        '/assets/js/diff_match_path.js',
    ],
    'hashes' => [
        '/assets/js/hashing.js',
    ]
];

$formats = [    
    'css' => 'CSS',
    'cpp' => 'C++',
    'htmlmixed' => 'HTML',
    'javascript' => 'JavaScript',
    'json' => 'JSON',
    'php' => 'PHP',
    'python' => 'Python',
    'sql' => 'SQL',
    'twig' => 'Twig',
    'yaml' => 'Yaml',
    'text' => 'Text',
    'd' => 'Table',
    'xml'  => 'XML',
];

$activeTool = $tools[$_GET['tool'] ?? 'f'] ?? $tools['f'];
$activeSnippet = getSnippet($_GET['hash'] ?? '');

function mysql(): mysqli
{
    global $mysqli;

    if ($mysqli === null) {
        $mysqli = new mysqli(getenv('MYSQL_HOST'), getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'), getenv('MYSQL_DATABASE'));

        if ($mysqli->connect_errno) {
            printf("Connect failed: %s\n", $mysqli->connect_error);
            exit();
        }

        $mysqli->set_charset('utf8mb4');
    }

    return $mysqli;
}


function getSnippet(string $hash): ?array
{
    if (!$hash) {
        return null;
    }

    $stmt = mysql()->prepare('SELECT * FROM snippets WHERE hash = ?');
    $stmt->bind_param('s', $hash);
    $stmt->execute();

    $result = $stmt->get_result()->fetch_assoc();
    
    $stmt->close();

    return $result;
}

function snippetHash(string $format, string $snippetLeft, ?string $snippetRight = null): string
{
    $str = "{$format}_{$snippetLeft}";
    if ($snippetRight) {
        $str .= "_{$snippetRight}";
    }

    $crc = rtrim(strtr(base64_encode(crc64($str)), '+/', '-_'), '=');
    
    return $crc;
}

function saveSnippet(string $format, string $snippetLeft, ?string $snippetRight = null, ?string $title = null): ?array
{
    if ($snippetLeft === $snippetRight) {
        $snippetRight = null;
    }

    $dbSafeSnippetLeft = dbSafeSnippet($snippetLeft);
    $dbSafeSnippetRight = $snippetRight ? dbSafeSnippet($snippetRight) : null;
    
    $title = $title ? $title : null;
        
    $hash = snippetHash($format, $snippetLeft, $snippetRight);
    
    $snippet = getSnippet($hash);

    if ($snippet) {
        return $snippet;
    }
    
    $stmt = mysql()->prepare('INSERT IGNORE INTO snippets VALUES (?, ?, ?, ?, ?, NULL)');
    $stmt->bind_param('sssss', $hash, $title, $dbSafeSnippetLeft, $dbSafeSnippetRight, $format);
    $stmt->execute();
    $stmt->close();
        
    return getSnippet($hash);
}

function dbSafeSnippet(string $snippet): string
{
    $snippet = htmlentities($snippet);
    $snippet = gzcompress($snippet, 9);    
    $snippet = base64_encode($snippet);    

    return (string) $snippet;
}

function htmlSafeSnippet(?string $snippet): string
{
    if ($snippet) {
        $snippet = html_entity_decode($snippet);
        $snippet = base64_decode($snippet);
        $snippet = gzuncompress($snippet);
    }
    
    return (string) $snippet;
}

function crc64Table(): array
{
    $crc64tab = [];

    $poly64rev = (0xC96C5795 << 32) | 0xD7870F42;

    for ($i = 0; $i < 256; $i++) {
        for ($part = $i, $bit = 0; $bit < 8; $bit++) {
            if ($part & 1) {
                $part = (($part >> 1) & ~(0x8 << 60)) ^ $poly64rev;
            } else {
                $part = ($part >> 1) & ~(0x8 << 60);
            }
        }

        $crc64tab[$i] = $part;
    }

    return $crc64tab;
}

function crc64(string $string, string $format = '%x'): string
{
    static $crc64tab;

    if ($crc64tab === null) {
        $crc64tab = crc64Table();
    }

    $crc = 0;

    for ($i = 0; $i < strlen($string); $i++) {
        $crc = $crc64tab[($crc ^ ord($string[$i])) & 0xff] ^ (($crc >> 8) & ~(0xff << 56));
    }

    return sprintf($format, $crc);
}

function response(array $data): void
{
    echo json_encode($data);
    exit();
}

function error(string $message): void
{
    header('Content-type: application/json');
    http_response_code(400);
    echo json_encode(['error' => $message]);
    exit();
}