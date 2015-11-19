<?php
namespace Cps\DakosyReservations\Domain\Model;

/***************************************************************
 *
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
 *  the Free Software Foundation; either version 3 of the License, or
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
 * Reservation
 */
class Reservation extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	const STATUS_NEW = 0;
	const STATUS_DRAFT = 1;
	const STATUS_SUBMITTED = 2;
	const STATUS_CANCELED_NO_CHARGE = 3;
	const STATUS_CANCELED_WITH_COSTS = 4;
	const STATUS_CLOSED = 5;
	const STATUS_CANCELED_BY_DAKOSY = 6;

	/**
	 * Hidden
	 * @var \int
	 */
	protected $hidden;


	/**
	 * status
	 *
	 * @var integer
	 */
	protected $status = 0;

	/**
	 * company
	 *
	 * @var \Cps\DakosyReservations\Domain\Model\Company
	 */
	protected $company = NULL;

	/**
	 * Responsible contact person for reservation.
	 *
	 * @var \Cps\DakosyReservations\Domain\Model\Person
	 * @validate \Cps\DakosyReservations\Domain\Validator\ContactValidator
	 */
	protected $contact = NULL;

	/**
	 * participants
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Cps\DakosyReservations\Domain\Model\Person>
	 */
	protected $participants = NULL;

	/**
	 * lesson
	 *
	 * @var \Cps\DakosyReservations\Domain\Model\Lesson
	 */
	protected $lesson = NULL;

	/**
	 * Privacy statement
	 * @var \boolean
	 * @validate Boolean(is=true)
	 */
	protected $privacyStatementAccepted = FALSE;

	/**
	 * Offers accepted
	 * @var \boolean
	 */
	protected $offersAccepted;

	/**
	 * Contact is participant
	 * @var \boolean
	 */
	protected $contactIsParticipant;

	/**
	 * Notifications
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Cps\DakosyReservations\Domain\Model\Notification>
	 */
	protected $notifications;

	/**
	 * Returns hidden
	 * @return \int
	 */
	public function getHidden() {
		return$this->hidden;
	}

	/**
	 * Sets hidden
	 * @param \int $hidden
	 */
	public function setHidden($hidden) {
		$this->hidden = $hidden;
	}

	/**
	 * Returns the status
	 *
	 * @return integer $status
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * Sets the status
	 *
	 * @param integer $status
	 * @return void
	 */
	public function setStatus($status) {
		$this->status = $status;
	}

	/**
	 * Returns the company
	 *
	 * @return \Cps\DakosyReservations\Domain\Model\Company $company
	 */
	public function getCompany() {
		return $this->company;
	}

	/**
	 * Sets the company
	 *
	 * @param \Cps\DakosyReservations\Domain\Model\Company $company
	 * @return void
	 */
	public function setCompany(Company $company) {
		$this->company = $company;
	}

	/**
	 * Returns the contact
	 *
	 * @return \Cps\DakosyReservations\Domain\Model\Person $contact
	 */
	public function getContact() {
		return $this->contact;
	}

	/**
	 * Sets the contact
	 *
	 * @param \Cps\DakosyReservations\Domain\Model\Person $contact
	 * @return void
	 */
	public function setContact(\Cps\DakosyReservations\Domain\Model\Person $contact) {
		$this->contact = $contact;
	}

	/**
	 * __construct
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all ObjectStorage properties
	 * Do not modify this method!
	 * It will be rewritten on each save in the extension builder
	 * You may modify the constructor of this class instead
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		$this->participants = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->notifications = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Adds a Person
	 *
	 * @param \Cps\DakosyReservations\Domain\Model\Person $participant
	 * @return void
	 */
	public function addParticipant(Person $participant) {
		$this->participants->attach($participant);
	}

	/**
	 * Removes a Person
	 *
	 * @param \Cps\DakosyReservations\Domain\Model\Person $participantToRemove The Person to be removed
	 * @return void
	 */
	public function removeParticipant(\Cps\DakosyReservations\Domain\Model\Person $participantToRemove) {
		$this->participants->detach($participantToRemove);
	}

	/**
	 * Returns the participants
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Cps\DakosyReservations\Domain\Model\Person> $participants
	 */
	public function getParticipants() {
		return $this->participants;
	}

	/**
	 * Sets the participants
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Cps\DakosyReservations\Domain\Model\Person> $participants
	 * @return void
	 */
	public function setParticipants(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $participants) {
		$this->participants = $participants;
	}

	/**
	 * Returns the lesson
	 *
	 * @return \Cps\DakosyReservations\Domain\Model\Lesson $lesson
	 */
	public function getLesson() {
		return $this->lesson;
	}

	/**
	 * Sets the lesson
	 *
	 * @param \Cps\DakosyReservations\Domain\Model\Lesson $lesson
	 * @return void
	 */
	public function setLesson(\Cps\DakosyReservations\Domain\Model\Lesson $lesson) {
		$this->lesson = $lesson;
	}

	/**
	 * Get the privacy statement accepted
	 * @return \boolean
	 */
	public function getPrivacyStatementAccepted() {
		return $this->privacyStatementAccepted;
	}

	/**
	 * Sets the privacy statement accepted
	 * @param \boolean $accepted
	 * @return void
	 */
	public function setPrivacyStatementAccepted($accepted) {
		$this->privacyStatementAccepted = $accepted;
	}

	/**
	 * Get the  offers accepted
	 * @return \boolean
	 */
	public function getOffersAccepted() {
		return $this->offersAccepted;
	}

	/**
	 * Sets the privacy statement accepted
	 * @param \boolean $accepted
	 * @return void
	 */
	public function setOffersAccepted($accepted) {
		$this->offersAccepted = $accepted;
	}

	/**
	 * Get contact is participant
	 * @return \boolean
	 */
	public function getContactIsParticipant() {
		return $this->contactIsParticipant;
	}

	/**
	 * Set contact is participant
	 * @var \boolean $contactIsParticipant
	 * @return void
	 */
	public function setContactIsParticipant($contactIsParticipant) {
		$this->contactIsParticipant = $contactIsParticipant;
	}

	/**
	 * Adds a Notification
	 *
	 * @param \Cps\DakosyReservations\Domain\Model\Notification $notification
	 * @return void
	 */
	public function addNotification(Notification $notification) {
		$this->notifications->attach($notification);
	}

	/**
	 * Removes a Notification
	 *
	 * @param \Cps\DakosyReservations\Domain\Model\Notification $notificationToRemove The Notification to be removed
	 * @return void
	 */
	public function removeNotification(\Cps\DakosyReservations\Domain\Model\Notification $notificationToRemove) {
		$this->notifications->detach($notificationToRemove);
	}

	/**
	 * Returns the notifications
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Cps\DakosyReservations\Domain\Model\Notification> $notifications
	 */
	public function getNotifications() {
		return $this->notifications;
	}

	/**
	 * Sets the notifications
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Cps\DakosyReservations\Domain\Model\Notification> $notifications
	 * @return void
	 */
	public function setNotifications(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $notifications) {
		$this->notifications = $notifications;
	}

}