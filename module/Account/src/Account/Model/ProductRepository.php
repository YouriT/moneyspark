<?php

namespace Account\Model;

use Doctrine\ORM\Query;

use Account\Entity\Product;

use Account\Entity\User;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
	
	
	private $hydrateMode = array(Query::HYDRATE_OBJECT, Query::HYDRATE_ARRAY);
	
	/**
	 * Get Displayable products
	 * @return Product
	 */
	public function getDisplayable($array=true)
	{
		$q = $this->createQueryBuilder("P")->
					where("P.dateBeginExpected > :now")->
					setParameter("now", new \DateTime());
		return $q->getQuery()->getResult($this->hydrateMode[(int)$array]);
	}
	
	
	
}