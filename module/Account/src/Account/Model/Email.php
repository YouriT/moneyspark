<?php
namespace Account\Model;

use Zend\Mail\Transport\SmtpOptions;

use Zend\Mail\Transport\Smtp;
use Zend\Mail\Message;
use Zend\Mime\Part;

class Email extends Message
{
	private $template;
	private $text;
	private $replace;
	
	public function __construct()
	{
		$this->addFrom("no-reply@befasty.com","Moneyspark")
			->setEncoding('UTF-8');
	}
	
	public function setTemplate($filePath)
	{
		$this->template = file_get_contents($filePath);
		return $this;
	}
	
	public function setText($string)
	{
		$this->text = $string;
		return $this;
	}
	
	public function setReplace($array)
	{
		$this->replace = $array;
		return $this;
	}
	
	public function send()
	{
		$mime = new \Zend\Mime\Message();
		if (count($this->replace) > 0)
			$html = new Part(str_replace(array_keys($this->replace), array_values($this->replace), $this->template));
		else
			$html = new Part($this->template);
		$html->type = "text/html";
		$text = new Part($this->text);
		$text->type = "text/plain";
		$mime->setParts(array($text,$html));
		$this->setBody($mime);
		
		if ($this->isValid())
		{
			$transport = new Smtp();
			return $transport->setOptions(new SmtpOptions(array(
				'host' => 'in.mailjet.com',
				'port' => '587',
				'connection_class' => 'login',
				'connection_config' => array(
					'username' => '9c317ebb7129193e21d80bac6ad3621c',
					'password' => 'cb0d42f79ed926b5fee2ad244c754fd4',
					'ssl' => 'tls'
				)
			)))->send($this);
		}	
	}
}