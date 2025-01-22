<?php

require('partials/head.php') ?>
<?php
require('partials/nav.php') ?>
<?php
require('partials/banner.php') ?>

<main>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">

        <div class="mt-5 md:w-1/6 rounded-lg bg-white px-8 py-4 shadow-md">
            <p>Total Meetings</p>

            <?php
            if (isset($_SESSION['user'])) { ?>
                <h1 class="text-4xl">
                    <?= $meetingCount ?? $meetingCount = 0; ?>
                </h1>
                <?php
            } else { ?>
                <h1 class="text-4xl">0</h1>
            <?php
            } ?>
        </div>
    </div>
</main>


<?php
require('partials/footer.php') ?>
