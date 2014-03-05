<?php

namespace Loki\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * Users
 *
 * @ORM\Table("`users`")
 * @ORM\Entity(repositoryClass="Loki\UserBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var
     * @ORM\OneToMany(targetEntity="Loki\CharacterBundle\Entity\Character", mappedBy="user")
     * @ORM\OrderBy({"updated" = "ASC"})
     */
    protected $characters;

    /**
     * @var
     * @ORM\Column( type="boolean")
     */
    protected $is_deleted;

    /**
     * @var
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @var
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    public function __construct()
    {
        $this->setCreated(new \DateTime());
        $this->setUpdated(new \DateTime());
        $this->is_deleted=false;
        $this->characters = new ArrayCollection();
        $this->roles = new ArrayCollection();
        parent::__construct();
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
    public function getCharacters()
    {
        return $this->characters;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getIsDeleted()
    {
        return $this->is_deleted;
    }

    /**
     * @return mixed
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @return \DateTime
     */
    public function getCredentialsExpireAt()
    {
        return $this->credentialsExpireAt;
    }

    /**
     * @return boolean
     */
    public function getCredentialsExpired()
    {
        return $this->credentialsExpired;
    }

    /**
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @return boolean
     */
    public function getExpired()
    {
        return $this->expired;
    }

    /**
     * @return \DateTime
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * @return boolean
     */
    public function getLocked()
    {
        return $this->locked;
    }

    /**
     * @param mixed $characters
     */
    public function setCharacters($characters)
    {
        $this->characters = $characters;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }


    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $is_deleted
     */
    public function setIsDeleted($is_deleted)
    {
        $this->is_deleted = $is_deleted;
    }

    /**
     * @param mixed $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $groups
     */
    public function setGroups($groups)
    {
        $this->groups = $groups;
    }


}
