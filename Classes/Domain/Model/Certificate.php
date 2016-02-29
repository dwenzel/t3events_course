<?php
namespace CPSIT\T3eventsCourse\Domain\Model;

/***************************************************************
 *  Copyright notice
 *  (c) 2015 Dirk Wenzel <dirk.wenzel@cps-it.de>
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
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Class Certificate
 *
 * @package CPSIT\T3eventsCourse\Domain\Model
 */
class Certificate extends AbstractEntity {

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var \CPSIT\T3eventsCourse\Domain\Model\CertificateType
	 */
	protected $type;

	/**
	 * @var string
	 */
	protected $description;

	/**
	 * @var string
	 */
	protected $shortPas1045;

	/**
	 * @var string
	 */
	protected $shortQcat;

	/**
	 * @var string
	 */
	protected $link;

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * @return CertificateType
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @param CertificateType $type
	 */
	public function setType($type) {
		$this->type = $type;
	}

	/**
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param string $description
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * @return string
	 */
	public function getShortPas1045() {
		return $this->shortPas1045;
	}

	/**
	 * @param string $shortPas1045
	 */
	public function setShortPas1045($shortPas1045) {
		$this->shortPas1045 = $shortPas1045;
	}

	/**
	 * @return string
	 */
	public function getShortQcat() {
		return $this->shortQcat;
	}

	/**
	 * @param string $shortQcat
	 */
	public function setShortQcat($shortQcat) {
		$this->shortQcat = $shortQcat;
	}

	/**
	 * @return string
	 */
	public function getLink() {
		return $this->link;
	}

	/**
	 * @param string $link
	 */
	public function setLink($link) {
		$this->link = $link;
	}



}