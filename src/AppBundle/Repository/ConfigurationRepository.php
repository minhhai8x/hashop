<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ConfigurationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ConfigurationRepository extends EntityRepository
{
    public function getConfigs()
    {
        $query   = $this->createQueryBuilder('cf')->getQuery();
        $results = $query->getOneOrNullResult();
        return $results;
    }
}