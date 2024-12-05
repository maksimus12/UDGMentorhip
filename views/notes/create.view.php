<?php require base_path('views/partials/head.php') ?>
<?php require base_path('views/partials/nav.php') ?>
<?php require base_path('views/partials/banner.php') ?>

<main>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="mt-5 md:col-span-2 md:mt-0">
                <h1 class="mb-5 text-2xl font-bold tracking-tight text-gray-900">Add new meetting record</h1>
                <form method="POST" action="/notes">
                    <div class="shadow sm:overflow-hidden sm:rounded-md">
                        <div class="space-y-6 bg-white px-4 py-5 sm:p-6">
                        <div>
                            <label
                                for="student"
                                class="block text-sm font-medium text-gray-700"
                            >Student</label>
                            <div class="mt-1">
                                <select
                                    id="student"
                                    name="student"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    placeholder="Metting Topic"
                                >
                                    <option value="Student 1">Student 1</option>
                                    <option value="Student 2">Student 2</option>
                                    <option value="Student 3">Student 3</option>
                                    <option value="Student 4">Student 4</option>
                                    <option value="Student 5">Student 5</option>
                                    <option value="Student 6">Student 6</option>
                                </select>

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
                                ><?= $_POST['topic'] ?? '' ?></input>

                                <?php if (isset($errors['topic'])) : ?>
                                    <p class="text-red-500 text-xs mt-2"><?= $errors['topic'] ?></p>
                                <?php endif; ?>
                        </div>
                        </div>
                            <div>
                                <label
                                    for="body"
                                    class="block text-sm font-medium text-gray-700"
                                >Dicussion key moments</label>
                                <div class="mt-1">
                                    <textarea
                                        id="body"
                                        name="body"
                                        rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        placeholder="Here's your notes..."
                                    ><?= $_POST['body'] ?? '' ?></textarea>

                                    <?php if (isset($errors['body'])) : ?>
                                        <p class="text-red-500 text-xs mt-2"><?= $errors['body'] ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
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
</main>

<?php require base_path('views/partials/footer.php') ?>
