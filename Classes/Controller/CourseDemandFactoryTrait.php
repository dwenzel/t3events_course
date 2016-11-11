<?php
namespace CPSIT\T3eventsCourse\Controller;

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

use CPSIT\T3eventsCourse\Domain\Factory\Dto\CourseDemandFactory;

/**
 * CourseDemandFactoryTrait
 * Provides a CourseDemandFactory
 */
trait CourseDemandFactoryTrait
{
    /**
     * @var \CPSIT\T3eventsCourse\Domain\Factory\Dto\CourseDemandFactory
     */
    protected $demandFactory;

    /**
     * Injects the CourseDemandFactory
     *
     * @param \CPSIT\T3eventsCourse\Domain\Factory\Dto\CourseDemandFactory $courseDemandFactory
     * @return void
     */
    public function injectCourseDemandFactory(CourseDemandFactory $courseDemandFactory)
    {
        $this->demandFactory = $courseDemandFactory;
    }
}

