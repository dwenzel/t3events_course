<?php
namespace CPSIT\T3eventsCourse\Controller\Backend;

use CPSIT\T3eventsCourse\Domain\Model\Dto\CourseDemand;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Reflection\ObjectAccess;
use Webfox\T3events\Controller\AbstractBackendController;
use Webfox\T3events\Controller\FilterableControllerInterface;
use Webfox\T3events\Controller\FilterableControllerTrait;

/**
 * Class CourseBackendController
 *
 * @package CPSIT\T3eventsCourse\Controller\Backend
 */
class CourseBackendController
	extends AbstractBackendController
	implements FilterableControllerInterface {
	use FilterableControllerTrait;

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
		$demand = $this->createDemandFromSettings($this->settings);

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
				'overwriteDemand' => $overwriteDemand,
				'filterOptions' => $this->getFilterOptions($this->settings['filter']),
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

		foreach ($settings as $propertyName => $propertyValue) {
			if (empty($propertyValue)) {
				continue;
			}
			switch ($propertyName) {
				case 'eventTypes':
					$demand->setEventType($propertyValue);
					break;
				case 'venues':
					$demand->setVenue($propertyValue);
					break;
				case 'maxItems':
					$demand->setLimit($propertyValue);
					break;
				case 'genres':
					$demand->setGenre($propertyValue);
					break;
				// all following fall through (see below)
				case 'periodType':
				case 'periodStart':
				case 'periodEndDate':
				case 'periodDuration':
				case 'search':
					break;
				default:
					if (ObjectAccess::isPropertySettable($demand, $propertyName)) {
						ObjectAccess::setProperty($demand, $propertyName, $propertyValue);
					}
			}
		}

		if (isset($settings['sortBy']) && isset($settings['sortDirection'])){
			$demand->setOrder($settings['sortBy'] . '|' . $settings['sortDirection']);
		} else {
			$demand->setOrder('headline');
		}
		if ($settings['period'] == 'specific') {
			$demand->setPeriodType($settings['periodType']);
		}
		if (isset($settings['periodType']) AND $settings['periodType'] != 'byDate') {
			$demand->setPeriodStart($settings['periodStart']);
			$demand->setPeriodDuration($settings['periodDuration']);
		}
		if ($settings['periodType'] == 'byDate') {
			if ($settings['periodStartDate']) {
				$demand->setStartDate($settings['periodStartDate']);
			}
			if ($settings['periodEndDate']) {
				$demand->setEndDate($settings['periodEndDate']);
			}
		}

		return $demand;
	}
}
