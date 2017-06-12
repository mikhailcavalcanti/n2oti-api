<?php

namespace N2oti\Api\Servico;

use N2oti\Api\Entidade\UsuarioEntidade;

/**
 * Description of UsuarioServico
 *
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com>
 */
class UsuarioServico extends ServicoAbstrato
{

    /**
     * 
     * {@inheritDoc}
     */
    public function criarInstanciaDaEntidade(array $dados)
    {
        return new UsuarioEntidade($dados['login'], $dados['senha']);
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function encontrarTodos(array $dados)
    {
        if (isset($dados['login']) && isset($dados['senha'])) {
            $dados['senha'] = UsuarioServico::criptografaSenha($dados['login'], $dados['senha']);
        }
        return $this->entityManager->getRepository(UsuarioEntidade::class)->findBy($dados);
    }

    /**
     * 
     * @param string $senha
     * @return string
     */
    public static function criptografaSenha($login, $senha)
    {
        $salt = hash('sha512', "{$login}{$senha}");
        return hash('sha512', $senha . $salt);
    }

}
