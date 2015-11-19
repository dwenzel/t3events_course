<?php
namespace Cps\DakosyReservations\Controller;
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
 * ReservationController
 */

class ReservationController extends AbstractController {

	/**
	 * reservationRepository
	 *
	 * @var \Cps\DakosyReservations\Domain\Repository\ReservationRepository
	 * @inject
	 */
	protected $reservationRepository = NULL;

	/**
	 * Lesson Repository
	 *
	 * @var \Cps\DakosyReservations\Domain\Repository\LessonRepository
	 * @inject
	 */
	protected $lessonRepository = NULL;

	/**
	 * Company Repository
	 *
	 * @var \Cps\DakosyReservations\Domain\Repository\CompanyRepository
	 * @inject
	 */
	protected $companyRepository = NULL;

	/**
	 * Participant Repository
	 *
	 * @var \Cps\DakosyReservations\Domain\Repository\PersonRepository
	 * @inject
	 */
	protected $personRepository = NULL;

	/**
	 * action show
	 *
	 * @param \Cps\DakosyReservations\Domain\Model\Reservation $reservation
	 * @return void
	 */
	public function showAction(\Cps\DakosyReservations\Domain\Model\Reservation $reservation) {
		if($this->isAccessAllowed($reservation)) {
			$this->view->assign('reservation', $reservation);
		} else {
			$this->denyAccess();
		}
	}

	/**
	 * action new
	 *
	 * @param \Cps\DakosyReservations\Domain\Model\Lesson $lesson
	 * @param \Cps\DakosyReservations\Domain\Model\Reservation $newReservation
	 * @ignorevalidation $newReservation
	 * @return void
	 */
	public function newAction(\Cps\DakosyReservations\Domain\Model\Lesson $lesson = NULL, \Cps\DakosyReservations\Domain\Model\Reservation $newReservation = NULL) {
		if(is_null($lesson)) {
			$error = 'message.selectLesson';
		} elseif(!$lesson->getFreePlaces()){
			$error = 'message.noFreePlacesForThisLesson';
		}
		if ($error) {
			$this->addFlashMessage(
				$this->translate($error), '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR, TRUE
			);
			$this->redirect('list', 'Lesson', 'dakosyreservations', array(), $this->settings['lesson']['listPid']);
		}
		if ($this->request->getOriginalRequest() instanceof \TYPO3\CMS\Extbase\Mvc\Request) {
			$newReservation = $this->request->getOriginalRequest()->getArgument('newReservation');
		}
		$this->view->assignMultiple(
			array(
				'newReservation' => $newReservation,
				'lesson' => $lesson
			)
		);
	}

	/**
	 * action create
	 *
	 * @param \Cps\DakosyReservations\Domain\Model\Reservation $newReservation
	 * @return void
	 */
	public function createAction(\Cps\DakosyReservations\Domain\Model\Reservation $newReservation) {
		if(is_null($newReservation->getUid())) {
			$contact = $newReservation->getContact();
			$newReservation->setStatus(\Cps\DakosyReservations\Domain\Model\Reservation::STATUS_NEW);
			$contact->setType(\Cps\DakosyReservations\Domain\Model\Person::PERSON_TYPE_CONTACT);
			if($newReservation->getContactIsParticipant()) {
				$participant = clone $contact;
				$participant->setType(\Cps\DakosyReservations\Domain\Model\Person::PERSON_TYPE_PARTICIPANT);
				$newReservation->addParticipant($participant);
				$participant->setReservation($newReservation);
				$newReservation->getLesson()->addParticipant($participant);
			}
			$this->addFlashMessage(
				$this->translate('message.reservation.create.success')
			);
			$this->reservationRepository->add($newReservation);
			$this->persistenceManager->persistAll();
			$this->setSessionKey('reservationUid', $newReservation->getUid());
			$this->forward('newParticipant', NULL, NULL, array('reservation' => $newReservation));
		} else {
			$this->denyAccess();
		}
	}

