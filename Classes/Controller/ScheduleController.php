<?php
namespace CPSIT\T3eventsCourse\Controller;

use CPSIT\T3eventsCourse\Domain\Model\Dto\ScheduleDemand;

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
	 * @var \Webfox\T3events\Domain\Repository\GenreRepository
	 * @inject
	 */
	protected $genreRepository;

	/**
	 * Event location repository
	 *
	 * @var \Webfox\T3events\Domain\Repository\EventLocationRepository
	 * @inject
	 */
	protected $eventLocationRepository;

	/**
	 * Audience Repository
	 *
	 * @var \Webfox\T3events\Domain\Repository\AudienceRepository
	 * @inject
	 */
	protected $audienceRepository;

	/**
	 * eventTypeRepository
	 *
	 * @var \Webfox\T3events\Domain\Repository\EventTypeRepository
	 * @inject
	 */
	protected $eventTypeRepository;

	/**
	 * action list
	 *
	 * @param \array $overwriteDemand
	 * @return void
	 */
	public function listAction($overwriteDemand = NULL) {
		$demand = $this->createDemandFromSettings($this->settings);
		if ($overwriteDemand) {
			$this->overwriteDemandObject($demand, $overwriteDemand);
		}
		$lessons = $this->lessonRepository->findDemanded($demand, FALSE);
		if (($lessons instanceof \TYPO3\CMS\Extbase\Persistence\QueryResult AND !$lessons->count())
			OR !count($lessons)
		) {
			$this->addFlashMessage(
				\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('message.noLessonsForSelection.text', $this->extensionName),
				\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('message.noLessonsForSelection.title', $this->extensionName),
				\TYPO3\CMS\Core\Messaging\FlashMessage::NOTICE
			);
		}
		$configuration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		$this->view->assignMultiple(
			array(
				'lessons' => $lessons,
				'demand' => $demand,
				'overwriteDemand' => $overwriteDemand,
				'storagePid' => $configuration['persistence']['storagePid']
			)
		);
	}

	/**
	 * action show
	 *
	 * @param \CPSIT\T3eventsCourse\Domain\Model\Schedule $lesson
	 * @return void
	 */
	public function showAction(\CPSIT\T3eventsCourse\Domain\Model\Schedule $lesson) {
		$this->view->assign('lesson', $lesson);
	}


	/**
	 * Filter action
	 *
	 * @param \array $overwriteDemand
	 */
	public function filterAction($overwriteDemand = NULL) {
		$genreUids = \TYPO3\CMS\Core\Utility\GeneralUtility::intExplode(',', $this->settings['genres'], TRUE);
		$eventLocationUids = \TYPO3\CMS\Core\Utility\GeneralUtility::intExplode(',', $this->settings['eventLocations'], TRUE);
		$eventTypeUids = \TYPO3\CMS\Core\Utility\GeneralUtility::intExplode(',', $this->settings['eventTypes'], TRUE);
		$audienceUids = \TYPO3\CMS\Core\Utility\GeneralUtility::intExplode(',', $this->settings['audiences'], TRUE);
		if (count($genreUids)) {
			$genres = array();
			foreach ($genreUids as $genreUid) {
				if ($this->courseRepository->countContainingGenre($genreUid)) {
					$genres[] = $this->genreRepository->findByUid($genreUid);
				}
			}
		} else {
			$genres = $this->genreRepository->findAll();
		}
		if (count($eventLocationUids)) {
			$eventLocations = array();
			foreach ($eventLocationUids as $eventLocationUid) {
				if ($this->lessonRepository->countByEventLocation($eventLocationUid)) {
					$eventLocations[] = $this->eventLocationRepository->findByUid($eventLocationUid);
				}
			}
		} else {
			$eventLocations = $this->eventLocationRepository->findAll();
		}
		if (count($eventTypeUids)) {
			$eventTypes = array();
			foreach ($eventTypeUids as $eventTypeUid) {
				if ($this->courseRepository->countByEventType($eventTypeUid)) {
					$eventTypes[] = $this->eventTypeRepository->findByUid($eventTypeUid);
				}
			}
		} else {
			$eventTypes = $this->eventTypeRepository->findAll();
		}
		if (count($audienceUids)) {
			$audiences = array();
			foreach ($audienceUids as $audienceUid) {
				if ($this->courseRepository->countContainingAudience($audienceUid)) {
					$audiences[] = $this->audienceRepository->findByUid($audienceUid);
				}
			}
		} else {
			$audiences = $this->audienceRepository->findAll();
		}
		$this->view->assignMultiple(
			array(
				'overwriteDemand' => $overwriteDemand,
				'genres' => $genres,
				'eventLocations' => $eventLocations,
				'audiences' => $audiences,
				'eventTypes' => $eventTypes
			)
		);
	}

	/**
	 * Create Demand from Settings
	 *
	 * @param \array $settings
	 * @return \Webfox\T3events\Domain\Model\Dto\EventDemand
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
	 * @param \array $overwriteDemand
	 */
	public function overwriteDemandObject(&$demand, $overwriteDemand) {
		foreach ($overwriteDemand as $propertyName => $propertyValue) {
			\TYPO3\CMS\Extbase\Reflection\ObjectAccess::setProperty($demand, $propertyName, $propertyValue);
		}
	}
}
