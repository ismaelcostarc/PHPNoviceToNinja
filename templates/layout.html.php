<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?></title>
    <link rel="shortcut icon"
          type="image/x-icon"
          href="assets/<?=$titleIcon?>.svg" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.0/css/bulma.min.css">
</head>
<body>
<header class="hero is-primary">
    <div class="hero-body">
        <h1 class="title">Recursos Livres</h1>
        <h2 class="subtitle">Material gratuito para estudantes de Desenvolvimento Web</h2>
    </div>
</header>

<nav class="navbar is-light">
    <div class="navbar-brand">
        <a role="button" class="navbar-burger burger" data-target="navbarWebLivre">
            <span></span>
            <span></span>
            <span></span>
        </a>
    </div>

    <div class="navbar-menu" id="navbarWebLivre">
        <div class="navbar-start">
            <a class="navbar-item" id="navbar-item-inicio" href="/index.php">Início</a>
            <a class="navbar-item" id="navbar-item-lista" href="/lista.php">Lista</a>
            <a class="navbar-item" id="navbar-item-adicionar" href="/adicionar.php">Adicionar um Novo</a>
        </div>
    </div>
</nav>

<section class="section">
    <div class="container">
        <?= $output ?>
    </div>
</section>

<footer class="section">
    <p>
        Feito por Ismael Costa
    </p>

    <div class="level">
        <div class="level-left">
            <div class="level-item">
                <a class="icon has-text-dark" href="https://github.com/ismaelcostarc">
                    <ion-icon name="logo-github"></ion-icon>
                </a>

                <a class="icon has-text-link" href="https://www.facebook.com/ismaelacostarc">
                    <ion-icon name="logo-facebook"></ion-icon>
                </a>

                <a class="icon has-text-danger" href="https://www.instagram.com/ismaelcostarc/">
                    <ion-icon name="logo-instagram"></ion-icon>
                </a>

                <a class="icon has-text-info" href="https://twitter.com/ismaelcostarc">
                    <ion-icon name="logo-twitter"></ion-icon>
                </a>

                <a class="icon has-text-link" href="https://www.linkedin.com/in/ismaelcostarc/">
                    <ion-icon name="logo-linkedin"></ion-icon>
                </a>

                <a class="icon has-text-danger" href="mailto:maelcosta96@gmail.com">
                    <ion-icon name="mail"></ion-icon>
                </a>
            </div>
        </div>
    </div>
</footer>
<script src="https://unpkg.com/ionicons@5.1.2/dist/ionicons.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {

        // Get all "navbar-burger" elements
        const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

        // Check if there are any navbar burgers
        if ($navbarBurgers.length > 0) {

            // Add a click event on each of them
            $navbarBurgers.forEach( el => {
                el.addEventListener('click', () => {

                    // Get the target from the "data-target" attribute
                    const target = el.dataset.target;
                    const $target = document.getElementById(target);

                    // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
                    el.classList.toggle('is-active');
                    $target.classList.toggle('is-active');

                });
            });
        }

    });

    $navbarItem = document.getElementById('navbar-item-<?= $itemMenuAtivo ?>');
    $navbarItem.classList.add('is-active');
</script>
</body>
</html>