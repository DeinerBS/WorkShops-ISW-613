<?php

const PROFILE_PICTURES_DIR = __DIR__ . '/../uploads/profile_pictures';
const PROFILE_PICTURES_URL = '/uploads/profile_pictures';
const PROFILE_PICTURE_MAX_BYTES = 2 * 1024 * 1024;

// The extension is picked from the detected content type, never from the client's file name
const PROFILE_PICTURE_TYPES = [
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
    'image/gif' => 'gif',
    'image/webp' => 'webp',
];

/**
 * Validates an uploaded picture and moves it into the uploads folder
 * @param array $file The $_FILES entry of the upload
 * @return array ['filename' => string] on success, or ['error' => string] with a messages.php error code
 */
function storeProfilePicture(array $file)
{
    if (!isset($file['error']) || is_array($file['error'])) {
        return ['error' => 'invalid_picture'];
    }

    if ($file['error'] === UPLOAD_ERR_INI_SIZE || $file['error'] === UPLOAD_ERR_FORM_SIZE) {
        return ['error' => 'picture_too_large'];
    }

    if ($file['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($file['tmp_name'])) {
        return ['error' => 'upload_failed'];
    }

    if ($file['size'] > PROFILE_PICTURE_MAX_BYTES) {
        return ['error' => 'picture_too_large'];
    }

    // Check the real content, the browser-provided type can be spoofed
    $mimeType = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
    if (!isset(PROFILE_PICTURE_TYPES[$mimeType]) || getimagesize($file['tmp_name']) === false) {
        return ['error' => 'invalid_picture'];
    }

    $filename = bin2hex(random_bytes(16)) . '.' . PROFILE_PICTURE_TYPES[$mimeType];

    if (!move_uploaded_file($file['tmp_name'], PROFILE_PICTURES_DIR . '/' . $filename)) {
        error_log('Profile picture upload error: could not move the file to ' . PROFILE_PICTURES_DIR);
        return ['error' => 'upload_failed'];
    }

    return ['filename' => $filename];
}

function deleteProfilePicture($filename)
{
    // basename() keeps the delete inside the uploads folder
    $path = PROFILE_PICTURES_DIR . '/' . basename((string) $filename);
    if ($filename !== null && $filename !== '' && is_file($path)) {
        unlink($path);
    }
}

function profilePictureUrl($filename)
{
    return PROFILE_PICTURES_URL . '/' . rawurlencode(basename($filename));
}
