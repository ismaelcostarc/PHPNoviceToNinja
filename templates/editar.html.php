<h2 class="title is-4">Edite um material:</h2>

<form method="POST" action="">
    <input type="hidden" name="recurso[id]" value="<?=$recurso['id']?>">

    <div class="field">
        <label class="label" for="recursoTitulo">Título</label>
        <div class="control">
            <input type="text" class="input is-large" name="recurso[titulo]" id="recursoTitulo" value="<?=$recurso['titulo']?>" required>
        </div>
    </div>

    <div class="field">
        <label class="label" for="recursoLink">Link</label>
        <div class="control">
            <input type="url" class="input" name="recurso[link]" id="recursoLink"  value="<?=$recurso['link']?>" required>
        </div>
    </div>

    <div class="field">
        <label class="label" for="recursoDescricao">Descrição</label>
        <div class="control">
            <textarea class="textarea" name="recurso[descricao]" id="recursoDescricao" required><?=$recurso['descricao']?></textarea>
        </div>
    </div>

    <div class="field is-grouped">
        <div class="control is-grouped">
            <input type="submit" class="button is-success" value="Enviar">
        </div>

        <div class="control">
            <input type="reset" class="button" value="Apagar">
        </div>
    </div>
    <form>