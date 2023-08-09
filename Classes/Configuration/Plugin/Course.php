<?php

namespace CPSIT\T3eventsCourse\Configuration\Plugin;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2019 Dirk Wenzel <wenzel@cps-it.de>
 *  All rights reserved
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the text file GPL.txt and important notices to the license
 * from the author is found in LICENSE.txt distributed with these scripts.
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use CPSIT\T3eventsCourse\Controller\CourseController;
use CPSIT\T3eventsCourse\Controller\ScheduleController;
use DWenzel\T3extensionTools\Configuration\PluginConfigurationInterface;
use DWenzel\T3extensionTools\Configuration\PluginConfigurationTrait;
use CPSIT\T3eventsCourse\Configuration\ExtensionConfiguration;

/**
 * Class Combined
 *
 * Provides configuration for combined plugin
 */
abstract class Course implements PluginConfigurationInterface
{
    use PluginConfigurationTrait;

    static protected $pluginName = 'Courses';
    static protected $controllerActions = 	[
        CourseController::class => 'list, show, filter',
        ScheduleController::class => 'list, show, filter',
    ];

    static protected $nonCacheableControllerActions = [
        CourseController::class => 'filter',
        ScheduleController::class => 'filter,list',
    ];

    static protected $extensionName = ExtensionConfiguration::EXTENSION_KEY;
    static protected string $vendorExtensionName = ExtensionConfiguration::VENDOR . '.' . ExtensionConfiguration::EXTENSION_KEY;

}
