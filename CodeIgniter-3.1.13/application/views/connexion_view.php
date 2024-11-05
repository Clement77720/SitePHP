<!doctype html>
<html lang="en" class="has-navbar-fixed-top">
<head>
    <meta charset="UTF-8" />
    <title>Connexion</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css" />
</head>
<body>
    <main class='container'>
        <section>
            <h1>Connexion</h1>
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>
            <form action="<?= site_url('connexion/login'); ?>" method="post">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" required>
                <button type="submit">Se connecter</button>
            </form>
        </section>
    </main>
</body>
</html>
