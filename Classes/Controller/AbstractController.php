<?php
namespace Cps\DakosyReservations\Controller;
/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 *
 *
 * @package t3events_course
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class AbstractController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {
	const SESSION_NAMESPACE = 'tx_dakosyreservations';

	/**
	 * Persistence Manager
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
	 * @inject
	 */
	protected $persistenceManager;

	/**
	 * Notification Service
	 *
	 * @var \Cps\DakosyReservations\Service\NotificationService
	 * @inject
	 */
	protected $notificationService;

	/**
	 * Request Arguments
	 * @var \array
	 */
	protected $requestArguments = NULL;

	/*
	 * Referrer Arguments
	 * @var \array
	 */
	protected $referrerArguments = array();

	/**
	 * @var string
	 */
	protected $entityNotFoundMessage = 'The requested entity could not be found';

	/**
	 * @var string
	 */
	protected $errorMessage = 'unknownError';

	/**
	 * Initialize Action
	 */
	public function initializeAction() {
		$this->setRequestArguments();
		$this->setReferrerArguments();
	}

	/**
	 * Set request arguments
	 *
	 * @return void
	 */
	protected function setRequestArguments() {
		$originalRequestArguments = $this->request->getArguments();
		$action = $originalRequestArguments['action'];
		unset($originalRequestArguments['action']);
		unset($originalRequestArguments['controller']);

		$this->requestArguments = array(
			'action' => $action ,
			'pluginName' => $this->request->getPluginName(),
			'controllerName' => $this->request->getControllerName(),
			'extensionName' => $this->request->getControllerExtensionName(),
			'arguments' => $originalRequestArguments,
		);
	}

	/**
	 * Set referrer arguments
	 *
	 * @return void
	 */
	protected function setReferrerArguments() {
		if($this->request->hasArgument('referrerArguments') AND
			is_array($this->request->getArgument('referrerArguments'))) {
		    $this->referrerArguments = $this->request->getArgument('referrerArguments');
		} else {
		    $this->referrerArguments = array();
		}
	}

	/**
	 * Get mapping configuration for property
	 *
	 * Returns the property mapping configuration for a given
	 * argument / property combination 
	 * or false if arguments does not have such an argument
	 *
	 * @param \string $argumentName Name of argument
	 * @param \string $propertyName Name of the property e.g. 'foo.bar'
	 * @return \TYPO3\CMS\Extbase\Property\PropertyMappingConfiguration|NULL
	 */
	protected function getMappingConfigurationForProperty($argumentName, $propertyName) {
		$mappingConfiguration = FALSE;
		if($this->arguments->hasArgument($argumentName)) {
			$mappingConfiguration = $this->arguments
				->getArgument($argumentName)
				->getPropertyMappingConfiguration()
				->forProperty($propertyName);
		}
		return $mappingConfiguration;
	}

	/**
	* @param \TYPO3\CMS\Extbase\Mvc\RequestInterface $request
	* @param \TYPO3\CMS\Extbase\Mvc\ResponseInterface $response
	* @return void
	* @throws \Exception
	* @override \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
	*/
	public function processRequest(\TYPO3\CMS\Extbase\Mvc\RequestInterface $request, \TYPO3\CMS\Extbase\Mvc\ResponseInterface $response) {
		try{
			parent::processRequest($request, $response);
		}
		catch(\Exception $exception) {
			// If the property mapper did throw a \TYPO3\CMS\Extbase\Property\Exception, because it was unable to find the requested entity, call the page-not-found handler.
			$previousException = $exception->getPrevious();
			if (($exception instanceof \TYPO3\CMS\Extbase\Property\Exception) && (($previousException instanceof \TYPO3\CMS\Extbase\Property\Exception\TargetNotFoundException) || ($previousException instanceof \TYPO3\CMS\Extbase\Property\Exception\InvalidSourceException))) {
				$configuration = isset($this->settings[strtolower($request->getControllerName())]['detail']['errorHandling'])? $this->settings[strtolower($request->getControllerName())]['detail']['errorHandling'] : NULL;
				if($configuration ) {
					$this->handleEntityNotFoundError($configuration);
				}
			}
			throw $exception;
		}
	}

	/**
	 * Error handling if requested entity is not found
	 *
	 * @param \string $configuration Configuration for handling
	 */
	public function handleEntityNotFoundError($configuration) {
		if(empty($configuration)) {
			return;
		}
		$configuration = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $configuration);
		switch($configuration[0]) {
			case 'redirectToListView':
				$this->redirect('list');
				break;
			case 'redirectToPage':
				if (count($configuration) === 1 || count($configuration) > 3) {
					$msg = sprintf('If error handling "%s" is used, either 2 or 3 arguments, splitted by "," must be used', $configuration[0]);
					throw new \InvalidArgumentException($msg);
				}
				$this->uriBuilder->reset();
				$this->uriBuilder->setTargetPageUid($configuration[1]);
				$this->uriBuilder->setCreateAbsoluteUri(TRUE);
				if (\TYPO3\CMS\Core\Utility\GeneralUtility::getIndpEnv('TYPO3_SSL')) {
					$this->uriBuilder->setAbsoluteUriScheme('https');
				}
				$url = $this->uriBuilder->build();
				if (isset($configuration[2])) {
					$this->redirectToUri($url, 0, (int)$configuration[2]);
				} else {
					$this->redirectToUri($url);
				}
				break;
			case 'pageNotFoundHandler':
					$GLOBALS['TSFE']->pageNotFoundAndExit($this->entityNotFoundMessage);
				break;
			default:
		}
	}

	/**
	 * Translate a given key
	 *
	 * @param \string $key
	 * @param \string $extension
	 * @param \array $arguments
	 * @codeCoverageIgnore
	 */
	public function translate($key, $extension='t3events_course', $arguments=NULL) {
		$translatedString = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate($key, $extension, $arguments);
		if(is_null($translatedString)) {
			return $key;
		}
		else {
			return $translatedString;
		}
	}

	/**
	 * Gets the frontend user
	 *
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FrontendUser	The current extended frontend user object
	 */
	protected function getFrontendUser() {
		if ($GLOBALS ['TSFE']->fe_user) {
			return $GLOBALS ['TSFE']->fe_user;
		}
	}

	/**
	 * Returns the object stored in the user´s session
	 * @param \string $key
	 * @return \Object the stored object
	 */
	public function getSessionKey($key) {
		return $this->getFrontendUser()->getKey('ses', self::SESSION_NAMESPACE.$key);
	}

	/**
	 * Writes something to storage
	 * @param \string $key
	 * @param \string $value
	 * @return	void
	 */
	public function setSessionKey($key,$value) {
		$this->getFrontendUser()->setKey('ses', self::SESSION_NAMESPACE.$key, $value);
		$this->getFrontendUser()->storeSessionData();
	}

	/**
	 * checks if object is stored in the user´s session
	 * @param \string $key
	 * @return \boolean
	 */
	public function hasKey($key) {
		$sessionData = $this->getFrontendUser()->getKey('ses', self::SESSION_NAMESPACE.$key);
		if ($sessionData == '') {
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * Checks if access is allowed
	 *
	 * @param \object $object Object which should be accessed
	 * @return \boolean
	 */
	public function isAccessAllowed($object) {
		$className = get_class($object);
		$isAllowed = FALSE;
		switch ($className) {
			case 'Cps\DakosyReservations\Domain\Model\Reservation':
				$isAllowed = ($this->hasKey('reservationUid')
					AND method_exists($object, 'getUid')
					AND $this->getSessionKey('reservationUid') == $object->getUid())? TRUE : FALSE;
				break;
			default:
				break;
		}
		return $isAllowed;
	}

}
