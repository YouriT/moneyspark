<?php 
namespace Account\Form;

use Zend\Form\Annotation as Form;

class Register
{
	/**
	 * @Form\Type("Zend\Form\Element\Text")
	 * @Form\Required(true)
	 * @Form\Filter({"name":"StripTags"})
	 * @Form\Validator({"name":"StringLength","options":{"min":"5"}})
	 */
	public $firstName;
	
	/**
	 * @Form\Type("Zend\Form\Element\Text")
	 * @Form\Required(true)
	 * @Form\Filter({"name":"StripTags"})
	 * @Form\Validator({"name":"StringLength","options":{"min":"5"}})
	 */
	public $lastName;
	
	/**
	 * @Form\Type("Zend\Form\Element\Text")
	 * @Form\Required(true)
	 * @Form\Filter({"name":"StripTags"})
	 * @Form\Validator({"name":"Date","options":{"patern":"/^\d{4}-\d{3}-\d{3}$/"}})
	 */
	public $birthDate;
	
	/**
	 * @Form\Type("Zend\Form\Element\Text")
	 * @Form\Required(true)
	 * @Form\Filter({"name":"StripTags"})
	 * @Form\Validator({"name":"Regex","options":{"pattern":"/^[a-z]{2}\_[A-Z]{2}$/"}})
	 */
	public $locale;
	
	/**
	 * @Form\Type("Zend\Form\Element\Text")
	 * @Form\Required(true)
	 * @Form\Filter({"name":"StripTags"})
	 * @Form\Attributes({"placeholder":"Mobile","class":"input-block-level"})
	 * @Form\Validator({"name":"RegEx","options":{"pattern":"#[0-9]{4,14}$#"}})
	 */
	public $phone;
	
	/**
	 * @Form\Type("Zend\Form\Element\Text")
	 * @Form\Required(true)
	 * @Form\Filter({"name":"StripTags"})
	 * @Form\Attributes({"placeholder":"Adresse e-mail","class":"input-block-level"})
	 * @Form\Validator({"name":"EmailAddress"})
	 */
	public $email;
	
	/**
	 * @Form\Type("Zend\Form\Element\Text")
	 * @Form\Required(true)
	 * @Form\Filter({"name":"StripTags"})
	 */
	public $iban;
	
	/**
	 * @Form\Type("Zend\Form\Element\Password")
	 * @Form\Required(true)
	 * @Form\Filter({"name":"StripTags"})
	 * @Form\Attributes({"placeholder":"Mot de passe","class":"input-block-level"})
	 * @Form\Validator({"name":"StringLength","options":{"min":"6"}})
	 */
	public $password;
}