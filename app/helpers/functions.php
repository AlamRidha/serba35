<?php
function base_path($path = '')
{
    return __DIR__ . '/../../' . ltrim($path, '/');
}

function base_url($path = '')
{
    return 'http://localhost/serba35/' . ltrim($path, '/');
}


function formatTanggalIndo($datetimeStr)
{
    $formatter = new IntlDateFormatter(
        'id_ID',
        IntlDateFormatter::FULL,
        IntlDateFormatter::SHORT,
        'Asia/Jakarta',
        IntlDateFormatter::GREGORIAN,
        "EEEE, d MMMM yyyy '/' HH:mm"
    );

    $timestamp = strtotime($datetimeStr);
    return $formatter->format($timestamp);
}
