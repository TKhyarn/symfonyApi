<?php

namespace Anaxago\CoreBundle\Repository;

/**
 * ProjectRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProjectRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param float $invested
     * @param int $id
     */
    public function putInvested(float $invested, int $id)
    {
        $this->getEntityManager()->createQuery('
            UPDATE Anaxago\CoreBundle\Entity\Project p
            SET p.invested = p.invested + :add
            WHERE p.id = :id
            ')
            ->setParameter(':add', $invested)
            ->setParameter(':id', $id)
            ->execute();

    }
}
