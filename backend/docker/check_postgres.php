<?php
$url = getenv('DATABASE_URL');
if (!empty($url)) {
    $parsed = parse_url($url);
    $host = $parsed['host'] ?? '';
    $port = $parsed['port'] ?? 5432;
    $user = !empty($parsed['user']) ? urldecode($parsed['user']) : '';
    $pass = !empty($parsed['pass']) ? urldecode($parsed['pass']) : '';
    $db   = ltrim(urldecode($parsed['path'] ?? ''), '/');
    parse_str($parsed['query'] ?? '', $query);
    $sslmode = $query['sslmode'] ?? 'require';
    $options = $query['options'] ?? '';

    if (empty($options) && preg_match('/^([a-z0-9-]+)\.([a-z0-9.-]+\.neon\.tech)$/i', $host, $m)) {
        $options = 'endpoint=' . str_replace('-pooler', '', $m[1]);
    }

    $dsn = "pgsql:host={$host};port={$port};dbname={$db};sslmode={$sslmode}";
    if (!empty($options)) {
        $dsn .= ";options='{$options}'";
    }
} else {
    $host = getenv('DB_HOST') ?: '127.0.0.1';
    $port = getenv('DB_PORT') ?: 5432;
    $user = getenv('DB_USERNAME') ?: 'postgres';
    $pass = getenv('DB_PASSWORD') ?: '';
    $db   = getenv('DB_DATABASE') ?: 'postgres';
    $sslmode = getenv('DB_SSLMODE') ?: 'prefer';
    $dsn = "pgsql:host={$host};port={$port};dbname={$db};sslmode={$sslmode}";
}

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_TIMEOUT => 6,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    echo "PostgreSQL connected successfully.\n";
    exit(0);
} catch (\Throwable $e) {
    echo "PostgreSQL connection error: " . $e->getMessage() . "\n";
    exit(1);
}
