# PHP Novice To Ninja

# Recursos Livres

Sistema para criação de listas de Materiais Gratuitos na internet, inspirado pela leitura do livro [PHP Novice To Ninja](https://www.amazon.com/PHP-MySQL-Novice-Ninja-Speed/dp/0994346980), com anotações feitas durante a leitura. 

Foram utilizados o Apache 2 como servidor web, MySQL como servidor de Banco de Dados e PHP 7.4. Para o frontend foi utilizado o framework Bulma. No backend foi utilizado o framework simples desenvolvido em PHP puro durante a leitura do livro, que será chamado de [Ninja]().

Aplicação hospedada no 000webhost: [https://recursoslivres.000webhostapp.com/](https://recursoslivres.000webhostapp.com/)

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

foreach($array as $chave => $valor) {
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

>Um script PHP que receba requisições HTTP e escolha qual template utilizar é chamado **Controller**. É uma boa prática arquitetural utilizar apenas um Controlador na pasta pública, que será chamado de **Front Controller** ou **Single Entry Point**.

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

PHP suporta tanto programação procedural quanto orientada a objetos. Objetos são criados em PHP com o uso da palavra reservada new. É possível acessar suas propriedades e métodos com o uso da seta (->).

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
- `ob_start()`: Essa função inicia o buffer de saída. Então tudo que for impresso será capturado, e não enviado para o browser.
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

# PHP Estruturado

## Tipos de Includes

- `include`;
- `require`;
- `include_once`;
- `require_once`.

As diferenças entre `include` e `require` são que se ocorrer algum erro no script incluído, `include` irá continuar o código normalmente. Já `require` irá interromper a execução do código imediatamente. Já `include_once` e `require_once` incluem o script apenas uma vez. Caso o script já tenha sido incluído antes, o comando é ignorado. É útil para operações custosas ou sensíveis que devem ser executadas apenas uma vez, como conexão ao Banco De Dados.  

## Funções

Funções em PHP seguem o seguinte modelo:

```PHP
function area($largura, $altura) {
    return $largura * $altura;
}
```

## Escopo das Variáveis

Variáveis em PHP possuem dois escopos: escopo local e escopo global. Uma variável declarada dentro de uma função terá escopo local e só poderá ser acessada dentro da própria função. Variáveis declaradas fora de funções terão escopo global e só poderão acessadas fora de funções. Para utilizar uma variável global dentro de uma função é necessário passar a variável como argumento, em um processo chamado **Injeção de Dependências**.  

## Argumentos

É possível dizer ao PHP o valor padrão de um argumento, caso não seja passado quando a função for chamada, da seguinte forma:  

```PHP
function soma($primeiro = 1, $segundo = 2) {
    return $primeiro + $segundo;
}

soma(); //retorna 3
soma(2); //retorna 4
```

## Datas em PHP

A classe `DateTime` pode ser usada para representar datas em PHP e formatar elas de diferentes formas:

```PHP
$date = new DateTime();
echo $date->format('d/m/Y H:i:s');
```

Quando um objeto `DateTime()` é instanciado sem argumentos a data gerada é a atual. É possível criar objetos `DateTime` a partir de strings, passando a string como argumento para o construtor. Ex:

```PHP
$date = new DateTime('5th March 2019');
echo $date->format('d/m/Y');
```

>Datas e tempo em MySQL sempre são armazenados no seguinte formato: `YYYY-MM-DD HH:MM:SS`.

## Null coalescing operator

No PHP 7 foi introduzido o **Null coalescing operator**, que realiza a operação "Se essa variável existir imprima ela, caso contrário imprima o seguinte". Exemplo:

```
<?= $resultado ?? 'Ocorreu um erro.' ?>
```

# Objetos e Classes

Tal como variáveis, classes podem conter quaisquer tipos de caracteres alfanuméricos nos seus nomes. Contudo, caracteres especiais como `-, +, *, /, {` ou espaço não são permitidos. Por convenção, nomes de classes em PHP utilizam **CamelCase**, começando com uma letra maiúscula, com o restante dos caracteres em letra minúscula, até a próxima palavra. Também, por convenção, utiliza-se uma classe por script, ambos com o mesmo nome.

Classes são modelos para construir objetos que possuem propriedades e métodos. Para criar um objeto de uma classe é utilizado o método especial __construct. É possível especificar o acesso a propriedades e métodos como privados ou públicos. Para as propriedades e métodos da própria classe é preciso utilizar a variável `$this`. Sintaxe:

```PHP
class {
    //Propriedades
    private $nome;
    private $notas;

    public function __construct($nome, $notas) {
        $this->nome = $nome;
        $this->notas = $notas;
    }
}
```

 ##  Type Hinting

 Para evitar que os argumentos sejam passados a um método de forma incorreta, é possível dizer ao interpretador PHP qual o tipo de cada argumento. Exemplo:

 ```PHP
 public function __contruct(string $nome, array $notas) {
     //...
 }
 ```

 Este é um aspecto da **Programação Defensiva** em PHP, um conjunto de técnicas de prevenção de bugs.

 # URLs Amigáveis

 Recursos podem ser acessados de duas formas. Podem ser arquivos reais existentes no servidor, como `http://exemplo.com/minhapagina.html`, ou podem ser construídos pelo servidor. Nesse segundo caso a URL necessita apenas receber as variáveis necessárias para saber como construir esse recurso. Essas variáveis podem ser passadas de duas formas: em *query strings* ou simulando o formato de pastas com **URL Rewriting** ou **URLs Amigáveis**. No formato de *query string* a URL seguiria o seguinte formato: `http://exemplo.com/?controller=alunos&action=adicionar&matricula=355`. Utilizando URLs Amigáveis ficaria: `http://exemplo.com/alunos/adicionar/355`.  

 Para que o servidor reconheça que o restante da URL após o domínio não são pastas, mas variáveis, é necessário configurar ele. No Apache, por exemplo, é possível informar os seguintes comandos no arquivo `.htaccess` na pasta pública:

 ```
 RewriteEngine On
 RewriteCond %{REQUEST_FILENAME} !-f
 RewriteCond %{REQUEST_FILENAME} !-d
 RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]
 ```

 No exemplo acima tudo que vier após o nome de domínio fica registrado na variável `url`. Se `http://exemplo.com/alunos/adicionar/355` for digitado no navegador, é possível acessar os valores com `$_GET['url'];` no script PHP. Existem várias formas de realizar a passagem de parâmetros para o código PHP, ficando a cargo do programador decidir.

 # Controllers

 *Controllers* são classes que definem qual template utilizar e quais dados enviar para esse template. O *controller* principal que decide qual controller específico utilizar é chamado **Front Controller** ou **Single Entry Point** e é o primeiro script a ser executado pela aplicação. Cada método em um objeto *controller* é chamado de **action**. Em uma aplicação de uma escola, por exemplo, poderíamos ter um *controller* para alunos, um para os professores, um para terceirizados, etc. O *Front Controller* dessa aplicação poderia receber uma requisição para verificar a média de notas de todos os alunos, logo ele escolheria o *controller* responsável pelos alunos, e o *action* que realiza a função de tirar a média das notas.  

 Por motivos de organização de código, cada *action* retorna variáveis que serão utilizados pelo layout, e um array interno com as variáveis específicas para aquele template. Por exemplo:

 ```PHP
 return [
     'titulo' => 'Média das notas de cada aluno',
     'menuAba' => 'alunos',
     'variaveis' => [
         'mediaNotas' => $mediasNotas,
         'quantidadeAlunos' => $quantidadeAlunos
     ]
 ];
 ```

 ## Extract

 Quando o *Front Controller* receber o array associativo com a resposta do controller específico, é possível separar o array em variáveis diferentes com a função `extract($array)`.

 >Antes de utilizar `extract($variaveis)` certifique-se de que essa operação seja realizada em um escopo diferente (dentro de uma função por exemplo), para evitar que haja conflitos de nomes, pois uma variável do template pode ter o mesmo nome que o variável utilizada pelo layout, como `titulo`.

 ## Rotas e Recursos

 Em aplicações modernas recursos não existem como arquivos físicos no servidor, quando um cliente solicita um recurso, a aplicação irá construir o recurso dependendo do *Controller* indicado, da *action* a ser tomada e da identificação do recurso específico. *Rotas* podem ser definidas como sendo o "endereço" de um recurso, elas podem indicar o *Controller* e passar a identificação do recurso específico que está sendo solicitado. Por exemplo, se o cliente solicita as notas de um aluno de matricula `348336`:

 ```
 http://escola.com/alunos/348336
 ```
 
 Neste caso a rota é `alunos/348336`. Nesse exemplo a URL informa ao servidor o *controller* a ser utilizado e a identificação do recurso, porém não informa qual *action* será chamada. Em aplicações que utilizam APIs REST é uma prática comum associar a *action* ao verbo HTTP. Por exemplo, para obter a nota do aluno cuja matrícula é `348336` o cabeçalho da requisição HTTP ficaria da seguinte forma:

 ```
 GET http://escola.com/alunos/348336 HTTP/1.1
 ```

 Em aplicações mais simples é possível também informar a *action* na própria rota:

 ```
 http://escola.com/alunos/obter/348336
 ```
 
 Enfim, a decisão de como deve ser feito o roteamento depende muito do framework utilizado, de algum padrão seguido e de decisões de arquitetura.

 ## Search Engines

 Em PHP, funções **não** são *case-sensitive*. Logo, se uma requisição especificar a ação específica, independente se escrever com letras minúsculas ou maiúsculas receberá o mesmo recurso. Por exemplo, `http://escola.com/alunos/obter/348336` e `http://escola.com/alunos/OBTER/348336` chamarão a mesma *action*: `obter`. Apesar de que a princípio isso não pareça ser problema, buscadores como Google tratam esse comportamento como páginas repetidas, jogando essas URLs para as últimas posições ou sequer exibindo elas. Para evitar isso é necessário tratar a URL digitada. É possivel checar se a URL está totalmente em minúscula, e caso não esteja, redirecionar para o endereço totalmente em minúsculo, tendo o cuidado de utilizar o código de resposta HTTP 301 Moved Permanently. Em PHP é feito da seguinte forma:

 ```PHP
 //A função strlower() torna todos os caracteres da string recebida em minúsculos
 if($route == strlower($route)) {
     $Controller->$action();
 } else {
     //Insere o código de resposta HTTP 301
     http_response_code(301);
     //Realiza o redirecionamento
     header('location: index.php/' . strlower($route));
 }
 ```

 ## Injeção de Dependências

 Os objetos que um determinado objeto necessita receber como argumentos são chamados **Dependências**. Muitas vezes não sabemos qual objeto estaremos utilizando, logo se torna um problema decidir quais serão os objetos a serem passados como parâmetros. Esse problema é conhecido como **Injeção de Dependências**, e existem diversas soluções propostas, porém nenhum é aceita como o melhor padrão.

 Por exemplo, em uma aplicação web teremos classes de **Controllers** porém não sabemos qual delas será chamada, e logo quais dependências ela necessitará.

 ## Autoloading, Namespaces e Composer

 *Namespaces* são um recurso do PHP para evitar que haja conflitos entre classes e pacotes. Sempre que uma classe declara estar dentro de um *namespace* é criada um diretório *virtual*. Por exemplo:

 ```PHP
 namespace Alunos;

 class AlunosController {
     //....
 }
 
 //------------ Em outro script

 $alunosController = new \Alunos\AlunosController();

 //------------ OU

 use \Alunos\AlunosController;

 $alunosController = new AlunosController();
 ```

 Também é possível usar namespace em *type hinting*:

 ```PHP
 function exemplo(\Alunos\AlunosController $controller) {
     //...
 }
 ```

 Dentro de classes que estão em *namespaces*, objetos de classes próprias do PHP necessitam do caractere `\` antes dos nomes, pois elas não pertencem ao *namespace* da classe, mas ao *namespace* **root** (`\`). Por exemplo:

  ```PHP
 namespace Alunos;

 class AlunosController {
    public function __construct(\PDO $conexaoBancoDeDados) {
        //...
    }
 }
 ```

 Conforme o código cresce, aumentam o número de *includes* e *requires* para cada script utilizado. Para diminuir a quantidade de código foi criado o **Autoloading**. Sempre que um objeto é instanciado ou *type hinting* for utilizado, e o script da class não estiver sido incluído com *include* ou *require*, a função *autoloader* irá buscar a classe no *namespace* de mesmo nome. Para informar ao interpretador PHP onde cada namespace está localizado é possível construir uma função própria, ou utilizar o gerenciador de dependências **Composer**. No arquivo `composer.json` basta informar:

 ```JSON
 {
    "name": "...",
    "authors": [
        {
            "name": "...",
            "email": "..."
        }
    ],
    "require": {},
    "autoload": {
        "psr-4": {
            "Alunos\\": "classes/Alunos",
            "Project\\": "classes/Project",
            "Namespace\\": "caminho do namespace"
        }
    }
}
 ```

 Feito isso, já será possível retirar todos os *includes* e *requires* para as classes.

 # Interfaces

 Tal como Java, em PHP é possível forçar que uma classe siga um padrão já especificado com o uso de **Interfaces**. Para se criar uma interface:

 ```PHP
 interface Routes {
     public function getRoutes();
 }
 ```

 Interfaces contém somente o cabeçalho dos métodos, a implementação fica a cargo das classes:

 ```PHP
 class AlunosRoutes implements Routes {
     public function getRoutes() {
         //Código
     }
 }
 ```

 Caso a classe não siga as regras da interface, o interpretador apresentará um erro.

 # Validação de Dados

 É necessário sempre validar as informações tanto do lado do cliente quanto do lado servidor. Do lado do cliente é possível validar os dados com HTML e Javascript. O atributo required em tags input no HTML exige que os campos não estejam em branco. O uso de tipos corretos de input também serve como uma validação.  

 Do lado do servidor podemos verificar cada dado, e caso algum esteja incorreto retornar novamente à página do formulário preenchida e com os avisos necessários.
 
 >Para evitar campos em branco é preferível utilizar a função `empty($campo)` invés de comparar a entrada a uma string vazia, `$campo == ''`, pois usuários maliciosos podem enviar um formulário sem sequer preencher nenhum campo, logo as variáveis sequer existirão. A função `empty()` verifica se a variável existe e possui valor.

 # Segurança de Senhas

 Existem diversas formas de armazenar senhas no Banco de Dados, porém atualmente a função mais segura é `password_hash($senha, PASSWORD_DEFAULT);`.

 # Cookies e Sessões

 O protocolo HTTP por padrão é **stateless**, ou seja, ele não armazena estados sobre o cliente. Porém é possível realizar isso com o uso de **cookies**. *Cookies* são pares nome-valor armazenados no cliente que podem ser transmitidos entre o cliente e servidor no cabeçalho de mensagens HTTP. Quando um cookie for enviado por um cliente pela primeira vez, todas as futuras requisições para o mesmo site utilizarão o conteúdo armazenado no *cookie*.  

 ## Ciclo de vida de um cookie gerado pelo PHP

 1. O navegador requisita uma URL que corresponde a um script PHP. Dentro do script é realizada uma chamada à função nativa `setcookie`.
 2. A página produzida pelo script PHP é enviada de volta para o navegador com um cabeçalho HTTP `set-cookie` que contém o nome e o valor do *cookie*.
 3. Quando recebe a resposta HTTP, o navegador armazena o *cookie* que veio no cabeçalho.
 4. As próximas requisições HTTP para a mesma URL conterão um cabeçalho contendo o nome e o valor do *cookie*.
 5. Quando o script PHP recebe uma requisição que contenha um *cookie* ele conseguirá acessar o nome e valor com o array associativo global $_COOKIE, contendo os nomes e valores dos cookies.  

>A função `setcookie()` deve ser chamada antes que qualquer envio seja feito para o cliente.

O único parâmetro obrigatório é o nome do *cookie*. Chamando a função `setcookie()` com apenas o nome do *cookie* irá deletar o *cookie* armazenado no cliente. Para criar ou modificar um *cookie* é necessário passar também um valor após o nome.  

Por padrão o *cookie* ficará armazenado no navegador até que ele seja fechado. Para que o *cookie* possa ser utilizado novamente é preciso informar em quanto tempo em que ele irá expirar. O formato de tempo padrão a ser utilizado é o **Unix Timestamp**. A função `time()` em PHP retorna a data atual no formato *Unix Timestamp*. Para informar ao navegador em quanto tempo o *cookie* irá expirar, acrescente o tempo em segundos. Por exemplo, para criar um *cookie* com duração de 1 ano:

```PHP
setcookie('nome', 'valor', time() + 3600 * 24 * 365);

//Para deletar ele
setcookie('nome', '', time() + 3600 * 24 * 365);
```

Outros parâmetros opcionais são parâmetros para informar o diretório, domínio e segurança. Mais informações na [Documentação oficial](https://www.php.net/manual/pt_BR/function.setcookie.php).  

*Cookies* são úteis para armazenar informações pequenas, como a quantidade de visitas no site, porém se torna inviável para armazenar dados grandes. Logo para aplicações grandes, como redes sociais ou e-commerces, **sessões** são mais úteis.

## Sessões

Sessões são dados do cliente armazenados no servidor (em um diretório configurado no php.ini, geralmente `/tmp` para Linux). Para acessar esses dados é necessário apenas um *cookie* com a identificação de acesso a esses dados. Por exemplo, para uma rede social, o primeiro login irá gerar um *cookie* de sessão com o login e senha do usuário. Para que em toda nova tela da rede o usuário não precise logar novamente, o *cookie* de sessão é enviado na requisição HTTP, autenticando o usuário.  

Para dizer ao PHP para verificar se já existe uma sessão ativa, ou criar uma nova, utilizamos a função `session_start()`. Após uma sessão ser iniciada, podemos inserir valores nela com a variável global `$_SESSION`. Por exemplo:

```PHP
session_start();
$_SESSION['myPassword'] = 'myPassword';

//Para remover a variável da sessão atual
unset($_SESSION['myPassword']);
//Se quisermos destruir a sessão atual
$_SESSION = [];
session_destroy();
```

## Logging

Para realizar o login de um usuário e manter ele, existem duas abordagens:

1. Podemos logar o usuário utilizando uma variável de sessão como uma "*flag*" (Por exemplo, `$_SESSION['userId'] = $userId`). Nas próximas páginas da aplicação podemos checar se está variável de sessão existe e ler o ID do usuário a partir dela.
2. Podemos armazenar tanto o e-mail quanto a senha de usuário na sessão. Quanto o cliente realizar novas requisições verificamos o e-mail e a senha e autenticamos novamente consultando o banco de dados.

A primeira opção é mais leve, porém a segunda é mais segura, logo sendo preferível utilizar ela.

>É uma boa prática autenticar novamente o usuário a cada página, pois se ele estiver acessando de dispositivos diferentes e modificar a senha ou o e-mail em um deles, o outro dispositivo já exigirá as novas credenciais.

>Na variável de sessão não armazene a senha que o usuário digitou, mas a senha "hasheada" do banco de dados.

## Session Fixation

Após um login bem sucedido, o ID do cookie da sessão deve ser modificado. Isso evita que hackers roubem o ID de um usuário e tentem se passar por ele. Em PHP essa modificação é feita com a função nativa `session_regenerate_id()`, que deve ser chamada após um login bem sucedido.

>Modificar o ID da sessão a cada vez que o usuário muda de página na aplicação aumentaria a segurança, porém possui diversas desvantagens. Por exemplo, se o usuário estiver com a aplicação aberta em múltiplas abas: se ele mudar de página em uma aba, se deslogaria de todas as outras. Por isso é recomendado modificar o ID da Sessão somente após o login.

# Return Types

É possível forçar o tipo de retorno de uma função ou método com o *type hinting*. É possível utilizar tanto tipos nativos quanto classes. Por exemplo:

```PHP
public function metodo() : int
{
    return 1;
}

public function funcao() : PDO
{
    return new PDO();
}
```

>Se você utilizar *return type declarations* em interfaces, as classes que implementam essas interfaces também precisam declarar o tipo do retorno no cabeçalho.

# Administração do MySQL

## Backup

É possível realizar backups no MySQL com a ferramenta **mysqlpump**. Insira o seguinte código no terminal:

```
mysqlpump -u username -ppassword databasename > databasename.sql
```

Para inserir a senha sem precisar "sair" da linha de comando, a senha é inserida junto com `-p`, sem espaços. Após o comando ser executado, todo o arquivo do banco de dados será transferido para databasename.sql. Caso ocorra algum problema no banco de dados, é necessário apenas fazer:

```
mysql -u username -ppassword databasename < databasename.sql
```

## Binary Logs

O problema em utilizar somente backups é que eles são feitos de tempos em tempos. Logo se um erro ocorreu antes que um backup fosse realizado a tempo, todo os dados seriam perdidos. Para aplicações como e-commerces, que armazenam compras feitas por clientes, isso é inadmissível.  

Para evitar esse problema existem os **binary logs** em MySQL. Com essa configuração é possível realizar um log de todas as consultas e operações feitas em um banco de dados. Logo se um problema ocorrer será necessário apenas restaurar o backup(feito com mysqlpump) e realizar novamente todas as operações armazenadas no log, feitas após o último backup.

Por padrão o MySQL não armazena logs das suas operações. Para que isso seja feito é necessário indicar nas configurações descomentando as linhas `log_bin = /var/log/mysql/mysql-bin.log` e `server-id = 1` no `/etc/mysql/mysqld.conf.d/mysqld.conf` (linux). Após isso, os arquivos de logs serão armazenados nos diretórios especificados.

>Se possível armazene os arquivos de log e backup em HDs diferentes do Banco de Dados em si. Pois se o problema acontecer no disco rígido onde está armazenado o banco de dados, os logs e backups estariam a salvo.

Após ocorrer um *crash* no Banco de Dados o procedimento seria então utilizar o backup já feito anteriormente com o mysqlpump. Para converter os arquivos em formatos de log para comandos sql e executar eles no backup é possível utilizar a ferramenta **mysqlbinlog**.  

O arquivo de backup é binlog.sql:
```
mysqlbinlog binlog.000001 > binlog.sql
```

Inserindo o arquivo de backup no banco de dados vazio:
```
mysql -u root -psenha < binlog.sql
```

## Chaves Estrangeiras

No design de Banco de Dados, uma coluna que contém valores que se conectam com outros valores iguais de outra tabela é chamada de **chave estrangeira**. Por exemplo, uma tabela que contenha a lista de alunos conterá uma coluna representando o ID da turma que o aluno estuda (que será a chave estrangeira). No mesmo Banco de Dados haverá uma tabela com as turmas, e o ID dessa tabela estará conectado à chave estrangeira da tabela de alunos.

Para garantir que as tabelas estejam realmente conectadas existem as **Restrições de Chave Estrangeira**. Para, por exemplo, o banco de dados impedir a exclusão de uma turma que ainda tenha alunos conectados a ela. Na linguagem SQL é feito da seguinte forma:

```SQL
CREATE TABLE `alunos` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nome` VARCHAR(255),
    `turma` INT,
    FOREIGN KEY (`turma`) REFERENCES `turmas` (`id`)
) DEFAULT CHARACTER SET utf8mb4 ENGINE=InnoDB;
```

## Ação Referencial

Invés de somente impedir que o programa exclua ou atualize registros que sejam chaves estrangeiras em outras tabelas, é possível escolher o comportamento com **ações referenciais**. Elas atuam sobre duas operações, **ON DELETE**, para operações de **DELETE**, e **ON UPDATE**, para ações de **UPDATE**. Existem diversas ações referenciais disponíveis, porém as mais comuns são **CASCADE**, **RESTRICT**, **SET NULL**, **NO ACTION** e **SET DEFAULT**. Por exemplo, para definirmos que se o registro de uma turma foi excluído, todos os alunos dessa turma fiquem com a coluna `turma` igual a `null` podemos fazer:

```SQL
CREATE TABLE `alunos` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nome` VARCHAR(255),
    `turma` INT,
    FOREIGN KEY (`turma`) REFERENCES `turmas` (`id`)
    ON UPDATE SET NULL
    ON DELETE SET NULL
) DEFAULT CHARACTER SET utf8mb4 ENGINE=InnoDB;
```

>Ações referenciais podem ser bem úteis, porém geram um problema: a lógica da aplicação fica em mais de um lugar. Se quisermos deletar um registro precisamos nos preocupar tanto com o método que faz a exclusão do arquivo, quando com as restrições de chave estrangeira. Por isso é uma boa prática delegar somente ao PHP a tarefa de impedir exclusões de registros que interfiram em outras tabelas, e evitar o uso tanto de ações referenciais quanto de restrições de chave estrangeira.

# ORM

Muitas vezes o modo como olhamos os dados podem ser conflitantes entre si. Em um banco de dados que contenha alunos e turmas podemos visualizar os dados de forma **relacional**, como tabelas que se relacionam entre si com chaves primárias e estrangeiras. Porém também podemos visualizar de forma **Orientada a Objetos**, sendo a turma 1, por exemplo, um objeto da classe *Turmas*, e essa turma contém(**encapsula**) objetos *aluno* da classe *Alunos*.

Algumas facilidades vindas do paradigma relacional, como `JOIN`, conflitam e até atrapalham a organização do código de forma orientada a objetos. Pois a Orientação a Objetos visualiza os dados de forma hierárquica. Para resolver esse problema o ideal é realizar a **separação de responsabilidades**. Uma forma de realizar isso é deixar as operações SQL o mais simples possíveis(Para apenas realizar operações básicas como Inserir, Deletar, Atualizar e Requisitar), e delegar a tarefa de organizar os dados para a linguagem orientada a objetos. Essa abordagem não é tão otimizada quanto realizar consultas SQL complexas, porém deixa o código mais organizado, escalável e testável.

Uma classe que "esconde" do usuário as operações com o Banco de Dados, e mostra os dados no paradigma orientado a objetos é chamada **Object Relational Mapper** (**ORM**). *ORM*s lidam com *objetos*, não dados puros. Uma classe que representa no paradigma OO um registro no BD é chamada **Entity** (**Entidade**).

>Dica: Para obter apenas as colunas de uma tabela no BD é possível apenas rodar o comando: `SELECT column_name FROM information_schema.columns WHERE table_name = 'nome_de_sua_tabela';`
