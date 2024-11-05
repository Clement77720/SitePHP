<main class='container'>
    <h5>Artists list</h5>
    <form method="GET" action="<?php echo site_url('artists'); ?>">
        <input type="text" name="search" placeholder="Search artists" value="<?php echo $this->input->get('search', TRUE); ?>">
        <button type="submit">Search</button>
    </form>
    <section class="list">
    <form method="GET" action="<?php echo site_url('artists/index'); ?>">
        <label for="order">Filtre:</label>
        <select name="order" id="order" onchange="this.form.submit()">
            <option value="name_asc" <?php echo $order == 'name_asc' ? 'selected' : ''; ?>>Croissant par Artists</option>
            <option value="name_desc" <?php echo $order == 'name_desc' ? 'selected' : ''; ?>>Décroissant par Artists</option>
        </select>
    </form>

    <?php
    foreach($artists as $artist){
        echo "<div><article>";
        echo "<header class='short-text'>";
        echo anchor("artists/view/{$artist->id}", $artist->name);
        echo "</header>";
        echo "</article></div>";
    }
    ?>
    </section>
</main>