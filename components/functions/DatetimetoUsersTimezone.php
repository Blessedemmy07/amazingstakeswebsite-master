<?php
function DateTimeToUsersTimezone($originalDateGiven) {
    // The server's timezone (example: "Europe/Berlin")
    $serverTimeZone = new DateTimeZone('Europe/Berlin');
    
    // The user's timezone (example: "Africa/Nairobi")
    // You can retrieve the user's timezone from their browser via JavaScript and pass it to the server
    // Here, let's assume it's passed as "Africa/Nairobi"
    $usersTimeZone = new DateTimeZone('Africa/Nairobi');
    
    // Convert the original date to a DateTime object in the server's timezone
    $date = new DateTime($originalDateGiven, $serverTimeZone);
    
    // Convert the date to the user's timezone
    $date->setTimezone($usersTimeZone);
    
    // Format the date in "dd/mm/yyyy H:mm" format
    return $date->format('d/m/Y H:i');
}