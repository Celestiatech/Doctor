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
$resolvedBasePath = realpath($basePath);
$resolvedRequestedFile = realpath($requestedFile);

// Security: Prevent directory traversal
if ($resolvedRequestedFile !== false && strpos($resolvedRequestedFile, $resolvedBasePath) !== 0) {
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

// Get the directory of the requested file to calculate correct base path
$fileDir = dirname($requestedFile);
$baseDirFromXhtml = str_replace($basePath, '', $fileDir);
$scriptPath = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
$scriptDir = rtrim(str_replace('/index.php', '', $scriptPath), '/');
$baseUrl = $scriptDir . '/xhtml/' . ($baseDirFromXhtml ? $baseDirFromXhtml . '/' : '');

// Read and process the HTML file
$htmlContent = file_get_contents($requestedFile);

// Inject base tag at the start of <head> so browsers resolve later asset URLs correctly.
$baseTag = '<base href="' . $baseUrl . '">';
if (stripos($htmlContent, '<head>') !== false) {
    $htmlContent = preg_replace('/<head>/i', "<head>\n" . $baseTag, $htmlContent, 1);
} else {
    $htmlContent = str_replace('</head>', $baseTag . "\n</head>", $htmlContent);
}

// Output the processed HTML
echo $htmlContent;
?>
