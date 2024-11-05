<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Playlists</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/styles.css'); ?>">
</head>
<body>
<main class='container'>
    <h2>Mes Playlists</h2>
    <a href="<?php echo site_url('playlists/create'); ?>">Créer une nouvelle playlist</a><br>
    <?php if (!empty($playlists)): ?>
        <ul>
            <?php foreach ($playlists as $playlist): ?>
                <li>
                    <h3><?php echo $playlist->playlist_name; ?></h3>
                    <p>Dernière modification : <?php echo $playlist->playlist_modified_date; ?></p>
                    <a href="<?php echo site_url('playlists/view/' . $playlist->id); ?>">Voir la playlist</a>
                    <!-- Bouton pour supprimer la playlist -->
                    <a href="<?php echo site_url('playlists/delete/' . $playlist->id); ?>">Supprimer</a>
                    <!-- Bouton pour dupliquer la playlist -->
                    <a href="<?php echo site_url('playlists/duplicate/' . $playlist->id); ?>">Dupliquer</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Aucune playlist disponible.</p>
    <?php endif; ?>
</main>
</body>
</html>