	/**
	 * action delete
	 *
	 * @param \Cps\DakosyReservations\Domain\Model\Reservation $reservation
	 * @return void
	 */
	public function deleteAction(\Cps\DakosyReservations\Domain\Model\Reservation $reservation) {
		if($this->isAccessAllowed($reservation)) {
			$this->addFlashMessage(
				$this->translate('message.reservation.delete.success')
			);
			if($participants = $reservation->getParticipants()) {
				foreach($participants as $participant) {
					$this->personRepository->remove($participant);
				}
			}
			if ($company = $reservation->getCompany()) {
				$this->companyRepository->remove($company);
			}
			if ($contact = $reservation->getContact()) {
				$this->personRepository->remove($contact);
			}
			$this->reservationRepository->remove($reservation);
		} else {
			$this->denyAccess();
		}
	}

	/**
	 * action newParticipant
	 *
	 * @param \Cps\DakosyReservations\Domain\Model\Reservation $reservation
	 * @param \Cps\DakosyReservations\Domain\Model\Person $newParticipant
	 * @ignorevalidation $newParticipant
	 * @return void
	 */
	public function newParticipantAction(\Cps\DakosyReservations\Domain\Model\Reservation $reservation,
		\Cps\DakosyReservations\Domain\Model\Person $newParticipant = NULL) {
		if($this->isAccessAllowed($reservation)
			AND $reservation->getStatus() == \Cps\DakosyReservations\Domain\Model\Reservation::STATUS_DRAFT
			OR 	$reservation->getStatus() == \Cps\DakosyReservations\Domain\Model\Reservation::STATUS_NEW){
			if(!$reservation->getStatus() == \Cps\DakosyReservations\Domain\Model\Reservation::STATUS_DRAFT) {
				$reservation->setStatus(\Cps\DakosyReservations\Domain\Model\Reservation::STATUS_DRAFT);
			}
			if(!$reservation->getLesson()->getFreePlaces()){
				$this->addFlashMessage(
					$this->translate('message.noFreePlacesForThisLesson'), '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR, TRUE
				);
			} elseif(!count($reservation->getParticipants())) {
				$this->addFlashMessage(
					$this->translate('message.reservation.newParticipant.addAtLeastOneParticipant'), '', \TYPO3\CMS\Core\Messaging\AbstractMessage::NOTICE
				);
			}
			if ($this->request->getOriginalRequest() instanceof \TYPO3\CMS\Extbase\Mvc\Request) {
				$newParticipant = $this->request->getOriginalRequest()->getArgument('newParticipant');
			}
			$this->view->assignMultiple(
				array(
					'newParticipant' => $newParticipant,
					'reservation' => $reservation
				)
			);
		}else {
			$this->denyAccess();
		}
	}

	/**
	 * action createParticipant
	 *
	 * @param \Cps\DakosyReservations\Domain\Model\Reservation $reservation
	 * @param \Cps\DakosyReservations\Domain\Model\Person $newParticipant
	 * @return void
	 */
	public function createParticipantAction(\Cps\DakosyReservations\Domain\Model\Reservation $reservation, \Cps\DakosyReservations\Domain\Model\Person $newParticipant) {
		if($this->isAccessAllowed($reservation)) {
			if(!$reservation->getStatus() == \Cps\DakosyReservations\Domain\Model\Reservation::STATUS_DRAFT) {
				$reservation->setStatus(\Cps\DakosyReservations\Domain\Model\Reservation::STATUS_DRAFT);
			}
			if($reservation->getLesson()->getFreePlaces()) {
				$newParticipant->setReservation($reservation);
				$newParticipant->setType(\Cps\DakosyReservations\Domain\Model\Person::PERSON_TYPE_PARTICIPANT);
				$reservation->addParticipant($newParticipant);
				$reservation->getLesson()->addParticipant($newParticipant);
				$this->reservationRepository->update($reservation);
				$this->lessonRepository->update($reservation->getLesson());
				$this->persistenceManager->persistAll();
				$this->addFlashMessage(
					$this->translate('message.reservation.createParticipant.success')
				);
				$this->redirect('newParticipant', NULL, NULL, array('reservation' => $reservation));
			} else {
				$this->redirect('checkout', 'Reservation', 'dakosyreservations', array('reservation'=>$reservation));
			}
		}else {
			$this->denyAccess();
		}
	}

