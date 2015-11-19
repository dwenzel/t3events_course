<?php
namespace Cps\DakosyReservations\Tests\Unit\Controller;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Dirk Wenzel <wenzel@cps-it.de>, CPS IT
 *  			Boerge Franck <franck@cps-it.de>, CPS IT
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
 * Test case for class Cps\DakosyReservations\Controller\ReservationController.
 *
 * @author Dirk Wenzel <wenzel@cps-it.de>
 * @author Boerge Franck <franck@cps-it.de>
 */
class ReservationControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \Cps\DakosyReservations\Controller\ReservationController
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = $this->getMock('Cps\\DakosyReservations\\Controller\\ReservationController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllReservationsFromRepositoryAndAssignsThemToView() {

		$allReservations = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$reservationRepository = $this->getMock('Cps\\DakosyReservations\\Domain\\Repository\\ReservationRepository', array('findAll'), array(), '', FALSE);
		$reservationRepository->expects($this->once())->method('findAll')->will($this->returnValue($allReservations));
		$this->inject($this->subject, 'reservationRepository', $reservationRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('reservations', $allReservations);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenReservationToView() {
		$reservation = new \Cps\DakosyReservations\Domain\Model\Reservation();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('reservation', $reservation);

		$this->subject->showAction($reservation);
	}

	/**
	 * @test
	 */
	public function newActionAssignsTheGivenReservationToView() {
		$reservation = new \Cps\DakosyReservations\Domain\Model\Reservation();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('newReservation', $reservation);
		$this->inject($this->subject, 'view', $view);

		$this->subject->newAction($reservation);
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenReservationToReservationRepository() {
		$reservation = new \Cps\DakosyReservations\Domain\Model\Reservation();

		$reservationRepository = $this->getMock('Cps\\DakosyReservations\\Domain\\Repository\\ReservationRepository', array('add'), array(), '', FALSE);
		$reservationRepository->expects($this->once())->method('add')->with($reservation);
		$this->inject($this->subject, 'reservationRepository', $reservationRepository);

		$this->subject->createAction($reservation);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenReservationToView() {
		$reservation = new \Cps\DakosyReservations\Domain\Model\Reservation();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('reservation', $reservation);

		$this->subject->editAction($reservation);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenReservationInReservationRepository() {
		$reservation = new \Cps\DakosyReservations\Domain\Model\Reservation();

		$reservationRepository = $this->getMock('Cps\\DakosyReservations\\Domain\\Repository\\ReservationRepository', array('update'), array(), '', FALSE);
		$reservationRepository->expects($this->once())->method('update')->with($reservation);
		$this->inject($this->subject, 'reservationRepository', $reservationRepository);

		$this->subject->updateAction($reservation);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenReservationFromReservationRepository() {
		$reservation = new \Cps\DakosyReservations\Domain\Model\Reservation();

		$reservationRepository = $this->getMock('Cps\\DakosyReservations\\Domain\\Repository\\ReservationRepository', array('remove'), array(), '', FALSE);
		$reservationRepository->expects($this->once())->method('remove')->with($reservation);
		$this->inject($this->subject, 'reservationRepository', $reservationRepository);

		$this->subject->deleteAction($reservation);
	}


}
