var Calendar = function (t) {
    this.divId = t.RenderID ? t.RenderID : '[data-render="calendar"]';
    this.DaysOfWeek = t.DaysOfWeek ? t.DaysOfWeek : ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
    this.Months = t.Months ? t.Months : [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];

    var e = new Date();
    this.CurrentMonth = e.getMonth();
    this.CurrentYear = e.getFullYear();

    // Save the initial (current) month and year
    this.InitialMonth = this.CurrentMonth;
    this.InitialYear = this.CurrentYear;

    var r = t.Format;
    this.f = "string" == typeof r ? r.charAt(0).toUpperCase() : "M";
};

// Restrict navigating to more than 3 months back
Calendar.prototype.prevMonth = function () {
    var pastMonthLimit = (this.InitialMonth - 3 + 12) % 12;
    var pastYearLimit = this.InitialYear + (this.InitialMonth - 3 < 0 ? -1 : 0);

    // Check if we're beyond the limit
    if (this.CurrentYear > pastYearLimit || (this.CurrentYear === pastYearLimit && this.CurrentMonth > pastMonthLimit)) {
        if (this.CurrentMonth === 0) {
            this.CurrentMonth = 11;
            this.CurrentYear -= 1;
        } else {
            this.CurrentMonth -= 1;
        }
    }

    this.divId = '[data-active="false"] .render';
    this.showCurrent();
};

// Restrict navigating to more than 3 months forward
Calendar.prototype.nextMonth = function () {
    var futureMonthLimit = (this.InitialMonth + 3) % 12;
    var futureYearLimit = this.InitialYear + (this.InitialMonth + 3 > 11 ? 1 : 0);

    // Check if we're beyond the limit
    if (this.CurrentYear < futureYearLimit || (this.CurrentYear === futureYearLimit && this.CurrentMonth < futureMonthLimit)) {
        if (this.CurrentMonth === 11) {
            this.CurrentMonth = 0;
            this.CurrentYear += 1;
        } else {
            this.CurrentMonth += 1;
        }
    }

    this.divId = '[data-active="false"] .render';
    this.showCurrent();
};

// Other methods remain the same

Calendar.prototype.previousYear = function () {
    this.CurrentYear = this.CurrentYear - 1;
    this.showCurrent();
};

Calendar.prototype.nextYear = function () {
    this.CurrentYear = this.CurrentYear + 1;
    this.showCurrent();
};

Calendar.prototype.showCurrent = function () {
    this.Calendar(this.CurrentYear, this.CurrentMonth);
};

Calendar.prototype.checkActive = function () {
    var monthsElement = document.querySelector(".months");
    if (monthsElement) {
        monthsElement.setAttribute(
            "class",
            monthsElement.getAttribute("class").includes("active") ? "months" : "months active"
        );
    }

    var monthA = document.querySelector(".month-a");
    var monthB = document.querySelector(".month-b");

    if (monthA && monthB) {
        if (monthA.getAttribute("data-active") === "true") {
            monthA.setAttribute("data-active", "false");
            monthB.setAttribute("data-active", "true");
        } else {
            monthA.setAttribute("data-active", "true");
            monthB.setAttribute("data-active", "false");
        }
    }

    setTimeout(function () {
        var headerElement = document.querySelector(".calendar .header");
        if (headerElement) {
            headerElement.setAttribute("class", "header active");
        }
    }, 200);

    var activeRender = document.querySelector('[data-active="true"] .render');
    if (activeRender) {
        var monthIndex = activeRender.getAttribute("data-month");
        if (monthIndex) {
            document.body.setAttribute("data-theme", this.Months[parseInt(monthIndex)].toLowerCase());
        }
    }
};

