<?php
if (!defined('APP_ROOT')) {
    define('APP_ROOT', __DIR__);
}

if (!defined('APP_URL')) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $scriptDir = dirname($_SERVER['SCRIPT_NAME'] ?? '/');
    $basePath = $scriptDir !== '/' ? rtrim($scriptDir, '/') : '';
    define('APP_URL', $protocol . '://' . $host . $basePath);
}

if (!function_exists('asset_url')) {
    function asset_url(string $path): string {
        return APP_URL . '/' . ltrim($path, '/');
    }
}

if (!function_exists('site_url')) {
    function site_url(string $path = ''): string {
        $path = ltrim($path, '/');
        return $path === '' ? APP_URL : APP_URL . '/' . $path;
    }
}

// Configurações do Dono do Site & API Resend
define('RESEND_API_KEY', 're_gyaHaSw1_PMF5gJkM9KLzkps6vZchHYxg'); // Cole sua chave do Resend aqui
define('DONO_EMAIL', 'rafadrummer1@gmail.com'); // E-mail cadastrado na conta Resend
?>