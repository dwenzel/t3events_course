<?php
namespace CPSIT\T3eventsCourse\Domain\Model;

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
use DWenzel\T3events\Domain\Model\Event;

/**
 * A course offer.
 */
class Course extends Event {
	use CourseEventTrait;

	const DEFAULT_EXTBASE_TYPE = 'Tx_T3eventsCourse_Course';

	/**
	 * @var string
	 */
	protected $extbaseType = self::DEFAULT_EXTBASE_TYPE;

}