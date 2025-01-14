<?php require base_path('views/partials/head.php') ?>
<?php require base_path('views/partials/nav.php') ?>
<?php require base_path('views/partials/banner.php') ?>

<?php

$table_headings_style = 'border-e border-neutral-200 px-6 py-4 dark:border-black/20';
$table_row_style = 'border-e border-neutral-200 whitespace-nowrap px-6 py-4 font-medium dark:border-black/10';

?>

<main>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <div class="table_component" role="region" tabindex="0">
            <div class="flex flex-col">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="flex  py-2 sm:px-6 lg:px-8">

                        <div class="w-6/12 overflow-hidden">
                            <table
                                class="table-auto border-collapse border border-gray-300 w-full min-w-full text-left text-sm font-light text-surface dark:text-black">
                                <thead
                                    class="border-b border-neutral-200 font-medium dark:border-black/20">
                                <tr>
                                    <th scope="col" class="w-0 <?= $table_headings_style ?>">Student</th>
                                    <th scope="col" class="w-0 text-center px-6 py-4">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($students as $index => $student) : ?>
                                    <tr class="border-b border-neutral-200 dark:border-black/10">
                                        <td class="<?= $table_row_style ?>">
                                            <?= htmlspecialchars($student['fname']) ?>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <div class="flex justify-center items-center">
                                                <a href="/student/edit?id=<?= $student['id']?>" class="
                                                mr-5
                                                rounded-md border
                                                border-transparent
                                                bg-orange-400 py-2 px-4 text-sm font-medium
                                                text-white shadow-sm
                                                hover:bg-orange-600
                                                focus:outline-none focus:ring-2
                                                focus:ring-indigo-500
                                                focus:ring-offset-">
                                                    Edit
                                                </a>
                                                <form class=" " method="post">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="id" value="<?= $student['id'] ?>">
                                                    <button
                                                            type="submit"
                                                            class="inline-flex justify-center rounded-md border border-transparent bg-red-500 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                                    >
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                                </table>


                        </div>
                        <div class="w-6/12 ml-5 overflow-hidden">
                            <form  method="POST" action="/students">
                                <div class="shadow sm:overflow-hidden sm:rounded-md">
                                    <div class="space-y-6 bg-white px-4 py-5 sm:p-6">
                                        <div>
                                            <label
                                                for="student"
                                                class="block text-sm font-medium text-gray-700"
                                            >New Student</label>
                                            <div class="mt-1">
                                                <input
                                                id="student"
                                                value="<?= $_POST['student_name'] ?? " " ?>"
                                                name="student_name"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            </div>
                                        </div>
                                        <?php if (isset($errors['student_name'])) : ?>
                                            <p class="text-red-500 text-xs mt-2"><?= $errors['student_name'] ?></p>
                                        <?php endif; ?>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                                        <button
                                            type="submit"
                                            class="inline-flex justify-center
                                                rounded-md border border-transparent
                                                bg-indigo-600 py-2 px-4 text-sm font-medium
                                                text-white shadow-sm hover:bg-indigo-700
                                                focus:outline-none focus:ring-2 focus:ring-indigo-500
                                                focus:ring-offset-2"
                                        >
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

<?php require base_path('views/partials/footer.php') ?>
