<?php require base_path('views/partials/head.php') ?>
<?php require base_path('views/partials/nav.php') ?>
<?php require base_path('views/partials/banner.php') ?>

<main>

    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="mt-5 md:col-span-2 md:mt-0">
                <form method="POST" action="/meeting">
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="id" value="<?=$meeting['post_id']?>">
                    <div class="shadow sm:overflow-hidden sm:rounded-md">
                        <div class="space-y-6 bg-white px-4 py-5 sm:p-6">
                        <div>
                            <label
                                    for="meeting_datetime"
                                    class="block text-sm font-medium text-gray-700"
                            >Meeting Date & Time</label>
                            <div class="mt-1 mb-5">
                                <input
                                        type="datetime-local"
                                        id="meeting_datetime"
                                        name="meeting_datetime"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        value="<?= $meeting['meeting_datetime'] ?? date('Y-m-d H:i:s') ?>"
                                >

                                <?php if (isset($errors['meeting_datetime'])) : ?>
                                    <p class="text-red-500 text-xs mt-2"><?= $errors['meeting_datetime'] ?></p>
                                <?php endif; ?>
                            </div>
                            <label
                                for="student"
                                class="block text-sm font-medium text-gray-700"
                            >Student</label>
                            <div class="mt-1">
                                <input type="hidden" name="student_id" value="<?=$meeting['student_id']?>">
                                <input type="text"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                       value="<?= $meeting['fname']?>" readonly>

                                <?php if (isset($errors['body'])) : ?>
                                    <p class="text-red-500 text-xs mt-2"><?= $errors['body'] ?></p>
                                <?php endif; ?>
                        </div>
                        </div>       
                        <div>
                            <label
                                for="topic"
                                class="block text-sm font-medium text-gray-700"
                            >Topic</label>
                            <div class="mt-1">
                                <input
                                    id="topic"
                                    name="topic"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    placeholder="Metting Topic"
                                    value="<?= $meeting['topic'] ?? '' ?>"
                                >

                                <?php if (isset($errors['topic'])) : ?>
                                    <p class="text-red-500 text-xs mt-2"><?= $errors['topic'] ?></p>
                                <?php endif; ?>
                        </div>
                        </div>    
                        <div>
                                <label
                                    for="body"
                                    class="block text-sm font-medium text-gray-700"
                                >Body</label>

                                <div class="mt-1">
                                    <textarea
                                        id="body"
                                        name="body"
                                        rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        placeholder="Here's an idea for a meeting..."
                                    ><?= $meeting['body'] ?? '' ?></textarea>

                                    <?php if (isset($errors['body'])) : ?>
                                        <p class="text-red-500 text-xs mt-2"><?= $errors['body'] ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                            <button
                                href="/meetings"
                                type="cancel"
                                class="inline-flex justify-center rounded-md border border-transparent bg-gray-400 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                            >
                                Cancel
                            </button>
                            <button
                                type="submit"
                                class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                            >
                                Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php require base_path('views/partials/footer.php') ?>
