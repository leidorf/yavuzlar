<?php
try {
    $pdo = new PDO('sqlite:' . __DIR__ . '/../db/quest-app.db');

    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (\Throwable $th) {
    echo "Hata: " . $th;
}
