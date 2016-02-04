<?php

namespace CPSIT\T3eventsCourse\Tests\Unit\Domain\Model;

/***************************************************************
 *  Copyright notice
 *  (c) 2014 Dirk Wenzel <wenzel@cps-it.de>, CPS IT
 *           Boerge Franck <franck@cps-it.de>, CPS IT
 *  All rights reserved
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
use CPSIT\T3eventsCourse\Domain\Model\Schedule;
use TYPO3\CMS\Core\Tests\UnitTestCase;

/**
 * Class ScheduleTest
 *
 * @package CPSIT\T3eventsCourse\Tests\Unit\Domain\Model
 */
class ScheduleTest extends UnitTestCase {

	/**
	 * @var \CPSIT\T3eventsCourse\Domain\Model\Schedule
	 */
	protected $subject;

	protected function setUp() {
		$this->subject = $this->getMock(
			Schedule::class, ['dummy'], [], '', TRUE
		);
	}

	/**
	 * @test
	 */
	public function getClassTimeForStringInitiallyReturnsNull() {
		$this->assertNull(
			$this->subject->getClassTime()
		);
	}

	/**
	 * @test
	 */
	public function setClassTimeForStringSetsClassTime() {
		$value = '123';
		$this->subject->setClassTime($value);

		$this->assertSame(
			$value,
			$this->subject->getClassTime()
		);
	}
}
