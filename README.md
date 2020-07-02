# PHP Novice To Ninja

Sistema desenvolvido durante a leitura do livro [PHP Novice To Ninja](https://www.amazon.com/PHP-MySQL-Novice-Ninja-Speed/dp/0994346980), com anotações e dicas retiradas do livro.  

Nesse projeto foi utilizado o Apache 2 como servidor web, MySQL como servidor de Banco de Dados e PHP 7.4. Para o frontend foi utilizado o framework Bulma.

Aplicação web hospedada no 000webhost: [https://recursoslivres.000webhostapp.com/](https://recursoslivres.000webhostapp.com/)
# Sintaxe do PHP

PHP é uma linguagem que roda dentro de um servidor web. Ao receber uma requisição HTTP o servidor web irá verificar os arquivos dentro da sua pasta pública (nesse caso `public_html`), se houver um arquivo `index.php`, ele será executado pelo interpretador PHP. Dentro de scripts, o código a ser executado está contido dentro do bloco `<?php ?>`. O que estiver fora desse bloco será enviado como `html` para o servidor.

>A parte `?>` é opcional caso não haja código html depois do script php, e é uma boa prática evitar seu uso quando não for necessário.  

PHP consiste em uma série de comandos. Cada comando é uma instrução que deve ser seguida até o fim antes que o interpretador passe para o próximo comando. Comandos PHP sempre terminam com `;`.  

Por exemplo:

```PHP
<?php
echo '<h2>Hello World</h2>';
```

`echo` é uma função que exibe o texto dado na saída, que nesse caso é um arquivo HTML a ser enviado para o navegador. Tudo que estiver entre aspas é considerado pelo PHP como **string**.  

>É possível utilizar aspas simples ou duplas, porém programadores PHP preferem aspas simples, pois o código HTML já utiliza aspas duplas.  

## Variáveis

Variáveis em PHP são reconhecidas pelo símbolo `$`. Ex: `$soma`. PHP é uma linguagem fracamente tipada, logo variáveis podem conter qualquer tipo de dados. É possível atribuir valores a uma variável com `=`. Ex:  

```PHP
$soma = 1 + 1;
```

## Operadores, comentários

Os operadores em PHP são os mesmos de outras linguagens como Java ou C: +, -, /, *, %. Comentários são inseridos com `//` e `/* */`. Um operador diferente em PHP é o operador de concatenação de strings, um ponto (`.`). Por exemplo:  

```PHP
$nome = 'Maria' . $sobrenome;
```

>Variáveis com strings: Ao utilizar variáveis dentro de aspas duplas, o valor da variável será impresso. Porém com aspas simples deve-se utilizar concatenação para conseguir o mesmo efeito. Por Exemplo:  

```PHP
$nome = 'Maria';
echo "$nome é uma aluna."; //Maria é uma aluna.
echo '$nome é uma aluna.'; //$nome é uma aluna.
echo $nome . ' é uma aluna.'; //Maria é uma aluna.
```

## Estrutura de controle e operadores lógicos

As estruturas de controle em PHP são as mesmas de linguagens como Java, C... Porém com a adição de `elseif`. Para comparar dois valores é possível utilizar `==` ou `===`. O primeiro exige que as duas variáveis tenham o mesmo valor, o segundo impõe que além de ter o mesmo valor, sejam do mesmo tipo. Os outros operados são iguais aos de outras linguagens: || e &&.  

>Em PHP é possível utilizar `and` e `or`, porém não são recomendados.  

## Looping

Os comandos de looping em PHP também são similares a outras linguagens:  
- for
- while
- do ... while

PHP possui o comando de loop foreach em duas formas:  

```PHP
foreach($array as $elemento) {
    //código
}

foreach($chave => $valor) {
    //código
}
```

## Arrays

Arrays em PHP são delimitados por colchetes como em outras linguagens. PHP permite que Arrays armazenem valores de quaisquer tipos. Exemplo:  

```PHP
$array = ['nome', 5, 10.0];
```

Os valores podem ser acessados por índice, a partir de 0 (`$array[0]`). Para inserir um novo valor no final do array é só utilizar os colchetes vazios com o operador de atribuição. Exemplo:  

```PHP
$array[] = 'novo valor';
```

Para adicionar ou modificar um índice específico deve-se apenas realizar uma atribuição:  

```PHP
$array[2] = 15.5;
```

ou da forma `chave => valor`  

```PHP
$array[
    2 => 15.5
];
```

Em PHP existe uma estrutura chamada **Array Associativo**, é um tipo de array em que podem ser utilizados strings como índices para os valores no array. Exemplo:  

```PHP
$aluno = [
    'nome' => 'Fulano',
    'nota' => 5
];
echo $aluno['nota']; //Imprime 5
```

>Existem algumas valores especiais que podem ser vistos como comandos dentro de uma string, logo deve-se usar `\` para imprimir esses caracteres, como `\'` ou `\\`.  

# Formulários

Uma aplicação PHP só é executada a partir de uma requisição de um cliente. Existem duas formas de se passar valores para um aplicação PHP, com **query string** ou no corpo da mensagem HTTP, com o método `POST`.  

## Query String

Em uma URL, tudo que vier após o sinal `?` e antes do sinal `#` é parte da **query string**. **Query String** é uma forma de passar valores, separados por `&`, na própria URL para a aplicação rodando no back-end. Esses valores por ser acessados pela variável global `$_GET`, um array associativo. Exemplo:  

URL: http://www.exemplo.com/?nome=Juliana&sobrenome=Almeida  

```PHP
echo $_GET['nome']; // Irá imprimir Juliana
echo $_GET['sobrenome']; // Irá imprimir Almeida
```

>Para facilitar verificar o valor de variáveis e encontrar erros é possível utilizar a função nativa `var_dump()`. Essa função recebe uma variável como argumento e imprime o tipo e seu valor. Se for um objeto ou um array também irá exibir valores seus valores internos.  

>Antes de imprimir qualquer valor na saída é preciso se certificar de que não haverá comandos HTML na saída que irá para o navegador, para evitar o ataque [Cross-Site Scripting](https://github.com/ismaelcostarc/PHPConceitos/blob/master/seguranca.md#10-ataques-ou-vulnerabilidades-em-aplica%C3%A7%C3%B5es-php). É possível fazer isso com a função nativa `htmlspecialchars()`, que transformará todos os caracteres que poderiam ser interpretados como código HTML em entidades HTML. Ex:  

```PHP
$text = '<script>alert("Teste")</script>';
echo $text;                     //irá criar uma caixa de alerta no navegador do usuário
echo htmlspecialchars($text, ENT_QUOTES, 'UTF-8');   //irá imprimir o texto correto (<script>alert("Teste")</script>) no documento HTML
```

`ENT_QUOTES` é uma constante PHP, constantes não precisam do símbolo `$` para serem utilizadas. Essa constante diz ao PHP para converter também as aspas, além de caracteres como `<` e `>`. `UTF-8` diz à função qual codificação utilizar para imprimir o texto no documento HTML. 

Além de inserir manualmente os valores na URL é possível enviar valores na **query string** utilizando o método `GET` em formulários HTML. Exemplo:

```HTML
<form action="index.php" method="GET">
    <input type="text" name="nome">
    <input type="text" name="sobrenome">
    <input type="submit">
</form>
```

Se forem digitados os valores `Maria` e `da Silva`, a URL gerada será `http://meusite.com/index.php?nome=Maria&sobrenome=da+Silva`.

```PHP
$nome = $_GET['nome']; //'Maria'
$sobrenome = $_GET['sobrenome'];//'da Silva'

echo 'Olá' . htmlspecialchars($nome, ENT_QUOTES, 'UTF-8') . ' ' . htmlspecialchars($sobrenome, ENT_QUOTES, 'UTF-8');
//Olá Maria da Silva
```

## POST

Também é possível enviar valores para a aplicação web por meio do método `POST` em formulários, porém nesse caso os valores vão ser enviados no corpo da requisição web, não na **query string** da URL. Exemplo:

```HTML
<form action="index.php" method="POST">
    <input type="text" name="nome">
    <input type="text" name="sobrenome">
    <input type="submit">
</form>
```

Se forem digitados os valores `Maria` e `da Silva`, a URL gerada será `http://meusite.com/index.php`.

```PHP
$nome = $_POST['nome']; //'Maria'
$sobrenome = $_POST['sobrenome'];//'da Silva'

echo 'Olá' . htmlspecialchars($nome, ENT_QUOTES, 'UTF-8') . ' ' . htmlspecialchars($sobrenome, ENT_QUOTES, 'UTF-8');
//Olá Maria da Silva
```

## GET ou POST

Por convenção se utiliza o método GET quando nenhuma informação será modificada no servidor, como uma busca. Quando o método GET é usado é possível atualizar a página, marcar como favorita, enviar para outras pessoas e não haverá nenhum efeito colateral. Já o método POST é utilizado quando alguma informação será modificada no servidor, como criar um cadastro ou deletar um usuário. Nesse caso não é uma operação considerada *segura*, logo se o usuário tentar atualizar a página, aparecerá um alerta.  

O método POST ao contrário do que muitos pensam não é mais seguro que o método GET em relação ao roubo de informações. Apesar de que com o método POST os valores não aparecerão na URL, eles estarão no corpo da mensagem HTTP, que é visível para os navegadores.

# PHP Templates

É uma boa prática separar o conteúdo HTML da aplicação, da lógica que ocorre no servidor. Para isso existem os templates, arquivos que possuem em sua maior parte apenas HTML, com poucas variáveis PHP apenas nos locais necessários. Então existe um código php que realizará a lógica da aplicação, e um template que conterá o visual.  

Por exemplo, um arquivo index.php:  

```PHP
<?php
$output = '';
for ($count = 1; $count <= 10; $count++) {
    $output .= $count . ' ';
}
include 'count.html.php';
```

e o arquivo count.html.php:  

```PHP
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Counting to Ten</title>
    </head>
    <body>
        <p>
        <?php echo $output; ?>
        </p>
    </body>
</html>
```

O comando `include` funciona como uma forma de copiar e colar. Ele apenas pega o conteúdo do arquivo especificado e cola no local que a função foi chamada.

>Segurança: Para evitar que o usuário possa acessar o template diretamente, ou outros arquivos php, é uma boa prática deixar apenas o script php inicial na pasta pública. O servidor tem acesso apenas a arquivos da pasta pública, porém o interpretador PHP pode acessar qualquer arquivo externo. É possível então criar uma pasta **Templates** fora da pasta pública, e utilizar os templates apenas quando necessários e por meio do script php central. Logo o script php seria:

```PHP
<?php
$output = '';
for ($count = 1; $count <= 10; $count++) {
    $output .= $count . ' ';
}
include __DIR__ . '/../templates/count.html.php';
```

>`__DIR__` é uma constante que possui o caminho absoluto do diretório principal. É uma boa prática utilizar o include com `__DIR__`, pois o include busca as pastas a partir da pasta pública, não a partir do diretório atual do script que está sendo executado. Utilizando `include __DIR__ .` estamos dizendo ao interpretador para iniciar a busca a partir do diretório atual.

>Um script PHP que receba requisições HTTP e escolha qual template utilizar é chamado **Controller**. É uma boa prática arquitetural utilizar apenas um Controlador na pasta pública, que será chamado de **Front Controller**.

# Banco de Dados

Existem 3 formas de conectar uma aplicação PHP a um Banco de Dados MySQL:

- A Biblioteca MySQL;
- A Biblioteca MySQLi;
- A Biblioteca PDO.

A biblioteca MySQL já está depreciada e não deve ser utilizada. A Biblioteca PDO tem se tornado mais comum, pois permite a conexão com qualquer banco de dados, não somente com MySQL. Para realizar a conexão com o servidor de banco de dados MySQL:

```PHP
$pdo = new PDO('mysql:host=localhost;dbname=databasename;charset=utf8','user','password');
```

>É importante dizer ao PHP qual codificação utilizar ao enviar dados ao banco de dados, por isso é importante inserir `charset=utf8`, ou ele utilizará codificações mais básicas como ISO-8859-1 (ou Latin-1).

>Realize a conexão com o Banco de Dados apenas quando necessária. A conexão com o servidor de Banco de Dados é um dos motivos para gargalos na aplicação, logo é recomendável evitar, quando possível.

É possível realizar todas as operações com o banco de dados a partir dos métodos do objeto `$pdo`.

## Tratamento de exceções

Se não for possível realizar a conexão com o banco de dados ou alguma operação falhar será lançada uma exceção. Além de não ser visualmente agradável para o usuário, uma exceção não capturada pode acabar exibindo informações sensíveis sobre o sistema, como senhas. Então **toda** exceção deve ser capturada. A captura de exceções em PHP é similar a Java:

```PHP
try {
// do something risky
}
catch (ExceptionType $e) {
// handle the exception
}
```
A exceção lançada por pelo PDO é do tipo PDOExpection. Logo a conexão com o banco de dados fica da seguinte maneira:  

```PHP
try {
    $pdo = new PDO('mysql:host=localhost;dbname=databasename;charset=utf8','user','password');
    $output = 'Database connection established.';
}
catch (PDOException $e) {
    $output = 'Unable to connect to the database server.';
}
```
Quando uma exceção é lançada o bloco try é imediatamente interrompido, e o script passa a executar o bloco catch.

# Orientação a Objetos em PHP

PHP suporta tanto programação procedural quanto orientada a objetos. Objetos são criados em PHP com o uso da palavra reservada new. É possível acessar suas propriedades e métodos com o urso da seta (->).

```PHP
$objeto = new ClasseDoObjeto();
$objeto->propriedade = valor;
$objeto->metodo();
```

>Após conectar com sucesso ao banco de dados, o objeto $pdo possui o comportamento padrão de não lançar mais exceções. É bom que todos os erros lancem exceções para facilitar encontrar e corrigir erros. É preciso usar o seguinte método do objeto $pdo:

```PHP
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
``` 

`PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION` são constantes da classe PDO. 

A exceção PDOException possui métodos interessantes para o ambiente de desenvolvimento (**Dados sobres os erros e exceções lançados não devem aparecer em ambiente de Produção**). Por exemplo:

```PHP
catch(PDOException $e) {
    echo $e->getMessage();    //Mostra a mensagem de erro da exceção
    echo $e->getFile();       //Mostra em qual arquivo ocorreu o erro
    echo $e->getLine();       //Mostra a linha do erro
}
```

>É possível forçar a desconexão com o banco de dados com o seguinte comando `$pdo = null`, porém geralmente não é necessário, já que o PHP automaticamente encerra a conexão no fim do script.

# Enviando Queries para o Banco de Dados

É possível executar comandos SQL com o método `exec`, que retorna o número de linhas afetadas. Logo o código completo para uma consulta fica:

```PHP
try {
    $pdo = new PDO('mysql:host=localhost;dbname=database;charset=utf8', 'user', 'password');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'UPDATE joke SET jokedate="2012-04-01" WHERE joketext LIKE "%programmer%"';
    $affectedRows = $pdo->exec($sql);
    $output = 'Updated ' . $affectedRows .' rows.';
}
catch (PDOException $e) {
    $output = 'Database error: ' . $e->getMessage() . '
    in ' .$e->getFile() . ':' . $e->getLine();
}

include __DIR__ . '/../templates/output.html.php';
```

Para consultas que retornem uma tabela existe o método `query()`, que retorna um objeto representando a tabela. Esse objeto possui o método `fetch()` que retorna a próxima linha sempre que é executado, e `false` quando chega no final da tabela, e `fetchAll()` que retorna um array com todas as linhas da tabela.  

```PHP
$query = 'SELECT * FROM `TABLE1`';
$result = $pdo->query($query);
while ($row = $result->fetch()) {
    $ids[] = $row['id'];
}

//ou

foreach ($result as $row) {
        $ids[] = $row['id'];
}
```

>É uma boa prática colocar o nome de tabelas, schemes e colunas entre crases para evitar que haja confusão com comandos SQL.

>Para inserir os resultados no template é possível utilizar a notação `<?= $variavavel ?>`, ela é equivalente a `<?php echo $variavel ?>.` Os comandos if, else e foreach também possuem versões curtas para serem utilizadas em templates:

```PHP
<?php if($variavel == 0): ?>
    //código HTML
<?php else: ?>
    //código HTML
<?php endif; ?>

//foreach:

<?php foreach($array as $item): ?>
    //código HTML
<?php? endforeach; >
```

>Existe uma função nativa no PHP chamada `isset()`, com ela é possível verificar se tal variável existe. Então é possível criar um erro, caso ocorra, inserir na variável `$error`, e utilizar `if(isset($error))` no template para exibir a mensagem de erro.  

# Output Buffer

Para se trabalhar com mais de um template no mesmo código se torna complicado utilizar apenas includes, pois quando a função include é chamada ela imediatamente imprime o conteúdo do template no browser. Em algumas situações queremos que esse conteúdo esteja dentro de outro template, como um template de layout. Para isso se utilizam as funções de Output Buffer.
- `ob_start()`: Essa função iniciar o buffer de saída. Então tudo que for impresso será capturado, e não enviado para o browser.
- `ob_get_clean()`: Essa função retorna tudo que foi capturado após o início do Output Buffer.

Exemplo:  

```PHP
ob_start();

include __DIR__ . '/../templates/conteudo.html.php';

$output = ob_get_clean();

include __DIR__ . '/../templates/layout.html.php';
```

Nesse exemplo o layout pode utilizar o conteúdo com a variável $output. 

# MySQL e PHP

## Passando datas para o MySQL

O próprio MySQL possui uma função pronta que insere a data atual no formato aceito pelo banco de dados: `CURDATE()`.  

## SQL Injection

É preciso ter cuidado ao enviar para o MySQL dados vindos do usuário, pois podem conter comandos SQL maliciosos (Ataque **SQL Injection**). Então antes de qualquer inserção é necessário tratar os dados vindos do cliente. Por exemplo, se o dado inserido de um usuário estiver na variável global $_POST['nome']:

```PHP
//Primeiro é preciso avisar ao sql onde estará o dado enviado pelo usuário com :nome
$sql = 'INSERT INTO `tabela` SET `nome` = :nome';

//O objeto que está realizando a conexão com o banco de dados ($pdo) irá preparar a inserção
//tomando os devidos cuidados, e devolverá um objeto
$stmt = $pdo->prepare($sql);

//O MySQL já está ciente dos locais que receberão valores do usuário, então já
//podemos inserir esses dados nos locais corretos
$stmt->bindValue(':recursoTexto', $_POST['recurso']);

//O comando SQL já pode ser executado com segurança
$stmt->execute();
```