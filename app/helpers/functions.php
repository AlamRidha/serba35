<?php
function base_path($path = '')
{
    return __DIR__ . '/../../' . ltrim($path, '/');
}

function base_url($path = '')
{
    return 'http://localhost/serba35/' . ltrim($path, '/');
}
