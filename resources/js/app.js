import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

// Table CheckBox
document.addEventListener("DOMContentLoaded", () => {
    const selectAllCheckbox = document.getElementById("select-all");
    const bookingCheckboxes = document.querySelectorAll(".booking-checkbox");

    selectAllCheckbox.addEventListener("change", function () {
        bookingCheckboxes.forEach((checkbox) => {
            checkbox.checked = selectAllCheckbox.checked;
        });
    });
});
