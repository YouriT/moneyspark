<?php

namespace Account\Model;

use Account\Entity\Product;

use Account\Entity\Investment;

use Account\Entity\User;

use Doctrine\ORM\EntityRepository;

class InvestmentRepository extends EntityRepository
{
	/**
	 * Get Rentability average
	 * @return double
	 */
	public function getRentabilityAverage(User $u)
	{
		$q = $this->createQueryBuilder("I")->
					select("SUM(I.rentabilityAchieved)")->
					where("I.ended = :ended AND I.user = :idUser")->
					setParameter("ended", true)->setParameter("idUser", $u->getId());
		return $q->getQuery()->getSingleScalarResult();
	}
	
	/**
	 * Get Ended Investments
	 * @return Investment
	 */
	public function getEnded(User $u)
	{
		$q = $this->createQueryBuilder("I")->
					where("I.ended = :ended AND I.user = :idUser")->
					setParameter("ended", true)->setParameter("idUser", $u->getId());
		return $q->getQuery()->getResult();
	}
	
	/**
	 * Get Current Investments
	 * @return Investment
	 */
	public function getCurrents(User $u)
	{
		$q = $this->createQueryBuilder("I")->
					where("I.ended = :ended AND I.user = :idUser")->
					setParameter("ended", false)->setParameter("idUser", $u->getId());
		return $q->getQuery()->getResult();
	}
	
	/**
	 * Get All Investments of an User
	 * @return Investment
	 */
	public function getTotal(User $u)
	{
		$q = $this->createQueryBuilder("I")->
		where("I.user = :idUser")->setParameter("idUser", $u->getId());
		return $q->getQuery()->getResult();
	}
	
	/**
	 * Get Current Invested Amount for a product
	 * @return double
	 */
	public function getSumInvestedAmounts(Product $p)
	{
		$q = $this->createQueryBuilder("I")->
					select("SUM(I.amount)")->
					where("I.product = :idProduct")->
					setParameter("idProduct", $p->getId());
		return $q->getQuery()->getSingleScalarResult();
	}
	
	
	
	
}