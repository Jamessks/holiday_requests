<?php require base_path('views/partials/head.php') ?>
<?php require base_path('views/partials/nav.php') ?>
<?php require base_path('views/partials/banner.php') ?>

<main>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <a href="manage/users/create" class="cursor-pointer text-white bg-blue-500 hover:bg-blue-700 font-medium py-2 px-4 rounded">
            Create User
        </a>
    </div>
    <div class="relative overflow-x-auto mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Username</th>
                    <th scope="col" class="px-6 py-3">Email</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <?= $user['username']; ?>
                        </th>
                        <td class="px-6 py-4">
                            <?= $user['email']; ?>
                        </td>
                        <td class="px-6 py-4 flex space-x-2">
                            <input type="hidden" name="user_id" value="<?= $user['id']; ?>">
                            <a href="manage/users/edit?user_id=<?= $user['id']; ?>" class="text-white bg-blue-500 hover:bg-blue-700 font-medium py-2 px-4 rounded">
                                Edit
                            </a>
                            <form action="/manage/users/destroy" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                <input type="hidden" name="user_id" value="<?= $user['id']; ?>">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="text-white bg-red-500 hover:bg-red-700 font-medium py-2 px-4 rounded">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<?php require base_path('views/partials/footer.php') ?>