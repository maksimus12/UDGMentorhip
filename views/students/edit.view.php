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
            <div class="flex flex-col">
                <div class=" sm:-mx-6 lg:-mx-8">
                    <div class="flex justify-center py-2 sm:px-6 lg:px-8">

                        <div class="w-6/12 ml-5 ">
                            <form method="POST" action="/student">
                                <div class="shadow sm:rounded-md">
                                    <div class="space-y-6 bg-white px-4 py-5 sm:p-6">
                                        <div>
                                            <label for="student" class="block text-sm font-medium text-gray-700">Edit
                                                Student</label>
                                            <div class="mt-1">
                                                <input type="hidden" name="_method" value="PATCH">
                                                <input type="hidden" name="id"
                                                       value="<?= $userStudent['student_id'] ?>">
                                                <input
                                                        id="student"
                                                        value="<?= $userStudent['student'] ?>"
                                                        name="student_name"
                                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            </div>

                                            <div class="mt-5 block">
                                                <label class="block text-sm font-medium text-gray-700">Mentor</label>
                                                <div class="relative">
                                                    <button type="button" id="mentor-dropdown-trigger"
                                                            class="mt-1 w-full rounded-md border border-gray-300 bg-white py-2 px-3 text-left shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                                                        Select Mentors
                                                    </button>
                                                    <div id="mentor-dropdown"
                                                         class="absolute left-0 mt-2 w-full rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 hidden max-h-[200px] overflow-y-auto">
                                                        <div class="py-1">
                                                            <?php
                                                            foreach ($allUsers as $user):
                                                                $isChecked = in_array(
                                                                    $user['id'],
                                                                    $mentorIds,
                                                                ) ? 'checked' : '';
                                                                ?>
                                                                <div class="flex items-center px-4 py-2">
                                                                    <input type="checkbox"
                                                                           id="mentor-<?= $user['id'] ?>"
                                                                           name="mentor[]"
                                                                           value="<?= $user['id'] ?>" <?= $isChecked ?>
                                                                           class="h-4 w-4 rounded border-gray-300 text-blue-500 focus:ring-2 focus:ring-blue-500">
                                                                    <label for="mentor-<?= $user['id'] ?>"
                                                                           class="ml-3 text-sm text-gray-600 cursor-pointer"><?= htmlspecialchars(
                                                                            $user['email'],
                                                                        ) ?></label>
                                                                </div>
                                                            <?php
                                                            endforeach; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        if (isset($errors['student_name'])) : ?>
                                            <p class="text-red-500 text-xs mt-2"><?= $errors['student_name'] ?></p>
                                        <?php
                                        endif; ?>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                                        <a
                                                href="/students"
                                                class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                        >
                                            Back
                                        </a>
                                        <button
                                                type="submit"
                                                class="inline-flex justify-center rounded-md border border-transparent bg-zinc-300 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-zinc-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                        >
                                            Update
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
<script>
    // Функция для обновления текста кнопки
    function updateSelectedMentors() {
        const trigger = document.getElementById('mentor-dropdown-trigger');
        const checkboxes = document.querySelectorAll('input[name="mentor[]"]:checked');
        const selectedMentors = Array.from(checkboxes).map(cb => {
            return cb.nextElementSibling.textContent.trim();
        });

        if (selectedMentors.length > 0) {
            trigger.textContent = selectedMentors.join(', ');
        } else {
            trigger.textContent = 'Select Mentors';
        }
    }

    // Открытие/закрытие выпадающего списка
    document.getElementById('mentor-dropdown-trigger').addEventListener('click', function () {
        document.getElementById('mentor-dropdown').classList.toggle('hidden');
    });

    // Закрытие при клике вне dropdown
    document.addEventListener('click', function (event) {
        var dropdown = document.getElementById('mentor-dropdown');
        var trigger = document.getElementById('mentor-dropdown-trigger');
        if (!dropdown.contains(event.target) && !trigger.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });

    // Обновление при изменении выбора
    document.querySelectorAll('input[name="mentor[]"]').forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectedMentors);
    });

    // Инициализация при загрузке страницы
    document.addEventListener('DOMContentLoaded', updateSelectedMentors);
</script>
<?php
require base_path('views/partials/footer.php') ?>
