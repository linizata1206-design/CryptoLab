<?php

// Folder yang boleh ditulis di Vercel hanya /tmp
foreach (['/tmp/views', '/tmp/storage/framework/cache', '/tmp/storage/framework/sessions'] as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
}

require __DIR__ . '/../public/index.php';