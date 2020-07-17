<h2 class="title is-4">Entrar</h2>

<form action="" method="POST">
    <?php if (isset($notifications) && in_array('emailOuSenhaErrada', $notifications)) : ?>
        <div class="notification is-danger is-light">O email e/ou a senha estão incorretos.</div>
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
            <input value="<?= $email ?? '' ?>" type="email" name="autor[email]" id="email" class="input" placeholder="exemplo@gmail.com" required>
        </div>
    </div>

    <?php if (isset($notifications) && in_array('senhaVazia', $notifications)) : ?>
        <div class="notification is-danger is-light">A senha não pode estar vazia.</div>
    <?php endif; ?>

    <div class="field">
        <label for="senha" class="label">Senha:</label>
        <div class="control has-icons-left">
            <span class="icon is-left">
                <ion-icon name="key"></ion-icon>
            </span>
            <input type="password" name="autor[senha]" id="senha" class="input" placeholder="********" required>
        </div>
    </div>

    <div class="field">
        <div class="control">
            <input type="submit" name="submit" value="Entrar" class="button is-success">
        </div>
    </div>
</form>