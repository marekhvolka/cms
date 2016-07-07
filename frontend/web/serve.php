<?php
$path = './' . $_SERVER['REQUEST_URI'] . '.php';

if (is_file($path)) {
    include $path;
} else {
    include 'index.php';
}