Calendar.prototype.Calendar = function (t, e) {
    if (typeof t === "number") this.CurrentYear = t;
    if (typeof e === "number") this.CurrentMonth = e;

    var today = new Date();
    var currentDay = today.getDate();
    var currentMonth = today.getMonth();
    var currentYear = today.getFullYear();
    var firstDayOfMonth = new Date(t, e, 1).getDay();
    var daysInMonth = new Date(t, e + 1, 0).getDate();
    var prevMonthDays = e === 0 ? new Date(t - 1, 11, 0).getDate() : new Date(t, e, 0).getDate();
    var headerContent = "<span>" + this.Months[e] + " &nbsp; " + t + "</span>";
    var calendarTable = '<div class="table">';

    calendarTable += '<div class="row head">';
    for (var i = 0; i < 7; i++) calendarTable += '<div class="cell">' + this.DaysOfWeek[i] + "</div>";
    calendarTable += "</div>";

    var l = dm = this.f === "M" ? 1 : firstDayOfMonth === 0 ? -5 : 2;
    for (var v = 0, c = 0; v < 6; v++) {
        calendarTable += '<div class="row">';
        for (var m = 0; m < 7; m++) {
            var h = c + dm - firstDayOfMonth;
            if (h < 1) {
                calendarTable += '<div class="cell disable">' + (prevMonthDays - firstDayOfMonth + l++) + "</div>";
            } else if (h > daysInMonth) {
                calendarTable += '<div class="cell disable">' + l++ + "</div>";
            } else {
                calendarTable += '<div class="cell' + (currentDay == h && this.CurrentMonth == currentMonth && this.CurrentYear == currentYear ? " active" : "") + '" data-date="' + h + '" data-month="' + this.CurrentMonth + '" data-year="' + this.CurrentYear + '"><span>' + h + "</span></div>";
                l = 1;
            }
            c % 7 === 6 && h >= daysInMonth && (v = 10), c++;
        }
        calendarTable += "</div>";
    }

    calendarTable += "</div>";

    var monthYearElement = document.querySelector('[data-render="month-year"]');
    if (monthYearElement) monthYearElement.innerHTML = headerContent;

    var divRender = document.querySelector(this.divId);
    if (divRender) {
        divRender.innerHTML = calendarTable;
        divRender.setAttribute("data-date", this.Months[e] + " - " + t);
        divRender.setAttribute("data-month", e);
    }

    this.attachDateClickHandler();
};

// Function to handle the click event on date cells
Calendar.prototype.attachDateClickHandler = function () {
    var dateCells = document.querySelectorAll('.cell:not(.disable)');
    dateCells.forEach(function (cell) {
        cell.onclick = function () {
            var selectedDay = this.getAttribute('data-date');
            var selectedMonth = this.getAttribute('data-month');
            var selectedYear = this.getAttribute('data-year');

            var selectedDate = selectedYear + "-" +
                ((parseInt(selectedMonth) + 1) < 10 ? '0' + (parseInt(selectedMonth) + 1) : (parseInt(selectedMonth) + 1)) + "-" +
                (selectedDay < 10 ? '0' + selectedDay : selectedDay);

            var phpPageUrl = "/football-predictions-by-date/" + encodeURIComponent(selectedDate);
            window.location.href = phpPageUrl;
        };
    });
};

window.onload = function () {
    var t = new Calendar({
        RenderID: ".render-a",
        Format: "M"
    });

    t.showCurrent();
    t.checkActive();

    var headerActions = document.querySelectorAll(".header [data-action]");
    headerActions.forEach(function (action) {
        action.onclick = function () {
            var calendarHeader = document.querySelector(".calendar .header");
            if (calendarHeader) calendarHeader.setAttribute("class", "header");

            var monthsElement = document.querySelector(".months");
            if (monthsElement && monthsElement.getAttribute("data-loading") === "true") {
                calendarHeader.setAttribute("class", "header active");
                return false;
            }

            monthsElement.setAttribute("data-loading", "true");
            var flowDirection = this.getAttribute("data-action").includes("prev") ? "left" : "right";
            this.getAttribute("data-action").includes("prev") ? t.prevMonth() : t.nextMonth();

            t.checkActive();
            monthsElement.setAttribute("data-flow", flowDirection);

            var activeMonth = document.querySelector('.month[data-active="true"]');
            if (activeMonth) {
                activeMonth.addEventListener("webkitTransitionEnd", function () {
                    monthsElement.removeAttribute("data-loading");
                });
                activeMonth.addEventListener("transitionend", function () {
                    monthsElement.removeAttribute("data-loading");
                });
            }
        };
    });
};
