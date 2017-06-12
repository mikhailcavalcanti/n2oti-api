<?php

namespace N2oti\Api\Servico;

/**
 *
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com
 */
interface CrudableServico
{

    /**
     * Cria um recurso com os dados providos pelo parâmetro $dados e retorna o recurso que foi criado (com o indice preenchido)
     * @param array $dados
     */
    public function criar(array $dados);

    /**
     * Atualiza um recurso idenficado pelo $indice com os dados providos pelo parâmetro $dados
     * @param integer $indice
     * @param array $dados
     */
    public function atualizar($indice, array $dados);

    /**
     * Deleta o recurso identificado pelo $indice
     * @param integer $indice
     */
    public function deletar($indice);

    /**
     * Retorna o recurso identificado pelo $indice
     * @param integer $indice
     */
    public function encontrar($indice);

    /**
     * Retorna todos os registros encontrados com os dados providos pelo parâmetro $dados 
     * @param array $dados
     */
    public function encontrarTodos(array $dados);
}
