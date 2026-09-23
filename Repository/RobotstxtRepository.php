<?php
/*
 * This file is part of the Sulu Robotstxt bundle.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace BitExpert\Sulu\RobotstxtBundle\Repository;

use BitExpert\Sulu\RobotstxtBundle\Entity\Robotstxt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Robotstxt>
 */
class RobotstxtRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Robotstxt::class);
    }

    public function create(): Robotstxt
    {
        $entity = new Robotstxt();

        $this->getEntityManager()->persist($entity);

        return $entity;
    }

    /**
     * @throws ORMException
     */
    public function remove(int $id): void
    {
        /** @var Robotstxt $entity */
        $entity = $this->getEntityManager()->getReference(
            $this->getClassName(),
            $id,
        );

        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    public function save(Robotstxt $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function findById(int $id): ?Robotstxt
    {
        return $this->find($id);
    }

    public function findByWebspaceKey(string $webspaceKey): ?Robotstxt
    {
        return $this->findOneBy(['webspace_key' => $webspaceKey]);
    }
}
