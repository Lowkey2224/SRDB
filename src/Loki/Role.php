<?php
/**
 * Created by JetBrains PhpStorm.
 * User: marcus
 * Date: 22.07.13
 * Time: 10:05
 * To change this template use File | Settings | File Templates.
 */

namespace Loki\CharacterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * Class Role roles for User entity
 * @ORM\Table("`roles`")
 * @ORM\Entity(repositoryClass="Loki\CharacterBundle\Repository\RoleRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields={"user"}, message="Dieser Nutzer hat diese Rolle bereits")
 */
class Role
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Loki\UserBundle\Entity\User", inversedBy="roles")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

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
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedValue()
    {
        $this->setUpdated(new \DateTime());
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
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return mixed
     */
    public function getUpdated()
    {
        return $this->updated;
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
     * @param mixed $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }



    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }


}