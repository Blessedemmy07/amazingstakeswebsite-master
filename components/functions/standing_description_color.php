<?php
// Array of colors
$colors = ["rgb(0, 70, 130)", "purple", "rgb(30, 168, 236)", "rgb(127, 0, 41)", "rgb(189, 0, 0)", "purple", "brown", "red"];

// Initialize an array to store color mapping and color with description
$colorMapping = [];
$colorWithName = [];

// Function to convert a string to sentence case
function toSentenceCase($string) {
    return ucfirst(strtolower($string));
}

// Function to assign a color based on the description
function assignColorToDescription($description) {
    global $colors, $colorMapping, $colorWithName;

    // Ensure $colorMapping is initialized as an array
    if (!is_array($colorMapping)) {
        $colorMapping = [];
    }

    // Ensure $colors is an array and has elements
    if (!is_array($colors) || count($colors) === 0) {
        return ["color" => "black", "colorWithName" => $colorWithName]; // Fallback color
    }

    // Check if a color is already assigned to this description
    if (isset($colorMapping[$description])) {
        return ["color" => $colorMapping[$description], "colorWithName" => $colorWithName];
    }

    // Assign a new color based on the index in the colors array
    $colorIndex = count($colorMapping) % count($colors);
    $color = $colors[$colorIndex];

    // Normalize description and handle "Relegation"
    if ($description !== null) {
        $normalizedDescription = toSentenceCase($description);

        if (strpos($normalizedDescription, "Relegation") !== false) {
            if ($normalizedDescription === "Relegation") {
                $color = "red";
            } else {
                $color = "brown";
            }
        }
    } else {
        $description = "Undefined"; // Handle null descriptions
    }

    // Store color mapping and add to colorWithName array
    $colorMapping[$description] = $color;
    $colorWithName[] = ["color" => $color, "description" => $description];

    return ["color" => $color, "colorWithName" => $colorWithName];
}
