<?php
namespace CPSIT\T3eventsCourse\Domain\Factory\Dto;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use CPSIT\T3eventsCourse\Domain\Model\Dto\CourseDemand;
use DWenzel\T3events\Domain\Factory\Dto\DemandFactoryInterface;
use DWenzel\T3events\Domain\Factory\Dto\EventDemandFactory;

/**
 * Class CourseDemandFactory
 * Creates CourseDemand objects
 */
class CourseDemandFactory extends EventDemandFactory
	implements DemandFactoryInterface {
    /**
     * Class name of the object created by this factory.
     */
    const DEMAND_CLASS = CourseDemand::class;
}
