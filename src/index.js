import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";

document.addEventListener("DOMContentLoaded", function () {
  const fromDate = flatpickr("#from-date", {
    dateFormat: "Y-m-d",
    onChange: function (selectedDates, dateStr) {
      toDate.set("minDate", dateStr);
    },
  });

  const toDate = flatpickr("#to-date", {
    dateFormat: "Y-m-d",
  });

  const flashNotifications = document.querySelectorAll(".flash_notification");

  flashNotifications.forEach(function (notification) {
    notification.addEventListener("click", function () {
      notification.classList.add("hidden");
    });
  });
});
