<?php

//  escapa texto antes de mostrarlo en HTML
function e($text)
{
    return htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8');
}

// Arma la URL de una ruta. Ejemplo: url('courses/edit', ['id' => 3])
// devuelve /index.php?route=courses/edit&id=3
function url($route, array $params = [])
{
    $url = '/index.php?route=' . $route;

    if (count($params) > 0) {
        $url .= '&' . http_build_query($params);
    }

    return $url;
}

// Redirige a una ruta y detiene el script
function redirect($route, array $params = [])
{
    header('Location: ' . url($route, $params));
    exit;
}