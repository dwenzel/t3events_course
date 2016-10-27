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
use DWenzel\T3events\Domain\Model\Dto\DemandInterface;
use DWenzel\T3events\Domain\Repository\PerformanceRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

/**
 * The repository for Lessons
 */
class ScheduleRepository extends PerformanceRepository {
	/**
	 * Returns an array of constraints created from a given demand object.
	 *
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @param \DWenzel\T3events\Domain\Model\Dto\DemandInterface $demand
	 * @return array<\TYPO3\CMS\Extbase\Persistence\Generic\Qom\Constraint>
	 */
	public function createConstraintsFromDemand(QueryInterface $query, DemandInterface $demand) {
		$constraints = parent::createConstraintsFromDemand($query, $demand);
		/** @var ScheduleDemand $demand */
		if ($demand->getDeadlineBefore() !== NULL) {
			$constraints[] = $query->lessThanOrEqual('deadline', $demand->getDeadlineBefore());
		}
		if ($demand->getDeadlineAfter() !== NULL) {
			$constraints[] = $query->greaterThan('deadline', $demand->getDeadlineAfter());
		}

		return $constraints;
	}
}