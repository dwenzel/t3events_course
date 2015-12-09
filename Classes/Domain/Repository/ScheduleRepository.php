<?php
namespace CPSIT\T3eventsCourse\Domain\Repository;

/***************************************************************
 *  Copyright notice
 *  (c) 2014 Dirk Wenzel <dirk.wenzel@cps-it.de>, CPS-IT
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
use CPSIT\T3eventsCourse\Domain\Model\Dto\ScheduleDemand;
use Webfox\T3events\Domain\Repository\PerformanceRepository;

/**
 * The repository for Lessons
 */
class ScheduleRepository extends PerformanceRepository {
	/**
	 * Returns an array of constraints created from a given demand object.
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
	 * @param \Webfox\T3events\Domain\Model\Dto\DemandInterface $demand
	 * @return array<\TYPO3\CMS\Extbase\Persistence\Generic\Qom\Constraint>
	 */
	protected function createConstraintsFromDemand(\TYPO3\CMS\Extbase\Persistence\QueryInterface $query, \Webfox\T3events\Domain\Model\Dto\DemandInterface $demand) {
		$constraints = parent::createConstraintsFromDemand($query, $demand);
		/** @var ScheduleDemand $demand */
		if ($demand->getDeadlineBefore() !== NULL) {
			$constraints[] = $query->lessThanOrEqual('deadline', $demand->getDeadlineBefore());
		}
		if ($demand->getDeadlineAfter() !== NULL) {
			$constraints[] = $query->greaterThan('deadline', $demand->getDeadlineAfter());
		}
		$constraintsConjunction = $demand->getConstraintsConjunction();
		if ($demand->getGenres()) {
			$genres = \TYPO3\CMS\Core\Utility\GeneralUtility::intExplode(',', $demand->getGenres());
			$genreConstraints = array();
			foreach ($genres as $genre) {
				$genreConstraints[] = $query->contains('course.genre', $genre);
			}
			$this->combineConstraints($query, $constraints, $genreConstraints, $constraintsConjunction);
		}
		if ($demand->getEventLocations()) {
			$eventLocations = \TYPO3\CMS\Core\Utility\GeneralUtility::intExplode(',', $demand->getEventLocations());
			$eventLocationConstraints = array();
			foreach ($eventLocations as $eventLocation) {
				$eventLocationConstraints[] = $query->equals('eventLocation.uid', $eventLocation);
			}
			$this->combineConstraints($query, $constraints, $eventLocationConstraints, $constraintsConjunction);
		}
		if ($demand->getEventTypes()) {
			$eventTypes = \TYPO3\CMS\Core\Utility\GeneralUtility::intExplode(',', $demand->getEventTypes());
			$eventTypeConstraints = array();
			foreach ($eventTypes as $eventType) {
				$eventTypeConstraints[] = $query->equals('course.eventType.uid', $eventType);
			}
			$this->combineConstraints($query, $constraints, $eventTypeConstraints, $constraintsConjunction);
		}
		if ($demand->getAudiences()) {
			$audiences = \TYPO3\CMS\Core\Utility\GeneralUtility::intExplode(',', $demand->getAudiences());
			$audienceConstraints = array();
			foreach ($audiences as $audience) {
				$audienceConstraints[] = $query->equals('course.audience.uid', $audience);
			}
			$this->combineConstraints($query, $constraints, $audienceConstraints, $constraintsConjunction);
		}

		return $constraints;
	}
}