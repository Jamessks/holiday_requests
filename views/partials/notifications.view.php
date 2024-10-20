<div id="notifications-board" class="hidden absolute top-10 -right-20 bg-blue-500 p-6 border-none rounded-2xl z-10 h-[450px] max-h-[450px] w-[300px] overflow-y-auto">
    <div class="notifications-area">
        <?php if (count($notifications) > 0): ?>
            <?php foreach ($notifications as $notification): ?>
                <div data-notification-id="<?= $notification['id'] ?>"
                    class="notification-item w-full max-w-xs p-4 text-gray-900 bg-white rounded-lg shadow dark:bg-gray-800 dark:text-gray-300 mb-4" role="alert">
                    <div class="flex items-center mb-6">
                        <span class="mb-1 text-sm font-semibold text-gray-900 dark:text-white"><?= $notification['message'] ?></span>
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
                            <span class="text-xs font-medium text-blue-600 dark:text-blue-500"><?= "Created at " . $notification['created_at'] ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div id="no-notifications-message" class="text-gray-500 <?= count($notifications) == 0 ? '' : ' hidden' ?>">
        <p class="text-white text-center">No new notifications</p>
    </div>
</div>
<div id="notifications-important" class="absolute top-0 left-0 w-4 h-4 pointer-events-none <?= count($notifications) == 0 ? ' hidden' : '' ?>">
    <svg xmlns="http://www.w3.org/2000/svg" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 512 512">
        <path fill="#A82C1F" fill-rule="nonzero" d="M256 0c70.686 0 134.69 28.658 181.016 74.984C483.342 121.31 512 185.314 512 256c0 70.686-28.658 134.69-74.984 181.016C390.69 483.342 326.686 512 256 512c-70.686 0-134.69-28.658-181.016-74.984C28.658 390.69 0 326.686 0 256c0-70.686 28.658-134.69 74.984-181.016C121.31 28.658 185.314 0 256 0z" />
        <circle fill="#D03827" cx="256" cy="256" r="226.536" />
        <path fill="#fff" fill-rule="nonzero" d="M275.546 302.281c-.88 22.063-38.246 22.092-39.099-.007-3.779-37.804-13.444-127.553-13.136-163.074.312-10.946 9.383-17.426 20.99-19.898 3.578-.765 7.512-1.136 11.476-1.132 3.987.007 7.932.4 11.514 1.165 11.989 2.554 21.402 9.301 21.398 20.444l-.044 1.117-13.099 161.385zm-19.55 39.211c14.453 0 26.168 11.717 26.168 26.171 0 14.453-11.715 26.167-26.168 26.167s-26.171-11.714-26.171-26.167c0-14.454 11.718-26.171 26.171-26.171z" />
    </svg>
</div>