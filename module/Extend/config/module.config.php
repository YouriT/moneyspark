<?php
namespace Extend;
return array(
	'view_helpers' => array(
		'factories' => array(
			'isXmlHttpRequest' => function ($sm)
			{
				$isXml = new XmlHttpRequest();
				$isXml->setXml($sm->getServiceLocator()->get('Request'));
				return $isXml;
			}
		)
	)
);