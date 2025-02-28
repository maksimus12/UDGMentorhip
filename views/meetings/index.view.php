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
            <div class="flex justify-between">
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
            <form action="" method="GET" class="flex w-fit items-end">
                <?php if(Core\Session::isAdmin()){ ?>
                <div class="mr-[10px]">
                <label for="start_date" class="block text-gray-700 font-bold mb-2">Mentor:</label>
                <select
                        name="mentor"
                        id="filter"
                        class="h-fit block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 mr-[10px]"
                >
                    <option value="" <?= empty($_GET['mentor']) ? 'selected' : '' ?>>All</option>
                    <?php foreach ($uniqueUsers as $uniqueUser): ?>
                        <option value="<?= $uniqueUser['id'] ?>" <?= (isset($_GET['mentor']) && $_GET['mentor'] == $uniqueUser['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($uniqueUser['email']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
                </div>
                <?php } ?>
                <div class="mr-[10px]">
                    <label for="start_date" class="block text-gray-700 font-bold mb-2">Student:</label>
                    <select
                            name="student"
                            id="filter"
                            class="h-fit block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 mr-[10px]"
                    >
                        <option value="" <?= empty($_GET['student']) ? 'selected' : '' ?>>All</option>
                        <?php foreach ($uniqueStudents as $uniqueStudent): ?>
                            <option value="<?= $uniqueStudent['id'] ?>" <?= (isset($_GET['student']) && $_GET['student'] == $uniqueStudent['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($uniqueStudent['fname']) ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="mr-[10px]">
                    <label for="start_date" class="block text-gray-700 font-bold mb-2">Start:</label>
                    <input type="date" id="start_date" name="startDate"  value="<?= $startDate ?>"   class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mr-[10px]">
                    <label for="end_date" class="block text-gray-700 font-bold mb-2">End:</label>
                    <input type="date" id="end_date" name="endDate"  value="<?= $endDate ?>" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <button
                        type="submit"
                        class="h-fit bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    Filter
                </button>
            </form>
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
                                    <th scope="col" class="w-0 <?= $table_headings_style ?>">Student </th>
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
                                                    date_format(date_create($meeting['meeting_datetime']), 'd.m.Y'),
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
                                                <form class="" method="post" action="/meeting">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="id" value="<?= $meeting['id'] ?>">
                                                    <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-red-500 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Delete</button>
                                                </form>
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
