<?php
namespace CPSIT\T3eventsCourse\ViewHelpers\PageRenderer;

	/***************************************************************
	 * Copyright notice
	 * (c) 2014 Dirk Wenzel <wenzel@cps-it.de>
	 * All rights reserved
	 * This script is part of the TYPO3 project. The TYPO3 project is
	 * free software; you can redistribute it and/or modify
	 * it under the terms of the GNU General Public License as published by
	 * the Free Software Foundation; either version 3 of the License, or
	 * (at your option) any later version.
	 * The GNU General Public License can be found at
	 * http://www.gnu.org/copyleft/gpl.html.
	 * This script is distributed in the hope that it will be useful,
	 * but WITHOUT ANY WARRANTY; without even the implied warranty of
	 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	 * GNU General Public License for more details.
	 * This copyright notice MUST APPEAR in all copies of the script!
	 ***************************************************************/
use CPSIT\T3eventsCourse\ViewHelpers\AbstractPageRendererViewHelper;

/**
 * Adds a javascript file to the page footer
 * Warning: The ViewHelper does not check whether the file exists!
 *
 * @package \CPSIT\T3eventsCourse\ViewHelpers\PageRenderer
 * @author Dirk Wenzel <wenzel@cps-it.de>
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @link http://www.cps-it.de
 */
class AddJsFooterFileViewHelper extends AbstractPageRendererViewHelper {

	/**
	 * @param string $file
	 * @param string $type
	 * @param bool $compress
	 * @param bool $forceOnTop
	 * @param string $allWrap
	 * @param bool $excludeFromConcatenation
	 * @param string $splitChar
	 * @return null
	 */
	public function render($file, $type = 'text/javascript', $compress = TRUE, $forceOnTop = FALSE, $allWrap = '', $excludeFromConcatenation = FALSE, $splitChar = '|') {
		$this->pageRenderer->addJsFooterFile(
			$file,
			$type,
			$compress,
			$forceOnTop,
			$allWrap,
			$excludeFromConcatenation,
			$splitChar
		);

		return NULL;
	}
}
