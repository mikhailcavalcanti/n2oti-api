<?php

namespace N2oti\Api\Servico;

use DomainException;
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
    public function validarDadosParaCriarRecurso(array $dados)
    {
        $errors = [];
        $camposObrigatorios = ['login', 'senha'];
        foreach ($camposObrigatorios as $campo) {
            try {
                call_user_func(array($this, "validar" . ucfirst($campo)), $dados);
            } catch (DomainException $exeption) {
                $errors[] = $exeption->getMessage();
            }
        }
        if (!empty($errors)) {
            throw new DomainException(implode('|', $errors));
        }
    }

    /**
     * 
     * {@inheritDoc}
     */
    public function validarDadosParaAlterarRecurso(array $dados)
    {
        $this->validarSenha($dados);
    }

    /**
     * 
     * @param array $dados
     * @throws DomainException
     */
    private function validarLogin(array $dados)
    {
        $erros = [];
        $login = isset($dados['login']) ? $dados['login'] : null;
        if (empty($login)) {
            $errors[] = 'O campo login do usuário é obrigatório';
        } else {
            $tamanhoMaximo = 100;
            if (strlen($login) > $tamanhoMaximo) {
                $errors[] = sprintf('O campo login do usuário só pode ter %d caracteres', $tamanhoMaximo);
            }
        }
        if (!empty($errors)) {
            throw new DomainException(implode('|', $errors));
        }
    }
    
    /**
     * 
     * @param array $dados
     * @throws DomainException
     */
    private function validarSenha(array $dados)
    {
        $erros = [];
        $senha = isset($dados['senha']) ? $dados['senha'] : null;
        if (empty($senha)) {
            $errors[] = 'O campo senha do usuário é obrigatório';
        }
        if (!empty($errors)) {
            throw new DomainException(implode('|', $errors));
        }
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
