<!-- artists.php -->
<?php foreach ($artists as $artist): ?>
    <div>
        <h3><?php echo $artist->name; ?></h3>

        <?php foreach ($artist->songs as $song): ?>
            <div>
                <p><?php echo $song->title; ?></p>

                <!-- Formulaire pour ajouter une chanson à une playlist -->
                <?php echo form_open('playlists/add_song_to_playlist'); ?>
                    <input type="hidden" name="track_id" value="<?php echo $song->id; ?>">
                    <label for="playlist_id_<?php echo $song->id; ?>">Ajouter à la playlist:</label>
                    <select name="playlist_id" id="playlist_id_<?php echo $song->id; ?>">
                        <?php foreach ($playlists as $playlist): ?>
                            <option value="<?php echo $playlist->id; ?>"><?php echo $playlist->playlist_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit">Ajouter</button>
                <?php echo form_close(); ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>