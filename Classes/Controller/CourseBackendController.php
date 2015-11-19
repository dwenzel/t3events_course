<?php
namespace Cps\DakosyReservations\Controller;

class CourseBackendController extends CourseController {
	/**
	 * Page uid
	 *
	 * @var integer
	 * @var integer
	 * @var integer
	 * @var integer
	 */
	protected $pageUid = 0;

	/**
	 * Initialize Action
	 * Function will be called before every other action
	 *
	 * @return void
	 */
	public function initializeAction() {
		$this->pageUid = (int)\TYPO3\CMS\Core\Utility\GeneralUtility::_GET('id');
		$this->setTsConfig();
		parent::initializeAction();
	}

	/**
	 * Set the TsConfig configuration for the extension
	 *
	 * @return void
	 */
	protected function setTsConfig() {
		$tsConfig = \TYPO3\CMS\Backend\Utility\BackendUtility::getPagesTSconfig($this->pageUid);
		if (isset($tsConfig['tx_dakosysemiars.']['module.']) && is_array($tsConfig['tx_dakosyreservations.']['module.'])) {
			$this->tsConfiguration = $tsConfig['tx_dakosyreservations.']['module.'];
		}
	}


	/**
	 * Create Demand from Settings
	 *
	 * @param \array $settings
	 * @return \Webfox\T3events\Domain\Model\Dto\EventDemand
	 */
	protected function createDemandFromSettings($settings) {
		$demand = $this->objectManager->get('Cps\\DakosyReservations\\Domain\\Model\\Dto\\CourseDemand');
		//$demand = parent::createDemandFromSettings($settings);
		$demand->setSortBy('headline');
		//$demand->setStoragePages((string)$this->pageUid);
		return $demand;
	}
}