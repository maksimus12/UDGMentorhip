<?php require base_path('views/partials/head.php') ?>
<?php require base_path('views/partials/nav.php') ?>
<?php require base_path('views/partials/banner.php') ?>

<main>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        
        <h3 class="mb-5 text-2xl font-bold tracking-tight text-gray-900"><?= htmlspecialchars($meeting['fname']). ": " .htmlspecialchars($meeting['topic']) ?></h3>

        <p><?= htmlspecialchars($meeting['body']) ?></p>

        <div class="flex">
            <footer class="mt-6">
            <a href="/meetings">
            <button
                type="submit"
                class="rounded-md border 
                        border-transparent 
                        bg-blue-500 py-2 px-4 text-sm font-medium 
                        text-white shadow-sm 
                        hover:bg-blue-700 
                        focus:outline-none focus:ring-2 
                        focus:ring-indigo-500 
                        focus:ring-offset- mr-5"
            >
                👈 Back
            </button></a>
        <!-- <a href="/note/edit?id=<?= $meeting['id']?>" class="text-green-500 border border-current px-4 py-2 rounded">Edit</a> -->
        </footer>
        <form class="mt-6" method="post">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="id" value="<?= $meeting['post_id'] ?>">
            <button
                type="submit"
                class="inline-flex justify-center rounded-md border border-transparent bg-red-500 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
            >
                Delete
            </button>
        </form>
        </div>
    </div>
</main>

<?php require base_path('views/partials/footer.php') ?>
