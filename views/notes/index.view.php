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
        <p class="mt-6 mb-10 primary">
            <a href="/notes/create" 
                class="rounded-md border 
                    border-transparent 
                    bg-blue-500 py-2 px-4 text-sm font-medium 
                    text-white shadow-sm 
                    hover:bg-blue-700 
                    focus:outline-none focus:ring-2 
                    focus:ring-indigo-500 
                    focus:ring-offset-2"
                    >Create Note 
            </a>
        </p>
        <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
        <div class="overflow-hidden">
            <table
            class="border-collapse border border-gray-300 w-full min-w-full text-left text-sm font-light text-surface dark:text-black">
            <thead
                class="border-b border-neutral-200 font-medium dark:border-black/20">
                <tr>
                <th scope="col" class="w-0 <?= $table_headings_style ?>">No</th>
                <th scope="col" class="w-0 <?= $table_headings_style ?>">Student</th>
                <th scope="col" class=" <?= $table_headings_style ?>">Topic</th>
                <th scope="col" class=" px-6 py-4 ">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($notes as $index => $note) : ?>
                <tr class="border-b border-neutral-200 dark:border-black/10">
                <td class="<?= $table_row_style ?>"><?= $index + 1?></td>
                <td class="<?= $table_row_style ?>">  
                     <?= htmlspecialchars($note['fname']) ?>
                </td>
                <td class="<?= $table_row_style ?>">
                    <a href="/note?id=<?= $note['id'] ?>" class="text-blue-500 hover:underline">
                            <?= htmlspecialchars($note['topic']) ?>
                    </a>
                </td>
                <td class="whitespace-nowrap px-6 py-4"> 
                    <div class="flex">
                        <a href="/note/edit?id=<?= $note['id']?>" class="rounded-md border 
                        border-transparent 
                        bg-orange-500 py-2 px-4 text-sm font-medium 
                        text-white shadow-sm 
                        hover:bg-orange-700 
                        focus:outline-none focus:ring-2 
                        focus:ring-indigo-500 
                        focus:ring-offset-"
                        >
                        Edit
                        </a>  
                        
                        <!-- <form class="ml-6" method="post">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="id" value="<?= $note['id'] ?>">
                            <button
                                type="submit"
                                class="inline-flex justify-center rounded-md border border-transparent bg-red-500 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                            >
                                Delete
                            </button>
                        </form> -->

                    </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            </table>
            
        </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    
</main>

<?php require base_path('views/partials/footer.php') ?>
