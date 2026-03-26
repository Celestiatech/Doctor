<?php
/**
 * ClinicMaster - Health & Medical Bootstrap Template
 * Main Router/Index File
 */

// Include slug generator functions
require_once(__DIR__ . '/generate_slug.php');

// Get the requested page
$page = isset($_GET['page']) ? getSafePage($_GET['page']) : 'medical/index';

// Define base path for static files
$basePath = __DIR__ . '/xhtml/';
$requestedFile = $basePath . $page . '.html';

// Security: Prevent directory traversal
if (strpos(realpath($requestedFile), realpath($basePath)) !== 0) {
    header("HTTP/1.0 403 Forbidden");
    exit('Access Denied');
}

// Check if the file exists
if (!file_exists($requestedFile) || is_dir($requestedFile)) {
    header("HTTP/1.0 404 Not Found");
    include($basePath . 'medical/error-404.html');
    exit();
}

// Set proper headers
header('Content-Type: text/html; charset=utf-8');
header('Cache-Control: public, max-age=3600');

// Include the requested HTML file
include($requestedFile);
?>
