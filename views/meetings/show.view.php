<?php

require base_path('views/partials/head.php') ?>
<?php
require base_path('views/partials/nav.php') ?>
<?php
require base_path('views/partials/banner.php') ?>

<main>
    <div class="mt-5 mx-auto max-w-3xl py-8 px-6 bg-white shadow-md rounded-lg">


        <article>

            <header class="mb-6 border-b pb-4">
                <h1 class="text-3xl font-bold text-gray-900">
                    <?= htmlspecialchars($meeting['topic']) ?>
                </h1>
                <p class="text-sm text-gray-600 mt-2">
                    <?php
                    if ($_SESSION['user']['user_role'] == \Core\UserRoles::ADMIN) { ?>
                        Mentor: <span class="font-semibold"><?= htmlspecialchars($meeting['email']) ?></span> •
                        <?php
                    } ?>
                    Student: <span class="font-semibold"><?= htmlspecialchars($meeting['fname']) ?></span>
                    • <?= date('F j, Y', strtotime($meeting['created_at'])) ?>
                </p>
            </header>


            <div class="prose prose-lg text-gray-800">
                <p><?= nl2br(htmlspecialchars($meeting['body'])) ?></p>
            </div>
        </article>


        <footer class="mt-8 flex justify-between">

            <a href="/meetings">
                <button class="bg-blue-500 text-white px-4 py-2 rounded-md shadow hover:bg-blue-700">
                    👈 Back
                </button>
            </a>


            <div class="flex">
                <a href="/meeting/edit?id=<?= $meeting['post_id'] ?>"
                   class="rounded-md border
                        mr-3
                        border-transparent
                        bg-yellow-500 py-2 px-4 text-sm font-medium
                        text-white shadow-sm
                        hover:bg-yellow-600
                        focus:outline-none focus:ring-2
                        focus:ring-indigo-500
                        focus:ring-offset-"
                >
                    Edit
                </a>
                <form method="post" onsubmit="confirmDelete()">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="id" value="<?= $meeting['post_id'] ?>">
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md shadow hover:bg-red-700">
                        Delete
                    </button>
                </form>
            </div>
        </footer>
    </div>
</main>
<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this record?");
    }
</script>
<?php
require base_path('views/partials/footer.php') ?>
