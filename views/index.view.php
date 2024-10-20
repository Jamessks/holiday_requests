<?php require('partials/head.php') ?>
<?php require('partials/nav.php') ?>
<?php require('partials/banner.php') ?>

<main>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <a href="holiday-request/create" class="cursor-pointer text-white bg-blue-500 hover:bg-blue-700 font-medium py-2 px-4 rounded">
            Make Holiday Request
        </a>
    </div>

    <div class="relative overflow-x-auto mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <?php if ($holidayRequests): ?>
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">From Date</th>
                        <th scope="col" class="px-6 py-3">To Date</th>
                        <th scope="col" class="px-6 py-3">Reason</th>
                        <th scope="col" class="px-6 py-3">Created At</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($holidayRequests as $request): ?>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4 relative">
                                <?= $request['from_date']; ?>
                                <span class="absolute right-0 top-1/2 transform -translate-y-1/2 border-l border-gray-300 h-3/5"></span>
                            </td>
                            <td class="px-6 py-4 relative">
                                <?= $request['to_date']; ?>
                                <span class="absolute right-0 top-1/2 transform -translate-y-1/2 border-l border-gray-300 h-3/5"></span>
                            </td>
                            <td class="px-6 py-4 relative">
                                <?= $request['reason']; ?>
                                <span class="absolute right-0 top-1/2 transform -translate-y-1/2 border-l border-gray-300 h-3/5"></span>
                            </td>
                            <td class="px-6 py-4 relative">
                                <?= $request['created_at']; ?>
                                <span class="absolute right-0 top-1/2 transform -translate-y-1/2 border-l border-gray-300 h-3/5"></span>
                            </td>
                            <td class="px-6 py-4 relative">
                                <?= $request['status']; ?>
                                <span class="absolute right-0 top-1/2 transform -translate-y-1/2 border-l border-gray-300 h-3/5"></span>
                            </td>
                            <td class="px-6 py-4 flex space-x-2 relative">
                                <?php if ($request['status'] == 'Pending') { ?>
                                    <form action="/holiday-request" method="POST" onsubmit="return confirm('Are you sure you want to cancel this holiday request?');">
                                        <input type="hidden" name="id" value="<?= $request['id']; ?>">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="text-white bg-red-500 hover:bg-red-700 font-medium py-2 px-4 rounded">
                                            Cancel
                                        </button>
                                    </form>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <h2>You have not submitted any holiday requests.</h2>
        <?php endif; ?>
    </div>

</main>

<?php require('partials/footer.php') ?>