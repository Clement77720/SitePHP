<!doctype html>
<html lang="en" class="has-navbar-fixed-top">
<head>
    <meta charset="UTF-8" />
    <title>MUSIC APP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <?= link_tag('assets/style.css') ?>
</head>
<body>
    <main class='container'>
        <nav>
            <ul>
                <li><strong>Music APP</strong></li>
                <?php if ($this->session->userdata('logged_in')): ?>
                    <li><strong><?= $this->session->userdata('prenom') . ' ' . $this->session->userdata('nom'); ?></strong></li>
                <?php endif; ?>
            </ul>
            <ul>
                <li><?= anchor('albums', 'Albums'); ?></li>
                <li><?= anchor('artists', 'Artists'); ?></li>
                <li><?= anchor('playlists', 'Playlists'); ?></li>
                <?php if ($this->session->userdata('logged_in')): ?>
                    <li><?= anchor('connexion/logout', 'Déconnexion'); ?></li>
                <?php else: ?>
                    <li><?= anchor('connexion', 'Connexion'); ?></li>
                    <li><?= anchor('inscription', 'Inscription'); ?></li>
                <?php endif; ?>
            </ul>
        </nav>
    </main>
</body>
</html>
