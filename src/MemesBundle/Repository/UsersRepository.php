<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-12-29
 * Time: 14:26
 */

namespace MemesBundle\Repository;
use Doctrine\ORM\EntityRepository;
use MemesBundle\Entity\Users;

class UsersRepository extends EntityRepository
{

    public function getQueryBuilder(array $params = array()){
        $qb = $this->createQueryBuilder('u')
            ->select('u');
    }

    public function getAuthor($slug){
        $qb = $this->createQueryBuilder('u')
            ->select('u')
            ->where('u.slug = :slug')
            ->setParameter('slug',$slug);

        $qb->getQuery()->getResult();
    }

}