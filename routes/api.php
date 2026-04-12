<?php

if (!function_exists('load_routes')) {
    function load_routes(string $filepath): void
    {
        $routes = function () use ($filepath) {
            require $filepath;
        };

        $routes();
    }
}

load_routes(base_path('/routes/api/v1/api.php'));
