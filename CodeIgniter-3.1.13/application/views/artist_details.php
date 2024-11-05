<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artist Details</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/styles.css'); ?>">
</head>
<body>
<main class='container'>
    <?php if (!empty($details)): ?>
        <h5>Artist Details: <?php echo $details[0]->artist_name; ?></h5>
        <section class="list">
            <?php
            $currentAlbum = '';
            foreach ($details as $detail) {
                if ($currentAlbum != $detail->album_name) {
                    if ($currentAlbum != '') {
                        echo "</ul>";
                    }
                    $currentAlbum = $detail->album_name;
                    echo "<div><article>";
                    echo "<header class='short-text'>";
                    echo "<h6>Album: {$detail->album_name}</h6>";
                    echo "</header>";
                    echo "<ul>";
                }
                echo "<li>Song: {$detail->song_name}</li>";
                echo "<li>
                        <form action='" . site_url('artists/add_to_playlist') . "' method='post'>
                            <input type='hidden' name='track_id' value='{$detail->song_id}'>
                            <select name='playlist_id'>";
                            foreach ($playlists as $playlist) {
                                echo "<option value='{$playlist->id}'>{$playlist->name}</option>";
                            }
                echo        "</select>
                            <button type='submit'>Ajouter à la playlist</button>
                        </form>
                      </li>";
            }
            if ($currentAlbum != '') {
                echo "</ul></article></div>";
            }
            ?>
        </section>
    <?php else: ?>
        <p>Aucun détail disponible pour cet artiste.</p>
    <?php endif; ?>
    <a href="<?php echo site_url('artists'); ?>">Retour à la liste des artistes</a>
</main>
</body>
</html>
