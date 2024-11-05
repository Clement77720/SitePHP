<main class='container'>
    <h5>Albums list</h5>
    <form method="GET" action="<?php echo site_url('albums'); ?>">
        <input type="text" name="search" placeholder="Search albums" value="<?php echo $this->input->get('search', TRUE); ?>">
        <button type="submit">Search</button>
    </form>
    <section class="list">
    <form method="GET" action="<?php echo site_url('albums/index'); ?>">
        <label for="order">Filtre:</label>
        <select name="order" id="order" onchange="this.form.submit()">
            <option value="year_asc" <?php echo $order == 'year_asc' ? 'selected' : ''; ?>>Croissant par Année</option>
            <option value="year_desc" <?php echo $order == 'year_desc' ? 'selected' : ''; ?>>Décroissant par Année</option>
            <option value="name_asc" <?php echo $order == 'name_asc' ? 'selected' : ''; ?>>Croissant par Albums</option>
            <option value="name_desc" <?php echo $order == 'name_desc' ? 'selected' : ''; ?>>Décroissant par Albums</option>
            <option value="artist_asc" <?php echo $order == 'artist_asc' ? 'selected' : ''; ?>>Croissant par Artists</option>
            <option value="artist_desc" <?php echo $order == 'artist_desc' ? 'selected' : ''; ?>>Décroissant par Artists</option>
            <option value="genre_asc" <?php echo $order == 'genre_asc' ? 'selected' : ''; ?>>Croissant par Genre Musical</option>
            <option value="genre_desc" <?php echo $order == 'genre_desc' ? 'selected' : ''; ?>>Décroissant par Genre Musical</option>
        </select>
    </form>

    <?php
    foreach($albums as $album){
        echo "<div><article>";
        echo "<header class='short-text'>";
        echo anchor("albums/view/{$album->id}","{$album->name}");
        echo "</header>";
        echo '<img src="data:image/jpeg;base64,'.base64_encode($album->jpeg).'" />';
        echo "<footer class='short-text'>{$album->year} - {$album->artistName}</footer>
        </article></div>";
    }

    ?>
    </section>
</main>