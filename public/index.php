<?php
declare(strict_types=1);

require_once '../vendor/autoload.php';

session_start();

require_once '../bootstrap/router.php';


if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_SESSION['_flash'])) {
    unset($_SESSION['_flash']);
}
