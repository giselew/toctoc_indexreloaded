<?php
/***************************************************************
 *  Copyright notice
*
*  (c) 2012 - 2014 Gisele Wendl <gisele.wendl@toctoc.ch>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 *
 *
 *   59: class tx_toctoc_indexreloaded_pi1 extends tslib_pibase
 *   73:     public function intPages(&$params, &$reference)
 *   90:     public function noIntPages(&$params, &$reference)
 *  106:     public function contentPostProc(&$params, &$reference)
 *
 * TOTAL FUNCTIONS: 3
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */


if (version_compare(TYPO3_version, '6.2', '<')) {
	require_once(PATH_tslib.'class.tslib_pibase.php');
} else {
	require_once \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('frontend') . 'Classes/Plugin/AbstractPlugin.php';
}

if (version_compare(TYPO3_version, '6.3', '>')) {
	(class_exists('t3lib_extMgm', FALSE) || interface_exists('t3lib_extMgm', FALSE)) ? TRUE : class_alias('\TYPO3\CMS\Core\Utility\ExtensionManagementUtility', 't3lib_extMgm');
	(class_exists('tslib_pibase', FALSE) || interface_exists('tslib_pibase', FALSE)) ? TRUE : class_alias('TYPO3\CMS\Frontend\Plugin\AbstractPlugin', 'tslib_pibase');
	(class_exists('t3lib_div', FALSE) || interface_exists('t3lib_div', FALSE)) ? TRUE : class_alias('TYPO3\CMS\Core\Utility\GeneralUtility', 't3lib_div');
}

/**
 * Toctoc Index Reloaded
 *
 * @author Gisele Wendl <gisele.wendl@toctoc.ch>
 * @package TYPO3
 * @subpackage toctoc_indexreloaded
 */
class tx_toctoc_indexreloaded_pi1 extends tslib_pibase {
	public $prefixId      = 'tx_toctoc_indexreloaded_pi1';		// Same as class name
	public $scriptRelPath = 'pi1/class.tx_toctoc_indexreloaded_pi1.php';	// Path to this script relative to the extension dir.
	public $extKey        = 'toctoc_indexreloaded';	// The extension key.
	public $pi_checkCHash = TRUE;

	    /**
 * Hook output after rendering the content.
 * - no cached pages
 *
 * @param	object		$params parameter array
 * @param	object		$reference parent object
 * @return	void
 */
    public function intPages(&$params, &$reference)
    {
        if (!$GLOBALS['TSFE']->isINTincScript()) {
            return;
        }

        $this->contentPostProc($params, $reference);
     }

    /**
 * Hook output after rendering the content.
 * - cached pages
 *
 * @param	object		$params $_params: parameter array
 * @param	object		$reference $pObj: parent object
 * @return	void
 */
    public function noIntPages(&$params, &$reference)
    {
        if ($GLOBALS['TSFE']->isINTincScript()) {
            return;
        }

        $this->contentPostProc($params, $reference);
    }

    /**
 * Parsing HTML content and reorganize CSS and JS
 *
 * @param	object		$_params: parameter array
 * @param	object		$reference $pObj: parent object
 * @return	string		$params['pObj']->content
 */
	public function contentPostProc(&$params, &$reference)	{
		$buffer = $params['pObj']->content;

		$showDebugWindow = TRUE;
		if (version_compare(TYPO3_version, '4.9', '>')) {
			if (!\TYPO3\CMS\Core\Utility\GeneralUtility::cmpIP(
					\TYPO3\CMS\Core\Utility\GeneralUtility::getIndpEnv('REMOTE_ADDR'),
					$GLOBALS['TYPO3_CONF_VARS']['SYS']['devIPmask'])
			) {
				$showDebugWindow = FALSE;

			}

		} else {
			if(!t3lib_div::cmpIP(t3lib_div::getIndpEnv('REMOTE_ADDR'), $GLOBALS['TYPO3_CONF_VARS']['SYS']['devIPmask'])) {
				$showDebugWindow = FALSE;
			}

		}

		$createVersionNumberedFilenamemode = trim(strtolower($GLOBALS['TYPO3_CONF_VARS']['FE']['versionNumberInFilename']));
		$opts = array();
		if (isset($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['toctoc_indexreloaded'])) {
			$opts = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['toctoc_indexreloaded']);
		}

		$conf = array();
		if (t3lib_extMgm::isLoaded('toctoc_indexreloaded') == TRUE) {
			$conf = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_toctoc_indexreloaded_pi1.'];
			if (count($conf) > 2) {
				$conf['APIKey'] = $opts['APIKey'];
				$conf['APIServer'] = $opts['APIServer'];
				$opts = $conf;
			}

		}

		$TSFEid = $GLOBALS['TSFE']->id;
		$userUid = $GLOBALS['TSFE']->fe_user->user['uid'];

		require_once(t3lib_extMgm::extPath('toctoc_indexreloaded', 'Classes/Controller/IndexReloaded.php'));
		$IndexReloaded = new GiseleWendl\ToctocIndexreloaded\Controller\IndexReloaded;

		$bufferout = $IndexReloaded->contentPostProc($buffer, $userUid, '', $showDebugWindow, $createVersionNumberedFilenamemode, $opts, $TSFEid);
		$params['pObj']->content = $bufferout;
	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/toctoc_indexreloaded/pi1/class.tx_toctoc_indexreloaded_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/toctoc_indexreloaded/pi1/class.tx_toctoc_indexreloaded_pi1.php']);
}
?>
