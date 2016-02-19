<?php
namespace CPSIT\T3eventsCourse\Controller\Backend;

use CPSIT\T3eventsCourse\Domain\Model\Dto\CourseDemand;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use Webfox\T3events\Controller\AbstractBackendController;

/**
 * Class CourseBackendController
 *
 * @package CPSIT\T3eventsCourse\Controller\Backend
 */
class CourseBackendController extends AbstractBackendController {

	/**
	 * courseRepository
	 *
	 * @var \CPSIT\T3eventsCourse\Domain\Repository\CourseRepository
	 * @inject
	 */
	protected $courseRepository;

	/**
	 * action list
	 *
	 * @param array $overwriteDemand
	 * @return void
	 */
	public function listAction($overwriteDemand = NULL) {
		$demand = $this->createDemandFromSettings(
			$this->settings[$this->settingsUtility->getControllerKey($this)]
		);

		if ($overwriteDemand === NULL) {
			$overwriteDemand = $this->moduleData->getOverwriteDemand();
		} else {
			$this->moduleData->setOverwriteDemand($overwriteDemand);
		}

		$this->overwriteDemandObject($demand, $overwriteDemand);
		$this->moduleData->setDemand($demand);

		$courses = $this->courseRepository->findDemanded($demand);

		if (($courses instanceof QueryResultInterface AND !$courses->count())
			OR !count($courses)
		) {
			$this->addFlashmessage(
				$this->translate('message.noCoursesFound.text'),
				$this->translate('message.noCoursesFound.title'),
				FlashMessage::WARNING
			);
		}
		$configuration = $this->configurationManager->getConfiguration(
			ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK
		);

		$this->view->assignMultiple(
			[
				'courses' => $courses,
				'demand' => $demand,
				'settings' => $this->settings,
				'storagePid' => $configuration['persistence']['storagePid'],
			]
		);
	}

	/**
	 * Create Demand from Settings
	 *
	 * @param array $settings
	 * @return \Webfox\T3events\Domain\Model\Dto\EventDemand
	 */
	protected function createDemandFromSettings($settings) {
		$demand = $this->objectManager->get(CourseDemand::class);
		$demand->setSortBy('headline');

		if (isset($settings['list']['maxItems'])) {
			$demand->setLimit($settings['list']['maxItems']);
		}

		return $demand;
	}
}
