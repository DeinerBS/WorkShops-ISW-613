<?php

const MESSAGES = [
    'error' => [
        'invalid_input' => 'Please fill in all the required fields correctly.',
        'invalid_credentials' => 'Invalid username or password.',
        'login_required' => 'You must log in to access that page.',
        'session_expired' => 'Your session expired. Please log in again.',
        'password_too_short' => 'The password must be at least 8 characters long.',
        'password_mismatch' => 'The passwords do not match.',
        'invalid_province' => 'Please select a valid province.',
        'username_taken' => 'That username is already taken.',
        'wrong_password' => 'The current password is incorrect.',
        'invalid_picture' => 'The profile picture must be a JPG, PNG, GIF or WEBP image.',
        'picture_too_large' => 'The profile picture must be 2 MB or smaller.',
        'upload_failed' => 'The profile picture could not be uploaded. Please try again.',
        'server_error' => 'Something went wrong. Please try again later.',
    ],
    'success' => [
        'registered' => 'Your account was created. You can now log in.',
        'logged_out' => 'You have been logged out.',
        'updated' => 'Your profile was updated.',
    ],
];

// Renders a Bootstrap alert for a known ?error= or ?success= code in the query string
function renderAlert()
{
    foreach (['error' => 'danger', 'success' => 'success'] as $type => $style) {
        $code = $_GET[$type] ?? null;
        if (is_string($code) && isset(MESSAGES[$type][$code])) {
            echo '<div class="alert alert-' . $style . '" role="alert">' . htmlspecialchars(MESSAGES[$type][$code]) . '</div>';
        }
    }
}
