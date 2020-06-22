<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Activity;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class ActivityRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, Activity::class);
	}

	public function countByPublic(): int
	{
		return (int) $this->createFindByPublicQueryBuilder()
			->select('COUNT(a.id)')
			->getQuery()
			->getSingleScalarResult();
	}

	/**
	 * @return Activity[]
	 */
	public function findByPublic(int $offset, int $limit): array
	{
		return $this->createFindByPublicQueryBuilder()
			->setFirstResult($offset)
			->setMaxResults($limit)
			->getQuery()
			->getResult();
	}

	public function countByUser(User $user, bool $includePrivate): int
	{
		return (int) $this->createFindByUserQueryBuilder($user, $includePrivate)
			->select('COUNT(a.id)')
			->getQuery()
			->getSingleScalarResult();
	}

	/**
	 * @param User $user
	 * @param int  $offset
	 * @param int  $limit
	 * @param bool $invludePrivate
	 *
	 * @return Activity[]
	 */
	public function findByUser(User $user, int $offset, int $limit, bool $invludePrivate): array
	{
		return $this->createFindByUserQueryBuilder($user, $invludePrivate)
			->setFirstResult($offset)
			->setMaxResults($limit)
			->getQuery()
			->getResult();
	}

	private function createFindByPublicQueryBuilder(): QueryBuilder
	{
		return $this->createQueryBuilder('a')
			->where('a.public = true');
	}

	private function createFindByUserQueryBuilder(User $user, bool $includePrivate): QueryBuilder
	{
		$queryBuilder = $this->createQueryBuilder('a')
			->where('a.user = :user')
			->setParameter('user', $user);

		if (!$includePrivate) {
			$queryBuilder->andWhere('a.public = true');
		}

		return $queryBuilder;
	}
}
