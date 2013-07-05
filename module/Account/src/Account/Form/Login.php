<?php
namespace Account\Form;

use Zend\Form\Annotation as Form;

/**
 * @author Youri
 */
class Login
{
	/**
	 * @Form\Type("Zend\Form\Element\Text")
	 * @Form\Required(true)
	 * @Form\Filter({"name":"StripTags"})
	 * @Form\Validator({"name":"EmailAddress"})
	 */
	public $email;
	
	/**
	 * @Form\Type("Zend\Form\Element\Password")
	 * @Form\Required(true)
	 * @Form\Filter({"name":"StripTags"})
	 */
	public $password;
}