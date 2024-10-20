document.addEventListener("DOMContentLoaded", function () {
  const notificationsBtn = document.getElementById("notifications-btn");
  const notificationsBoard = document.getElementById("notifications-board");
  const noNotificationsMessage = document.getElementById(
    "no-notifications-message"
  );
  const notificationsImportant = document.getElementById(
    "notifications-important"
  );
  let currentNotifications = [];

  if (notificationsBtn && notificationsBoard) {
    notificationsBtn.addEventListener("click", function () {
      notificationsBtn.classList.toggle("outline-none");
      notificationsBtn.classList.toggle("ring-2");
      notificationsBtn.classList.toggle("ring-white");
      notificationsBtn.classList.toggle("ring-offset-2");
      notificationsBtn.classList.toggle("ring-offset-gray-800");
      notificationsBoard.classList.toggle("hidden");
    });

    // Event delegation for close buttons
    notificationsBoard.addEventListener("click", function (event) {
      if (event.target.classList.contains("notification-close-btn")) {
        const notificationElement = event.target.closest(".notification-item");
        const notificationId = notificationElement.getAttribute(
          "data-notification-id"
        );

        fetch(`/api/notifications`, {
          method: "PATCH",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ notificationId }),
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              notificationElement.remove();

              const notificationsArea = document.querySelector(
                ".notifications-area"
              );
              if (notificationsArea.children.length === 0) {
                noNotificationsMessage.classList.remove("hidden");
                notificationsImportant.classList.add("hidden");
              }
              currentNotifications = [];
            } else {
              console.error("Failed to mark notification as read");
            }
          })
          .catch((error) => {
            console.error("Error:", error);
          });
      }
    });

    function checkForNotifications() {
      fetch("/api/notifications")
        .then((response) => response.json())
        .then((data) => {
          const notificationCount = data.count;

          if (notificationCount > 0) {
            const newNotifications = data.notifications;

            if (
              JSON.stringify(newNotifications) !==
              JSON.stringify(currentNotifications)
            ) {
              updateNotificationBoard(newNotifications);
              currentNotifications = newNotifications;
            }
            notificationsImportant.classList.remove("hidden");
            noNotificationsMessage.classList.add("hidden");
          } else {
            notificationsImportant.classList.add("hidden");
            noNotificationsMessage.classList.remove("hidden");
            currentNotifications = [];
          }
        })
        .catch((error) =>
          console.error("Error fetching notifications:", error)
        );
    }

    function updateNotificationBoard(notifications) {
      const notificationsArea = document.querySelector(".notifications-area");
      notificationsArea.innerHTML = "";

      notifications.forEach((notification) => {
        const notificationElement = document.createElement("div");
        notificationElement.classList.add(
          "notification-item",
          "w-full",
          "max-w-xs",
          "p-4",
          "text-gray-900",
          "bg-white",
          "rounded-lg",
          "shadow",
          "dark:bg-gray-800",
          "dark:text-gray-300",
          "mb-4"
        );
        notificationElement.setAttribute(
          "data-notification-id",
          notification.id
        );
        notificationElement.innerHTML = `
          <div class="flex items-center mb-6">
              <span class="mb-1 text-sm font-semibold text-gray-900 dark:text-white">${notification.message}</span>
              <button
                  type="button"
                  class="notification-close-btn ms-auto -mx-1.5 -my-1.5 bg-white justify-center items-center flex-shrink-0 text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                  aria-label="Close">
                  <span class="sr-only">Close</span>
                  <svg class="pointer-events-none w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                  </svg>
              </button>
          </div>
          <div class="flex items-center">
              <div class="ms-3 text-sm font-normal space-y-20">
                  <span class="text-xs font-medium text-blue-600 dark:text-blue-500">Created at ${notification.created_at}</span>
              </div>
          </div>
        `;

        notificationsArea.appendChild(notificationElement);
      });

      if (notifications.length === 0) {
        noNotificationsMessage.classList.remove("hidden");
      } else {
        noNotificationsMessage.classList.add("hidden");
      }
    }

    setInterval(checkForNotifications, 5000);
  }
});
