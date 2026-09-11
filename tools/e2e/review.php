<?php
/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
declare(strict_types=1);

$base = $argv[1] ?? 'http://localhost:8080';
$resp = http_get($base.'/compliance/report/daily');
$ok = ($resp['code'] ?? 0) === 200;

echo "STATUS: ".json_encode($resp['json'] ?? [], JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE).PHP_EOL;

exit($ok ? 0 : 1);

function http_get(string $url): array {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 5,
    ]);
    $out = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return ['code' => $code, 'json' => json_decode($out ?? '[]', true), 'body' => $out];
}
