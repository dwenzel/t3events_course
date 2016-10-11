<?php
namespace CPSIT\T3eventsCourse\Controller;

use CPSIT\T3eventsCourse\Domain\Model\Dto\ScheduleDemand;
use CPSIT\T3eventsCourse\Domain\Model\Schedule;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResult;
use TYPO3\CMS\Extbase\Reflection\ObjectAccess;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Class ScheduleController
 *
 * @package CPSIT\T3eventsCourse\Controller
 */
class ScheduleController extends AbstractController {

	/**
	 * Schedule Repository
	 *
	 * @var \CPSIT\T3eventsCourse\Domain\Repository\ScheduleRepository
	 * @inject
	 */
	protected $lessonRepository;

	/**
	 * Course Repository
	 *
	 * @var \CPSIT\T3eventsCourse\Domain\Repository\CourseRepository
	 * @inject
	 */
	protected $courseRepository;

	/**
	 * genreRepository
	 *
	 * @var \DWenzel\T3events\Domain\Repository\GenreRepository
	 * @inject
	 */
	protected $genreRepository;

	/**
	 * Event location repository
	 *
	 * @var \DWenzel\T3events\Domain\Repository\EventLocationRepository
	 * @inject
	 */
	protected $eventLocationRepository;

	/**
	 * Audience Repository
	 *
	 * @var \DWenzel\T3events\Domain\Repository\AudienceRepository
	 * @inject
	 */
	protected $audienceRepository;

	/**
	 * eventTypeRepository
	 *
	 * @var \DWenzel\T3events\Domain\Repository\EventTypeRepository
	 * @inject
	 */
	protected $eventTypeRepository;

	/**
	 * action list
	 *
	 * @param array $overwriteDemand
	 * @return void
	 */
	public function listAction($overwriteDemand = NULL) {
		$demand = $this->createDemandFromSettings($this->settings);
		if ($overwriteDemand) {
			$this->overwriteDemandObject($demand, $overwriteDemand);
		}
		$lessons = $this->lessonRepository->findDemanded($demand, FALSE);
		if (($lessons instanceof QueryResult AND !$lessons->count())
			OR !count($lessons)
		) {
			$this->addFlashMessage(
				LocalizationUtility::translate('message.noLessonsForSelection.text', $this->extensionName),
				LocalizationUtility::translate('message.noLessonsForSelection.title', $this->extensionName),
				FlashMessage::NOTICE
			);
		}
		$configuration = $this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		$this->view->assignMultiple(
			[
				'lessons' => $lessons,
				'demand' => $demand,
				'overwriteDemand' => $overwriteDemand,
				'storagePid' => $configuration['persistence']['storagePid']
            ]
		);
	}

	/**
	 * action show
	 *
     * @param \CPSIT\T3eventsCourse\Domain\Model\Schedule $lesson
	 * @return void
	 */
	public function showAction(Schedule $lesson) {
		$this->view->assign('lesson', $lesson);
	}


