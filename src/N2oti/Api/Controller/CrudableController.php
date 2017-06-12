<?php

namespace N2oti\Api\Controller;

use Symfony\Component\HttpFoundation\Request;

/**
 *
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com
 */
interface CrudableController
{

    /**
     * Cria um recurso com os dados providos do $request e retorna o recurso que foi criado (com o indice preenchido)
     * @param Request $request
     */
    public function criarAction(Request $request);

    /**
     * Atualiza um recurso idenficado pelo $indice com os dados providos pelo $request
     * @param integer $indice
     * @param Request $request
     */
    public function atualizarAction($indice, Request $request);

    /**
     * Deleta o recurso identificado pelo $indice
     * @param integer $indice
     */
    public function deletarAction($indice);

    /**
     * Retorna o recurso identificado pelo $indice
     * @param integer $indice
     */
    public function encontrarAction($indice);

    /**
     * Retorna todos os registros encontrados com os dados providos pelo $request
     * @param Request $request
     */
    public function encontrarTodosAction(Request $request);
}
