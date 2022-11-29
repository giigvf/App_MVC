<?php

namespace App\Model;

use App\DAO\LoginDAO;

/**
 * A camada model é responsável por transportar os dados da Controller até a DAO e vice-versa.
 * Também é atribuído a Model a validação dos dados da View e controle de acesso aos métodos
 * da DAO.
 */
class LoginModel extends Model
{

    public $id, $nome, $email, $senha;



     
    public function autenticar()
    {
        $dao = new LoginDAO();
        
        $dados_usuario_logado = $dao->selectByEmailAndSenha($this->email, $this->senha);

        if(is_object($dados_usuario_logado))
            return $dados_usuario_logado;
        else
            null;
    }

    public function save()
    {
      

        $dao = new LoginDAO();

        
        if(empty($this->id)) 
        {
            
            $dao->insert($this);
        } else {
            $dao->update($this); 
        }
    }

    public function delete(int $id)
    {
        

        $dao = new LoginDAO();

        $dao->delete($id);
    }


}