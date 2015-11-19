<?php
namespace Cps\DakosyReservations\Domain\Validator;

class ContactValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator {

	/**
	 * Is contact valid
	 *
	 * @param mixed $contact
	 */
	public function isValid($contact) {
		if(!$contact instanceof \Cps\DakosyReservations\Domain\Model\Person) {
			$this->addError('Contact must be a Person.', 1410958031);
			return FALSE;
		}
		$email = $contact->getEmail();
		if( is_null($email) OR $email === '') {
			$this->addError('E-Mail must not be empty.', 1410958066);
			return FALSE;
		}
		$phone = $contact->getPhone();
		if(is_null($phone) OR $phone === '') {
			$this->addError('Phone must not be empty.', 1417193585);
		}
		return TRUE;
	}
}