<?php

namespace App\Classes;

class CustomDatePicker
{
    private $selectedDate;

    public function __construct()
    {
        // Initialize selected date to today or to the date in the URL query if provided
        $this->selectedDate = isset($_GET['date']) ? strtotime($_GET['date']) : time();
    }

    // Function to handle date change and update the page
    public function handleDateChange($newDate)
    {
        // Set new selected date and reload the page
        $this->selectedDate = strtotime($newDate);
        $this->redirectWithDate($newDate);
    }

    // Function to select previous date
    public function selectPreviousDateOnClick()
    {
        $newDate = date('Y-m-d', strtotime('-1 day', $this->selectedDate));
        $this->redirectWithDate($newDate);
    }

    // Function to select next date
    public function selectNextDateOnClick()
    {
        $newDate = date('Y-m-d', strtotime('+1 day', $this->selectedDate));
        $this->redirectWithDate($newDate);
    }

    // Redirects to the page with the selected date as a URL parameter
    private function redirectWithDate($date)
    {
        header("Location: /football-predictions-by-date/" . urlencode($date));
        exit();
    }

    // Function to get date range
    public function getDateRange()
    {
        $previousDays = 6;
        $nextDays = 15;
        $today = time();
        return [
            'firstDate' => strtotime("-$previousDays days", $today),
            'lastDate' => strtotime("+$nextDays days", $today)
        ];
    }

    // Render the component
    public function render()
    {
        $dateSelected = date('d', $this->selectedDate);
        $output = '<div class="row custom-select">';
        
        // Previous date button
        $output .= '<div class="col-2" onclick="selectPreviousDate()" style="font-size: 15px; cursor: pointer; margin-top: 3px;">
                        <span style="padding: 4px 10px 3px 10px; background: #202c3c; color: white; border-radius: 5px;">
                            <i class="bi bi-arrow-left-circle"></i>
                        </span>
                    </div>';
        
        // Date dropdown
        $output .= '<div class="col-8" style="background-color: #202c3c; border-radius: 5px;">
                        <div style="position: relative;">
                            <span style="position: absolute; left: 30px; font-size: 17px;">&#128197;</span>
                            <select id="date-select" name="date" class="form-control text-center custom-select-option fixturesTextSize"
                                style="padding: 3px 10px 3px 10px; background: #202c3c; color: white; border: none; font-weight: bold;"
                                onchange="handleDateChange(this.value)">';

        // Generate date options
        $firstDate = $this->getDateRange()['firstDate'];
        $lastDate = $this->getDateRange()['lastDate'];
        for ($i = 0; $i <= ($lastDate - $firstDate) / 86400; $i++) {
            $optionDate = strtotime("+$i day", $firstDate);
            $isToday = (date('Y-m-d', $optionDate) === date('Y-m-d'));
            $selected = (date('Y-m-d', $optionDate) === date('Y-m-d', $this->selectedDate)) ? 'selected' : '';
            $optionDateFormatted = date('Y-m-d', $optionDate);
            $output .= "<option value=\"$optionDateFormatted\" $selected style=\"" . ($isToday ? 'font-weight: bold;' : '') . "\">" .
                ($isToday ? 'TODAY' : date('d/m. D', $optionDate)) .
                "</option>";
        }

        $output .= '    </select>
                        </div>
                    </div>';

        // Next date button
        $output .= '<div class="col-2" onclick="selectNextDate()" style="font-size: 15px; cursor: pointer; margin-top: 3px;">
                        <span style="padding: 3px 10px 3px 10px; background: #202c3c; color: white; border-radius: 5px;">
                            <i class="bi bi-arrow-right-circle"></i>
                        </span>
                    </div>';
        $output .= '</div>';

        // JavaScript functions for handling date changes and updating the dropdown
        $output .= '<script>
            function handleDateChange(selectedDate) {
                window.location.href = "/football-predictions-by-date/" + encodeURIComponent(selectedDate);
            }

            function selectPreviousDate() {
                var dateSelect = document.getElementById("date-select");
                var currentDate = new Date(dateSelect.value);
                currentDate.setDate(currentDate.getDate() - 1);

                var newDate = currentDate.toISOString().split("T")[0];
                dateSelect.value = newDate;
                handleDateChange(newDate);
            }

            function selectNextDate() {
                var dateSelect = document.getElementById("date-select");
                var currentDate = new Date(dateSelect.value);
                currentDate.setDate(currentDate.getDate() + 1);

                var newDate = currentDate.toISOString().split("T")[0];
                dateSelect.value = newDate;
                handleDateChange(newDate);
            }
        </script>';

        return $output;
    }
}
