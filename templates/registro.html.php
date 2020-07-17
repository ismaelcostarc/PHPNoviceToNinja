<h2 class="title is-4">Cadastrar um Novo Usuário</h2>

<form action="" method="POST">
    <div class="field is-6-tablet">
        <?php if (isset($notifications) && in_array('nomeVazio', $notifications)) : ?>
            <div class="notification is-danger is-light">O nome não pode estar vazio.</div>
        <?php endif; ?>

        <label for="nome" class="label">Nome:</label>
        <div class="control has-icons-left is-6-tablet">
            <span class="icon is-left">
                <ion-icon name="person"></ion-icon>
            </span>
            <input value="<?= $nome ?? '' ?>" type="text" name="autor[nome]" id="nome" class="input is-6-tablet" placeholder="João da Silva" required>
        </div>
    </div>

    <?php if (isset($notifications) && in_array('emailExistente', $notifications)) : ?>
        <div class="notification is-danger is-light">O email informado já está cadastrado.</div>
    <?php endif; ?>

    <?php if (isset($notifications) && in_array('emailVazio', $notifications)) : ?>
        <div class="notification is-danger is-light">O email não pode estar vazio.</div>
    <?php endif; ?>

    <div class="field">
        <label for="email" class="label">Email:</label>
        <div class="control has-icons-left">
            <span class="icon is-left">
                <ion-icon name="mail"></ion-icon>
            </span>
            <input value="<?= $email ?? '' ?>" type="text" name="autor[email]" id="email" class="input" placeholder="exemplo@gmail.com" required>
        </div>
    </div>

    <?php if (isset($notifications) && in_array('senhaVazia', $notifications)) : ?>
        <div class="notification is-danger is-light">A senha não pode estar vazia.</div>
    <?php endif; ?>

    <?php if (isset($notifications) && in_array('senhaPequena', $notifications)) : ?>
        <div class="notification is-danger is-light">A senha não pode ter menos que 8 caracteres.</div>
    <?php endif; ?>

    <div class="field">
        <label for="senha" class="label">Senha:</label>
        <span class="subtitle is-7">(digite uma senha com no mínimo 8 caracteres)</span>
        <div class="control has-icons-left">
            <span class="icon is-left">
                <ion-icon name="key"></ion-icon>
            </span>
            <input type="password" name="autor[senha]" id="senha" class="input" placeholder="********" required>
        </div>
    </div>

    <div class="field">
        <div class="control">
            <input type="submit" name="submit" value="Registrar" class="button is-success">
        </div>
    </div>
</form>