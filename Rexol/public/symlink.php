<?php
$target = '../storage/app/public';
$shortcut = 'storage';
if (file_exists($shortcut)) {
    echo "Symlink already exists!";
} else {
    symlink($target, $shortcut);
    echo "Symlink created successfully!";
}
