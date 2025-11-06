<?php
$base = 'http://127.0.0.1:8000';
$loginUrl = $base . '/login';

// GET /login
$ch = curl_init($loginUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
$response = curl_exec($ch);
if ($response === false) {
    echo "GET ERROR: " . curl_error($ch) . PHP_EOL;
    exit(1);
}
$headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$headers = substr($response, 0, $headerSize);
$body = substr($response, $headerSize);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Extract cookies from Set-Cookie headers
$cookies = [];
if (preg_match_all('/Set-Cookie:\s*([^;\r\n]+)/i', $headers, $cmatches)) {
    $cookies = $cmatches[1];
}
$cookieHeader = implode('; ', $cookies);

// Extract CSRF token from HTML
if (!preg_match('/name="_token"\s+value="([^"]+)"/', $body, $m)) {
    echo "NO_CSRF_TOKEN_FOUND\n";
    exit(2);
}
$token = $m[1];

// Prepare POST data
$post = [
    '_token' => $token,
    'email' => 'test@example.com',
    'password' => 'password123',
];

// POST /login
$ch2 = curl_init($loginUrl);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch2, CURLOPT_HEADER, true);
curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, false);
curl_setopt($ch2, CURLOPT_POST, true);
curl_setopt($ch2, CURLOPT_POSTFIELDS, http_build_query($post));
if (!empty($cookieHeader)) {
    curl_setopt($ch2, CURLOPT_HTTPHEADER, ['Cookie: ' . $cookieHeader]);
}
$response2 = curl_exec($ch2);
if ($response2 === false) {
    echo "POST ERROR: " . curl_error($ch2) . PHP_EOL;
    exit(3);
}
$headerSize2 = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
$headers2 = substr($response2, 0, $headerSize2);
$body2 = substr($response2, $headerSize2);
$code2 = curl_getinfo($ch2, CURLINFO_HTTP_CODE);

// Extract Set-Cookie from response
$cookies2 = [];
if (preg_match_all('/Set-Cookie:\s*([^;\r\n]+)/i', $headers2, $cmatches2)) {
    $cookies2 = $cmatches2[1];
}

// Extract Location header if present
$location = null;
if (preg_match('/Location:\s*(.*)/i', $headers2, $lm)) {
    $location = trim($lm[1]);
}

echo "POST_STATUS:" . $code2 . PHP_EOL;
if ($location) echo "LOCATION:" . $location . PHP_EOL;

echo "---COOKIES_AFTER---" . PHP_EOL;
foreach ($cookies2 as $c) echo $c . PHP_EOL;

echo "---HEADERS_AFTER---" . PHP_EOL;
echo $headers2 . PHP_EOL;

curl_close($ch);
curl_close($ch2);
