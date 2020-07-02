<?php foreach ($recursos as $recurso) : ?>
    <div class="card">
        <div class="card-header">
            <p class="card-header-title">
                <span class="title is-4">
                    <a href="<?= htmlspecialchars($recurso['link'], ENT_QUOTES, 'UTF-8') ?>">
                        <?= htmlspecialchars($recurso['titulo'], ENT_QUOTES, 'UTF-8') ?></a>
                </span>
            </p>
        </div>

        <div class="card-content">
            <div class="subtitle is-6">
                <?= htmlspecialchars($recurso['data'], ENT_QUOTES, 'UTF-8') ?>
            </div>
            <div>
                <?= htmlspecialchars($recurso['descricao'], ENT_QUOTES, 'UTF-8') ?>
            </div>
        </div>

        <div class="card-footer">
            <div class="card-footer-item">
                <button class="button">Editar</button>
            </div>

            <div class="card-footer-item">
                <form action="apagar.php" method="POST">
                    <input type="hidden" name="recursoId" value="<?= $recurso['id'] ?>">
                    <input type="submit" class="button is-danger" value="Apagar">
                </form>
            </div>
        </div>
    </div>
    </div>
<?php endforeach; ?>