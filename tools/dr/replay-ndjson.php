<?php
/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
declare(strict_types=1);

$files = array_slice($argv, 1);
if (!$files) {
    fwrite(STDERR, "usage: php replay-ndjson.php <file1> [file2..]\n");
    exit(1);
}

$endpoint = getenv('COMPLIANCE_DECIDE_URL') ?: 'http://localhost:8080/compliance/restore';

foreach ($files as $file) {
    $h = fopen($file, 'r');
    if (!$h) {
        continue;
    }
    while (($line = fgets($h)) !== false) {
        $data = json_decode($line, true);
        if (!is_array($data)) {
            continue;
        }
        $ch = curl_init($endpoint);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => json_encode($data, JSON_UNESCAPED_UNICODE),
        ]);
        curl_exec($ch);
        curl_close($ch);
    }
    fclose($h);
}
