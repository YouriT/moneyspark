<?php

namespace Account\Model;

use Account\Entity\Product;

use Account\Entity\User;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
	/**
	 * Get Displayable products
	 * @return Product
	 */
	public function getDisplayable(User $u)
	{
		$q = $this->createQueryBuilder("P")->
					where("P.dateBeginExpected > :now")->
					setParameter("now", new \DateTime());
		return $q->getQuery()->getResult();
	}
	
	
	
}