
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une playlist</title>
</head>
<body>

<h2>Créer une playlist</h2>
<?php echo form_open('playlists/create'); ?>
    <label for="playlist_name">Nom de la playlist:</label><br>
    <input type="text" name="playlist_name" id="playlist_name" required><br>

    <input type="checkbox" id="is_random" name="is_random" value="1">
    <label for="is_random">Playlist aléatoire</label><br>

    <div id="random_options">
        <label for="genre">Genre:</label>
        <select name="genre" id="genre">
            <?php foreach ($genres as $genre): ?>
                <option value="<?php echo $genre->name; ?>"><?php echo $genre->name; ?></option>
            <?php endforeach; ?>
        </select><br>
        
        <label for="num_tracks">Nombre de morceaux:</label>
        <input type="number" name="num_tracks" id="num_tracks" value="10" min="1" max="100" required><br>
    </div>

    <button type="submit">Créer</button><br>
<?php echo form_close(); ?>

<a href="<?php echo site_url('playlists'); ?>">Retour à la liste des playlists</a>

</body>
</html>