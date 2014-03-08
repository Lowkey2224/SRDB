<?php
/**
 * Created by JetBrains PhpStorm.
 * User: marcus
 * Date: 22.07.13
 * Time: 10:47
 * To change this template use File | Settings | File Templates.
 */

namespace Loki\CharacterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class EquipItem
 * @package Loki\CharacterBundle\Entity
 * @ORM\Table("`equip_items`")
 * @ORM\Entity(repositoryClass="Loki\CharacterBundle\Repository\EquipItemRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class EquipItem extends AbstractEntity
{

    /**
     * @ORM\ManyToOne(targetEntity="Loki\CharacterBundle\Entity\Character", inversedBy="items")
     * @ORM\JoinColumn(name="character_id", referencedColumnName="id")
     */
    protected $character;

    /**
     * @ORM\Column(type="integer")
     */
    protected $amount;

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $character
     */
    public function setCharacter($character)
    {
        $this->character = $character;
    }

    /**
     * @return mixed
     */
    public function getCharacter()
    {
        return $this->character;
    }


}