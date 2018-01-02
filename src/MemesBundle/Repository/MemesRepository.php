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
            ->orderBy('m.id','DESC');

        return $qb->getQuery()->getResult();
    }

    public function getSingle($slug){
        $qb = $this->createQueryBuilder('m')
            ->select('m,c')
            ->leftJoin('m.comments','c')
            ->where('m.slug = :slug')
            ->setParameter('slug', $slug);

        return $qb->getQuery()->getResult();
    }

}