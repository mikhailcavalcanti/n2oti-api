<?php

namespace N2oti\Api\Entidade;

use Doctrine\ORM\Mapping as ORM;
use N2oti\Api\Servico\UsuarioServico;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Description of UsuarioEntidade
 *
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com
 * @ORM\Entity
 * @ORM\Table(name="n2oti.usuario")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 */
class UsuarioEntidade implements CrudableEntidade, UserInterface
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
     * @ORM\Column(type="string", name="login", length=100, unique=true,
     * options={
     *    "comment":"O login de acesso do usuário"
     * })
     * @var string
     */
    private $login;

    /**
     * @ORM\Column(type="string", name="senha",length=128, options={
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
        $this->senha = UsuarioServico::criptografaSenha($login, $senha);
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
            $login = isset($atributos['login']) ? $atributos['login'] : $this->login;
            $this->senha = UsuarioServico::criptografaSenha($login, $atributos['senha']);
        }
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

    /**
     * @see UserInterface::eraseCredentials()
     */
    public function eraseCredentials()
    {
        unset($this->senha);
    }

    public function getPassword()
    {
        
    }

    public function getRoles()
    {
        
    }

    public function getSalt()
    {
        
    }

    /**
     * @see UserInterface::getUsername()
     * @return string
     */
    public function getUsername()
    {
        return $this->login;
    }

}
