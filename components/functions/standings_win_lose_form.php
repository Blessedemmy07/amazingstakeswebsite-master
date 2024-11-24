<?php
function StandingsFormWinLose($currentFormVals, $key) {
    $formDrawing = '';

    if ($currentFormVals != null) {
        for ($i = 0; $i < strlen($currentFormVals); $i++) {
            $letter = $currentFormVals[$i];
            $backgroundColor = '';
            $label = '';

            // Determine the color and label based on the match result
            if ($letter === "W") {
                $backgroundColor = "green";
                $label = "W";
            } elseif ($letter === "D") {
                $backgroundColor = "#ffb400";
                $label = "D";
            } elseif ($letter === "L") {
                $backgroundColor = "red";
                $label = "L";
            }

            // Generate the HTML for each result
            $formDrawing .= '
            <div class="responsive-cell team-link-standings">
                <span class="number-circle rounded-square m-1"
                      style="background-color: ' . $backgroundColor . ';
                             text-align: left;
                             font-size: 11px;
                             display: inline-block;">
                    ' . $label . '
                </span>
            </div>';
        }
    }

    return $formDrawing;
}
