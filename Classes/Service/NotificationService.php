<?php
namespace Cps\DakosyReservations\Service;

use TYPO3\CMS\Core\Cache\Backend\NullBackend;

class NotificationService {
	/**
	 * Object Manager
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManager
	 * @inject
	 */
	protected $objectManager;

	/**
	 * Configuration Manager
	 * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
	 * @inject
	 */
	protected $configurationManager;

	/**
	 * Notify using the given data
	 *
	 * @param string $recipient
	 * @param string $sender
	 * @param $subject
	 * @param string $templateName
	 * @param null|string $format
	 * @param $folderName
	 * @param array $variables
	 * @param array|null $attachments Variables which are passed to the template for rendering
	 * @param array $attachments
	 * @return \bool
	 */
	public function notify($recipient, $sender, $subject, $templateName, $format = NULL, $folderName, $variables = array(), $attachments = NULL) {
		$templateView = $this->buildTemplateView($templateName, $format, $folderName);
		$templateView->assignMultiple($variables);
		$body = $templateView->render();

		/** @var $message \TYPO3\CMS\Core\Mail\MailMessage */
		$message = $this->objectManager->get('TYPO3\\CMS\\Core\\Mail\\MailMessage');
		$message->setTo($recipient)
			->setFrom($sender)
			->setSubject($subject);
		$mailFormat = ($format == 'plain')? 'text/plain': 'text/html';

		$message->setBody($body, $mailFormat);
		if ($attachments){
			foreach($attachments as $attachment) {
				$fileToAttach =  $this->buildAttachementFromTemplate($attachment);
				$message->attach($fileToAttach);
			}
		}
		$message->send();
		return $message->isSent();
	}

	/**
	 * Renders the body of a notification using a given template
	 *
	 * @param \string $templateName
	 * @param \string|null $format
	 * @param \string $folderName
	 * @param \array $variables
	 * @return \string
	 */
	public function render($templateName, $format = NULL, $folderName, $variables = array()) {
		$templateView = $this->buildTemplateView($templateName, $format, $folderName);
		$templateView->assignMultiple($variables);
		return $templateView->render();
	}

	/**
	 * Sends a prepared notification
	 * Returns true on success and false on failure.
	 *
	 * @param \Cps\DakosyReservations\Domain\Model\Notification $notification
	 * @return bool
	 */
	public function send(&$notification) {
		/** @var $message \TYPO3\CMS\Core\Mail\MailMessage */
		$message = $this->objectManager->get('TYPO3\\CMS\\Core\\Mail\\MailMessage');
		$message->setTo($notification->getRecipient())
			->setFrom($notification->getSender())
			->setSubject($notification->getSubject());
		$mailFormat = ($notification->getFormat() == 'plain')? 'text/plain': 'text/html';

		$message->setBody($notification->getBodytext(), $mailFormat);
		$message->send();
		if($message->isSent()) {
			$notification->setSentAt(new \DateTime());
		}
		return $message->isSent();
	}

	/**
	 * Get a template view
	 *
	 * Uses the given template name
	 *
	 * @var \string $templateName
	 * @var \string $format Format for content. Default is html
	 * @return \TYPO3\CMS\Fluid\View\StandaloneView
	 */
	protected function buildTemplateView($templateName, $format = NULL, $folderName = NULL) {
		/** @var \TYPO3\CMS\Fluid\View\StandaloneView $emailView */
		$emailView = $this->objectManager->get('TYPO3\\CMS\\Fluid\\View\\StandaloneView');
		$emailView->setTemplatePathAndFilename(
			$this->getTemplatePathAndFileName($templateName, $folderName)
		);
		$emailView->setPartialRootPath(
			$this->getPartialRootPath()
		);
		if($format == 'plain') {
			$emailView->setFormat('txt');
		}
		return $emailView;
	}

	/**
	 * @var \array $data An array containing data for attachement generation
	 * @return \Swift_Attachment
	 */
	protected function buildAttachementFromTemplate($data) {
		$attachmentView = $this->buildTemplateView(
			$data['templateName'],
			NULL,
			$data['folderName']
		);
		$attachmentView->assignMultiple($data['variables']);
		$content = $attachmentView->render();
		$attachment = \Swift_Attachment::newInstance(
			$content,
			$data['fileName'],
			$data['mimeType']
		);
		return $attachment;
	}

	/**
	 * Get template path and file name
	 *
	 * @var \string $templateName File name (without extension)
	 * @var \string $folderName Optional folder name, default 'Email'
	 * @return \string
	 */
	protected function getTemplatePathAndFileName($templateName, $folderName = 'Email') {
		$extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		$templateRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPath']);
		$templatePathAndFilename = $templateRootPath . $folderName . '/' . $templateName . '.html';
		return $templatePathAndFilename;
	}

	/**
	 * Get the partial root path from framework configuration
	 *
	 * @return string
	 */
	protected function getPartialRootPath() {
		$extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		return \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['partialRootPath']);
	}

	/**
	 * Clones a given notification
	 *
	 * @param \Cps\DakosyReservations\Domain\Model\Notification $oldNotification
	 * @return \Cps\DakosyReservations\Domain\Model\Notification
	 */
	public function duplicate($oldNotification) {
		$notification = $this->objectManager->get('\\Cps\\DakosyReservations\\Domain\\Model\\Notification');
		$accessibleProperties = \TYPO3\CMS\Extbase\Reflection\ObjectAccess::getSettablePropertyNames($notification);
		foreach($accessibleProperties as $property) {
			\TYPO3\CMS\Extbase\Reflection\ObjectAccess::setProperty(
				$notification,
				$property,
				$oldNotification->_getProperty($property));
		}
		return $notification;
	}
}