	/**
	 * Filter action
	 *
	 * @param array $overwriteDemand
	 */
	public function filterAction($overwriteDemand = NULL) {
		$genreUids = GeneralUtility::intExplode(',', $this->settings['genres'], TRUE);
		$eventLocationUids = GeneralUtility::intExplode(',', $this->settings['eventLocations'], TRUE);
		$eventTypeUids = GeneralUtility::intExplode(',', $this->settings['eventTypes'], TRUE);
		$audienceUids = GeneralUtility::intExplode(',', $this->settings['audiences'], TRUE);
		if (count($genreUids)) {
			$genres = [];
			foreach ($genreUids as $genreUid) {
				if ($this->courseRepository->countContainingGenre($genreUid)) {
					$genres[] = $this->genreRepository->findByUid($genreUid);
				}
			}
		} else {
			$genres = $this->genreRepository->findAll();
		}
		if (count($eventLocationUids)) {
			$eventLocations = [];
			foreach ($eventLocationUids as $eventLocationUid) {
				if ($this->lessonRepository->countByEventLocation($eventLocationUid)) {
					$eventLocations[] = $this->eventLocationRepository->findByUid($eventLocationUid);
				}
			}
		} else {
			$eventLocations = $this->eventLocationRepository->findAll();
		}
		if (count($eventTypeUids)) {
			$eventTypes = [];
			foreach ($eventTypeUids as $eventTypeUid) {
				if ($this->courseRepository->countByEventType($eventTypeUid)) {
					$eventTypes[] = $this->eventTypeRepository->findByUid($eventTypeUid);
				}
			}
		} else {
			$eventTypes = $this->eventTypeRepository->findAll();
		}
		if (count($audienceUids)) {
			$audiences = [];
			foreach ($audienceUids as $audienceUid) {
				if ($this->courseRepository->countContainingAudience($audienceUid)) {
					$audiences[] = $this->audienceRepository->findByUid($audienceUid);
				}
			}
		} else {
			$audiences = $this->audienceRepository->findAll();
		}
		$this->view->assignMultiple(
			[
				'overwriteDemand' => $overwriteDemand,
				'genres' => $genres,
				'eventLocations' => $eventLocations,
				'audiences' => $audiences,
				'eventTypes' => $eventTypes
            ]
		);
	}

	/**
	 * Create Demand from Settings
	 *
	 * @param array $settings
	 * @return \CPSIT\T3eventsCourse\Domain\Model\Dto\ScheduleDemand
	 */
	protected function createDemandFromSettings($settings) {
		/** @var \CPSIT\T3eventsCourse\Domain\Model\Dto\ScheduleDemand $demand */
		$demand = $this->objectManager->get(ScheduleDemand::class);

		if ($settings['period'] == 'specific') {
			$demand->setPeriodType($settings['periodType']);
		} else {
			$demand->setPeriod($settings['period']);
		}
		if ($settings['period'] === 'futureOnly'
			OR $settings['period'] === 'pastOnly'
		) {
			$demand->setDate(new \DateTime('midnight'));
		}
		if (isset($settings['periodType']) AND $settings['periodType'] != 'byDate') {
			$demand->setPeriodStart($settings['periodStart']);
			$demand->setPeriodDuration($settings['periodDuration']);
		}
		if ($settings['periodType'] == 'byDate' AND $settings['periodStartDate']) {
			$demand->setStartDate($settings['periodStartDate']);
		}
		if ($settings['periodType'] == 'byDate' AND $settings['periodEndDate']) {
			$demand->setEndDate($settings['periodEndDate']);
		}
		if ($settings['hideAfterDeadline']) {
			$demand->setDeadlineAfter(new \DateTime());
		}
		$demand->setConstraintsConjunction($settings['constraintsConjunction']);

		if (!empty($settings['genres'])) {
			$demand->setGenres($settings['genres']);
		}
		if (!empty($settings['eventLocations'])) {
			$demand->setEventLocations($settings['eventLocations']);
		}
		if (!empty($settings['eventTypes'])) {
			$demand->setEventTypes($settings['eventTypes']);
		}
		if (!empty($settings['audiences'])) {
			$demand->setAudiences($settings['audiences']);
		}

		// sorting
		switch ($settings['sortBy']) {
			case 'title':
				$demand->setSortBy('course.headline');
				break;
			default:
				$demand->setSortBy('date');
				break;
		}
		$demand->setSortDirection($settings['sortDirection']);
		if ($demand->getSortBy()) {
			$demand->setOrder($demand->getSortBy() . '|' . $settings['sortDirection']);
		}

		$demand->setLimit((int) $settings['maxItems']);

		return $demand;
	}

	/**
	 * Overwrites a given demand object by an propertyName => $propertyValue array
	 *
	 * @param \CPSIT\T3eventsCourse\Domain\Model\Dto\ScheduleDemand $demand
	 * @param array $overwriteDemand
	 */
	public function overwriteDemandObject(&$demand, $overwriteDemand) {
		foreach ($overwriteDemand as $propertyName => $propertyValue) {
			ObjectAccess::setProperty($demand, $propertyName, $propertyValue);
		}
	}
}
