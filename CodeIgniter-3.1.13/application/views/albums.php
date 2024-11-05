<!-- albums.php -->
<?php foreach ($albums as $album): ?>
    <div>
        <h3><?php echo $album->title; ?></h3>
        <p><?php echo $album->artist; ?></p>
        <p><?php echo $album->release_date; ?></p>

        <!-- Formulaire pour ajouter un album à une playlist -->
        <?php echo form_open('playlists/add_album_to_playlist'); ?>
            <input type="hidden" name="album_id" value="<?php echo $album->id; ?>">
            <label for="playlist_id_<?php echo $album->id; ?>">Ajouter à la playlist:</label>
            <select name="playlist_id" id="playlist_id_<?php echo $album->id; ?>">
                <?php foreach ($playlists as $playlist): ?>
                    <option value="<?php echo $playlist->id; ?>"><?php echo $playlist->playlist_name; ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Ajouter</button>
        <?php echo form_close(); ?>
    </div>
<?php endforeach; ?>