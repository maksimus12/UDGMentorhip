<?php

require('partials/head.php') ?>
<?php
require('partials/nav.php') ?>
<?php
require('partials/banner.php') ?>
<?php

$table_headings_style = 'border-e border-neutral-200 px-6 py-4 dark:border-black/20';
$table_row_style = 'border-e border-neutral-200 whitespace-nowrap px-6 py-4 font-medium dark:border-black/10';

?>

<main>
    <div class=" mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <form action="" method="GET" class="flex w-fit items-end">

            <div class="mr-[10px]">
                <label for="start_date" class="block text-gray-700 font-bold mb-2">Start:</label>
                <input type="date" id="start_date" name="startDate" value="<?= $startDate ?>"
                       class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mr-[10px]">
                <label for="end_date" class="block text-gray-700 font-bold mb-2">End:</label>
                <input type="date" id="end_date" name="endDate" value="<?= $endDate ?>"
                       class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button
                    type="submit"
                    class="h-fit bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
                Filter
            </button>
        </form>
        <div class="mt-5 md:w-1/6 rounded-lg bg-white px-8 py-4 shadow-md">
            <p>Total Meetings</p>

            <?php
            if (isset($_SESSION['user'])) { ?>
                <h1 class="text-4xl">
                    <?= $meetingCount ?? $meetingCount = 0; ?>
                </h1>
                <?php
            } ?>
        </div>
        <div class="flex">
            <div class="mt-5 md:w-1/4 rounded-lg bg-white   shadow-md overflow-hidden border border-gray-200">
                <table
                        class="border-collapse w-full min-w-full text-left text-sm font-light text-surface dark:text-black">
                    <thead
                            class="bg-gray-100 border-b border-neutral-200 font-medium dark:border-black/20">
                    <tr>
                        <th scope="col" class="w-0 <?= $table_headings_style ?>">Student</th>
                        <th scope="col" class="<?= $table_headings_style ?>">Meetings</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($meetingByStudent as $index => $meeting) : ?>
                        <tr class="border-b border-neutral-200 dark:border-black/10">
                            <td class="<?= $table_row_style ?>">
                                <?= htmlspecialchars($meeting['studentName']) ?>
                            </td>
                            <td class="<?= $table_row_style ?>">
                                <?= htmlspecialchars($meeting['meetingCount']) ?>
                            </td>
                        </tr>
                    <?php
                    endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php
            if (Core\Session::isAdmin()) : ?>
                <div class="ml-5 mt-5 md:w-2/6 rounded-lg bg-white   shadow-md overflow-hidden border border-gray-200">
                    <table
                            class="border-collapse w-full min-w-full text-left text-sm font-light text-surface dark:text-black">
                        <thead
                                class="bg-gray-100 border-b border-neutral-200 font-medium dark:border-black/20">
                        <tr>
                            <th scope="col" class="w-0 <?= $table_headings_style ?>">Mentor</th>
                            <th scope="col" class="<?= $table_headings_style ?>">Meetings</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($meetingsByMentor as $index => $mentor) : ?>
                            <tr class="border-b border-neutral-200 dark:border-black/10">
                                <td class="<?= $table_row_style ?>">
                                    <?= htmlspecialchars($mentor['username']) ?>
                                </td>
                                <td class="<?= $table_row_style ?>">
                                    <?= htmlspecialchars($mentor['meetingCount']) ?>
                                </td>
                            </tr>
                        <?php
                        endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php
            endif ?>
        </div>
    </div>

</main>


<?php
require('partials/footer.php') ?>
