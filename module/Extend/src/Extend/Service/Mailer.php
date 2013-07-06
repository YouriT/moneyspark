<?php
namespace Extend\Service;

use Zend\Mail\Message;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;

class Mailer extends AbstractService
{
	/**
	 * @var \Zend\View\Renderer\RendererInterface
	 */
	protected $renderer;

	/**
	 * @var \Zend\Mail\Transport\Smtp
	 */
	protected $smtpTransport;

	/**
	 * Return a HTML message ready to be sent
	 *
	 * @param  array|string                           $to          An array containing the recipients of the mail
	 * @param  string                                 $subject     Subject of the mail
	 * @param  string|\Zend\View\Model\ModelInterface $nameOrModel Either the template to use, or a ViewModel
	 * @param  null|array                             $values      Values to use when the template is rendered
	 * @return Message
	 */
	public function createHtmlMessage($to, $subject, $nameOrModel, $values = array())
	{
		$renderer = $this->getRenderer();
		$content = $renderer->render($nameOrModel, $values);

		$text = new MimePart('');
		$text->type = "text/plain";

		$html = new MimePart($content);
		$html->type = "text/html";

		$body = new MimeMessage();
		$body->setParts(array($text, $html));

		$message = $this->getDefaultMessage();
		$message->setSubject($subject)
		->setBody($body)
		->setTo($to);

		return $message;
	}

	/**
	 * Return a text message ready to be sent
	 *
	 * @param  array|string                           $to          An array containing the recipients of the mail
	 * @param  string                                 $subject     Subject of the mail
	 * @param  string|\Zend\View\Model\ModelInterface $nameOrModel Either the template to use, or a ViewModel
	 * @param  null|array                             $values      Values to use when the template is rendered
	 * @return Message
	 */
	public function createTextMessage($to, $subject, $nameOrModel, $values = array())
	{
		$renderer = $this->getRenderer();
		$content = $renderer->render($nameOrModel, $values);

		$message = $this->getDefaultMessage();
		$message->setSubject($subject)
		->setBody($content)
		->setTo($to);

		return $message;
	}

	/**
	 * Send the message
	 *
	 * @param Message $message
	 */
	public function send(Message $message)
	{
		$this->getSmtpTransport()->send($message);
	}

	/**
	 * Get the renderer
	 *
	 * @return \Zend\View\Renderer\RendererInterface
	 */
	protected function getRenderer()
	{
		if ($this->renderer === null) {
			$this->renderer = $this->getServiceManager()->get('ViewRenderer');
		}

		return $this->renderer;
	}

	/**
	 * Get the transport
	 *
	 * @return \Zend\Mail\Transport\Smtp
	 */
	protected function getSmtpTransport()
	{
		if ($this->smtpTransport === null) {
			$this->smtpTransport = $this->getServiceManager()->get('common.mailer.smtp_transport');
		}

		return $this->smtpTransport;
	}

	/**
	 * @return Message
	 */
	protected function getDefaultMessage()
	{
		return $this->getServiceManager()->get('common.mailer.default_message');
	}
}