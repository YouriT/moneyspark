<?php

namespace Account\Model;

use Account\Entity\ProductHistory;

use Account\Entity\Product;

use Doctrine\ORM\EntityRepository;

class ProductHistoryRepository extends EntityRepository
{
	/**
	 * Get last known rentability for a financial product
	 * @return ProductHistory
	 */
	public function getLast(Product $p)
	{
		$q = $this->createQueryBuilder("PH")->
		where("PH.product = :idProduct")->
		setParameter("idProduct", $p->getId())->orderBy("PH.date", "DESC")->setMaxResults(1);
		return $q->getQuery()->getResult();
	}
}