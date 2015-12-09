<?php
namespace CPSIT\T3eventsCourse\Controller;

/***************************************************************
 *  Copyright notice
 *  (c) 2014 Dirk Wenzel <wenzel@cps-it.de>, CPS IT
 *  All rights reserved
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

class CourseController extends \TYPO3\CMS\Extbase\MVC\Controller\ActionController {

	/**
	 * courseRepository
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
	 * venueRepository
	 *
	 * @var \Webfox\T3events\Domain\Repository\VenueRepository
	 * @inject
	 */
	protected $venueRepository;

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
		$demand = $this->createDemandFromSettings($overwriteDemand);
		$courses = $this->courseRepository->findDemanded($demand);

		if (($courses instanceof \TYPO3\CMS\Extbase\Persistence\QueryResult AND !$courses->count())
			OR !count($courses)
		) {
			$this->addFlashmessage(
				$this->translate('message.noCoursesFound.text'),
				$this->translate('message.noCoursesFound.title'),
				\TYPO3\CMS\Core\Messaging\FlashMessage::WARNING
			);
		}
		$configuration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);

		$this->view->assignMultiple(
			array(
				'courses' => $courses,
				'demand' => $demand,
				'settings' => $this->settings,
				'storagePid' => $configuration['persistence']['storagePid'],
			)
		);
	}

	/**
	 * action show
	 *
	 * @param \CPSIT\T3eventsCourse\Domain\Model\Course $course
	 * @return void
	 */
	public function showAction(\CPSIT\T3eventsCourse\Domain\Model\Course $course) {
		$this->view->assign('course', $course);
	}

	/**
	 * action quickMenu
	 *
	 * @return void
	 */
	public function filterAction() {

		// get session data
		$sessionData = $GLOBALS['TSFE']->fe_user->getKey('ses', 'tx_t3events_overwriteDemand');
		$this->view->assign('overwriteDemand', unserialize($sessionData));

		// get genres from plugin
		$genres = $this->genreRepository->findMultipleByUid($this->settings['genres'], 'title');

		// get venues from plugin
		$venues = $this->venueRepository->findMultipleByUid($this->settings['venues'], 'title');

		// get event types from plugin
		$eventTypes = $this->eventTypeRepository->findMultipleByUid($this->settings['eventTypes'], 'title');

		$this->view->assignMultiple(
			array(
				'genres' => $genres,
				'venues' => $venues,
				'eventTypes' => $eventTypes
			)
		);
	}

	/**
	 * Build demand from settings respecting overwriteDemand
	 *
	 * @param \array overwriteDemand
	 * @return \Webfox\T3events\Domain\Model\Dto\EventDemand
	 */
	protected function createDemandFromSettings($overwriteDemand = NULL) {
		$demand = $this->objectManager->get('\\CPSIT\\T3eventsCourse\\Domain\\Model\\Dto\\CourseDemand');

		if (!is_null($overwriteDemand)) {
			$demand->setGenre($overwriteDemand['genre']);
			$demand->setVenue($overwriteDemand['venue']);
			$demand->setEventType($overwriteDemand['eventType']);
			$demand->setCategoryConjunction($overwriteDemand['categoryConjunction']);

			// set sort criteria
			switch ($overwriteDemand['sortBy']) {
				case 'date':
					$demand->setSortBy('performances.date');

					break;
				case 'headline':
					$demand->setSortBy('headline');
					break;
				default:
					$demand->setSortBy('lessons.date');
					break;
			}
			// set sort direction
			switch ($overwriteDemand['sortDirection']) {
				case 'asc':
					$demand->setSortDirection('asc');
					break;
				case 'desc':
					$demand->setSortDirection('desc');
					break;
				default:
					$demand->setSortDirection('asc');
					break;
			}
			// store data in session
			$sessionData = serialize($overwriteDemand);
			$GLOBALS['TSFE']->fe_user->setKey('ses', 'tx_t3events_overwriteDemand', $sessionData);
			$GLOBALS['TSFE']->fe_user->storeSessionData();
		}
		// get arguments from plugin
		if (!$demand->getSortBy()) {
			switch ($this->settings['sortBy']) {
				case 'date':
					$demand->setSortBy('lessons.date');
					break;
				case 'title':
					$demand->setSortBy('headline');
					break;

				default:
					$demand->setSortBy('lessons.date');
					break;
			}
		}

		(!$demand->getEventType()) ? $demand->setEventType($this->settings['eventTypes']) : NULL;
		if (!$demand->getSortDirection()) {
			$demand->setSortDirection($this->settings['sortDirection']);
		}
		if ((int) $this->settings['maxItems']) {
			$demand->setLimit((int) $this->settings['maxItems']);
		}
		if (!$demand->getVenue() && $this->settings['venues'] != '') {
			$demand->setVenue($this->settings['venues']);
		}
		if (!$demand->getGenre() && $this->settings['genres'] != '') {
			$demand->setGenre($this->settings['genres']);
		}
		$demand->setPeriod($this->settings['period']);
		if ($this->settings['period'] == 'specific') {
			$demand->setPeriodType($this->settings['periodType']);
		}
		if (isset($this->settings['periodType']) AND $this->settings['periodType'] != 'byDate') {
			$demand->setPeriodStart($this->settings['periodStart']);
			$demand->setPeriodDuration($this->settings['periodDuration']);
		}
		if ($this->settings['periodType'] == 'byDate' && $this->settings['periodStartDate']) {
			$demand->setStartDate($this->settings['periodStartDate']);
		}
		if ($this->settings['periodType'] == 'byDate' && $this->settings['periodEndDate']) {
			$demand->setEndDate($this->settings['periodEndDate']);
		}
		if (!$demand->getCategoryConjunction()) {
			$demand->setCategoryConjunction($this->settings['categoryConjunction']);
		}

		return $demand;
	}

	/**
	 * Translate a given key
	 *
	 * @param \string $key
	 * @param \string $extension
	 * @param \array $arguments
	 * @codeCoverageIgnore
	 */
	public function translate($key, $extension = 't3events_course', $arguments = NULL) {
		$translatedString = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate($key, $extension, $arguments);
		if (is_null($translatedString)) {
			return $key;
		} else {
			return $translatedString;
		}
	}

}

