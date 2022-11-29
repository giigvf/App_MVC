<?php

namespace App\DAO;

use App\Model\LoginModel;
use \PDO;

/**
 * As classes DAO (Data Access Object) são responsáveis por executar os
 * SQL junto ao banco de dados.
 */
class LoginDAO extends DAO
{
     /**
     * Método construtor, sempre chamado na classe quando a classe é instanciada.
     * Exemplo de instanciar classe (criar objeto da classe):
     * $dao = new PessoaDAO();
     */
    public function __construct()
    {
        /**
         * Chamando o construtor da classe DAO, isto é, toda vez que chamos o consturo da classe DAO
         * estamos fazendo a conexão com o banco de dados.
         */
        parent::__construct();       
    }


    

    /**
     * Retorna um registro específico da tabela pessoa do banco de dados.
     * Note que o método exige um parâmetro $id do tipo inteiro.
     */
    public function selectByEmailAndSenha($email, $senha)
    {
        $sql = "SELECT * FROM usuarios WHERE email = ? AND senha = sha1(?) ";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $email);
        $stmt->bindValue(2, $senha);
        $stmt->execute();

        return $stmt->fetchObject("App\Model\LoginModel"); // Retornando um objeto específico PessoaModel
    }

   /**
     * Método esta recebendo a model e pegando os dados referente a tabela para inserilos (insert)
     */
    function insert(LoginModel $model) 
    {
        // Trecho de código SQL com marcadores ? para substituir com os dados, no prepare   
        $sql = "INSERT INTO usuarios 
                (nome, email, senha) 
                VALUES (?,?,?)";
        

        //a variavel stmt tera a consulta montada, alem de o prepare estar dentro da 
        //$conexao e recebendo com os marcadores correspondentes
       
        $stmt = $this->conexao->prepare($sql);

        // Aqui, o bindValue recebe o valor da determinada posição, que veio via
        //parâmetro da model
        $stmt->bindValue(1, $model->nome);
        $stmt->bindValue(1, $model->email);
        $stmt->bindValue(1, $model->senha);
        
        
        // A consulta é executada
        $stmt->execute();      
    }




/**
     * Recebe o Model preenchido com os dados e atualiza no banco 
     * (o id deve estar preenchido)
     */
    public function update(loginModel $model)
    {
        $sql = "UPDATE usuarios SET nome=?, email=?, senha=?  WHERE id=? ";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $model->nome);
        $stmt->bindValue(2, $model->email);
        $stmt->bindValue(3, $model->senha);
        $stmt->bindValue(4, $model->id);
        
        $stmt->execute();
    }


    /**
     * Método que seleciona e retorna todos (*) os registro da tabela no banco.
     */



    public function select()
    {
        $sql = "SELECT * FROM usuarios ";

        $stmt = $this->conexao->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }
    
}