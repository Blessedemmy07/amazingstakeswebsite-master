<?php
function getDeviceType() {
    $userAgent = $_SERVER['HTTP_USER_AGENT'];

    // Check for mobile devices
    if (preg_match('/Mobile|Android|iPhone|iPad|iPod/', $userAgent)) {
        return 'mobile';
    }

    // Check for tablets
    if (preg_match('/Tablet|iPad/', $userAgent)) {
        return 'tablet';
    }

    // Default is desktop
    return 'desktop';
}
