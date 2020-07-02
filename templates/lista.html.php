<?php foreach ($recursos as $recurso): ?>
    <div class="box">
        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    <?= htmlspecialchars($recurso['recursoTexto'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
            </div>

            <div class="level-right">
                <div class="level-item">
                    <form action="apagar.php" method="POST">
                        <input type="hidden" name="recursoId" value="<?=$recurso['recursoId']?>">
                        <input type="submit" class="button is-danger" value="Apagar">
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>