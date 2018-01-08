<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-12-29
 * Time: 13:31
 */

namespace MemesBundle\Repository;
use Doctrine\ORM\EntityRepository;
use MemesBundle\Controller\AddController;
use MemesBundle\Entity\Memes;

class MemesRepository extends EntityRepository
{

    public function getQueryBuilder(array $params = array())
    {
        $qb = $this->createQueryBuilder('m')
            ->select('m')
            ->orderBy('m.id', 'DESC');

        return $qb->getQuery()->getResult();
    }

    public function getSingle($slug)
    {
        $qb = $this->createQueryBuilder('m')
            ->select('m,c')
            ->leftJoin('m.comments', 'c')
            ->where('m.slug = :slug')
            ->setParameter('slug', $slug)
            ->orderBy('c.id', 'DESC');

        return $qb->getQuery()->getResult();
    }

    public function getMemes()
    {
        $qb = $this->createQueryBuilder('m')
            ->select('m')
            ->where('m.type = :type')
            ->setParameter('type', AddController::MEM_TYPE)
            ->orderBy('m.id', 'DESC');
        return $qb->getQuery()->getResult();
    }

    public function getPhrases()
    {
        $qb = $this->createQueryBuilder('m')
            ->select('m')
            ->where('m.type = :type')
            ->setParameter('type', AddController::PHRASE_TYPE)
            ->orderBy('m.id', 'DESC');
        return $qb->getQuery()->getResult();
    }

    public function getTop()
    {
        $qb = $this->createQueryBuilder('m')
            ->select('m')
            ->orderBy('m.ratePositive', 'DESC');

        return $qb->getQuery()->getResult();
    }

    public function getVideos()
    {
        $qb = $this->createQueryBuilder('m')
            ->select('m')
            ->where('m.type = :type')
            ->setParameter('type', AddController::VIDEOS_TYPE)
            ->orderBy('m.id', 'DESC');
        return $qb->getQuery()->getResult();
    }
}