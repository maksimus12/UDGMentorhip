<?php

require base_path('views/partials/head.php') ?>
<?php
require base_path('views/partials/nav.php') ?>
<?php
require base_path('views/partials/banner.php') ?>

<?php

$table_headings_style = 'border-e border-neutral-200 px-6 py-4 dark:border-black/20';
$table_row_style = 'border-e border-neutral-200 whitespace-nowrap px-6 py-4 font-medium dark:border-black/10';

$id = $_GET['page-nr'] ?? 1;
?>

<main id="<?= $id ?>">
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
            <form id="meeting-filter" action="" method="GET" class="flex w-fit items-end">
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
                                                <?php

                                                if(mb_strlen($meeting['topic']) > 31) {
                                                    echo htmlspecialchars(mb_substr($meeting['topic'], 0, 30) . "...");
                                                }else{
                                                    echo htmlspecialchars($meeting['topic']);
                                                }
                                                 ?>
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
                                                <form class="" method="post" action="/meeting" onsubmit="return confirmDelete()">
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


<!--            Pagination-->


            <div class="flex items-center justify-between px-4 py-3 sm:px-6">

                <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">

                    <div>
                        <p class="text-sm text-gray-700">
                            Total:
                            <span class="font-medium"><?= htmlspecialchars($allRecords) ?></span>
                            results
                        </p>
                    </div>
                    <div>
                        <nav class="isolate inline-flex -space-x-px rounded-md shadow-xs" aria-label="Pagination">

                            <?php if (isset($_GET['page-nr']) && $_GET['page-nr'] > 1){
                                ?>
                            <a href="?page-nr=<?= htmlspecialchars($_GET['page-nr']-1) ?>" class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-gray-300 ring-inset hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                <span class="sr-only">Previous</span>
                                <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                    <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <?php } else {
                            ?>
                            <a class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-gray-300 ring-inset hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                <span class="sr-only">Previous</span>
                                <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                    <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <?php }
                            ?>
                            <!-- Current: "z-10 bg-indigo-600 text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600", Default: "text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:outline-offset-0" -->

                            <?php for($i = 1; $i<= $pages; $i++){ ?>
                                <a href="?page-nr=<?= $i ?>"  class="page-number relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-gray-300 ring-inset focus:z-20 focus:outline-offset-0"><?= $i ?></a>
                            <?php }
                            ?>



                            <?php if (!isset($_GET['page-nr'])){
                            ?>
                            <a href="?page-nr=2" class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-gray-300 ring-inset hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                <span class="sr-only">Next</span>
                                <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                    <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <?php }elseif(isset($_GET['page-nr']) && $_GET['page-nr'] >= $pages){

                            ?>
                                <a class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-gray-300 ring-inset hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                    <span class="sr-only">Next</span>
                                    <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                        <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            <?php }else{
                            ?>
                            <a href="?page-nr=<?= htmlspecialchars($_GET['page-nr']+1) ?>" class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-gray-300 ring-inset hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                <span class="sr-only">Next</span>
                                <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                    <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <?php }
                            ?>
                        </nav>
                    </div>
                </div>
            </div>

        </div>
    </div>

</main>
<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this record?");
    }

    const filterForm = document.getElementById('meeting-filter');

    filterForm.addEventListener('submit', function(e) {
        const controls = this.querySelectorAll('select[name], input[name]');
        controls.forEach(control => {
            if (control.value === '') {
                control.disabled = true;
            }
        });
    });


    const links = document.querySelectorAll('.page-number');
    const main = document.querySelector('main');
    const currentPage = parseInt(main.id, 10) || 1;
    const idx = currentPage - 1;
    if (links[idx]) {
        links[idx].classList.add(
            'bg-indigo-600',
            'text-white'
        );
    }

    document.addEventListener('DOMContentLoaded', () => {
        const links = Array.from(document.querySelectorAll('.page-number'));
        const currentIndex = links.findIndex(a => a.classList.contains('bg-indigo-600'));
        const total = links.length;
        const windowSize = 2;

        // figure out which indexes to show: first, last, and current±windowSize
        const toShow = new Set([
            0, 1,
            total - 3, total - 2, total - 1,
            ...Array(windowSize * 2 + 1).fill().map((_, i) => currentIndex - windowSize + i)
        ]);

        const makeEllipsis = () => {
            const span = document.createElement('span');
            span.className = 'relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-gray-300 ring-inset focus:outline-offset-0';
            span.textContent = '…';
            return span;
        };

        let lastWasHidden = false;
        links.forEach((link, idx) => {
            if (toShow.has(idx) && idx >= 0 && idx < total) {
                if (lastWasHidden) {
                    link.parentNode.insertBefore(makeEllipsis(), link);
                }
                link.style.display = 'inline-flex';
                lastWasHidden = false;
            } else {
                link.style.display = 'none';
                lastWasHidden = true;
            }
        });
    });
</script>

<?php
require base_path('views/partials/footer.php') ?>
