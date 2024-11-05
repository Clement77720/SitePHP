<!-- application/views/inscription.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    <main class='container'>
        <section>
            <h1>Inscription</h1>
            <!-- Formulaire d'inscription -->
            <form action="<?php echo site_url('inscription/register'); ?>" method="post">
                <label for="prenom">Prénom:</label>
                <input type="text" id="prenom" name="prenom" required>
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" required>
                <input type="submit" value="Inscription">
            </form>
        </section>
    </main>
</body>
</html>