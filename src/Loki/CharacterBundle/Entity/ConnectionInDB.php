<?php
/**
 * Created by Marcus "Loki" Jenz 
 * Date: 08.03.14
 * Time: 10:53
 */

namespace Loki\CharacterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Skill
 *
 * @ORM\Table("`connection_in_db`")
 * @ORM\Entity(repositoryClass="Loki\CharacterBundle\Repository\ConnectionInDBRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ConnectionInDB extends AbstractEntity
{

} 