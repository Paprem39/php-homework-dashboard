// ===============================
// Main Application JS
// ===============================

// Common
document.addEventListener("DOMContentLoaded", () => {

    // Clock
    if (typeof updateClock === "function") {
        updateClock();
        setInterval(updateClock, 1000);
    }

});