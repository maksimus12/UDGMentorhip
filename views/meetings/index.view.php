<?php

require base_path('views/partials/head.php') ?>
<?php
require base_path('views/partials/nav.php') ?>
<?php
require base_path('views/partials/banner.php') ?>

<?php

$table_headings_style = 'border-e border-neutral-200 px-6 py-4 dark:border-black/20';
$table_row_style = 'border-e border-neutral-200 whitespace-nowrap px-6 py-4 font-medium dark:border-black/10';

?>

<main>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <div class="table_component" role="region" tabindex="0">
            <div class="flex">
                <p class="mr-5 mt-6 mb-10 primary">
                    <a href="/meetings/create"
                       class="rounded-md border
                    border-transparent 
                    bg-blue-500 py-2 px-4 text-sm font-medium 
                    text-white shadow-sm 
                    hover:bg-blue-700 
                    focus:outline-none focus:ring-2 
                    focus:ring-indigo-500 
                    focus:ring-offset-2"
                    >Create Meeting
                    </a>
                </p>
            </div>
            <div class="flex flex-col">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                        <div class="overflow-hidden">
                            <table
                                    class="border-collapse border border-gray-300 w-full min-w-full text-left text-sm font-light text-surface dark:text-black">
                                <thead
                                        class="border-b border-neutral-200 font-medium dark:border-black/20">
                                <tr>
                                    <?php

                                    if (Core\Session::isAdmin()) { ?>
                                        <th scope="col" class="w-0 <?= $table_headings_style ?>">Mentor</th>
                                        <?php
                                    } ?>
                                    <th scope="col" class="w-0 <?= $table_headings_style ?>">Student</th>
                                    <th scope="col" class=" <?= $table_headings_style ?>">Topic</th>
                                    <th scope="col" class=" <?= $table_headings_style ?>">Date</th>
                                    <th scope="col" class=" px-6 py-4 ">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php

                                foreach ($meetings as $index => $meeting) : ?>
                                    <tr class="border-b border-neutral-200 dark:border-black/10">
                                        <?php
                                        if (Core\Session::isAdmin()) { ?>
                                            <td class="<?= $table_row_style ?>">
                                                <?= htmlspecialchars($meeting['email']) ?>
                                            </td>
                                            <?php
                                        } ?>
                                        <td class="<?= $table_row_style ?>">
                                            <?= htmlspecialchars($meeting['fname']) ?>
                                        </td>
                                        <td class="<?= $table_row_style ?>">
                                            <a href="/meeting?id=<?= $meeting['id'] ?>"
                                               class="text-blue-500 hover:underline">
                                                <?= htmlspecialchars($meeting['topic']) ?>
                                            </a>
                                        </td>
                                        <td class="<?= $table_row_style ?>">
                                            <p>
                                                <?= htmlspecialchars(
                                                    date_format(date_create($meeting['meeting_datetime']), 'Y-m-d H:i'),
                                                ); ?>
                                            </p>
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-4">
                                            <div class="flex">
                                                <a href="/meeting/edit?id=<?= $meeting['id'] ?>" class="rounded-md border
                                                    border-transparent
                                                    mr-3
                                                    bg-orange-500 py-2 px-4 text-sm font-medium
                                                    text-white shadow-sm
                                                    hover:bg-orange-700
                                                    focus:outline-none focus:ring-2
                                                    focus:ring-indigo-500
                                                    focus:ring-offset-"
                                                >
                                                    Edit
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                endforeach; ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

<?php
require base_path('views/partials/footer.php') ?>
