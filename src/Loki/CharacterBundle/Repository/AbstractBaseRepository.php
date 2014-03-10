<?php
/**
 * Created by PhpStorm.
 * User: marcus
 * Date: 14.02.14
 * Time: 17:49
 */

namespace Loki\CharacterBundle\Repository;


use Doctrine\ORM\EntityRepository;

abstract class AbstractBaseRepository extends EntityRepository{

    /**
     * @param $entry
     * @return mixed
     */
    public function persist($entry)
    {
        $em = $this->getEntityManager();
        $em->persist($entry);
        $em->flush();

        return $entry;
    }

    /**
     * @param $entry
     */
    public function delete($entry)
    {
        $em = $this->getEntityManager();
        $em->remove($entry);
        $em->flush();
    }

} 