<?php

if (!defined('TYPO3_MODE')) die('Access denied.');

if (version_compare(TYPO3_version, '6.3', '>')) {
	(class_exists('t3lib_extMgm', FALSE)) ? TRUE : class_alias('\TYPO3\CMS\Core\Utility\ExtensionManagementUtility', 't3lib_extMgm');
}

// Add static files for plugins
t3lib_extMgm::addStaticFile($_EXTKEY, 'static/', 'TocToc Indexreloaded');

?>