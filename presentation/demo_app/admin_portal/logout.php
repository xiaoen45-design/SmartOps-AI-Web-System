<?php
require_once __DIR__ . '/admin_auth.php';
unset($_SESSION['admin_email'], $_SESSION['admin_name']);
redirect_to('login.php');
