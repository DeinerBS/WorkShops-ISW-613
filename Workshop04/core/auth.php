<?php

const SESSION_TIMEOUT_SECONDS = 30 * 60;

const REMEMBER_COOKIE = 'remembered_username';

function startSession()
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
}


function loginUser(array $user)
{
    startSession();
  
    session_regenerate_id(true);

    $_SESSION['user_id'] = (int) $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['province_id'] = $user['province_id'] !== null ? (int) $user['province_id'] : null;
    $_SESSION['province_name'] = $user['province_name'];
    $_SESSION['profile_picture'] = $user['profile_picture'];
    $_SESSION['last_activity'] = time();
}

function logoutUser()
{
    startSession();
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 3600, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }

    session_destroy();
}

// Redirige al login
function requireLogin()
{
    startSession();

    if (!isset($_SESSION['user_id'])) {
        redirect('auth/login', ['error' => 'login_required']);
    }

    if (time() - ($_SESSION['last_activity'] ?? 0) > SESSION_TIMEOUT_SECONDS) {
        logoutUser();
        redirect('auth/login', ['error' => 'session_expired']);
    }

    $_SESSION['last_activity'] = time();
}

function rememberUsername($username)
{
    setcookie(REMEMBER_COOKIE, $username, [
        'expires' => time() + 60 * 60 * 24 * 30,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
}

function forgetUsername()
{
    setcookie(REMEMBER_COOKIE, '', [
        'expires' => time() - 3600,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
}