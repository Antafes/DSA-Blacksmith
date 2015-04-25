<?php
namespace Helper;

/**
 * Description of Mail
 *
 * @author Neithan
 */
class Mail
{
	/**
	 * Send an email
	 *
	 * @param array  $recipient
	 * @param string $subject
	 * @param string $message
	 *
	 * @return type
	 */
	public static function send($recipient, $subject, $message)
	{
		$translator = \SmartWork\Translator::getInstance();

		$mailer = new \PHPMailer(true);
		$mailer->set('CharSet', $GLOBALS['config']['charset']);
		$mailer->setFrom($GLOBALS['mail']['sender'], $translator->getTranslation('title'));
		$mailer->addAddress($recipient[0], $recipient[1]);
		$mailer->set('Subject', $subject);
		$mailer->set('AltBody', strip_tags($message));
		$mailer->msgHTML($message);
		$mailer->isHTML(true);

		return $mailer->send();
	}
}
