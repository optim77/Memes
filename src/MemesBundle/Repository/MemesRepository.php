<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-12-29
 * Time: 13:31
 */

namespace MemesBundle\Repository;
use Doctrine\ORM\EntityRepository;
use MemesBundle\Entity\Memes;

class MemesRepository extends EntityRepository
{

    public function getQueryBuilder(array $params = array()){
        $qb = $this->createQueryBuilder('m')
            ->select('m')
            ->orderBy('m.date','ASC');

        return $qb->getQuery()->getResult();
    }

}