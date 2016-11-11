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

use CPSIT\T3eventsCourse\Domain\Factory\Dto\ScheduleDemandFactory;

/**
 * ScheduleDemandFactoryTrait
 * Provides a ScheduleDemandFactory
 */
trait ScheduleDemandFactoryTrait
{
    /**
     * @var \CPSIT\T3eventsCourse\Domain\Factory\Dto\ScheduleDemandFactory
     */
    protected $demandFactory;

    /**
     * Injects the ScheduleDemandFactory
     *
     * @param \CPSIT\T3eventsCourse\Domain\Factory\Dto\ScheduleDemandFactory $scheduleDemandFactory
     * @return void
     */
    public function injectScheduleDemandFactory(ScheduleDemandFactory $scheduleDemandFactory)
    {
        $this->demandFactory = $scheduleDemandFactory;
    }
}

