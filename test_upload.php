<?php
/**
 * Test script untuk cek upload functionality
 * Akses via browser: http://localhost:8000/test_upload.php
 */

// Check if images directory exists and is writable
$imagesDir = __DIR__ . '/public/images';

echo "<h2>Upload System Test</h2>";

// Test 1: Directory exists
if (file_exists($imagesDir)) {
    echo "✅ Directory public/images EXISTS<br>";
} else {
    echo "❌ Directory public/images NOT FOUND<br>";
}

// Test 2: Directory is writable
if (is_writable($imagesDir)) {
    echo "✅ Directory public/images is WRITABLE<br>";
} else {
    echo "❌ Directory public/images is NOT WRITABLE<br>";
}

// Test 3: Test create a file
$testFile = $imagesDir . '/test_' . time() . '.txt';
if (file_put_contents($testFile, 'test')) {
    echo "✅ Can CREATE files in public/images<br>";
    unlink($testFile); // Delete test file
} else {
    echo "❌ Cannot CREATE files in public/images<br>";
}

// Test 4: Check PHP upload settings
echo "<br><h3>PHP Upload Settings:</h3>";
echo "upload_max_filesize: " . ini_get('upload_max_filesize') . "<br>";
echo "post_max_size: " . ini_get('post_max_size') . "<br>";
echo "max_file_uploads: " . ini_get('max_file_uploads') . "<br>";

// Test 5: Simple upload form
?>
<br>
<h3>Test Upload Form:</h3>
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="test_image" accept="image/*"><br><br>
    <button type="submit" name="test_submit">Upload Test Image</button>
</form>

<?php
if (isset($_POST['test_submit'])) {
    if (isset($_FILES['test_image']) && $_FILES['test_image']['error'] === 0) {
        $uploadedFile = $_FILES['test_image'];
        $fileName = time() . '_test_' . basename($uploadedFile['name']);
        $destination = $imagesDir . '/' . $fileName;
        
        if (move_uploaded_file($uploadedFile['tmp_name'], $destination)) {
            echo "<br>✅ <strong>SUCCESS!</strong> File uploaded: " . $fileName . "<br>";
            echo "<img src='/images/" . $fileName . "' style='max-width: 200px;'><br>";
        } else {
            echo "<br>❌ <strong>FAILED</strong> to move uploaded file<br>";
        }
    } else {
        echo "<br>⚠️ No file uploaded or upload error<br>";
        if (isset($_FILES['test_image'])) {
            echo "Error code: " . $_FILES['test_image']['error'] . "<br>";
        }
    }
}
?>
