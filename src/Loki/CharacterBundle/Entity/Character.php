<?php

namespace Loki\CharacterBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * Chars
 *
 * @ORM\Table("`characters`")
 * @ORM\Entity(repositoryClass="Loki\CharacterBundle\Repository\CharacterRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Character extends AbstractEntity
{


    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $race;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $occupation;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $reputation;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $goodKarma;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $karmapool;

    /**
     * @var integer
     * 1 = SC, 2 = NSC
     * @ORM\Column(type="integer")
     */
    protected $type;

    /**
     * @var
     * @ORM\OneToMany(targetEntity="Loki\CharacterBundle\Entity\CharacterToAttribute", mappedBy="character", fetch="EAGER")
     */
    protected $attributes;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Loki\CharacterBundle\Entity\CharacterToSkill", mappedBy="character", fetch="EAGER")
     **/
    protected $skills;

    /**
     * Correlation to a user, who should be a partner.
     * @var User
     * @ORM\ManyToOne(targetEntity="Loki\UserBundle\Entity\User", inversedBy="characters")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    protected $user;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Loki\CharacterBundle\Entity\EquipItem", mappedBy="character", fetch="EAGER")
     */
    protected $items;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Loki\CharacterBundle\Entity\ConnectionNotInDB", mappedBy="owner", fetch="EAGER")
     */
    protected $connectionsNotInDB;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Loki\CharacterBundle\Entity\ConnectionInDB", mappedBy="owner", fetch="EAGER")
     */
    protected $connectionsInDB;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Loki\CharacterBundle\Entity\ConnectionInDB", mappedBy="target", fetch="LAZY")
     */
    protected $connectionsInDBTarget;



    public function __construct()
    {
        parent::__construct();
        $this->items = new ArrayCollection();
        $this->connectionsNotInDB = new ArrayCollection();
        $this->connectionsInDB = new ArrayCollection();
        $this->connectionsInDBTarget = new ArrayCollection();
        $this->skills = new ArrayCollection();
        $this->attributes = new ArrayCollection();
        $this->reputation = 0;
        $this->goodKarma = 0;
        $this->karmapool = 0;
    }

    /**
     * @param mixed $attributes
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @return mixed
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $connectionsInDB
     */
    public function setConnectionsInDB($connectionsInDB)
    {
        $this->connectionsInDB = $connectionsInDB;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getConnectionsInDB()
    {
        return $this->connectionsInDB;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $connectionsNotInDB
     */
    public function setConnectionsNotInDB($connectionsNotInDB)
    {
        $this->connectionsNotInDB = $connectionsNotInDB;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getConnectionsNotInDB()
    {
        return $this->connectionsNotInDB;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param int $goodKarma
     */
    public function setGoodKarma($goodKarma)
    {
        $this->goodKarma = $goodKarma;
    }

    /**
     * @return int
     */
    public function getGoodKarma()
    {
        return $this->goodKarma;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param int $karmapool
     */
    public function setKarmapool($karmapool)
    {
        $this->karmapool = $karmapool;
    }

    /**
     * @return int
     */
    public function getKarmapool()
    {
        return $this->karmapool;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $occupation
     */
    public function setOccupation($occupation)
    {
        $this->occupation = $occupation;
    }

    /**
     * @return string
     */
    public function getOccupation()
    {
        return $this->occupation;
    }

    /**
     * @param string $race
     */
    public function setRace($race)
    {
        $this->race = $race;
    }

    /**
     * @return string
     */
    public function getRace()
    {
        return $this->race;
    }

    /**
     * @param int $reputation
     */
    public function setReputation($reputation)
    {
        $this->reputation = $reputation;
    }

    /**
     * @return int
     */
    public function getReputation()
    {
        return $this->reputation;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $skills
     */
    public function setSkills($skills)
    {
        $this->skills = $skills;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param \Loki\CharacterBundle\Entity\User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return \Loki\CharacterBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }





}