	/**
	 * Checkout Action
	 *
	 * @param \Cps\DakosyReservations\Domain\Model\Reservation $reservation
	 * @return void
	 */
	public function checkoutAction(\Cps\DakosyReservations\Domain\Model\Reservation $reservation) {
		if($this->isAccessAllowed($reservation)) {
			$this->view->assign('reservation', $reservation);
		} else {
			$this->denyAccess();
		}
	}

	/**
	 * Confirm Action
	 *
	 * @param \Cps\DakosyReservations\Domain\Model\Reservation $reservation
	 * @return void
	 */
	public function confirmAction(\Cps\DakosyReservations\Domain\Model\Reservation $reservation) {
		if($this->isAccessAllowed($reservation)) {
			$reservation->setStatus(\Cps\DakosyReservations\Domain\Model\Reservation::STATUS_SUBMITTED);
			$this->addFlashMessage(
				$this->translate('message.reservation.confirm.success')
			);
			if($this->settings['reservation']['confirm']['sendNotification']) {
				/** @var \Cps\DakosyReservations\Domain\Model\Notification $notification */
				$notification = $this->objectManager->get('Cps\\DakosyReservations\\Domain\\Model\Notification');
				$notification->setRecipient($reservation->getContact()->getEmail());
				$notification->setSender($this->settings['reservation']['confirm']['fromEmail']);
				$notification->setSubject($this->settings['reservation']['confirm']['subject']);
				$notification->setFormat('html');
				$bodyText = $this->notificationService->render(
					$this->settings['reservation']['confirm']['templateFileName'],
					'html',
					$this->settings['reservation']['confirm']['folderName'],
					array('reservation' => $reservation, 'settings' => $this->settings)
				);
				$notification->setBodytext($bodyText);
				$reservation->addNotification($notification);
				$notificationSuccess = $this->notificationService->send($notification);
				if($notificationSuccess) {
					$mailMessageKey = 'message.reservation.sendNotification.success';
					$mailMessageSeverity = \TYPO3\CMS\Core\Messaging\AbstractMessage::OK;
				}
				else {
					$mailMessageKey = 'message.reservation.sendNotification.error';
					$mailMessageSeverity = \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING;
				}
				$this->addFlashMessage($this->translate($mailMessageKey), NULL, $mailMessageSeverity);
			}
			$this->reservationRepository->update($reservation);
			$this->forward('show', NULL, NULL, array('reservation' => $reservation));
		} else {
			$this->denyAccess();
		}
	}

	/**
	 * action removeParticipant
	 *
	 * @param \Cps\DakosyReservations\Domain\Model\Reservation $reservation
	 * @param \Cps\DakosyReservations\Domain\Model\Person $participant
	 * @return void
	 */
	public function removeParticipantAction(
		\Cps\DakosyReservations\Domain\Model\Reservation $reservation,
		\Cps\DakosyReservations\Domain\Model\Person $participant
		) {
		if($this->isAccessAllowed($reservation)) {
			$reservation->removeParticipant($participant);
			$reservation->getLesson()->removeParticipant($participant);
			$this->personRepository->remove($participant);
			$this->addFlashMessage(
				$this->translate('message.reservation.removeParticipant.success')
			);
			$this->redirect('newParticipant', NULL, NULL, array('reservation' => $reservation));
		} else {
			$this->denyAccess();
		}
	}

	/**
	 * Returns custom error flash messages, or
	 * display no flash message at all on errors.
	 *
	 * @return string|boolean The flash message or FALSE if no flash message should be set
	 * @override \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
	 */
	protected function getErrorFlashMessage() {
		$key = 'error'.'.reservation.' . str_replace('Action', '', $this->actionMethodName) . '.' . $this->errorMessage;
		$message = $this->translate($key);
		if($message == NULL) {
			return FALSE;
		} else {
			return $message;
		}
	}

	/**
	 * Deny access
	 *
	 * Issues an error message and redirects
	 * @return void
	 */
	private function denyAccess() {
		$this->clearCacheOnError();
		$this->addFlashMessage(
			$this->translate('error.reservation.' . str_replace('Action', '', $this->actionMethodName) . '.accessDenied'), '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR, TRUE
		);
		$this->redirect('list', 'Lesson', 'dakosyreservations', array(), $this->settings['lesson']['listPid']);
	}
}
