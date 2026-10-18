<?php
require_once __DIR__ . '/../utils/auth.php';

logoutUser();

header('Location: /index.php?success=logged_out');
