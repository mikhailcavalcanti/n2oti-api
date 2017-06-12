<?php

namespace N2oti\Api\Entidade;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of UsuarioEntidade
 *
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com
 * @ORM\Entity
 * @ORM\Table(name="n2oti.usuario")
 */
class UsuarioEntidade implements CrudableEntidade
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id_usuario", options={
     *    "comment":"chave única identificadora da tabela usuário"
     * })
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @var integer
     */
    private $indice;

    /**
     * @ORM\Column(type="string", name="login", length=100,
     * options={
     *    "comment":"O login de acesso do usuário"
     * })
     * @var string
     */
    private $login;

    /**
     * @ORM\Column(type="string", name="senha", options={
     *    "comment":"A senha de acesso do usuário"
     * }))
     * @var integer
     */
    private $senha;

    /**
     * 
     * @param string $login O login de acesso do usuário
     * @param integer $senha A senha de acesso do usuário
     */
    public function __construct($login, $senha)
    {
        $this->login = $login;
        $this->senha = $this->criptografaSenha($senha);
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function alterar(array $atributos)
    {
        foreach ($this as $nomeDoAtributo => $valorDoAtributo) {
            $this->$nomeDoAtributo = isset($atributos[$nomeDoAtributo]) ? $atributos[$nomeDoAtributo] : $valorDoAtributo;
        }
        if (isset($atributos['senha'])) {
            $this->senha = $this->criptografaSenha($atributos['senha']);
        }
    }

    /**
     * 
     * @param string $senha
     * @return string
     */
    private function criptografaSenha($senha)
    {
        $salt = uniqid();
        return hash('sha512', $senha . $salt);
    }

    /**
     * 
     * @return integer
     */
    public function getIndice()
    {
        return $this->indice;
    }

    /**
     * 
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * 
     * @return string
     */
    public function getSenha()
    {
        return $this->senha;
    }

}
