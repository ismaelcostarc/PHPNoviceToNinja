<h2 class="title is-4"><?= $title ?? 'Recursos Livres' ?></h2>

<form method="POST" action="">
    <input type="hidden" name="recurso[id]" value="<?= $recurso['id'] ?? '' ?>">
    <!-- A data original de materiais já existentes é enviada na resposta HTTP para evitar que 
    o recurso fique com a data do dia que foi atualizado, não do dia que foi inserido -->
    <input type="hidden" name="recurso[data]" value="<?= $recurso['data'] ?? '' ?>">

    <?php if (isset($notifications) && in_array('tituloVazio', $notifications)) : ?>
        <div class="notification is-danger is-light">O título não pode estar vazio.</div>
    <?php endif; ?>

    <div class="field">
        <label class="label" for="recursoTitulo">Título</label>
        <div class="control">
            <input type="text" class="input is-large" name="recurso[titulo]" id="recursoTitulo" value="<?= $recurso['titulo'] ?? '' ?>" required>
        </div>
    </div>

    <?php if (isset($notifications) && in_array('linkVazio', $notifications)) : ?>
        <div class="notification is-danger is-light">O link não pode estar vazio.</div>
    <?php endif; ?>

    <?php if (isset($notifications) && in_array('linkExistente', $notifications)) : ?>
        <div class="notification is-danger is-light">Este Link já foi adicionado.</div>
    <?php endif; ?>

    <div class="field">
        <label class="label" for="recursoLink">Link</label>
        <div class="control">
            <input type="url" class="input" name="recurso[link]" id="recursoLink" value="<?= $recurso['link'] ?? '' ?>" required>
        </div>
    </div>

    <?php if (isset($notifications) && in_array('descricaoVazia', $notifications)) : ?>
        <div class="notification is-danger is-light">A descrição não pode estar vazia.</div>
    <?php endif; ?>

    <div class="field">
        <label class="label" for="recursoDescricao">Descrição</label>
        <div class="control">
            <textarea class="textarea" name="recurso[descricao]" id="recursoDescricao" required><?= $recurso['descricao'] ?? '' ?></textarea>
        </div>
    </div>

    <div class="field is-grouped">
        <div class="control is-grouped">
            <input type="submit" class="button is-success" value="Enviar">
        </div>

        <div class="control">
            <input type="reset" class="button" value="<?= $valorReset ?>">
        </div>
    </div>
    <form>