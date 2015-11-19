<?php
namespace Cps\DakosyReservations\Controller;

class LessonBackendController extends LessonController {
	/**
	 * Page uid
	 *
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
		$this->lessonRepository->setDefaultOrderings(array('date' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING));
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
		if (isset($tsConfig['module.']['tx_dakosyreservations.']['lesson.']) && is_array($tsConfig['module.']['tx_dakosyreservations.']['lesson.'])) {
			$this->tsConfiguration = $tsConfig['module.']['tx_dakosyreservations.']['lesson.'];
		}
	}


	/**
	 * Create Demand from Settings
	 *
	 * @param \array $settings
	 * @return \Webfox\T3events\Domain\Model\Dto\EventDemand
	 */
	protected function createDemandFromSettings($settings) {
		$demand = parent::createDemandFromSettings($settings['lesson']['list']);
		return $demand;
	}
}