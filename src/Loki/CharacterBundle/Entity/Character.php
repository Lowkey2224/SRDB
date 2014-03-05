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
class Character
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

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
     * @ORM\OneToMany(targetEntity="Loki\CharacterBundle\Entity\ConnectionNotInDB", mappedBy="character", fetch="EAGER")
     */
    protected $connectionsNotInDB;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    public function __construct()
    {
        $this->setCreated(new \DateTime());
        $this->setUpdated(new \DateTime());
        $this->items = new ArrayCollection();
        $this->connectionsNotInDB = new ArrayCollection();
        $this->skills = new ArrayCollection();
        $this->attributes = new ArrayCollection();
        $this->reputation = 0;
        $this->goodKarma = 0;
        $this->karmapool = 0;
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedValue()
    {
        $this->setUpdated(new \DateTime());
    }

    /**
     * @return mixed
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getConnectionsNotInDB()
    {
        return $this->connectionsNotInDB;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getGoodKarma()
    {
        return $this->goodKarma;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return int
     */
    public function getKarmapool()
    {
        return $this->karmapool;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getOccupation()
    {
        return $this->occupation;
    }

    /**
     * @return string
     */
    public function getRace()
    {
        return $this->race;
    }

    /**
     * @return int
     */
    public function getReputation()
    {
        return $this->reputation;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @return \Loki\CharacterBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $attributes
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $connectionsNotInDB
     */
    public function setConnectionsNotInDB($connectionsNotInDB)
    {
        $this->connectionsNotInDB = $connectionsNotInDB;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param int $goodKarma
     */
    public function setGoodKarma($goodKarma)
    {
        $this->goodKarma = $goodKarma;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    /**
     * @param int $karmaPool
     */
    public function setKarmapool($karmaPool)
    {
        $this->karmapool = $karmaPool;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param string $occupation
     */
    public function setOccupation($occupation)
    {
        $this->occupation = $occupation;
    }

    /**
     * @param string $race
     */
    public function setRace($race)
    {
        $this->race = $race;
    }

    /**
     * @param int $reputation
     */
    public function setReputation($reputation)
    {
        $this->reputation = $reputation;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $skills
     */
    public function setSkills($skills)
    {
        $this->skills = $skills;
    }

    /**
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @param mixed $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * @param \Loki\CharacterBundle\Entity\User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }





}
