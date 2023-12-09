<?php
$cacheTime = 3600; // Default cache time (1 hour)
$cacheDir = $_SERVER['DOCUMENT_ROOT'] . '/splash-usage'; // Fixed cache folder name

function minify_css($content) {
    // Generate a unique cached filename based on the MD5 hash of the original CSS content
    $hashedFilename = md5($content);
    $cachedFile = $cacheDir . '/' . $hashedFilename . '.css';

    // Check if a cached version exists and is still valid
    if (file_exists($cachedFile) && (time() - filemtime($cachedFile)) < $cacheTime && $hashedFilename === md5(file_get_contents($cachedFile))) {
        return file_get_contents($cachedFile);
    }

    // Minify the original CSS
    $minifiedCSS = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $content); // Remove comments
    $minifiedCSS = preg_replace('/\s*([\{\}:;,])\s*/', '$1', $minifiedCSS); // Remove whitespace

    // Save the minified content to the cached file
    file_put_contents($cachedFile, $minifiedCSS);

    // Return the minified content
    return $minifiedCSS;
}

// Usage example (calling minify_css function and echoing the result)
// $thisfile = '/css/offer1.css'; // Specify the CSS file you want to minify
// $minifiedContent = minify_css(file_get_contents($thisfile));
// echo '<style>';
// echo $minifiedContent; // You can echo the result if needed
// echo '</style>';
?>

