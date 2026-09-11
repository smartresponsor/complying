<?php
/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
declare(strict_types=1);

$endpoint = $argv[1] ?? 'http://localhost:8080/compliance/status';
$iterations = (int)($argv[2] ?? 30);
$p95_max_ms = (int)($argv[3] ?? 700);
$error_max = (float)($argv[4] ?? 0.5);

$times = [];
$errors = 0;

for ($i = 0; $i < $iterations; $i++) {
    $start = microtime(true);
    $ch = curl_init($endpoint);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 3,
    ]);
    $res = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err = curl_error($ch);
    curl_close($ch);
    $latency = (microtime(true) - $start) * 1000;
    $times[] = $latency;
    if ($code !== 200) {
        $errors++;
    } else {
        $json = json_decode($res ?? '', true);
        if (is_array($json) && (($json['status'] ?? '') !== 'ok')) {
            $errors++;
        }
    }
    usleep(50000);
}

sort($times);
$idx = (int)floor(0.95 * count($times)) - 1;
if ($idx < 0) {
    $idx = 0;
}
$p95 = $times[$idx];
$error_rate = ($errors / $iterations) * 100.0;

echo "p95_ms={$p95}\n";
echo "error_rate_percent={$error_rate}\n";

$failed = false;
if ($p95 > $p95_max_ms) {
    echo "SLO FAIL: p95 {$p95}ms > {$p95_max_ms}ms\n";
    $failed = true;
}
if ($error_rate > $error_max) {
    echo "SLO FAIL: errors {$error_rate}% > {$error_max}%\n";
    $failed = true;
}

exit($failed ? 1 : 0);
