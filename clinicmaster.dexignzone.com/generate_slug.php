<?php
/**
 * Generate URL-friendly slug from string
 */
function generateSlug($string) {
    // Convert to lowercase
    $slug = strtolower($string);
    
    // Replace spaces with hyphens
    $slug = str_replace(' ', '-', $slug);
    
    // Remove special characters
    $slug = preg_replace('/[^a-z0-9-]/', '', $slug);
    
    // Replace multiple hyphens with single hyphen
    $slug = preg_replace('/-+/', '-', $slug);
    
    // Remove leading and trailing hyphens
    $slug = trim($slug, '-');
    
    return $slug;
}

/**
 * Convert slug back to readable title
 */
function slugToTitle($slug) {
    $title = str_replace('-', ' ', $slug);
    return ucfirst($title);
}

/**
 * Check if page exists
 */
function pageExists($page, $basePath = 'xhtml/') {
    $filePath = $basePath . $page . '.html';
    return file_exists($filePath);
}

/**
 * Get safe page name
 */
function getSafePage($page) {
    // Remove any dangerous characters
    $page = preg_replace('/[^a-z0-9-]/', '', strtolower($page));
    // Prevent directory traversal
    $page = str_replace('..', '', $page);
    return $page;
}

/**
 * Redirect with proper status code
 */
function redirect($url, $statusCode = 303) {
    header("Location: $url", true, $statusCode);
    exit();
}

/**
 * Get current page
 */
function getCurrentPage() {
    $page = isset($_GET['page']) ? $_GET['page'] : 'index';
    return getSafePage($page);
}
?>
