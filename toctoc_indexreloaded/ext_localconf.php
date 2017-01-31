<?php
if (!defined ('TYPO3_MODE')) die('Access denied.');
if (version_compare(TYPO3_version, '6.3', '>')) {
	(class_exists('t3lib_extMgm', FALSE)) ? TRUE : class_alias('\TYPO3\CMS\Core\Utility\ExtensionManagementUtility', 't3lib_extMgm');
}

t3lib_extMgm::addPItoST43($_EXTKEY, 'pi1/class.tx_toctoc_indexreloaded_pi1.php', '_pi1', 'header_layout', 0);

// hook is called after Caching!
// => for form modification on pages with COA_/USER_INT objects. 
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-output']['toctoc_index_reloaded'] =
'EXT:'.$_EXTKEY.'/pi1/class.tx_toctoc_indexreloaded_pi1.php:tx_toctoc_indexreloaded_pi1->intPages';

// hook is called before Caching!
// => for form modification on pages on their way in the cache.
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-all']['toctoc_index_reloaded'] =
'EXT:'.$_EXTKEY.'/pi1/class.tx_toctoc_indexreloaded_pi1.php:tx_toctoc_indexreloaded_pi1->noIntPages';
?>