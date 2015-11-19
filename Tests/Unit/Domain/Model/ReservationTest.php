<?php

namespace Cps\DakosyReservations\Tests\Unit\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Dirk Wenzel <wenzel@cps-it.de>, CPS IT
 *           Boerge Franck <franck@cps-it.de>, CPS IT
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Test case for class \Cps\DakosyReservations\Domain\Model\Reservation.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Dirk Wenzel <wenzel@cps-it.de>
 * @author Boerge Franck <franck@cps-it.de>
 */
class ReservationTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {
	/**
	 * @var \Cps\DakosyReservations\Domain\Model\Reservation
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = new \Cps\DakosyReservations\Domain\Model\Reservation();
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getStatusReturnsInitialValueForInteger() {
		$this->assertSame(
			0,
			$this->subject->getStatus()
		);
	}

	/**
	 * @test
	 */
	public function setStatusForIntegerSetsStatus() {
		$this->subject->setStatus(12);

		$this->assertAttributeEquals(
			12,
			'status',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getCompanyReturnsInitialValueForCompany() {
		$this->assertEquals(
			NULL,
			$this->subject->getCompany()
		);
	}

	/**
	 * @test
	 */
	public function setCompanyForCompanySetsCompany() {
		$companyFixture = new \Cps\DakosyReservations\Domain\Model\Company();
		$this->subject->setCompany($companyFixture);

		$this->assertAttributeEquals(
			$companyFixture,
			'company',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getContactReturnsInitialValueForPerson() {
		$this->assertEquals(
			NULL,
			$this->subject->getContact()
		);
	}

	/**
	 * @test
	 */
	public function setContactForPersonSetsContact() {
		$contactFixture = new \Cps\DakosyReservations\Domain\Model\Person();
		$this->subject->setContact($contactFixture);

		$this->assertAttributeEquals(
			$contactFixture,
			'contact',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getParticipantsReturnsInitialValueForPerson() {
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getParticipants()
		);
	}

	/**
	 * @test
	 */
	public function setParticipantsForObjectStorageContainingPersonSetsParticipants() {
		$participant = new \Cps\DakosyReservations\Domain\Model\Person();
		$objectStorageHoldingExactlyOneParticipants = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneParticipants->attach($participant);
		$this->subject->setParticipants($objectStorageHoldingExactlyOneParticipants);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneParticipants,
			'participants',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addParticipantToObjectStorageHoldingParticipants() {
		$participant = new \Cps\DakosyReservations\Domain\Model\Person();
		$participantsObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$participantsObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($participant));
		$this->inject($this->subject, 'participants', $participantsObjectStorageMock);

		$this->subject->addParticipant($participant);
	}

	/**
	 * @test
	 */
	public function removeParticipantFromObjectStorageHoldingParticipants() {
		$participant = new \Cps\DakosyReservations\Domain\Model\Person();
		$participantsObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$participantsObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($participant));
		$this->inject($this->subject, 'participants', $participantsObjectStorageMock);

		$this->subject->removeParticipant($participant);

	}

	/**
	 * @test
	 */
	public function getLessonReturnsInitialValueForLesson() {	}

	/**
	 * @test
	 */
	public function setLessonForLessonSetsLesson() {	}
}
