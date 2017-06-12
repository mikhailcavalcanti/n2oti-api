<?php

namespace N2oti\Api\Entidade;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of AcessorioEntidade
 *
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com
 * @ORM\Entity
 * @ORM\Table(name="n2oti.acessorio")
 */
class AcessorioEntidade implements CrudableEntidade
{

    /**
     * Constante que indica que o acessório é de fábrica
     */
    const TIPO_FABRICA = 1;

    /**
     * Constante que indica que o acessório é de opcional
     */
    const TIPO_OPCIONAL = 2;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id_acessorio", options={
     *    "comment":"chave única identificadora da tabela acessorio"
     * })
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @var integer
     */
    private $indice;

    /**
     * @ORM\Column(type="string", name="nome_do_acessorio", length=100,
     * options={
     *    "comment":"o nome do acessorio do carro"
     * })
     * @var string
     */
    private $nome;

    /**
     * @ORM\Column(type="smallint", name="tipo_acessorio", options={
     *    "comment":"o tipo do acessorio do carro. 1 - acessorio de fabrica e 2 para acessorio opcional"
     * }))
     * @var integer
     */
    private $tipo;

    /**
     * 
     * @param string $nome O nome do acessório que será posto em um modelo de um carro
     * @param integer $tipo O tipo do acessório que será posto no carro, tendo dois valores possíveis,
     * TIPO_FABRICA = 1 e TIPO_OPCIONAL = 2
     */
    public function __construct($nome, $tipo)
    {
        $this->nome = $nome;
        $this->tipo = $tipo;
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
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * 
     * @return integer
     */
    public function getTipo()
    {
        return $this->tipo;
    }

}
