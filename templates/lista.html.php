<div class="level">
    <div class="level-left">
        <p class="level-item">Total: <?= $numeroRecursos ?></p>
    </div>

    <div class="level-right">
        <form>
            <div class="field">
                <label class="label" for="ordem">Ordenar por:</label>
                <div class="control">
                    <div class="select">
                        <select id="ordem" name="ordem">
                            <option>Data de Inserção</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php foreach ($recursos as $recurso) : ?>
    <div class="box">
        <h1 class="title is-4">
            <a href="<?= h($recurso['link']) ?>">
                <?= h($recurso['titulo']) ?></a>
        </h1>

        <h2 class="title is-6">
            <?= h($recurso['autorId']) ?>
        </h2>
        <h3 class="subtitle is-6">
            <?= h($recurso['data']) ?>
        </h3>

        <div class="content">
            <?= h($recurso['descricao']) ?>
        </div>

        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    <a class="button" href="/editar.php?id=<?= $recurso['id'] ?>">Editar</a>
                </div>

                <div class="level-item">
                    <form action="apagar.php" method="POST">
                        <input type="hidden" name="recursoId" value="<?= $recurso['id'] ?>">
                        <input type="submit" class="button is-danger" value="Apagar">
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>