<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Album Details</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/styles.css'); ?>">
</head>
<body>
    <main class='container'>
        <h2>Album Details</h2>

        <?php foreach ($details as $detail): ?>
            <div>
                <article>
                    <header class='short-text'>
                        <h3>Album: <?php echo $detail->album_name; ?></h3>
                        <p>Artist: <?php echo $detail->artist_name; ?></p>
                        <p>Genre: <?php echo $detail->genre_name; ?></p>
                    </header>
                    <ul>
                        <li>Track: <?php echo $detail->track_number; ?></li>
                        <li>Song: <?php echo $detail->song_name; ?></li>
                        <li>Duration: <?php echo $detail->track_duration; ?></li>
                        <li>
                            <form action="<?php echo site_url('albums/add_to_playlist'); ?>" method="post">
                                <input type="hidden" name="track_id" value="<?php echo $detail->track_id; ?>">
                                <select name="playlist_id">
                                    <?php foreach ($playlists as $playlist): ?>
                                        <option value="<?php echo $playlist->id; ?>"><?php echo $playlist->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit">Ajouter à la playlist</button>
                            </form>
                        </li>
                    </ul>
                </article>
            </div>
        <?php endforeach; ?>

        <?php if (!empty($details)): ?>
        <div>
            <h3>Ajouter tout l'album à une playlist</h3>
            <form action="<?php echo site_url('albums/add_album_to_playlist'); ?>" method="post">
                <input type="hidden" name="album_id" value="<?php echo $details[0]->album_id; ?>">
                <select name="playlist_id">
                    <?php foreach ($playlists as $playlist): ?>
                        <option value="<?php echo $playlist->id; ?>"><?php echo $playlist->name; ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Ajouter tout l'album à la playlist</button>
            </form>
        </div>
        <?php endif; ?>

    </main>
</body>
</html>