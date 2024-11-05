<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voir la Playlist</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/styles.css'); ?>">
</head>
<body>
<main class='container'>
    <h2><?php echo $playlist_name; ?></h2>
    <p>Dernière modification : <?php echo isset($playlist_modified_date) ? $playlist_modified_date : 'N/A'; ?></p>
    <h3>Chansons dans cette playlist :</h3>
    <?php if (!empty($songs)): ?>
        <ul>
            <?php foreach ($songs as $song): ?>
                <li>
                    <?php echo $song->name; ?>
                    <form action="<?php echo site_url('playlists/remove_song/' . $playlist_id); ?>" method="post" style="display:inline;">
                        <input type="hidden" name="track_id" value="<?php echo $song->id; ?>">
                        <button type="submit">Supprimer</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Aucune chanson dans cette playlist.</p>
    <?php endif; ?>

    <a href="<?php echo site_url('playlists'); ?>">Retour à la liste des playlists</a>
    
</main>
</body>
</html>