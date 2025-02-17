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
                    <div class="flex justify-center py-2 sm:px-6 lg:px-8">
                        <div class="w-6/12 ml-5 overflow-hidden">
                            <form method="POST" action="/mentorpass">
                                <div class="shadow sm:overflow-hidden sm:rounded-md">
                                    <div class="space-y-6 bg-white px-4 py-5 sm:p-6">
                                        <h1 class="font-bold">CHANGE PASSWORD FOR: <span class="text-blue-500"><?= strtoupper($mentor["email"])?></span></h1>
                                        <div>
                                            <input type="hidden" name="_method" value="PATCH">
                                            <input type="hidden" name="id" value="<?= $mentor['id'] ?>">
                                            <label
                                                for="mentor"
                                                class="block text-sm font-medium text-gray-700"
                                            >New Password</label>
                                            <div class="mt-1">
                                                <input
                                                    id="mentor"
                                                    value=""
                                                    name="new-pass"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            </div>
                                        </div>
                                    <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                                        <a
                                            href="/mentors"
                                            class="inline-flex justify-center
                                                rounded-md border border-transparent
                                                bg-indigo-600 py-2 px-4 text-sm font-medium
                                                text-white shadow-sm hover:bg-indigo-700
                                                focus:outline-none focus:ring-2 focus:ring-indigo-500
                                                focus:ring-offset-2"
                                        >
                                            Back
                                        </a>
                                        <button
                                            type="submit"
                                            class="inline-flex justify-center
                                                rounded-md border border-transparent
                                                bg-zinc-300 py-2 px-4 text-sm font-medium
                                                text-white shadow-sm hover:bg-zinc-400
                                                focus:outline-none focus:ring-2 focus:ring-indigo-500
                                                focus:ring-offset-2"
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

<?php require base_path('views/partials/footer.php') ?>
