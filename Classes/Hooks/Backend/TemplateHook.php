<?php
/**
 * Created by PhpStorm.
 * User: wenzel
 * Date: 17.11.14
 * Time: 14:31
 */

class TemplateHook {
	public function addBackendJavaScript(&$aParams, $oTemplate) {
		// ajax calls
		$oTemplate->getPageRenderer()->addJsFile('sysext/backend/Resources/Public/JavaScript/tabmenu.js');
	}
}