<?php require base_path('views/partials/head.php') ?>
<?php require base_path('views/partials/nav.php') ?>
<?php require base_path('views/partials/banner.php') ?>

<main>
    <div class="mx-auto max-w-7xl py-6 px-4 sm:px-6 lg:px-8">
        <a href="/" class="dark:bg-blue-500 text-white py-2 px-4 rounded  hover:bg-blue-700">Back</a>
    </div>
    <div class="flex min-h-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 rounded-2xl w-full max-w-md space-y-8 p-12">
            <form action="/holiday-request" method="POST">
                <div class="flex flex-col mb-4">
                    <label for="from-date" class="block text-gray-300">Date From:</label>
                    <div class="flex items-center">
                        <input type="text" id="from-date" name="from_date" class="p-2 border rounded" required>
                        <span class="p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m4 4H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z" />
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="flex flex-col mb-4">
                    <label for="to-date" class="block text-gray-300">Date To:</label>
                    <div class="flex items-center">
                        <input type="text" id="to-date" name="to_date" class="p-2 border rounded" required>
                        <span class="p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m4 4H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z" />
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="flex flex-col w-[200px] mb-4">
                    <label for="reason" class="block text-gray-300">Reason for Leave:</label>
                    <select id="reason" class="mt-1 p-2 border rounded cursor-pointer" name="reason" required>
                        <option value="" disabled selected>Select a reason</option>
                        <?php foreach ($reasons as $reason): ?>
                            <option value="<?= $reason['id'] ?>"><?= $reason['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Submit</button>
                <?php if (isset($_SESSION['_flash']['errors'])): ?>
                    <ul class="mt-4">
                        <?php foreach ($_SESSION['_flash']['errors'] as $field => $error): ?>
                            <li class="text-red-500 text-xs mt-2"><?= $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </form>
        </div>
    </div>
</main>

<?php require base_path('views/partials/footer.php') ?>