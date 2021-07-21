<?php

namespace CPSIT\T3eventsCourse\Configuration\Module;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2019 Dirk Wenzel
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

use CPSIT\T3eventsCourse\Controller\Backend\CourseBackendController;
use DWenzel\T3extensionTools\Configuration\ModuleRegistrationInterface;
use DWenzel\T3extensionTools\Configuration\ModuleRegistrationTrait;

/**
 * Class Course
 */
abstract class Course extends DefaultRegistration implements ModuleRegistrationInterface
{
    use ModuleRegistrationTrait;

    static protected $subModuleName = 'm4';
    static protected $controllerActions = [
        CourseBackendController::class => 'list, show, reset, new',
    ];
    static protected $moduleConfiguration = [
        'access' => 'user,group',
        'icon' => 'EXT:t3events_course/Resources/Public/Icons/open-book.svg',
        'labels' => 'LLL:EXT:t3events_course/Resources/Private/Language/locallang_m4.xlf',
    ];

}
