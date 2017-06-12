<?php

namespace N2oti\Api\Entidade;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Description of ModeloEntidade
 *
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com
 * @ORM\Entity
 * @ORM\Table(name="n2oti.modelo")
 */
class ModeloEntidade implements CrudableEntidade
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id_modelo", options={
     *    "comment":"chave única identificadora da tabela modelo"
     * })
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    private $indice;

    /**
     * @ORM\Column(type="string", name="nome_do_modelo", length=100,
     * options={
     *    "comment":"o nome do modelo do carro"
     * })
     * @var string
     */
    private $nome;

    /**
     * @ORM\Column(type="integer", name="ano_modelo", options={
     *    "comment":"o ano do modelo do carro"
     * }))
     * @var integer
     */
    private $ano;

    /**
     * @ORM\Column(type="integer", name="aro_da_roda", options={
     *    "comment":"o aro da roda do modelo do carro"
     * }))
     * @var integer
     */
    private $aro;

    /**
     * @ORM\ManyToMany(targetEntity="N2oti\Api\Entidade\AcessorioEntidade")
     * @ORM\JoinTable(name="n2oti.modelo_acessorio",
     *      joinColumns={@ORM\JoinColumn(name="id_modelo", referencedColumnName="id_modelo")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_acessorio", referencedColumnName="id_acessorio")}
     * )
     * @var ArrayCollection
     */
    private $acessorios;

    /**
     * 
     * @param string $nome Nome do modelo do carro
     * @param integer $ano O ano do modelo do carro
     * @param integer $aro O aro da roda do modelo do carro
     * @param ArrayCollection $acessorios
     */
    public function __construct($nome, $ano, $aro, ArrayCollection $acessorios = null)
    {
        $this->nome = $nome;
        $this->ano = $ano;
        $this->aro = $aro;
        $this->acessorios = $acessorios ? $acessorios : new ArrayCollection();
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
    public function getAno()
    {
        return $this->ano;
    }

    /**
     * 
     * @return integer
     */
    public function getAro()
    {
        return $this->aro;
    }

    /**
     * 
     * @return ArrayCollection
     */
    public function getAcessorios()
    {
        return $this->acessorios;
    }

}
