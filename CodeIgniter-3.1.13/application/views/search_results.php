<h5>Search Results</h5>
<section class="list">
    <?php foreach ($searchResults as $result) { ?>
        <div>
            <article>
                <header class="short-text">
                    <?php echo anchor("albums/view/{$result->id}", "{$result->name}"); ?>
                </header>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($result->jpeg); ?>" />
                <footer class="short-text">
                    <?php echo "{$result->year} - {$result->artistName}"; ?>
                </footer>
            </article>
        </div>
    <?php } ?>
</section>
