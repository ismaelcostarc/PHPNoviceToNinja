<?php

namespace Ninja;

class DatabaseTable
{
    private $pdo;
    private $table;
    private $primaryKey;
    private $entityName;
    //Argumentos para a criação das Entidades
    public $constructArgs;

    public function __construct(
        \PDO $pdo,
        string $table,
        string $primaryKey,
        //stdClass é um classe vazia nativa do PHP, caso nenhuma Entidade
        //seja especificada, o objeto retornado será o padrão
        string $entityName = '\stdClass',
        array $constructArgs = []
    ) {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->primaryKey = $primaryKey;
        $this->entityName = $entityName;
        //Caso a entidade relacionada ao recurso do banco de dados necessitar de 
        //outras tabelas, essas serão informadas no parâmetro $constructorArgs
        $this->constructArgs = $constructArgs;
    }

    //O método query realiza o tratamento adequado para evitar o ataque SQL Injection,
    //executa o sql e retorna a resposta do banco de dados
    private function query($sql, $parameters = [])
    {
        $query = $this->pdo->prepare($sql);

        foreach ($parameters as $chave => $valor) {
            $query->bindValue($chave, $valor);
        }

        $query->execute();

        return $query;
    }

    //Retorna a quantidade de recursos na tabela
    public function quantity()
    {
        $sql = "SELECT COUNT(*) FROM `$this->table`;";
        $numero = $this->query($sql)->fetch()[0];

        return $numero;
    }

    //Recebe um array como argumento, verifica se há algum objeto DateTime,
    //e transforma para o formato para MySQL
    private function processDates($values)
    {
        foreach ($values as $key => $value) {
            if ($value instanceof \DateTime) {
                $values[$key] = $value->format('Y-m-d h:i:s');
            }
        }

        return $values;
    }

    //O método save() salva o recurso no Banco de Dados, se o recurso não existir, é inserido
    //caso já exista um recurso com a mesma chave primária, ele é atualizado.
    //Se o recurso já existir será lançada uma exceção.
    public function save($record)
    {
        //Verificar se existe alguma data e formata
        $record = $this->processDates($record);
        try {
            //Se for uma ação de adicionar um novo recurso, a chave primária que está na resposta HTTP
            //será uma string vazia, poré a chave primária informada deve
            //ser null, pois dessa forma o MySQL irá gerar uma chave nova com auto-increment. 
            //Caso contrário, a ação será de editar, então a chave primária irá para o comando SQL com
            //a chave primária de um recurso existente, emitindo uma exceção, que será capturada
            //pelo catch().
            if ($record[$this->primaryKey] == '') {
                $record[$this->primaryKey] = null;
            }

            $this->create($record);
        } catch (\PDOException $e) {
            $this->updateById($record, $record[$this->primaryKey]);
        }
    }

    //Retorna um array com o nome das colunas da tabela
    public function columns()
    {
        $sql = 'SELECT column_name FROM information_schema.columns WHERE table_name = \'' . $this->table . '\';';

        //Os parâmetros (\PDO::FETCH_COLUMN, 0) servem para que os nomes das colunas não venham
        //duplicados
        $result = $this->query($sql)->fetchAll(\PDO::FETCH_COLUMN, 0);

        return $result;
    }

    //--------------------------------------CRUD---------------------------------------------
    //Create

    //$record é um array associativo contendo o nome das colunas e os valores que deverão ser inseridos
    //[
    //  coluna => valor
    //]
    private function create($record)
    {
        $sql = "INSERT INTO `$this->table` (";
        //$parameters é um array associativo que informa qual será o valor de cada variável
        //no comando SQL
        $parameters = [];

        foreach ($record as $column => $value) {
            $sql .= "`$column`,";
        }

        //Após uma lista com os nomes das colunas sobra uma vírgula no final,
        //que deve ser retirada com rtrim()
        $sql = rtrim($sql, ',');

        $sql .= ') VALUES (';

        foreach ($record as $column => $value) {
            $sql .= ':' . $column . ',';

            $parameters[':' . $column] = $value;
        }

        //Após uma lista com os nomes das variáveis sobra uma vírgula no final,
        //que deve ser retirada com rtrim()
        $sql = rtrim($sql, ',');

        $sql .= ');';

        //Após isso, o SQL gerado será, por exemplo:
        //INSERT INTO `alunos` (`nome`, `nota`) VALUES (:nome, :nota);
        //
        //Array $parameters:
        //[
        //  ':nome' => 'João da Silva',
        //  ':nota' => 9    
        //]

        //O comando SQL já pode ser executado com segurança
        $this->query($sql, $parameters);
    }

    //Read

    //Retorna um array com todos os recursos da tabela
    public function readAll()
    {
        $sql = "SELECT * FROM `$this->table`;";
        $result = $this->query($sql);

        return $result->fetchAll(\PDO::FETCH_CLASS, $this->entityName, [$this]);
    }

    //Retorna um recurso específico de acordo com o nome da coluna
    public function read($column, $value)
    {
        // $sql = "SELECT * FROM `$this->table` WHERE `$column` = $value;";
        $sql = "SELECT * FROM `$this->table` WHERE `$column` = :$column;";

        $parameters = [
            ':' . $column => $value
        ];

        $result = $this->query($sql, $parameters);

        return $result->fetchAll(\PDO::FETCH_CLASS, $this->entityName, [$this]);
    }

    //Update

    private function updateById($record, $id)
    {
        $sql = "UPDATE `$this->table` SET ";
        //$parameters é um array associativo que informa qual será o valor de cada variável
        //no comando SQL
        $parameters = [];

        foreach ($record as $column => $value) {
            $sql .= "`$column` = :$column,";

            $parameters[':' . $column] = $value;
        }

        //Após uma lista com os nomes das variáveis sobra uma vírgula no final,
        //que deve ser retirada com rtrim()
        $sql = rtrim($sql, ',');

        $sql .= " WHERE `$this->primaryKey` = $id;";

        //Após isso, o SQL gerado será, por exemplo:
        //UPDATE `alunos` SET `nome` = :nome, `nota` = :nota WHERE `matricula` = 345;
        //
        //Array $parameters:
        //[
        //  ':nome' => 'João da Silva',
        //  ':nota' => 7    
        //]

        //O comando SQL já pode ser executado com segurança
        $this->query($sql, $parameters);
    }

    //Delete

    //Apaga um recurso específico por seu ID
    //$primaryKey é o nome da coluna que contém a chave primária
    //que pode ser 'id', 'cpf', 'matricula', etc
    public function deleteById($id)
    {
        $sql = "DELETE FROM `$this->table` WHERE `$this->primaryKey` = $id";
        $this->query($sql);
    }
}
