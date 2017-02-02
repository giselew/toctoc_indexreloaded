<?php
namespace GiseleWendl\ToctocIndexreloaded\Controller;
/***************************************************************
 *  Copyright notice
*
*  (c) 2017 Gisele Wendl <gisele.wendl@toctoc.ch>
*  All rights reserved
*
*  This script is free software; you can redistribute it and/or modify
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
 *   61: class IndexReloaded
 *  180:     public function contentPostProc($buffer, $userUid = 0, $relativePathToExtension = '', $showDebugWindow = FALSE,
			$createVersionNumberedFilenamemode = 'querystring', $opts = array(), $TSFEid = 0)
 * 2541:     private function foldingCSSreportentry($entryname, $filecontents, $mediacorrectrules = FALSE)
 * 2607:     private function mergeCSS($soucedirectory, $filename, $foldingmd5, $filecontent, $filecontentbelowthefold, $filecontentoPosabove, $filecontentoPosbelow)
 * 2754:     protected function htmlFoldMeta($bufferin)
 * 2918:     protected function splitCSSBelowAboveTheFold($filecontent)
 * 3000:     protected function crunchcss($buffer, $minimal = FALSE)
 * 3030:     protected function isCompressed($buffer)
 * 3051:     protected function compressjs($buffer, $doMinify, $minimal = FALSE)
 * 3084:     protected function handleCssAtImportFiles($writecsstext, $checkpath, $checkpatharr, $countcheckpatharr)
 * 3211:     protected function createVersionNumberedFilename($file, $forceQueryString = FALSE)
 * 3272:     protected function currentPageName()
 * 3312:     protected function apiCall($secret, $datain)
 * 3418:     private function get_client_ip()
 *
 * TOTAL FUNCTIONS: 14
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */

if (!class_exists('JSMinTtirl')) {
	require(realpath(str_replace('Classes\Controller', '', str_replace('Classes/Controller', '', dirname(__FILE__)))) . DIRECTORY_SEPARATOR .
			str_replace('/', DIRECTORY_SEPARATOR, 'Resources/Public/Contrib/JSmin/jsminttirl.php'));
}

/**
 * Toctoc Index Reloaded
 *
 * @author Gisele Wendl <gisele.wendl@toctoc.ch>
 * @package TYPO3
 * @subpackage toctoc_indexreloaded
 */

class IndexReloaded {

// OPTIONS
	protected $dontmod = TRUE;
	// 1 = dont modify original output at all
	protected $dontmodjs = FALSE;
	// 1 = dont modify original js when protected $dontmod=0
	protected $dontmodcss = FALSE;
	// 1 = dont modify original css when protected $dontmod=0
	protected $excludesarr = array();
	// parts of js or css-filenames, that should be excluded when $this->dontmod=0, $this->dontmodjs=0 or/and $this->dontmodcss=0
	// for inline scripts/styles a part of the script is ok for identification
	protected $includesarr =array();
	// parts of js or css-filenames, that must be included when $this->dontmod=0, $this->dontmodjs=0 or/and $this->dontmodcss=0
	// $includesarr-elements overwrite the $excludesarr. This good for inline-script filtering, ...
	// ... because sometimes inlinescripts hold values that change on every page reload (eg hashes for changing passwords)
	// ... in the present default config the inline JS holding the information for ajax-login forms from toctoc_comments is handled accordingly:
	// ... when there's a login form, the js is kept inline thus avoiding permanent creation of new typo3temp-javascript files
	protected $excludesprocessingarr = array();
	protected $includesprocessingarr = array();
	// processing of files to typo3temp
	protected $typo3tempsubfolder = 'typo3temp/TocTocIndexReloaded';
	protected $optProcessfiles = TRUE;
	protected $optProcessjsfiles = TRUE;
	protected $optProcesscssfiles = TRUE;
	protected $asynchLastJS = FALSE;
	// enable file processing
	protected $forceNewFiles = FALSE;
	// force creation of new files.
	// You can force new files (CSS and JS) with URL-Parameter ?forceNewFiles=1 as well.

	protected $doCrunchCSS = TRUE;
	// CSS will be compressed

	protected $generateCSSbelowTheFold = TRUE;
	protected $mergeCSSbelowTheFold = TRUE;
	// CSS will be split in above and below the fold
	protected $bufferintags = array();
	protected $bufferinclasses = array();
	protected $bufferinputtypes = array();
	protected $bufferinids = array();
	protected $tagsToKeepAboveTheFold = array();
	protected $classesToKeepAboveTheFold = array();
	protected $IDsToKeepAboveTheFold = array();

	protected $mediaFromAboveToBelow = array();
	protected $mediaBelow = array();
	protected $mediaAbove = array();
	protected $mediaNewBelow = array();
	protected $mediaNewAbove = array();
	protected $mediaOldBelow = array();
	protected $mediaOldAbove = array();

	protected $moveAtMedia = FALSE;
	protected $freezeFolding = FALSE;
	protected $inlineCSSaboveTheFold = FALSE;
	protected $countUnionMetaInitialElements = 0;
	protected $countUnionMetaMovedSelectors = 0;
	protected $countUnionMetaNewElements = 0;
	protected $countUnionMetabeforeDrop = 0;
	protected $countUnionMetaafterDrop = 0;

	protected $pruneHTMLBaseToDisk = FALSE;
	protected $pruneHTMLBase = '';

	protected $makefoldingCSSreport = FALSE;
	protected $foldingCSSreport = array();
	protected $iFCSSRep = -1;
	protected $lenoutputcssabove = 0;
	protected $lenoutputcssbelow = 0;

	protected $checkDupesOnFoldingMerge = FALSE;

	// end of CSS above-below the fold variables

	protected $doCompressJs = TRUE;
	// JS will be compressed
	protected $optMinifyjsfiles = TRUE;
	protected $showDebugWindow = TRUE;
	// show the debug window by default
	// You can force the debug window with URL-Parameter ?showDebugWindow=1 as well.
	protected $showDebugWindowBodyTag = '<body>';
	// the html of the debug windows is appended to this tag
	protected $showOptionsInDebugWindow = FALSE;
	protected $nominifyarr = array();
	protected $productionMode = FALSE;

	protected $showDebugWindowCSS = TRUE;
	protected $createVersionNumberedFilenamemode = 'querystring';
	protected $TSFEid = 0;
	protected $userUid = 0;

	protected $extensionrelwinpath = 'typo3conf\ext\toctoc_indexreloaded';
	protected $extensionrelpath = 'typo3conf/ext/toctoc_indexreloaded';

	public $donExtkey = 'toctoc_indexreloaded';
	public $donExtension = 'toctoc_indexreloaded';
	public $donExtversion = '193';
	public $donationserver = 'www.toctoc.ch';
	public $secret = '';
	public $runtimeTtIrl = 0;

	// try fix bad CSS
	protected $tryFixBadCSS = FALSE;

	// OPTIONS END

	/**
	 * Parsing HTML content and reorganize CSS and JS
	 *
	 * @param	string		$buffer: HTML to be post processed
	 * @param	int		$userUid: Id of the current user, 0 if not logged in
	 * @param	string		$relativePathToExtension: when called from outside TYPO3 then relative path to extension comes with this variable
	 * @param	boolean		$showDebugWindow: If the debug-window caqn be shown (filtered with TYPO3 devip mask)
	 * @param	string		$createVersionNumberedFilenamemode: ...
	 * @param	array		$opts: Legacey options from extension manager configuration
	 * @param	int		$TSFEid: TYPO3-pageid
	 * @return	string		$buffer, modified
	 */
	public function contentPostProc($buffer, $userUid = 0, $relativePathToExtension = '', $showDebugWindow = FALSE,
			$createVersionNumberedFilenamemode = 'querystring', $opts = array(), $TSFEid = 0) {
		$lenbuffer = strlen($buffer);
		$starttimedebug = microtime(TRUE);
		$starttimedebugcallback = $starttimedebug;
		$this->showDebugWindowCSS = $showDebugWindow;
		$this->showDebugWindow = $showDebugWindow;
		$this->createVersionNumberedFilenamemode = $createVersionNumberedFilenamemode;
		$this->TSFEid = $TSFEid;
		$this->userUid = $userUid;
		$this->runtimeTtIrl = time();
		$this->secret = trim($opts['APIKey']);
		$this->donationserver = trim($opts['APIServer']);
		$APIreset = FALSE;
		$baseurl = '';
		if (($_SERVER['HTTPS'] != '') && ($_SERVER['HTTPS'] != 'off')) {
			$baseurl = 'https://'. $_SERVER['SERVER_NAME'];
		} else {
			$baseurl = 'http://'. $_SERVER['SERVER_NAME'];
		}

		if (count($opts) < 3) {
			$opts = require_once(realpath(str_replace('Classes\Controller', '', str_replace('Classes/Controller', '', dirname(__FILE__)))) . DIRECTORY_SEPARATOR .
			str_replace('/', DIRECTORY_SEPARATOR, 'Resources/Public/RawConfig/configuration.php'));
			$this->typo3tempsubfolder = $opts['tempsubfolder'];
			$this->secret = $opts['APIKey'];
			$this->donationserver = trim($opts['APIServer']);
			$this->extensionrelpath = str_replace('\\', '/', $relativePathToExtension);
			$this->extensionrelwinpath = str_replace('/', '\\', $relativePathToExtension);
			$this->TSFEid = $this->currentPageName();

			if ($opts['forceBaseURL'] != '') {
				$baseurl = $opts['forceBaseURL'];
			}

			if ($opts['DebugIP'] != '') {
				if ($opts['DebugIP'] == '*') {
					if (intval($opts['showDebugWindow']) == 1) {
						$this->showDebugWindowCSS = TRUE;
						$this->showDebugWindow = TRUE;

					}

				} else {
					$ip = $this->get_client_ip();
					if ($opts['DebugIP'] == $ip) {
						if (intval($opts['showDebugWindow']) == 1) {
							$this->showDebugWindowCSS = TRUE;
							$this->showDebugWindow = TRUE;

						}

					}

				}

			}

		} else {
			$this->typo3tempsubfolder = $opts['typo3tempsubfolder'];
		}

		$debuginfolding = '';
		$tdifftolastrun = 1000*(microtime(TRUE) - $starttimedebug);
		$starttimedebug = microtime(TRUE);
		$starttimedebugfolding = microtime(TRUE);
		$debuginfolding .= '<span>Initialize: '. round($tdifftolastrun, 1) . ' ms</span><br />' . $debuginfolding;

		if (count($opts) > 0) {
			if ($opts['deactivateOnPages'] != '') {
				if (str_replace($this->TSFEid, '', $opts['deactivateOnPages']) != $opts['deactivateOnPages']) {
					$deactivateOnPagesarr = explode(',', $opts['deactivateOnPages']);
					$cntda = count($deactivateOnPagesarr);
					$foundpage = FALSE;
					for($i = 0; $i < $cntda; $i++){
						if (trim($deactivateOnPagesarr[$i]) == trim($this->TSFEid)) {
							$foundpage = TRUE;
							break;
						}

					}

					if ($foundpage == TRUE) {
						$opts['dontmod'] = 1;
					}

				}

			}

			$this->mergeCSSbelowTheFold = FALSE;
			if (intval($opts['generateCSSbelowTheFold']) == 1) {
				$this->generateCSSbelowTheFold = TRUE;

				if (intval($opts['inlineCSSaboveTheFold']) == 1) {
					$this->inlineCSSaboveTheFold = TRUE;
				}

				if (intval($opts['mergeCSSbelowTheFold']) == 1) {
					$this->mergeCSSbelowTheFold = TRUE;
					if (intval($opts['checkDupesOnFoldingMerge']) == 1) {
						$this->checkDupesOnFoldingMerge = TRUE;
					}

				}

				if (intval($opts['showDebugWindow']) == 1) {
					if (intval($opts['CSSFoldingReport']) == 1) {
						$this->makefoldingCSSreport = TRUE;
					}

				}

			} else {
				if (isset($opts['generateCSSbelowTheFold'])) {
					$this->generateCSSbelowTheFold = FALSE;
				}

			}
			// DebugWindow
			$thisshowDebugWindowwasTRUE = FALSE;
			if ($this->showDebugWindow == TRUE) {
				$thisshowDebugWindowwasTRUE = TRUE;
			}

			if (intval($opts['showDebugWindow']) == 0) {
				$this->showDebugWindow = FALSE;
				$this->showDebugWindowCSS = FALSE;
			}

			if (intval($opts['showOptionsInDebugWindow']) == 1) {
				$this->showOptionsInDebugWindow = TRUE;
			} else {
				if (isset($opts['showOptionsInDebugWindow'])) {
					$this->showOptionsInDebugWindow = FALSE;
				}

			}

			$foldingmd5 = '';
			$foldingmd5filename = '';
			if ($this->generateCSSbelowTheFold == TRUE) {
				$this->moveAtMedia = TRUE;
				if (trim($opts['tagsToKeepAboveTheFold']) != '') {
					$opts['tagsToKeepAboveTheFold'] = str_replace(' ', '', $opts['tagsToKeepAboveTheFold']);
					$this->tagsToKeepAboveTheFold = explode(',', $opts['tagsToKeepAboveTheFold']);
				}

				if (trim($opts['classesToKeepAboveTheFold']) != '') {
					$opts['classesToKeepAboveTheFold'] = str_replace(' ', '', $opts['classesToKeepAboveTheFold']);
					$this->classesToKeepAboveTheFold = explode(',', $opts['classesToKeepAboveTheFold']);
				}

				if (trim($opts['IDsToKeepAboveTheFold']) != '') {
					$opts['IDsToKeepAboveTheFold'] = str_replace(' ', '', $opts['IDsToKeepAboveTheFold']);
					$this->IDsToKeepAboveTheFold = explode(',', $opts['IDsToKeepAboveTheFold']);
				}

				if (intval($opts['freezeFolding']) != 0) {
					$this->freezeFolding = TRUE;
				}
				if ((intval($opts['mergeCSSbelowTheFold']) == 0) && ($this->freezeFolding == TRUE)) {
					$foldingmd5 = $this->htmlFoldMeta($buffer);
					$tdifftolastrun = 1000*(microtime(TRUE) - $starttimedebugfolding);
					$debuginfolding .=  '<span>Folding element cloud: '. round($tdifftolastrun, 1) . ' ms</span><br />';
					$foldingmd5filename = '-' . $foldingmd5;
					$starttimedebug = microtime(TRUE);
				} elseif ($this->freezeFolding == FALSE) {
					$foldingmd5 = $this->htmlFoldMeta($buffer);
					$tdifftolastrun = 1000*(microtime(TRUE) - $starttimedebugfolding);
					$debuginfolding .=  '<span>Folding element cloud: '. round($tdifftolastrun, 1) . ' ms</span><br />';
					$foldingmd5filename = '-' . $foldingmd5;
					$starttimedebug = microtime(TRUE);
				}

			}

			if (intval($opts['dontmod']) == 1) {
				$this->dontmod = TRUE;
			} else {
				if (isset($opts['dontmod'])) {
					$this->dontmod = FALSE;
				}

			}

			if (trim($opts['showDebugWindowBodyTag']) != '') {
				$this->showDebugWindowBodyTag = $opts['showDebugWindowBodyTag'];
			}

			if (intval($opts['forceNewFiles']) == 1) {
				$this->forceNewFiles = TRUE;
			} else {
				if (isset($opts['forceNewFiles'])) {
					$this->forceNewFiles = FALSE;
				}

			}

			if (intval($opts['dontmodJS']) == 1) {
				$this->dontmodjs = TRUE;
			} else {
				if (isset($opts['dontmodJS'])) {
					$this->dontmodjs = FALSE;
				}

			}

			if (intval($opts['dontmodCSS']) == 1) {
				$this->dontmodcss = TRUE;
			} else {
				if (isset($opts['dontmodCSS'])) {
					$this->dontmodcss = FALSE;
				}

			}

			if (intval($opts['optProcessfiles']) == 1) {
				$this->optProcessfiles = TRUE;
			} else {
				if (isset($opts['optProcessfiles'])) {
					$this->optProcessfiles = FALSE;
				}

			}

			if (intval($opts['optProcessjsfiles']) == 1) {
				$this->optProcessjsfiles = TRUE;
			} else {
				if (isset($opts['optProcessjsfiles'])) {
					$this->optProcessjsfiles = FALSE;
				}

			}

			if ($this->optProcessjsfiles == TRUE) {
				if (intval($opts['asynchLastJS']) == 1) {
					$this->asynchLastJS = TRUE;
				}

			}

			if (intval($opts['optMinifyjsfiles']) == 1) {
				$this->optMinifyjsfiles = TRUE;

			} else {
				if (isset($opts['optMinifyjsfiles'])) {
					$this->optMinifyjsfiles = FALSE;
				}

			}

			if (intval($opts['optProcesscssfiles']) == 1) {
				$this->optProcesscssfiles = TRUE;
			} else {
				if (isset($opts['optProcesscssfiles'])) {
					$this->optProcesscssfiles = FALSE;
				}

			}

			$this->tryFixBadCSS = FALSE;
			if (intval($opts['tryFixBadCSS']) == 1) {
				$this->tryFixBadCSS = TRUE;
			}

			if (intval($opts['doCrunchCSS']) == 1) {
				$this->doCrunchCSS = TRUE;
			} else {
				if (isset($opts['doCrunchCSS'])) {
					$this->doCrunchCSS = FALSE;
				}

			}

			if (isset($opts['includesarr'])) {
				$this->includesarr = explode(',', $opts['includesarr']);
			}

			if (isset($opts['excludesarr'])) {
				$this->excludesarr = explode(',', $opts['excludesarr']);
			}

			if (isset($opts['excludesProcessing'])) {
				$this->excludesprocessingarr = explode(',', $opts['excludesProcessing']);
			}

			if (isset($opts['includesProcessing'])) {
				$this->includesprocessingarr = explode(',', $opts['includesProcessing']);
			}

			$this->nominifyarr = explode(',', $opts['noMinifyjsList']);

			if (intval($opts['productionMode']) == 1) {
				$this->productionMode = TRUE;
			}

			// end | get TYPO3 Extension configuration options

			// build some string for debug window, options used
			$dbgepa = $opts['excludesProcessing'];
			$dbgipa = $opts['includesProcessing'];
			$dbgea = $opts['excludesarr'];
			$dbgia = $opts['includesarr'];
			$dbgnm = $opts['noMinifyjsList'];
			// end | build some string for debug window, options used

			// options dependencies
			if ($this->dontmodjs == TRUE) {
				$this->optProcessjsfiles = FALSE;
			}

			if ($this->dontmodcss == TRUE) {
				$this->optProcesscssfiles = FALSE;
			}
			// end | options dependencies
		}

		// options dependencies
		if ($this->optMinifyjsfiles == TRUE) {
			$this->doCompressJs = TRUE;
		} else {
			$this->doCompressJs = FALSE;
		}

		if ($this->productionMode == FALSE) {
			if (!empty($_GET['forceNewFiles'])){
				if ($_GET['forceNewFiles'] == '1'){
					$this->dontmod =FALSE;
					$this->dontmodjs =FALSE;
					$this->dontmodcss = FALSE;
					$this->optProcessfiles = TRUE;
					$this->optProcessjsfiles = TRUE;
					$this->optProcesscssfiles = TRUE;
					$this->forceNewFiles = TRUE;
				}

			}

			if (!empty($_GET['showDebugWindow'])){
				if ($_GET['showDebugWindow'] == '1'){
					if ($thisshowDebugWindowwasTRUE == TRUE) {
						$this->showDebugWindow = TRUE;
						$this->showDebugWindowCSS = TRUE;
					}

				}

			}

			if (!empty($_GET['dontModIndex'])){
				if ($_GET['dontModIndex'] == '1'){
					$this->dontmod = TRUE;
				}

			}

		}

		// ensure options hierarchy
		if ($this->optProcesscssfiles == FALSE){
			$this->doCrunchCSS = FALSE;
		}

		if ($this->dontmodcss == TRUE){
			$this->dontmodcss = TRUE;
			$this->optProcesscssfiles = FALSE;
			$this->doCrunchCSS = FALSE;
		}

		if ($this->doCompressJs == FALSE){
			$this->optMinifyjsfiles = FALSE;
		}

		if ($this->optProcessjsfiles == FALSE){
			$this->doCompressJs = FALSE;
			$this->optMinifyjsfiles = FALSE;
		}

		if ($this->dontmodjs == TRUE){
			$this->optProcessjsfiles = FALSE;
			$this->doCompressJs = FALSE;
			$this->optMinifyjsfiles = FALSE;
		}

		if ($this->dontmod == TRUE){
			$this->dontmodjs = TRUE;
			$this->dontmodcss = TRUE;
			$this->optProcessfiles = FALSE;
			$this->optProcessjsfiles = FALSE;
			$this->optProcesscssfiles = FALSE;
			$this->forceNewFiles = FALSE;
			$this->doCompressJs = FALSE;
			$this->optMinifyjsfiles = FALSE;
			$this->doCrunchCSS = FALSE;
		}

		if ($this->generateCSSbelowTheFold == TRUE) {
			$cfgstrCSS = 's';
		} else {
			$cfgstrCSS = 'a';
		}

		if ($this->doCrunchCSS == TRUE) {
			$cfgstrCSS .= 'c';
		} else {
			$cfgstrCSS .= 'u';
		}

		if (intval($this->userUid) == 0) {
			$cfgstrCSS .= 'a';
		} else {
			$cfgstrCSS .= 'l';
		}

		// end | options dependencies

		// string with options used for debug window

		$debugopt = '';


		if ($this->showDebugWindow == TRUE) {
			if ($this->showOptionsInDebugWindow == TRUE) {
				$debugopt = '<div class="ttirl_subtitle"><span><strong>Options</strong></span></div>
						<div>
						<span class="ttirlsmall">';
				$debugopt .= 'dontmod: ' . ((intval($this->dontmod) == 0) ? ' 0' : ' 1') . '<br />';
				$debugopt .= 'dontmodjs: ' . ((intval($this->dontmodjs) == 0) ? ' 0' : ' 1') . '<br />';
				$debugopt .= 'dontmodcss: ' . ((intval($this->dontmodcss) == 0) ? ' 0' : ' 1') . '<br />';
				$debugopt .= 'forceNewFiles: ' . ((intval($this->forceNewFiles) == 0) ? ' 0' : ' 1') . '<br />';
				$debugopt .= 'optProcessfiles: ' . ((intval($this->optProcessfiles) == 0) ? ' 0' : ' 1') . '<br />';
				$debugopt .= 'optProcessjsfiles: ' . ((intval($this->optProcessjsfiles) == 0) ? ' 0' : ' 1') . '<br />';
				$debugopt .= 'optProcesscssfiles: ' . ((intval($this->optProcesscssfiles) == 0) ? ' 0' : ' 1') . '<br />';
				$debugopt .= 'doCrunchCSS: ' . ((intval($this->doCrunchCSS) == 0) ? ' 0' : ' 1') . '<br />';
				$debugopt .= 'doCompressJs: ' . ((intval($this->doCompressJs) == 0) ? ' 0' : ' 1') . '<br />';
				$debugopt .= 'optMinifyjsfiles: ' . ((intval($this->optMinifyjsfiles) == 0) ? ' 0' : ' 1') . '<br />';
				$debugopt .= 'noMinify: ' . $dbgnm . '<br />';
				$debugopt .= 'excludes: ' . $dbgea . '<br />';
				$debugopt .= 'includes: ' . $dbgia . '<br />';
				$debugopt .= 'excludesProcessing: ' . $dbgepa . '<br />';
				$debugopt .= 'includesProcessing: ' . $dbgipa . '<br />';
				$debugopt .= 'generateCSSbelowTheFold: ' . ((intval($this->generateCSSbelowTheFold) == 0) ? ' 0' : ' 1') . '<br />';
				$debugopt .= 'mergeCSSbelowTheFold: ' . ((intval($this->mergeCSSbelowTheFold) == 0) ? ' 0' : ' 1') . '<br />';
				$debugopt .= 'freezeFolding: ' . ((intval($this->freezeFolding) == 0) ? ' 0' : ' 1') . '<br />';
				$debugopt .= 'inlineCSSaboveTheFold: ' . ((intval($this->inlineCSSaboveTheFold) == 0) ? ' 0' : ' 1') . '<br />';
				$debugopt .= 'checkDupesOnFoldingMerge: ' . ((intval($this->checkDupesOnFoldingMerge) == 0) ? ' 0' : ' 1');
				$debugopt .= '</span>
						</div>';
			}

			$debuginfo = '<div id="tt_ri_dbg">';
			$debuginfo .= '<span class="tt_ri_dbg_close" title="close debug window" onclick="document.getElementById(\'tt_ri_dbg\').style.display=\'none\';">X</span>
					<div class="ttirl_title"><strong>TocToc Index Reloaded</strong><br /><span class="ttirlsmall">'.date('F j, Y, g:i a').'</span></div>';
		}
		// end | string with options used for debug window

		// inits of vars used in this function
		$scriptoutput = '';
		$cssoutput = '';
		$cssoutbelow = '';
		$excludarrcnt = count($this->excludesarr);
		$excludprocessingarrcnt = count($this->excludesprocessingarr);
		$includesprocessingarrcnt = count($this->includesprocessingarr);
		$incluedescnt = count($this->includesarr);
		$noMinifycnt = count($this->nominifyarr);
		$cntininecss = 0;
		$cntininejs = 0;
		$cntcss = 0;
		$cntjs = 0;
		$lenInlinecss = 0;
		$lenInlinejs = 0;
		$lencss = 0;
		$lenjs = 0;
		$cntoutputcss = 0;
		$cntoutputjs = 0;
		$lenoutputcss = 0;
		$lenoutputjs = 0;
		$cntkeepcss = 0;
		$cntkeepcssext = 0;
		$cntkeepjs = 0;
		$cntkeepjsext = 0;
		// end | inits of vars used in this function
	// end | Do the grouping on the CSS
		if ($this->showDebugWindow == TRUE) {
			$tdifftolastrun = 1000*(microtime(TRUE) - $starttimedebug);
			$starttimedebug = microtime(TRUE);
			$debuginfo .=  $debuginfolding . '<span>Load options: '. round($tdifftolastrun, 1) . ' ms</span><br />';
		}
		// save the input and make some basic replacements in the input for the subsequent processing
		$bufferin=$buffer;

		$buffer = str_replace('<!--[IF', '<!--[if', $buffer);
		$buffer = str_replace('<![ENDIF]-->', '<![endif]-->', $buffer);
		$buffer = str_replace('<SCRIPT', '<script', $buffer);
		$buffer = str_replace('</SCRIPT>', '</script>', $buffer);
		$buffer = str_replace('REL="STYLESHEET"', 'rel="stylesheet"', $buffer);
		$buffer = str_replace('<LINK', '<link', $buffer);
		$buffer = str_replace('SRC="HTTPS:', 'src="https:', $buffer);
		$buffer = str_replace('SRC="', 'src="', $buffer);
		$buffer = str_replace('HREF="', 'href="', $buffer);
		$buffer = str_replace('<STYLE', '<style', $buffer);
		$buffer = str_replace('</STYLE>', '</style>', $buffer);

		$buffer = str_replace('src="' . $baseurl, 'src="', $buffer);
		$buffer = str_replace('url("' . $baseurl, 'url("', $buffer);

		if ($this->tryFixBadCSS == TRUE) {
			$corrections = explode('<link ', $buffer);
			$crcnt = count($corrections);
			if ($crcnt > 1) {
				for ($i = 1; $i < $crcnt;$i++) {
					$correctionstags = explode('>', $corrections[$i]);
					$correctionstags[0] = str_replace("'", '"', $correctionstags[0]);
					$correctionstags[0] = str_replace('  ', ' ', $correctionstags[0]);

					$correctionstypotremens = explode('//', $correctionstags[0]);
					if (count($correctionstypotremens) >1) {
						$correctionstags[0] = $correctionstypo . implode('/', $correctionstypotremens);
						$correctionstags[0] = str_replace('https:/', 'https://', $correctionstags[0]);
						$correctionstags[0] = str_replace('http:/', 'http://', $correctionstags[0]);
					}
					if ($baseurl != '') {
						$correctionstags[0] = str_replace($baseurl, '', $correctionstags[0]);
					}
					$corrections[$i] = implode('>', $correctionstags);

				}

				$buffer = implode('<link ', $corrections);
			}

			$corrections = explode('<style ', $buffer);
			$crcnt = count($corrections);
			if ($crcnt > 1) {
				for ($i = 1; $i < $crcnt;$i++) {
					$correctionstags = explode('>', $corrections[$i]);
					$correctionstags[0] = str_replace("'", '"', $correctionstags[0]);
					$correctionstags[0] = str_replace('  ', ' ', $correctionstags[0]);


					$corrections[$i] = implode('>', $correctionstags);

				}

				$buffer = implode('<style ', $corrections);
			}
		}
		if ($this->showDebugWindow == TRUE) {
			$tdifftolastrun = 1000*(microtime(TRUE) - $starttimedebug);
			$starttimedebug = microtime(TRUE);
			$debuginfo .= '<span>Normalize HTML: '. round($tdifftolastrun, 1) . ' ms</span><br />';
		}
		// end | save the input and make some basic replacements in the input for the subsequent processing

		// checkin if-tags for scripts or stylesheets
		$indexifarr= explode('<!--[if', $buffer);
		$indexifarrcnt=count($indexifarr);
		$condifs=array();
		$posif = 0;
		$debug = '';
		$skippedi =0;
		for($i=1;$i<$indexifarrcnt;$i++) {
			$indexifarr2= explode(']>', $indexifarr[$i - $skippedi]);
			$condifs[$i - $skippedi-1]['if'] = '<!--[if'.$indexifarr2[0] . ']>';
			$newiflen = strlen('<!--[if') + strlen($indexifarr2[0]) + strlen(']>');
			$condifs[$i - $skippedi-1]['iflength'] = $newiflen;
			$indexendifarr2= explode('<![endif]-->', $indexifarr2[1]);
			if (trim(str_replace("\n", '', str_replace("\r", '', $indexendifarr2[0]))) != '') {
				if (str_replace('<script', '', $indexendifarr2[0]) != $indexendifarr2[0]) {
					$condifs[$i - $skippedi-1]['js'] = 1;
				} else {
					$condifs[$i - $skippedi-1]['js'] = 0;
				}

				if (str_replace('rel="stylesheet"', '', $indexendifarr2[0]) != $indexendifarr2[0]) {
					$condifs[$i - $skippedi-1]['css'] = 1;
				} else {
					if (str_replace('<style', '', $indexendifarr2[0]) != $indexendifarr2[0]) {
						$condifs[$i - $skippedi-1]['css'] = 1;
					} else {
						$condifs[$i - $skippedi-1]['css'] = 0;
					}

				}
			} else {
				$condifs[$i - $skippedi-1]['if'] = '';
				$condifs[$i - $skippedi-1]['iflength'] = '';
				$skippedi++;
			}
			$posif = $posif + strlen($indexifarr[$i - $skippedi-1]);
			if (trim($indexendifarr2[0]) != '') {
				$condifs[$i - $skippedi-1]['posif'] = $posif;
				$condifs[$i - $skippedi-1]['statementlen'] = strlen($indexendifarr2[0]);
			}
			$posif = $posif + strlen('<!--[if');
		}
		// end | checkin if-tags for scripts or stylesheets

		// find scripts in the page
		if ($this->dontmodjs == 0) {
			$indexjsarr= explode('<script', $buffer);
			$indexjsarrcnt=count($indexjsarr);
			$scripts=array();
			$posscript = 0;
			$iSkipped =1;
			$posscriptipliscorr = 0;
			$scriptiplusstart = '';
			$strlenscript = strlen('<script');
			for($i=1;$i<$indexjsarrcnt;$i++) {
				$posscript = $posscript + $posscriptipliscorr + strlen($indexjsarr[$i-1]);
				$posscriptipliscorr = 0;
				$scriptiplusstart = '';
				$strlenscript =strlen('<script');
				$indexjsarr2= explode('</script>', $indexjsarr[$i]);
				if (count($indexjsarr2) == 1) {
					// no </script>, so 2nd script could be part of a document.write("<script ....
					if (($i+1) < $indexjsarrcnt) {
						$scriptiplusstart = '<script' . $indexjsarr2[0];
						$strlenscript = strlen('<script<script');
						$i++;
						$iSkipped++;
						$posscriptipliscorr = strlen($indexjsarr[$i-1]);
						$indexjsarr2= explode('</script>', $indexjsarr[$i]);
					}

				}

				$excludethis = FALSE;
				$excludeprocessingthis = FALSE;
				for($j=0;$j<$excludarrcnt;$j++) {
					if (str_replace(trim($this->excludesarr[$j]), '', $indexjsarr2[0]) != $indexjsarr2[0]) {
						$excludethis = TRUE;
					}

				}

				for($j=0;$j<$excludprocessingarrcnt;$j++) {
					if (str_replace(trim($this->excludesprocessingarr[$j]), '', $indexjsarr2[0]) != $indexjsarr2[0]) {
						$excludeprocessingthis = TRUE;
					}

				}

				for($j=0;$j<$incluedescnt;$j++) {
					if (str_replace(trim($this->includesarr[$j]), '', $indexjsarr2[0]) != $indexjsarr2[0]) {
						$excludethis = FALSE;
					}

				}

				for($j=0;$j<$includesprocessingarrcnt;$j++) {
					if (str_replace(trim($this->includesprocessingarr[$j]), '', $indexjsarr2[0]) != $indexjsarr2[0]) {
						$excludeprocessingthis = FALSE;
					}

				}

				if ($excludethis == FALSE) {
					$scripts[$i-$iSkipped]['script'] = $scriptiplusstart . '<script'.$indexjsarr2[0] . '</script>';
					$scripts[$i-$iSkipped]['posscript'] = $posscript;
					if ($excludeprocessingthis == TRUE) {
						$scripts[$i-$iSkipped]['scriptnoprocessing'] = 1;
					} else  {
						$scripts[$i-$iSkipped]['scriptnoprocessing'] = 0;
					}

				} else  {
					$cntkeepjs++;
					$iSkipped++;
				}

				$posscript = $posscript + $strlenscript;
			}

		}
		// end | find scripts in the page

		// find style and stylesheets in the page
		if ($this->dontmodcss == 0) {
			$indexcssarr= explode('<link ', $buffer);
			$indexcssarrcnt=count($indexcssarr);
			$cascadingslink=array();
			$poscascadings = 0;
			$idown=1;
			for($i=1;$i<$indexcssarrcnt;$i++) {
				$poscascadings = $poscascadings + strlen($indexcssarr[$i-1]);
				$indexcssarr2= explode('>', $indexcssarr[$i]);
				if (str_replace('rel="stylesheet"', '', $indexcssarr2[0]) != $indexcssarr2[0]) {
					$excludethis = FALSE;
					$excludeprocessingthis = FALSE;
					for($j=0;$j<$excludarrcnt;$j++) {
						if (str_replace(trim($this->excludesarr[$j]), '', $indexcssarr2[0]) != $indexcssarr2[0]) {
							$excludethis = TRUE;
						}

					}

					for($j=0;$j<$excludprocessingarrcnt;$j++) {
						if (str_replace(trim($this->excludesprocessingarr[$j]), '', $indexcssarr2[0]) != $indexcssarr2[0]) {
							$excludeprocessingthis = TRUE;
						}

					}

					for($j=0;$j<$incluedescnt;$j++) {
						if (str_replace(trim($this->includesarr[$j]), '', $indexcssarr2[0]) != $indexcssarr2[0]) {
							$excludethis = FALSE;
						}

					}

					for($j=0;$j<$includesprocessingarrcnt;$j++) {
						if (str_replace(trim($this->includesprocessingarr[$j]), '', $indexcssarr2[0]) != $indexcssarr2[0]) {
							$excludeprocessingthis = FALSE;
						}

					}

					if ($excludethis == FALSE) {
						$cascadingslink[$i-$idown]['css'] = '<link '.$indexcssarr2[0] . '>';
						$cascadingslink[$i-$idown]['inlinestyle'] = '';
						$cascadingslink[$i-$idown]['poscascadings'] = $poscascadings;
						if ($excludeprocessingthis == TRUE) {
							$cascadingslink[$i-$idown]['cssnoprocessing'] = 1;
						} else  {
							$cascadingslink[$i-$idown]['cssnoprocessing'] = 0;
						}

					}	else  {
						$cntkeepcss++;
						$cntcss--;
						$idown++;
					}

				} else {
					$idown++;
				}

				$poscascadings = $poscascadings + strlen('<link ');
			}

			$indexcssinlarr = explode('<style', $buffer);
			$indexcssinlarrcnt = count($indexcssinlarr);
			$cascadingsi = array();
			$poscascadings = 0;
			$idown=1;
			for($i=1;$i<$indexcssinlarrcnt;$i++) {
				$containcomment= FALSE;
				$poscascadings = $poscascadings + strlen($indexcssinlarr[$i-1]);
				$fulltagarr= explode('</style>', $indexcssinlarr[$i]);
				$styletagcomplete= '<style' . $fulltagarr[0] . '</style>';
				$indexcssinlarrwrk = str_replace('<!--', '', $fulltagarr[0]);
				$indexcssinlarrwrk = str_replace('-->', '', $indexcssinlarrwrk);
				if ($indexcssinlarrwrk != $fulltagarr[0]) {
					$containcomment = TRUE;
 					$indexcssinlarr2 = explode('--', $fulltagarr[0]);
 					$inlinestyle = $this->crunchcss($indexcssinlarr2[1]);

				} else {
					$indexcssinlarr2 = explode('>', $fulltagarr[0]);

					$inlinestyle = $this->crunchcss($indexcssinlarr2[1]);
				}

				$excludethis = FALSE;
				for($j=0;$j<$excludarrcnt;$j++) {
					if (str_replace(trim($this->excludesarr[$j]), '', $fulltagarr[0]) != $fulltagarr[0]) {
						$excludethis = TRUE;
					}

				}

				for($j=0;$j<$incluedescnt;$j++) {
					if (str_replace(trim($this->includesarr[$j]), '', $fulltagarr[0]) != $fulltagarr[0]) {
						$excludethis = FALSE;
					}

				}

				if ($excludethis == FALSE) {
					$cascadingsi[$i-$idown]['css'] = $styletagcomplete;
					$cascadingsi[$i-$idown]['inlinestyle'] = $inlinestyle;
					$cascadingsi[$i-$idown]['poscascadings'] = $poscascadings;
				}	else  {
					$idown++;
				}

			}

			$poscascadings = $poscascadings + strlen('<style');
			$cascadingss = array();
			$icss=0;
			$cascadingslinkcount = count($cascadingslink);
			$cascadingsicount = count($cascadingsi);
			$lastib=0;
			$ib=0;
			for ($i=0;$i<$cascadingslinkcount;$i++) {
				$candposcascadingslink = intval($cascadingslink[$i]['poscascadings']);
				$foundi2=0;
				if ($cascadingsicount > $lastib) {
					for ($ib=$lastib;$ib<$cascadingsicount;$ib++) {
						$candposcascadingsi = intval($cascadingsi[$ib]['poscascadings']);
						if ($candposcascadingsi < $candposcascadingslink) {
							$candposcascadings = $candposcascadingsi;
							$lastib=$ib+1;
							$cascadingss[$icss]['css'] = $cascadingsi[$ib]['css'];
							$cascadingss[$icss]['inlinestyle'] = $cascadingsi[$ib]['inlinestyle'];
							$cascadingss[$icss]['poscascadings'] = $cascadingsi[$ib]['poscascadings'];
							$cascadingss[$icss]['cssnoprocessing'] = $cascadingsi[$ib]['cssnoprocessing'];
							$icss++;
						}

					}

				}

				$cascadingss[$icss]['css'] = $cascadingslink[$i]['css'];
				$cascadingss[$icss]['inlinestyle'] = $cascadingslink[$i]['inlinestyle'];
				$cascadingss[$icss]['poscascadings'] = $cascadingslink[$i]['poscascadings'];
				$cascadingss[$icss]['cssnoprocessing'] = $cascadingslink[$i]['cssnoprocessing'];
				$icss++;
				if (($i+1)==$cascadingslinkcount) {
					for ($ib=$lastib;$ib<$cascadingsicount;$ib++) {
							$lastib=$ib+1;
							$cascadingss[$icss]['css'] = $cascadingsi[$ib]['css'];
							$cascadingss[$icss]['inlinestyle'] = $cascadingsi[$ib]['inlinestyle'];
							$cascadingss[$icss]['poscascadings'] = $cascadingsi[$ib]['poscascadings'];
							$cascadingss[$icss]['cssnoprocessing'] = $cascadingsi[$ib]['cssnoprocessing'];
							$icss++;
					}

				}

			}

		}
		if ($this->showDebugWindow == TRUE) {
			$tdifftolastrun = 1000*(microtime(TRUE) - $starttimedebug);
			$starttimedebug = microtime(TRUE);
			$debuginfo .= '<span>Find scripts and CSS: '. round($tdifftolastrun, 1) . ' ms</span><br />';
		}
		// end | find style and stylesheets in the page

		// build JS groups

		if ($this->dontmodjs == 0) {
			$condifscnt =count($condifs);
			$scriptscnt =count($scripts);
			$scriptoutputarr=array();
			$bufferout=$buffer;
			$icondifs=-1;
			$externalmode=0;
			// position on the first if with js inside
			Do {
				$icondifs++;
			} while (($condifs[$icondifs]['js']==0) && ($icondifs<$condifscnt));

			$indexinif = 0;
			$scriptblock=1;
			$exludefromprocessing = intval($scripts[0]['scriptnoprocessing']);
			$forcenewgroupprocessingexcluded = 1;
			for ($i=0;$i<$scriptscnt;$i++) {
				if ($exludefromprocessing != intval($scripts[$i]['scriptnoprocessing'])) {
					$forcenewgroupprocessingexcluded = 0;
					$exludefromprocessing = intval($scripts[$i]['scriptnoprocessing']);
					$scriptblock++;
				}

				$bufferout= str_replace($scripts[$i]['script'], '', $bufferout);
				if ($condifscnt > 0) {
					if ($icondifs<$condifscnt) {
						if (($condifs[$icondifs]['posif'] < $scripts[$i]['posscript']) && ($condifs[$icondifs]['posif']+$condifs[$icondifs]['iflength']+
								$condifs[$icondifs]['statementlen'] > $scripts[$i]['posscript'])) {
							// then the script is inside the if
							if ($indexinif == 0) {
								$indexinif = $indexinif + strlen($scripts[$i]['script']);
								$scripts[$i]['script'] = "\n". $condifs[$icondifs]['if']  . "\n". $scripts[$i]['script']. "\n";
								$scriptblock = $scriptblock + $forcenewgroupprocessingexcluded;
								$scripts[$i]['ifstate'] =$condifs[$icondifs]['if'];
							} else {
								$indexinif = $indexinif + strlen($scripts[$i]['script']);
							}

						}

						if (($condifs[$icondifs]['posif'] < $scripts[$i]['posscript']) && ($condifs[$icondifs]['posif']+$condifs[$icondifs]['iflength']+
								$condifs[$icondifs]['statementlen'] <
								$scripts[$i]['posscript'])) {
							$scriptblock = $scriptblock + $forcenewgroupprocessingexcluded;
							$scripts[$i-1]['script'] =$scripts[$i-1]['script'] . "\n". '<![endif]-->';
							$scripts[$i-1]['endifstate'] ='<![endif]-->';

							$indexinif = 0;
							$scripts[$i]['block'] = $scriptblock;
							$icondifs++;
							Do {
								$icondifs++;
							} while (($condifs[$icondifs]['js']==0) &&
									($condifs[$icondifs]['posif']+$condifs[$icondifs]['iflength']+
									$condifs[$icondifs]['statementlen'] <
									$scripts[$i]['posscript']) &&
									($icondifs<$condifscnt));
						}

					}

				}

				$scripts[$i]['block'] = $scriptblock;
				$forcenewgroupprocessingexcluded = 1;
			}

			$scriptoutput = '';
			for ($i=0;$i<$scriptscnt;$i++) {
				if ((str_replace('src="//', '', $scripts[$i]['script']) != $scripts[$i]['script']) ||
						(str_replace('src="https:', '', $scripts[$i]['script']) != $scripts[$i]['script']) ||
						(str_replace('src="http:', '', $scripts[$i]['script']) != $scripts[$i]['script']) ||
						(str_replace('src="//', '', $scripts[$i]['script']) != $scripts[$i]['script'])){
					if ($externalmode ==0) {
						$scriptblock++;
					}

					$scripts[$i]['file'] = '';
					$scripts[$i]['filequerystring'] = '';
					$externalmode =1;
					$cntkeepjs++;
					$cntkeepjsext++;
					$cntjs--;
					//external script
				} else {
					if ($externalmode == 1) {
						$scripts[$i]['script'] = $scripts[$i]['script'];
						$scriptblock++;
					}

					$filearr=explode(' src="', $scripts[$i]['script']);
					$filearr2=explode('"', $filearr[1]);
					if (DIRECTORY_SEPARATOR == '\\') {
						// windows
						$filefromroot= str_replace('/', '\\', $filearr2[0]);
					} else {
						$filefromroot = $filearr2[0];
					}

					if (substr($filefromroot, 0, 1) != DIRECTORY_SEPARATOR) {
						$filefromroot = DIRECTORY_SEPARATOR . $filefromroot;
					}

					$rawfilestrarr=explode('?', realpath(str_replace($this->extensionrelwinpath . '\Classes\Controller', '', str_replace($this->extensionrelpath . '/Classes/Controller', '', dirname(__FILE__)))) . $filefromroot);
					$rawfilestr=$rawfilestrarr[0];
					$rawfilestr=str_replace('.gzip', '', $rawfilestr);
					if (str_replace('.php', '', $rawfilestr) != $rawfilestr) {
						$isphp = 1;
					} else {
						$isphp = 0;
					}

					$scripts[$i]['file'] = str_replace(':\\', ':\\\\', $rawfilestr);
					if (count($rawfilestrarr) > 1) {
						//$rawfilestr=$rawfilestrarr[1];
						$rawfilestrarr2=explode('"',$rawfilestrarr[1]);
						$rawfilestr=$rawfilestrarr2[0];
						$rawfilestr=str_replace(':\\', ':\\\\', $rawfilestr);
						if (intval($rawfilestr) != 0) {
							// like 1395835571
							if (time()-intval($rawfilestr) > 5) {
								$scripts[$i]['filequerystring'] = $rawfilestr;
							}

						}

					}

					if ($isphp == 1) {
						if ($externalmode == 0) {
							$scripts[$i]['script'] = "\n". $scripts[$i]['script'];
							$cssblock++;
						}

						$externalmode = 1;
					} else {
						$externalmode = 0;
					}

				}

				$scripts[$i]['block'] = $scriptblock . intval($scripts[$i]['block']);
				$scripts[$i]['external'] = $externalmode;
				$scriptoutput .= $scripts[$i]['script'] ."\n";
			}

		}
		// end | build JS groups
		// Do the grouping on the CSS

		if ($this->dontmodcss == 0) {
			$condifscnt =count($condifs);
			$cascadingsscnt =count($cascadingss);
			$cssoutputarr=array();
			$icondifs=-1;
			$externalmode=0;
			// position on the first if with js inside
			Do {
				$icondifs++;
			} while (($condifs[$icondifs]['css']==0) && ($icondifs<$condifscnt));

			$indexinif = 0;
			$cssblock=1;
			$exludefromprocessing = $cascadingss[0]['cssnoprocessing'];
			$forcenewgroupprocessingexcluded = 1;
			for ($i=0;$i<$cascadingsscnt;$i++) {
				if ($exludefromprocessing != intval($cascadingss[$i]['cssnoprocessing'])) {
					$forcenewgroupprocessingexcluded = 0;
					$exludefromprocessing = intval($cascadingss[$i]['cssnoprocessing']);
					$cssblock++;
				}

				$bufferout= str_replace($cascadingss[$i]['css'], '', $bufferout);
				if ($condifscnt > 0) {
					if ($icondifs<$condifscnt) {
						if (($condifs[$icondifs]['posif'] < $cascadingss[$i]['poscascadings']) && ($condifs[$icondifs]['posif']+$condifs[$icondifs]['iflength']+
								$condifs[$icondifs]['statementlen'] >
								$cascadingss[$i]['poscascadings'])) {
							// then the css is inside the if
							if ($indexinif == 0) {
								$indexinif = $indexinif + strlen($cascadingss[$i]['css']);
								$cascadingss[$i]['css'] =  "\n" . $condifs[$icondifs]['if'] . "\n". $cascadingss[$i]['css']. "\n";
								$cssblock = $cssblock + $forcenewgroupprocessingexcluded;
								$cascadingss[$i]['ifstate'] =$condifs[$icondifs]['if'];
							} else {
								$indexinif = $indexinif + strlen($cascadingss[$i]['css']);
							}

						}

						if (($condifs[$icondifs]['posif'] < $cascadingss[$i]['poscascadings']) && ($condifs[$icondifs]['posif']+$condifs[$icondifs]['iflength']+
								$condifs[$icondifs]['statementlen'] <
								$cascadingss[$i]['poscascadings'])) {
							$cssblock = $cssblock + $forcenewgroupprocessingexcluded;
							$cascadingss[$i-1]['css'] =$cascadingss[$i-1]['css'] . "\n". '<![endif]-->';
							$cascadingss[$i-1]['endifstate'] ='<![endif]-->';
							$indexinif = 0;
							$icondifs++;
							Do {
								$icondifs++;
							} while (($condifs[$icondifs]['css']==0) &&
									($condifs[$icondifs]['posif']+$condifs[$icondifs]['iflength']+
											$condifs[$icondifs]['statementlen'] <
											$cascadingss[$i]['poscascadings']) &&
									($icondifs<$condifscnt));

						}

					}

				}

				$cascadingss[$i]['block'] = $cssblock;
				$forcenewgroupprocessingexcluded = 1;
			}

			$cssoutput = '';
			$cssoutputbelow = '';
			$cssblock= 1;
			$mediatype = '';
			for ($i=0; $i<$cascadingsscnt; $i++) {
				if ((str_replace('src="https:', '', $cascadingss[$i]['css']) != $cascadingss[$i]['css']) ||
						(str_replace('src="http:', '', $cascadingss[$i]['css']) != $cascadingss[$i]['css']) ||
						(str_replace('src="//', '', $cascadingss[$i]['css']) != $cascadingss[$i]['css']) ||
						(str_replace('href="//', '', $cascadingss[$i]['css']) != $cascadingss[$i]['css']) ||
						(str_replace('href="http:', '', $cascadingss[$i]['css']) != $cascadingss[$i]['css']) ||
						(str_replace('href="https:', '', $cascadingss[$i]['css']) != $cascadingss[$i]['css'])) {
					if ($externalmode == 0) {
						$cascadingss[$i]['css'] = "\n". $cascadingss[$i]['css'];
						$cssblock++;
					}

					$cascadingss[$i]['file'] = '';
					$cascadingss[$i]['filequerystring'] = '';
					$cascadingss[$i]['path'] = '';
					$cascadingss[$i]['mediatype'] = '';
					$externalmode = 1;
					$cntkeepcss++;
					$cntkeepcssext++;
					$cntcss--;
					//external css
				} else {
					if ($externalmode == 1) {
						$cascadingss[$i]['css'] = "\n". $cascadingss[$i]['css'];
						$cssblock++;
					}

					// mediatype
					$mediatype = '';
					$mediaarr = array();
					$mediaarr = explode('media="', $cascadingss[$i]['css']);
					if (count($mediaarr) > 1) {
						$newmediatypearr = explode('"', $mediaarr[1]);
						if (count($newmediatypearr) > 0) {
							$mediatype = $newmediatypearr[0];
						}

					}

					if (($mediatype == '') || (trim($mediatype) == 'all')) {
						$cascadingss[$i]['mediatype'] = '';
					} else {
						$cascadingss[$i]['mediatype'] = '@media ' . trim($mediatype) . ' {' . "\n";
					}

					$filearr=explode('href="', $cascadingss[$i]['css']);
					$filearr2=explode('"', $filearr[1]);
					$pathfromroot=substr($filearr2[0], 0, strrpos($filearr2[0], '/'));
					if (substr($pathfromroot, 0, 1) != '/') {
						$pathfromroot = '/'. $pathfromroot;
					}

					if (DIRECTORY_SEPARATOR == '\\') {
						// windows
						$filefromroot = str_replace('/', '\\', $filearr2[0]);
					} else {
						$filefromroot = $filearr2[0];
					}

					if (substr($filefromroot, 0, 1) != DIRECTORY_SEPARATOR) {
						$filefromroot = DIRECTORY_SEPARATOR . $filefromroot;
					}

					$filefromroot = str_replace('.gzip', '', $filefromroot);
					if (str_replace('.php', '', $filefromroot) != $filefromroot) {
						$isphp = 1;
					} else {
						$isphp = 0;
					}
					$rawfilestrarr=explode('?', realpath(str_replace($this->extensionrelwinpath . '\Classes\Controller', '',
							str_replace($this->extensionrelpath . '/Classes/Controller', '', dirname(__FILE__)))) .
							$filefromroot);
					$rawfilestr = $rawfilestrarr[0];
					$cascadingss[$i]['file'] = str_replace(':\\', ':\\\\', $rawfilestr);
					if (count($rawfilestrarr) > 1) {
						$rawfilestrarr2 = explode('"',$rawfilestrarr[1]);
						$rawfilestr = $rawfilestrarr2[0];
						$rawfilestr = str_replace(':\\', ':\\\\', $rawfilestr);
						if (intval($rawfilestr) != 0) {
							// like 1395835571
							if (time()-intval($rawfilestr) > 5) {
								$cascadingss[$i]['filequerystring'] = $rawfilestr;
							}

						}

					}

					$cascadingss[$i]['path'] = $pathfromroot;
					$rootpath = str_replace(':\\', ':\\\\', realpath(str_replace('Classes'. DIRECTORY_SEPARATOR. 'Controller', '', dirname(__FILE__))) . DIRECTORY_SEPARATOR);

					$rootpath = str_replace($this->extensionrelwinpath . DIRECTORY_SEPARATOR , '', str_replace($this->extensionrelpath. DIRECTORY_SEPARATOR, '', $rootpath));
					$rootpath .= str_replace('/', DIRECTORY_SEPARATOR, substr($_SERVER['REQUEST_URI'], 1));
					if (($cascadingss[$i]['file'] == $rootpath)
							&&($cascadingss[$i]['inlinestyle'] == '')) {
						if ($externalmode == 0) {
							$cascadingss[$i]['css'] = "\n". $cascadingss[$i]['css'];
							$cssblock++;
						}

						$externalmode = 1;
					} elseif ($isphp == 1) {
						if ($externalmode == 0) {
							$cascadingss[$i]['css'] = "\n". $cascadingss[$i]['css'];
							$cssblock++;
						}

						$externalmode = 1;
					} else {
						$externalmode = 0;
					}

				}

				$cascadingss[$i]['external'] = $externalmode;
				$cascadingss[$i]['block'] = $cssblock . intval($cascadingss[$i]['block']);
				$cssoutput .= $cascadingss[$i]['css'] ."\n";
				if ($this->generateCSSbelowTheFold == TRUE) {
					$cssoutputbelow .= str_replace('.css', 'below.css', $cascadingss[$i]['css']). "\n";
				}

			}

		}

		// end | Do the grouping on the CSS
		if ($this->showDebugWindow == TRUE) {
			$tdifftolastrun = 1000*(microtime(TRUE) - $starttimedebug);
			$starttimedebug = microtime(TRUE);
			$debuginfo .= '<div><span>Regroup found files: '. round($tdifftolastrun, 1) . ' ms</span><br />';
		}

		// now build filenames for the master file found from files in blocks and make new scripts array
		$lastfiletime = 0;
		clearstatcache();
		if ($this->dontmodjs == 0) {
			$iscriptblock = intval($scripts[0]['block']);
			$groupedscripts = array();
			$g=0;
			$gsub=0;
			$tmpmd5str='';
			for ($i=0;$i<$scriptscnt;$i++) {
				if ($iscriptblock != intval($scripts[$i]['block'])) {
					$iscriptblock = intval($scripts[$i]['block']);
					if  (($tmpmd5str !='') || ($lastfiletime != 0)) {
						$groupedscripts[$g]['md5css'] = 'f' . round($lastfiletime, 0) . $tmpmd5str . $g . '.js';
					} else {
						$groupedscripts[$g]['md5css'] = '';
					}

					$tmpmd5str='';
					$lastfiletime = 0;
					$g++;
					$gsub=0;
					$groupedscripts[$g]['scriptoutput'] = "\n";
				}

				$groupedscripts[$g]['file'][$gsub] = array();
				if ($scripts[$i]['file'] == str_replace(':\\', ':\\\\', (realpath(str_replace($this->extensionrelwinpath . '\Classes\Controller',
						'', str_replace($this->extensionrelpath . '/Classes/Controller', '', dirname(__FILE__)))) . DIRECTORY_SEPARATOR))) {
					$groupedscripts[$g]['file'][$gsub][0] = 'inline';
					$cntininejs++;
					if (($scripts[$i]['external'] == 0) && ($scripts[$i]['scriptnoprocessing'] == 0)) {
						$groupedscripts[$g]['file'][$gsub][1] = str_replace('<!--', '', str_replace('// -->', '', $scripts[$i]['script']));
					} else {
						$groupedscripts[$g]['file'][$gsub][1] = $scripts[$i]['script'];
					}

					$lenInlinejs = $lenInlinejs + strlen($groupedscripts[$g]['file'][$gsub][1]);
				} else {
					$cntjs++;
					$groupedscripts[$g]['file'][$gsub][0] = $scripts[$i]['file'];
					$groupedscripts[$g]['file'][$gsub][1] = '';

				}

				$groupedscripts[$g]['scriptoutput']  .= $scripts[$i]['script']. "\n";
				if (($scripts[$i]['external'] == 0) && ($scripts[$i]['scriptnoprocessing'] == 0)) {
					if ($groupedscripts[$g]['file'][$gsub][0] != 'inline') {
						if ($scripts[$i]['filequerystring'] != '') {
							$filetime = $scripts[$i]['filequerystring'];
						} else {
							if (str_replace('typo3temp', '', $scripts[$i]['file']) != $scripts[$i]['file']) {
								$filetime = filesize($scripts[$i]['file']);
							} else {
								$filetime = @filemtime($scripts[$i]['file']);
							}
						}
						$lastfiletime=($lastfiletime+$filetime)/2;
					} else {
						$tmpmd5str .= 'i' . strlen($scripts[$i]['script']) . '_';
					}

					$ifstate='';
					if (isset($scripts[$i]['ifstate'])) {
						$ifstate=$scripts[$i]['ifstate'] . "\n";
					}

					$endifstate='';
					if (isset($scripts[$i]['endifstate'])) {
						$endifstate=$scripts[$i]['endifstate'] . "\n";
					}

					if ($groupedscripts[$g]['ifstate'] == '') {
						$groupedscripts[$g]['ifstate'] = $groupedscripts[$g]['ifstate'] . $ifstate;
					}

					if ($groupedscripts[$g]['endifstate'] == '') {
						$groupedscripts[$g]['endifstate'] = $groupedscripts[$g]['endifstate'] . $endifstate;
					}

				}

				$gsub++;
			}
			if  (($tmpmd5str !='') || ($lastfiletime != 0)) {
				$groupedscripts[$g]['md5css'] = 'f' . round($lastfiletime, 0) . $tmpmd5str . $g . '.js';
			} else {
				$groupedscripts[$g]['md5css'] = '';
			}

			$groupedscriptscount=count($groupedscripts);
			$scriptoutput='';
			for ($i=0;$i<$groupedscriptscount;$i++) {
				$scriptoutput .= $groupedscripts[$i]['scriptoutput'];
			}

		}

		// end | now build filenames for the master file found from files in blocks and make new scripts array
		// now build filenames for blockfiles and make new css array
		if ($this->dontmodcss == 0) {
			$cssblock = 0;
			$groupedcss = array();
			$g=0;
			$gsub=0;
			$tmpmd5str='';
			$lastfiletime = 0;
			$tmpfilename = '';
			for ($i=0;$i<$cascadingsscnt;$i++) {
				if ($cssblock != intval($cascadingss[$i]['block'])) {
					$cssblock = intval($cascadingss[$i]['block']);
					if (($tmpmd5str != '') || ($lastfiletime != 0)) {
						$groupedcss[$g]['md5css'] = 'f' . md5($tmpfilename . $tmpmd5str) . '-' . $cfgstrCSS . $g . $foldingmd5filename . '.css';
					} else {
						$groupedcss[$g]['md5css'] = '';
					}

					$tmpmd5str='';
					$lastfiletime = 0;
					$tmpfilename = '';
					$g++;
					$gsub=0;
					$groupedcss[$g]['cssoutput'] =  "\n";
				}

				$groupedcss[$g]['file'][$gsub]=array();
				if ($cascadingss[$i]['file'] == (str_replace(":\\", ":\\\\", realpath(str_replace($this->extensionrelwinpath . '\Classes\Controller', '',
						str_replace($this->extensionrelpath . '/Classes/Controller', '', dirname(__FILE__))))) . DIRECTORY_SEPARATOR)) {
					$groupedcss[$g]['file'][$gsub][0] = 'inline';
					$cntininecss++;
					$groupedcss[$g]['file'][$gsub][1] = $cascadingss[$i]['inlinestyle'];
					$groupedcss[$g]['file'][$gsub][2] = '';

				} else {
					$groupedcss[$g]['file'][$gsub][0] = $cascadingss[$i]['file'];
					$cntcss++;
					$groupedcss[$g]['file'][$gsub][1] = $cascadingss[$i]['path'];
					$groupedcss[$g]['file'][$gsub][2] = $cascadingss[$i]['mediatype'];

				}

				$groupedcss[$g]['cssoutput']  .=  $cascadingss[$i]['css'] . "\n";
				if (($cascadingss[$i]['external'] == 0) && ($cascadingss[$i]['cssnoprocessing'] == 0)) {
					if ($groupedcss[$g]['file'][$gsub][0] != 'inline') {

						if ($cascadingss[$i]['filequerystring'] != '') {
							$filetime = $cascadingss[$i]['filequerystring'];
						} else {
							if (str_replace('typo3temp', '', $cascadingss[$i]['file']) != $cascadingss[$i]['file']) {
								$filetime = filesize($cascadingss[$i]['file']);
							} else {
								$filetime = @filemtime($cascadingss[$i]['file']);
							}

						}

						$lastfiletime=($lastfiletime+$filetime)/2;
						$tmpfilename .= '-' . $filetime;
     				} else {
						$tmpmd5str .= 's'. strlen($cascadingss[$i]['css']) . '_';
					}

					$ifstate='';
					if (isset($cascadingss[$i]['ifstate'])) {
						$ifstate=$cascadingss[$i]['ifstate'] . "\n";
					}

					$endifstate='';
					if (isset($cascadingss[$i]['endifstate'])) {
						$endifstate=$cascadingss[$i]['endifstate'] . "\n";
					}

					if ($groupedcss[$g]['ifstate'] == '') {
						$groupedcss[$g]['ifstate'] = $groupedcss[$g]['ifstate'] . $ifstate;
					}

					if ($groupedcss[$g]['endifstate'] == '') {
						$groupedcss[$g]['endifstate'] = $groupedcss[$g]['endifstate'] . $endifstate;
					}

				}

				$gsub++;
			}

			if (($tmpmd5str !='') || ($lastfiletime != 0)) {
				$groupedcss[$g]['md5css'] = 'f' . md5($tmpfilename . $tmpmd5str) . '-' . $cfgstrCSS . $g . $foldingmd5filename . '.css';
			} else {
				$groupedcss[$g]['md5css'] = '';
			}

			$groupedcsscount=count($groupedcss);
			$cssoutput='';
			for ($i=0;$i<$groupedcsscount;$i++) {
				$cssoutput .= $groupedcss[$i]['cssoutput']. "\n";
			}

			if ($this->generateCSSbelowTheFold == TRUE) {
				$cssoutputbelow='';
				for ($i=0;$i<$groupedcsscount;$i++) {
					$cssoutputbelow .= str_replace('.css', 'below.css', $groupedcss[$i]['cssoutput']). "\n";
				}

			}

		}

		// end | build filenames for blockfiles and make new css array
		if ($this->showDebugWindow == TRUE) {
			$tdifftolastrun = 1000*(microtime(TRUE) - $starttimedebug);
			$starttimedebug = microtime(TRUE);
			$debuginfo .= '<span>Create output file names: '. round($tdifftolastrun, 1) . ' ms</span><br />';
		}

		if ($this->optProcessfiles == TRUE) {
			if (DIRECTORY_SEPARATOR == '\\') {
				// windows
				$filefromroot= str_replace('/', '\\', $this->typo3tempsubfolder);
			} else {
				$filefromroot = $this->typo3tempsubfolder;
			}

			if (substr($filefromroot, 0, 1) != DIRECTORY_SEPARATOR) {
				$filefromroot = DIRECTORY_SEPARATOR . $filefromroot;
			}

			$checkfolderpath = realpath(str_replace($this->extensionrelwinpath . '\Classes\Controller', '',
					str_replace($this->extensionrelpath . '/Classes/Controller', '', dirname(__FILE__)))) . $filefromroot;
			if (!is_dir($checkfolderpath)) {
				if (DIRECTORY_SEPARATOR == '\\') {
					// windows
					$filefromroot= str_replace('/', '\\', $this->typo3tempsubfolder);
				} else {
					$filefromroot = $this->typo3tempsubfolder;
				}

				if (substr($filefromroot, 0, 1) != DIRECTORY_SEPARATOR) {
					$filefromroot = DIRECTORY_SEPARATOR . $filefromroot;
				}

				mkdir(realpath(str_replace($this->extensionrelwinpath . '\Classes\Controller', '',
							str_replace($this->extensionrelpath . '/Classes/Controller', '', dirname(__FILE__)))) . $filefromroot);
			}

			if ($this->optProcessjsfiles == TRUE) {
				if (DIRECTORY_SEPARATOR == '\\') {
					// windows
					$filefromroot= str_replace('/', '\\', $this->typo3tempsubfolder . '/js');
				} else {
					$filefromroot = $this->typo3tempsubfolder . '/js';
				}

				if (substr($filefromroot, 0, 1) != DIRECTORY_SEPARATOR) {
					$filefromroot = DIRECTORY_SEPARATOR . $filefromroot;
				}

				$checkfolderpath = realpath(str_replace($this->extensionrelwinpath . '\Classes\Controller', '',
						str_replace($this->extensionrelpath . '/Classes/Controller', '', dirname(__FILE__)))) . $filefromroot;

				if (!is_dir($checkfolderpath)) {
					if (DIRECTORY_SEPARATOR == '\\') {
						// windows
						$filefromroot= str_replace('/', '\\', $this->typo3tempsubfolder . '/js');
					} else {
						$filefromroot = $this->typo3tempsubfolder . '/js';
					}

					if (substr($filefromroot, 0, 1) != DIRECTORY_SEPARATOR) {
						$filefromroot = DIRECTORY_SEPARATOR . $filefromroot;
					}

					mkdir(realpath(str_replace($this->extensionrelwinpath . '\Classes\Controller', '',
					str_replace($this->extensionrelpath . '/Classes/Controller', '', dirname(__FILE__)))) . $filefromroot);
				}

				$processedfiles=0;
				if (str_replace(':\\\\', '', $checkfolderpath) == $checkfolderpath) {
					$checkfolderpath = str_replace(':\\', ':\\\\', $checkfolderpath);
				}

				for ($i=0;$i<=$groupedscriptscount;$i++) {
					if ($groupedscripts[$i]['md5css'] != '') {
						if ((!file_exists($checkfolderpath . DIRECTORY_SEPARATOR . $groupedscripts[$i]['md5css'])) || ($this->forceNewFiles == TRUE)) {
							$groupedfilescount=count($groupedscripts[$i]['file']);
							$filecontent='';
							for ($j=0;$j<$groupedfilescount;$j++) {
								$writejstext='';
								$checkfile= $groupedscripts[$i]['file'][$j][0];

								if ($groupedscripts[$i]['file'][$j][0] == 'inline') {
									$writejstext = str_replace('</script>', '', $groupedscripts[$i]['file'][$j][1]);
									$writejstextarr = explode('>', $writejstext);
									$writejstextarr[0] = 'inlinestarttag';
									$writejstext = str_replace('inlinestarttag>', '', implode('>', $writejstextarr));
									if ($this->doCompressJs == TRUE) {
										$writejstextarrspace=explode(' ', $writejstext);
										$writejstextarrtabs=explode("\n", $writejstext);
										if (count($writejstextarrspace)+count($writejstextarrtabs)>4) {
											$excludethis = FALSE;
											for($nomini=0;$nomini<$noMinifycnt;$nomini++) {
												if (str_replace(trim($this->nominifyarr[$nomini]), '', $writejstext) != $writejstext) {
													$excludethis = TRUE;
												}

											}

											if ($excludethis == FALSE) {
												if ($this->isCompressed($writejstext) == FALSE) {
													$writejstext = $this->compressjs($writejstext, $this->optMinifyjsfiles);
												} else {
													$writejstext = $this->compressjs($writejstext, $this->optMinifyjsfiles, TRUE);
												}

											}

										}

									}

								} elseif (file_exists($checkfile)) {
									$writejstext = file_get_contents($checkfile);
									$lenjs = $lenjs + strlen($writejstext);
									if (str_replace('function ', '', $writejstext) != $writejstext){
										$writejstext = file_get_contents($checkfile);
										if ($this->doCompressJs == TRUE) {
											$writejstextarrspace=explode(' ', $writejstext);
											$writejstextarrtabs=explode("\n", $writejstext);
											if (count($writejstextarrspace)+count($writejstextarrtabs)>4) {
												$excludethis = FALSE;
												for($nomini=0;$nomini<$noMinifycnt;$nomini++) {
													if (str_replace(trim($this->nominifyarr[$nomini]), '', $writejstext) != $writejstext) {
														$excludethis = TRUE;
													}

												}

												if ($excludethis == FALSE) {
													if ($this->isCompressed($writejstext) == FALSE) {
														$writejstext = $this->compressjs($writejstext, $this->optMinifyjsfiles);
													} else {
														$writejstext = $this->compressjs($writejstext, $this->optMinifyjsfiles, TRUE);
													}

												}

											} else {
												// remove comments
												$writejstext = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $writejstext);
											}

										}

									} else {
										$writejstext = file_get_contents($checkfile);
										if ($this->doCompressJs == TRUE) {
											$writejstextarrspace=explode(' ', $writejstext);
											$writejstextarrtabs=explode("\n", $writejstext);
											if (count($writejstextarrspace)+count($writejstextarrtabs)>4) {
												$excludethis = FALSE;
												for($nomini=0;$nomini<$noMinifycnt;$nomini++) {
													if (str_replace(trim($this->nominifyarr[$nomini]), '', $writejstext) != $writejstext) {
														$excludethis = TRUE;
													}

												}

												if ($excludethis == FALSE) {
													if ($this->isCompressed($writejstext) == FALSE) {
														$writejstext = $this->compressjs($writejstext, $this->optMinifyjsfiles);
													} else {
														$writejstext = $this->compressjs($writejstext, $this->optMinifyjsfiles, TRUE);
													}													}

											} else {
												$writejstext = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $writejstext);
											}

										}

									}

									$processedfiles++;
								}

								if ($this->optMinifyjsfiles == FALSE) {
									$writejstext = '{' . "\n" . $writejstext   . '}' . "\n";
								} else {
									$writejstext = '{' . $writejstext   . '}';
								}

								$filecontent .= $writejstext;
							}

							file_put_contents($checkfolderpath . DIRECTORY_SEPARATOR . $groupedscripts[$i]['md5css'], $filecontent);
							$cntoutputjs++;
							$lenoutputjs = $lenoutputjs + strlen($filecontent);
						}

						$ifstate='';
						if (isset($groupedscripts[$i]['ifstate'])) {
							$ifstate=$groupedscripts[$i]['ifstate'];
						}

						$endifstate='';
						if (isset($groupedscripts[$i]['endifstate'])) {
							$endifstate=$groupedscripts[$i]['endifstate'];
						}
						$async = '';
						if ($i == ($groupedscriptscount - 1)) {
							If ($this->asynchLastJS == TRUE) {
								$async = 'async ';
							}
						}

						$groupedscripts[$i]['scriptoutput'] = $ifstate . '<script ' . $async . 'src="/' . $this->typo3tempsubfolder . '/js/' . $groupedscripts[$i]['md5css'] .
						'" type="text/javascript"></script>' . $endifstate . "\n";
					}

				}

				$groupedscriptscount=count($groupedscripts);
				$scriptoutput='';
				for ($i=0;$i<$groupedscriptscount;$i++) {
					$scriptoutput .=$groupedscripts[$i]['scriptoutput'];
				}

				$tdifftolastrun = 1000*(microtime(TRUE) - $starttimedebug);
				$starttimedebug=microtime(TRUE);
				if ($this->showDebugWindow == TRUE) {
					$debuginfo .= '<span>Check output, '. $groupedscriptscount .' JS files: '. round($tdifftolastrun, 1) . ' ms</span><br />';
				}
			}

			//css files
			if ($this->optProcesscssfiles == TRUE) {
				if (DIRECTORY_SEPARATOR == '\\') {
					// windows
					$filefromroot= str_replace('/', '\\', $this->typo3tempsubfolder . '/css');
				} else {
					$filefromroot = $this->typo3tempsubfolder . '/css';
				}

				if (substr($filefromroot, 0, 1) != DIRECTORY_SEPARATOR) {
					$filefromroot = DIRECTORY_SEPARATOR . $filefromroot;
				}

				$checkfolderpath = realpath(str_replace($this->extensionrelwinpath . '\Classes\Controller', '', str_replace($this->extensionrelpath . '/Classes/Controller',
						'', dirname(__FILE__)))) . $filefromroot;
				if (str_replace(':\\\\', '', $checkfolderpath) == $checkfolderpath) {
					$checkfolderpath=str_replace(':\\', ':\\\\', $checkfolderpath);
				}

				if (!is_dir($checkfolderpath)) {
					if (DIRECTORY_SEPARATOR == '\\') {
						// windows
						$filefromroot= str_replace('/', '\\', $this->typo3tempsubfolder . '/css');
					} else {
						$filefromroot = $this->typo3tempsubfolder . '/css';
					}

					if (substr($filefromroot, 0, 1) != DIRECTORY_SEPARATOR) {
						$filefromroot = DIRECTORY_SEPARATOR . $filefromroot;
					}

					mkdir(realpath(str_replace($this->extensionrelwinpath . '\Classes\Controller', '', str_replace($this->extensionrelpath . '/Classes/Controller',
					'', dirname(__FILE__)))) . $filefromroot);
				}

				$processedfiles=0;
				$j2 = 0;

				if ($this->generateCSSbelowTheFold == TRUE) {
					$starttimedebugmerge = microtime(TRUE);
					$debugmergetime = 0;
				}
				if ($this->showDebugWindow == TRUE) {
					//return json_encode($groupedcss, JSON_PRETTY_PRINT);
				}
				for ($i=0;$i<$groupedcsscount;$i++) {
					if ($groupedcss[$i]['md5css'] != '') {
						if ($this->freezeFolding == FALSE) {
							if ((!file_exists($checkfolderpath . DIRECTORY_SEPARATOR . $groupedcss[$i]['md5css'])) || ($this->forceNewFiles == TRUE)) {
								$groupedfilescount=count($groupedcss[$i]['file']);
								$filecontent='';
								for ($j=0;$j<$groupedfilescount;$j++) {
									$writecsstext='';
									$checkfile= $groupedcss[$i]['file'][$j][0];
									if ($groupedcss[$i]['file'][$j][0] == 'inline') {
										$groupedcss[$i]['file'][$j][1] = str_replace("\n", '', $groupedcss[$i]['file'][$j][1]);
										$writecsstext = str_replace('</style>', '', $groupedcss[$i]['file'][$j][1]);
										$writecsstextarr = explode('>', $writecsstext);
										if (count($writecsstextarr) > 1) {
											$writecsstextarr[0] = 'inlinestarttag';
											$writecsstext = str_replace('inlinestarttag>', "\n", implode('>', $writecsstextarr)) . "\n";
										}
										//$writecsstexts = $writecsstext;
										$writecsstext = $this->handleCssAtImportFiles($writecsstext, '', array(), 0);
										//return ' in: ' . $writecsstexts . ' out: ' . $writecsstext . ' from: ' . json_encode($groupedcss[$i]['file'], JSON_PRETTY_PRINT);
									} elseif (file_exists($checkfile)) {
										$writecsstext = file_get_contents($checkfile);

										//leave:
										//url("https://fbstatic-a.akamaihd.net/rsrc.php/v2/y1/r/LVx-xkvaJ0b.png");
										//url("data:image/png;...
										//change
										//url("../img/rclogos.jpg")
										//url("/fileadmin/themes/default/img/logon.gif")
										$checkpath= $groupedcss[$i]['file'][$j][1];
										$checkpatharr = explode('/', $checkpath);
										$countcheckpatharr = count($checkpatharr);
										$writecsstext = $this->handleCssAtImportFiles($writecsstext, $checkpath, $checkpatharr, $countcheckpatharr);
		 								$lencss = $lencss + strlen($writecsstext);
										$hypos='';
										$writecsstextarr = explode('url(', $writecsstext);
										$writecsstextarrcount=count($writecsstextarr);
										for ($q=1;$q<$writecsstextarrcount;$q++) {
											$hypos='';
											if (substr($writecsstextarr[$q], 0, 1) == '\'') {
												$writecsstextarr[$q]=substr($writecsstextarr[$q], 1);
												$hypos='\'';
											}

											if (substr($writecsstextarr[$q], 0, 1) == '"') {
												$writecsstextarr[$q]=substr($writecsstextarr[$q], 1);
												$hypos='"';
											}

											$writecsstextarr2 = explode($hypos . ')', $writecsstextarr[$q]);
											$urltocheck = $writecsstextarr2[0];
											$urltocheckout = str_replace('https://', '', $urltocheck);
											$urltocheckout = str_replace('http://', '', $urltocheckout);
											$urltocheckout = str_replace('data:', '', $urltocheckout);
											if ($urltocheckout == $urltocheck)  {
												if (substr($urltocheck, 0, 1) != '/') {
													$checkuppatharr = explode('../', $urltocheck);
													$countcheckuppatharr = count($checkuppatharr);
													if ($countcheckuppatharr>0) {
														$outurltocheck = $checkuppatharr[$countcheckuppatharr-1];
														$outurltocheckpart1 ='';
														for ($p=0;$p<=$countcheckpatharr-$countcheckuppatharr;$p++) {
															$outurltocheckpart1 .=$checkpatharr[$p].'/';
														}

														$urltocheck = $outurltocheckpart1 . $outurltocheck;
													} else {
														$urltocheck =$checkpath .'/' . $urltocheck;
													}

													$writecsstextarr2[0]=$urltocheck;
												}

											}

											$writecsstextarr[$q] = $hypos .  implode($hypos . ')', $writecsstextarr2);
										}

										$writecsstext = implode('url(', $writecsstextarr);
										$processedfiles++;
									}

									$endmediatype = '';
									$startmediatype = '';
									if ($groupedcss[$i]['file'][$j][2] != '') {
										$endmediatype = "\n" . '}';
										$startmediatype = $groupedcss[$i]['file'][$j][2];
									}

									$filecontent .= $startmediatype . $writecsstext . $endmediatype . "\n";
								}

								if ($this->tryFixBadCSS == TRUE) {
									// the special filter for the crimes of Daniel Martin
									// please don't laugh - it is true - hold on:
									if (str_replace('<?php', '', $filecontent) != $filecontent) {
										$filecontent = $this->crunchcss($filecontent);
										$filecontent = str_replace('screenand', 'screen and', $filecontent);
										// then probably it's him, he made again an "exclusive" site (wordpress...)
										// with self protected code
										$danielmartinphpcrimes = explode('<?php', $filecontent);
										$countdmc = count($danielmartinphpcrimes);
										for ($dm = 1; $dm < $countdmc; $dm++) {
											// let's suppose there's always an end tag ...
											$danielmartinphpcrimesendtags = explode('?>', $danielmartinphpcrimes[$dm]);
											array_shift($danielmartinphpcrimesendtags);
											$danielmartinphpcrimes[$dm] = implode('', $danielmartinphpcrimesendtags);
										}

										$filecontent = implode('', $danielmartinphpcrimes);
									}

									if (str_replace('w\\', '', $filecontent) != $filecontent) {
										// now stupidities like "t\op:19px;"
										$filecontent = $this->crunchcss($filecontent);
										$danielmartinphpcrimes = explode('t\\', $filecontent);
										$countdmc = count($danielmartinphpcrimes);

										for ($dm = 1; $dm < $countdmc; $dm++) {
											// let's suppose there's always an end tag ...
											$danielmartinphpcrimesendtags = explode(';', $danielmartinphpcrimes[$dm]);
											array_shift($danielmartinphpcrimesendtags);
											$danielmartinphpcrimes[$dm] = implode(';', $danielmartinphpcrimesendtags);
										}

										$filecontent = implode('', $danielmartinphpcrimes);

										$danielmartinphpcrimes = explode('w\\', $filecontent);
										$countdmc = count($danielmartinphpcrimes);
										//return $countdmc;
										for ($dm = 1; $dm < $countdmc; $dm++) {
											// let's suppose there's always an end tag ...
											$danielmartinphpcrimesendtags = explode(';', $danielmartinphpcrimes[$dm]);
											array_shift($danielmartinphpcrimesendtags);
											$danielmartinphpcrimes[$dm] = implode(';', $danielmartinphpcrimesendtags);
										}

										$filecontent = implode('', $danielmartinphpcrimes);

									}
								}

								if ($this->generateCSSbelowTheFold == TRUE) {
									$starttimedebugmerge = microtime(TRUE);
									$filecontents = array();
									$filecontentsave = $filecontent;
									$filecontent = $this->crunchcss($filecontent);
									$this->iFCSSRep++;
									$unsetgenerateCSSbelowTheFold = FALSE;
									if ($this->freezeFolding == FALSE) {
										If ((strlen($this->secret) != 20) && (strlen($this->secret) != 19)) {
											$unsetgenerateCSSbelowTheFold = TRUE;
										} else {

											//return json_encode($groupedcss, JSON_PRETTY_PRINT);
											$filecontents = $this->splitCSSBelowAboveTheFold($filecontent);
										}

										if (($filecontents == '') || ($unsetgenerateCSSbelowTheFold == TRUE)) {
											//fall back on error with API-Server
											$filecontent = $filecontentsave;
											$this->generateCSSbelowTheFold = FALSE;
											$this->inlineCSSaboveTheFold = FALSE;
											$this->mergeCSSbelowTheFold = FALSE;
											$this->makefoldingCSSreport = FALSE;
											$groupedcss[$i]['md5css'] = str_replace($foldingmd5filename, '', $groupedcss[$i]['md5css']);
											$cfgstrCSSnew = str_replace('s', 'a', $cfgstrCSS);
											$groupedcss[$i]['md5css'] = str_replace('-' . $cfgstrCSS, '-' . $cfgstrCSSnew, $groupedcss[$i]['md5css']);
											$cfgstrCSSold = $cfgstrCSS;
											$cfgstrCSS = $cfgstrCSSnew;
											$APIreset = TRUE;

										} else {
											$filecontent = $filecontents[0];
											$filecontentbelowthefold = $filecontents[1];
											$filecontentoPosabove = $filecontents[2];
											$filecontentoPosbelow = $filecontents[3];
										}
									} else {
										$filecontent = '';
										$filecontentbelowthefold = '';
									}

								} else {
									if ($APIreset == TRUE) {
										$groupedcss[$i]['md5css'] = str_replace($foldingmd5filename, '', $groupedcss[$i]['md5css']);
										$groupedcss[$i]['md5css'] = str_replace('-' . $cfgstrCSSold, '-' . $cfgstrCSSnew, $groupedcss[$i]['md5css']);
									}

								}

								if ($this->freezeFolding == FALSE) {
									if ($this->doCrunchCSS == TRUE) {
										if ($this->isCompressed($filecontent) == FALSE) {
											$filecontent = $this->crunchcss($filecontent);
										} else {
											$filecontent = $this->crunchcss($filecontent, TRUE);
										}

										if ($this->generateCSSbelowTheFold == TRUE) {
											if ($filecontentbelowthefold != '') {
												if ($this->isCompressed($filecontentbelowthefold) == FALSE) {
													$filecontentbelowthefold = $this->crunchcss($filecontentbelowthefold);
												} else {
													$filecontentbelowthefold = $this->crunchcss($filecontentbelowthefold, TRUE);
												}

											}

										}

									}

									file_put_contents($checkfolderpath . DIRECTORY_SEPARATOR . $groupedcss[$i]['md5css'], $filecontent);
								}

								if ($this->generateCSSbelowTheFold == TRUE) {
									if ($this->freezeFolding == FALSE) {
										if ($this->pruneHTMLBaseToDisk == TRUE) {
											file_put_contents($checkfolderpath . DIRECTORY_SEPARATOR . str_replace('.css', '.txt', $groupedcss[$i]['md5css']), $this->pruneHTMLBase);
										}

										file_put_contents($checkfolderpath . DIRECTORY_SEPARATOR . str_replace('.css', 'below.css', $groupedcss[$i]['md5css']), $filecontentbelowthefold);
									}
									if ($this->mergeCSSbelowTheFold != TRUE) {
										$this->lenoutputcssbelow = $this->lenoutputcssbelow + strlen($filecontentbelowthefold);
										$this->lenoutputcssabove = $this->lenoutputcssabove + strlen($filecontent);
									}

									$cntoutputcssbelow++;
									$lenoutputcss = $lenoutputcss + strlen($filecontentbelowthefold);
									if ($this->mergeCSSbelowTheFold == TRUE) {
										if ($this->freezeFolding == FALSE) {
											$retcode = $this->mergeCSS($checkfolderpath . DIRECTORY_SEPARATOR, $groupedcss[$i]['md5css'], $foldingmd5, $filecontent, $filecontentbelowthefold, $filecontentoPosabove, $filecontentoPosbelow);
											if ($retcode == 'ko') {
												$this->mergeCSSbelowTheFold = FALSE;
												$this->generateCSSbelowTheFold = FALSE;
												$this->inlineCSSaboveTheFold = FALSE;
											}

										}

									}

								}

								$cntoutputcss++;
								$lenoutputcss = $lenoutputcss + strlen($filecontent);
							}
						}

						if ($this->generateCSSbelowTheFold == TRUE) {
							if ($this->freezeFolding == FALSE) {
								$tdifftolastrunmerge = 1000*(microtime(TRUE) - $starttimedebugmerge);
								$debugmergetime = $debugmergetime + $tdifftolastrunmerge;
							} else {
								$debugmergetime = 0;
							}

						}

						$ifstate='';
						if (isset($groupedcss[$i]['ifstate'])) {
							$ifstate=$groupedcss[$i]['ifstate'];
						}

						$endifstate='';
						if (isset($groupedcss[$i]['endifstate'])) {
							$endifstate=$groupedcss[$i]['endifstate'];
						}

						if ($this->generateCSSbelowTheFold == TRUE) {
							if (($this->mergeCSSbelowTheFold == TRUE) && ($this->freezeFolding == FALSE)) {
								$filenamelink = '/' . $this->typo3tempsubfolder . '/css/merged/' .	str_replace($foldingmd5filename, '', $groupedcss[$i]['md5css']);
							} elseif (($this->mergeCSSbelowTheFold == TRUE) && ($this->freezeFolding == TRUE)) {
								$filenamelink = '/' . $this->typo3tempsubfolder . '/css/merged/' . $groupedcss[$i]['md5css'];
							} elseif (($this->mergeCSSbelowTheFold == FALSE) && ($this->freezeFolding == TRUE)) {
								$filenamelink = '/' . $this->typo3tempsubfolder . '/css/' . $groupedcss[$i]['md5css'];
							} else {
								$filenamelink = '/' . $this->typo3tempsubfolder . '/css/' .	$groupedcss[$i]['md5css'];
							}

							$path = realpath(str_replace($this->extensionrelwinpath . '\Classes\Controller', '',
							str_replace($this->extensionrelpath . '/Classes/Controller', '', dirname(__FILE__)))) . $filenamelink;
							if ($this->inlineCSSaboveTheFold == TRUE) {
								if (file_exists($path)) {
									$modfilenamelink = file_get_contents($path);
								} else {
									$modfilenamelink = '';
								}
							} else {
								$modfilenamelink = $this->createVersionNumberedFilename($filenamelink, TRUE);
							}

						} else {
							$modfilenamelink = '/' . $this->typo3tempsubfolder . '/css/' .	str_replace($foldingmd5filename, '', $groupedcss[$i]['md5css']);
						}

						if ($modfilenamelink != '') {
							if ($this->inlineCSSaboveTheFold == TRUE) {
								$groupedcss[$i]['cssoutput'] = $ifstate . '<style>' . $modfilenamelink . '</style>' . $endifstate . "\n";
							} else {
								$groupedcss[$i]['cssoutput'] = $ifstate . '<link rel="stylesheet" type="text/css" href="' . $modfilenamelink . '" />' . $endifstate . "\n";
							}
						} else {
							$groupedcss[$i]['cssoutput'] = '';
						}

						if ($this->generateCSSbelowTheFold == TRUE) {
							if ($this->mergeCSSbelowTheFold == TRUE) {
								if ($this->freezeFolding == TRUE) {
									$filenamelink = '/' . $this->typo3tempsubfolder . '/css/merged/' .
											str_replace('.css', 'below.css', str_replace('-' . $foldingmd5, '-', $groupedcss[$i]['md5css']));
								} else {
									$filenamelink = '/' . $this->typo3tempsubfolder . '/css/merged/' .
									str_replace('.css', 'below.css', str_replace('-' . $foldingmd5, '', $groupedcss[$i]['md5css']));
								}
							} else {
								if ($this->freezeFolding == TRUE) {
									$filenamelink = '/' . $this->typo3tempsubfolder . '/css/' .	str_replace('.css', 'below.css', $groupedcss[$i]['md5css']);

								} else {
									$filenamelink = '/' . $this->typo3tempsubfolder . '/css/' .	str_replace('.css', 'below.css', $groupedcss[$i]['md5css']);
								}
							}

							$modfilenamelink = $this->createVersionNumberedFilename($filenamelink, TRUE);
							$groupedcss[$i]['cssoutputbelow'] = $ifstate . '<link rel="stylesheet" type="text/css" href="' . $modfilenamelink . '" />' . $endifstate . "\n";

						} else {
							$groupedcss[$i]['cssoutputbelow'] = '';
						}

					}

				}

				$groupedcsscount = count($groupedcss);
				$cssoutput = '';
				$cssoutputbelow = '';
				for ($i=0;$i<$groupedcsscount;$i++) {
					$cssoutput .= $groupedcss[$i]['cssoutput'];
					$cssoutputbelow .= $groupedcss[$i]['cssoutputbelow'];
				}

				$tdifftolastrun = 1000*(microtime(TRUE) - $starttimedebug);
				$starttimedebug = microtime(TRUE);
				if ($this->showDebugWindow == TRUE) {
					$debuginfo .= '<span>Check output, ' . $groupedcsscount . ' CSS files: ' . round($tdifftolastrun, 1) . ' ms</span><br />';
				}

			}

		}

		$bufferout= str_replace('</body>', "\n". $scriptoutput . "\n". '</body>', $bufferout);
		if (trim($cssoutputbelow) != '') {
			$cssoutputbelowarr = explode("\n", $cssoutputbelow);
			$jsoutputbelow = '<script async type="text/javascript">' . "\n" . '
	function loadStyleSheet(src){
		if (document.createStyleSheet) document.createStyleSheet(src);
		else {
			var stylesheet = document.createElement(\'link\');
			stylesheet.href = src;
			stylesheet.rel = \'stylesheet\';
			stylesheet.type = \'text/css\';
			document.getElementsByTagName(\'body\')[0].appendChild(stylesheet);
		}
	}
';
			$onIF = 0;
			foreach($cssoutputbelowarr as $cssoutputblw) {
				if (trim($cssoutputblw) != '') {
					$cssoutputblwsrc = str_replace('<link rel="stylesheet" type="text/css" href="', '', $cssoutputblw);
					$cssoutputblwsrc = str_replace('" />', '', $cssoutputblwsrc);
					if (($cssoutputblwsrc == '<!--[if IE]>') || ($cssoutputblwsrc == '<!--[if IE 7]>') || ($cssoutputblwsrc == '<!--[if IE 9]>') || ($cssoutputblwsrc == '<!--[if IE 8]>')) {
						$jsoutputbelow .= "\t" . 'if (navigator.appName === \'Microsoft Internet Explorer\') {' . "\n";
						$onIF = 1;
					} elseif (substr($cssoutputblwsrc, 0, 4) == '<!--') {
						$onIF = 0;
					} else {
						if (str_replace('<![endif]-->', '', $cssoutputblwsrc) != $cssoutputblwsrc) {
							$cssoutputblwsrc = str_replace('<![endif]-->', '', $cssoutputblwsrc);
							if ($onIF == 1) {
								$jsoutputbelow .= "\t" . "\t" . 'loadStyleSheet(\'' . $cssoutputblwsrc .'\');' . "\n";
								$jsoutputbelow .= "\t" . '}' . "\n";
								$onIF = 0;
							}

						} else {
							if ($onIF == 1) {
								$jsoutputbelow .= "\t";
							}

							$jsoutputbelow .= "\t" . 'loadStyleSheet(\'' . $cssoutputblwsrc .'\');' . "\n";
						}

					}

				}

			}

			$jsoutputbelow .= '</script>';
			$bufferout= str_replace('</body>', "\n". $jsoutputbelow . "\n". '</body>', $bufferout);
			// if you want css-files above body:
			// $bufferout= str_replace('</body>', "\n". $cssoutputbelow . "\n". '</body>', $bufferout);

		}

		$bufferout= str_replace('</head>', "\n". $cssoutput . "\n". '</head>', $bufferout);

		$lenbufferout=strlen($bufferout);
		if ($this->showDebugWindow == TRUE) {
			$tdifftolastrun = 1000*(microtime(TRUE) - $starttimedebugcallback);
			if ($this->generateCSSbelowTheFold == TRUE) {
				$debuginfo .= '<span>CSS above/below the fold: '. round($debugmergetime, 1) . ' ms</span>';
			}
			$debuginfo .= '<br /><strong>Total time: '. round($tdifftolastrun, 1) . ' ms</strong></div>';

			$debuginfo .= '<div class="ttirl_subtitle"><strong>Input</strong><span class="ttirlsmall">, files found for processing</span></div><div>';
			if ($cntininecss > 0) {
				$debuginfo .= '<span>Inline CSS: ' . $cntininecss . '</span><br />';
			}

			if ($cntininejs > 0) {
				$debuginfo .= '<span>Inline JS: ' . $cntininejs . ' </span><br />';
			}

			if ($cntcss > 0) {
				$debuginfo .= '<span>CSS files: ' . $cntcss . ' </span><br />';
			}

			if ($cntjs > 0) {
				$debuginfo .= '<span>JS files: ' . $cntjs . ' </span><br />';
			}

			if (intval(($lenInlinecss + $lencss)/1024) > 0) {
				$debuginfo .= '<span>Length CSS: ' . intval(($lenInlinecss + $lencss)/1024) . 'kb </span><br />';
			} else {
				if (intval(($lenInlinecss + $lencss)) > 0) {
					$debuginfo .= '<span>Length CSS: ' . intval(($lenInlinecss + $lencss)) . 'bytes </span><br />';
				}
			}

			if (intval(($lenInlinejs + $lenjs)/1024) > 0) {
				$debuginfo .= '<span>Length JS: ' . intval(($lenInlinejs + $lenjs)/1024) . 'kb </span><br />';
			} else {
				if (intval(($lenInlinecss + $lencss)) > 0) {
					$debuginfo .= '<span>Length JS: ' . intval(($lenInlinejs + $lenjs)) . 'bytes </span><br />';
				}
			}

			$debuginfo .= '</div>';

			if (intval($cntkeepcss + $cntkeepjs)  > 0) {
				$debuginfo .= '<div class="ttirl_subtitle"><strong>Unchanged</strong><span class="ttirlsmall">, files excluded from processing</span></div><div>';
				if (intval($cntkeepcss)  > 0) {
					$debuginfo .= '<span>CSS files kept: ' . $cntkeepcss . ' </span>';
					if (intval($cntkeepcssext)  > 0) {
						$debuginfo .= '<span class="ttirlsmall"> (external CSS files: ' . $cntkeepcssext . ')</span>';
					}
					$debuginfo .= '</span><br />';

				}
				if (intval($cntkeepjs)  > 0) {
					$debuginfo .= '<span>JS files kept: ' . $cntkeepjs . ' </span>';
					if (intval($cntkeepjsext)  > 0) {
						$debuginfo .= '<span class="ttirlsmall"> (external JS files: ' . $cntkeepjsext . ')</span>';
					}
					$debuginfo .= '</span><br />';

				}
				$debuginfo .= '</div>';
			}

			if (intval($cntoutputcss + $cntoutputjs)  > 0) {
				$debuginfo .= '<div class="ttirl_subtitle"><strong>Output</strong></div><div>';


				if (intval($cntoutputcss)  > 0) {
					$debuginfo .= '<span>CSS files: ' . $cntoutputcss . ' </span><br />';
					if (($cntoutputcss > 0) && ($cntcss > 0)){
						$debuginfo .= '<span class="ttirlsmall">Change CSS requests: <b>' . round(100*(($cntoutputcss)/($cntcss)-1), 1) . '%</b></span><br />';
					}

				}

				if (intval($cntoutputjs)  > 0) {
					$debuginfo .= '<span>JS files: ' . $cntoutputjs . ' </span><br />';
					if (($cntoutputjs > 0) && ($cntjs > 0)){
						$debuginfo .= '<span class="ttirlsmall">Change JS requests: <b>' . round(100*(($cntoutputjs)/($cntjs)-1), 1) . '%</b></span><br />';
					}

				}

				$debuginfo .= '</div>';
			}
			if ((intval($lenoutputcss/1024)+intval($lenoutputjs/1024))  > 0) {
				$debuginfo .= '<div class="ttirl_subtitle"><strong>Output - file size</strong></div><div>';
				if (intval($lenoutputcss/1024)  > 0) {
					$debuginfo .= '<span>Length CSS: ' . intval($lenoutputcss/1024) . 'kb </span><br />';
					if ((intval($lenoutputcss/1024)  > 0) && (intval(($lenInlinecss + $lencss)/1024) > 0)){
						$debuginfo .= '<span class="ttirlsmall">Change in size: <b>' . round(100*((intval($lenoutputcss/1024))/
								((intval(($lenInlinecss + $lencss)/1024)))-1), 1) . '%</b></span><br />';
					}

					if (intval($this->lenoutputcssabove/1024)  > 0) {
						$debuginfo .= '<span>Length CSS above the fold: ' . intval($this->lenoutputcssabove/1024) . 'kb </span><br />';
					} elseif (intval($this->lenoutputcssabove)  > 0) {
						$debuginfo .= '<span>Length CSS above the fold: ' . intval($this->lenoutputcssabove) . 'bytes </span><br />';
					}

					if (intval($this->lenoutputcssbelow/1024)  > 0) {
						$debuginfo .= '<span>Length CSS below the fold: ' . intval($this->lenoutputcssbelow/1024) . 'kb </span><br />';
					} elseif (intval($this->lenoutputcssbelow)  > 0) {
						$debuginfo .= '<span>Length CSS below the fold: ' . intval($this->lenoutputcssbelow) . 'bytes </span><br />';
					}

				}

				if (intval($lenoutputjs/1024)  > 0) {
					$debuginfo .= '<span>Length JS: ' . intval($lenoutputjs/1024) . 'kb </span><br />';
					if ((intval($lenoutputjs/1024)  > 0) && (intval(($lenInlinejs + $lenjs)/1024) > 0)){
						$debuginfo .= '<span class="ttirlsmall">Change in size: <b>' . round(100*((intval($lenoutputjs/1024))/
								((intval(($lenInlinejs + $lenjs)/1024)))-1), 1) . '%</b></span><br />';
					}

				}
				$debuginfo .= '</div>';
			}

			if ((intval($lenbuffer/1024)  > 0) && (intval($lenbufferout/1024)  > 0)) {
				$debuginfo .= '<div class="ttirl_subtitle"><strong>Output - overall</strong></div><div>';
				$debuginfo .= '<span>Length HTML went from ' . intval($lenbuffer/1024) . 'kb to ' .
								intval($lenbufferout/1024) . 'kb</span><br />';
					$debuginfo .= '<span class="ttirlsmall">Change in size: <b>' . round(100*((intval($lenbufferout/1024))/
							((intval(($lenbuffer)/1024)))-1), 1) . '%</b></span><br />';
				$debuginfo .= '</div>';

			}

			if ($this->freezeFolding == TRUE) {
				$debuginfo .= '<div class="ttirl_subtitle ttirl_subtitleinfo"><strong>Folding - information</strong></div><div>';
				$debuginfo .= '<span>freezeFolding is enabled (!)</span><br />';
				$debuginfo .= '</div>';
			}

			if (($this->makefoldingCSSreport == TRUE) && (count($this->foldingCSSreport) > 0)) {
				$cntcssfilesforreport = count($this->foldingCSSreport);
				$startctrl = 0;
				$newselabove = 0;
				$newselbelow = 0;
				$totalselectorsold = 0;
				$totalselectorsnew = 0;
				$totalselectorsend = 0;
				$totalmergeCSSOldAboveStart = 0;
				$totalmergeCSSOldBelowStart = 0;
				$totalmergeCSSNewAboveStart = 0;
				$totalmergeCSSNewBelowStart = 0;
				$totalmergeCSSBelowEnd = 0;
				$totalmergeCSSAboveEnd = 0;
				for ($r = 0; $r < $cntcssfilesforreport; $r++) {
					$newselabove = $newselabove + $this->foldingCSSreport[$r]['mergeCSSAboveEnd']['selectors'] - $this->foldingCSSreport[$r]['mergeCSSOldAboveStart']['selectors'];
					$newselbelow = $newselbelow + $this->foldingCSSreport[$r]['mergeCSSBelowEnd']['selectors'] - $this->foldingCSSreport[$r]['mergeCSSOldBelowStart']['selectors'];
					$totalselectorsold = $totalselectorsold + $this->foldingCSSreport[$r]['mergeCSSOldBelowStart']['selectors'] + $this->foldingCSSreport[$r]['mergeCSSOldAboveStart']['selectors'];
					$totalselectorsnew = $totalselectorsnew + $this->foldingCSSreport[$r]['mergeCSSNewBelowStart']['selectors'] + $this->foldingCSSreport[$r]['mergeCSSNewAboveStart']['selectors'];
					$totalselectorsend = $totalselectorsend + $this->foldingCSSreport[$r]['mergeCSSBelowEnd']['selectors'] + $this->foldingCSSreport[$r]['mergeCSSAboveEnd']['selectors'];
					$totalmergeCSSOldAboveStart = $totalmergeCSSOldAboveStart + $this->foldingCSSreport[$r]['mergeCSSOldAboveStart']['selectors'];
					$totalmergeCSSOldBelowStart = $totalmergeCSSOldBelowStart + $this->foldingCSSreport[$r]['mergeCSSOldBelowStart']['selectors'];
					$totalmergeCSSNewAboveStart = $totalmergeCSSNewAboveStart + $this->foldingCSSreport[$r]['mergeCSSNewAboveStart']['selectors'];
					$totalmergeCSSNewBelowStart = $totalmergeCSSNewBelowStart + $this->foldingCSSreport[$r]['mergeCSSNewBelowStart']['selectors'];
					$totalmergeCSSBelowEnd = $totalmergeCSSBelowEnd + $this->foldingCSSreport[$r]['mergeCSSBelowEnd']['selectors'];
					$totalmergeCSSAboveEnd = $totalmergeCSSAboveEnd + $this->foldingCSSreport[$r]['mergeCSSAboveEnd']['selectors'];
				}
				$debuginfo .= '<div class="ttirl_subtitle"><strong>CSS folding</strong></div><div>';

				if ($this->countUnionMetaInitialElements > 0) {
					$debuginfo .= '<span>Selectors new: ' . $totalselectorsnew . ' (' .
							$totalmergeCSSNewAboveStart. '/' .$totalmergeCSSNewBelowStart. ')</span><br />' .
							'<span>Selectors old: ' . $totalselectorsold . ' (' .
							$totalmergeCSSOldAboveStart. '/' .$totalmergeCSSOldBelowStart. ')</span><br />' .

						'<span>Selectors result: ' . $totalselectorsend . ' (' .
							$totalmergeCSSAboveEnd. '/' .$totalmergeCSSBelowEnd. ')</span><br />' .
						'<span>Moved selectors: '. $this->countUnionMetaMovedSelectors . '</span><br />' .
						'<span>New elements: '. $this->countUnionMetaNewElements . '</span><br />';
					if ($this->checkDupesOnFoldingMerge == TRUE) {
						$debuginfo .= '<span>Elements before drop: '. $this->countUnionMetabeforeDrop . '</span><br />' .
						'<span>Elements after drop: '. $this->countUnionMetaafterDrop . '</span><br />';
					}

					/* $debuginfo .='<span>Details for the Union:<small><pre>' .
					json_encode($this->foldingCSSreport, JSON_PRETTY_PRINT) .
							'</pre></small></span><br />'; */
				}
				$debuginfo .= '</div>';

			}

			$debuginfo .= $debugopt;
			$debuginfo .= '</div>';

			$debuginfo .= '<style>
	#tt_ri_dbg {
		position:absolute;
		color:#000;
		left: 2px;
		top: 2px;
		z-index: 5000;
		padding: 4px;
		max-width: 25%;
		background-color: white;
		min-width: 135px;
		border: 1px solid #AAAAAA;
		opacity: 0.86;
	}
	#tt_ri_dbg span, #tt_ri_dbg p, #tt_ri_dbg strong, #tt_ri_dbg small {
		color:#000;
	}
	#tt_ri_dbg span.tt_ri_dbg_close {
		font-weight: 700;
		background-color: #EFEFEF;
		border-radius: 4px;
		float: right;
		cursor: pointer;
		border: 1px solid #AAA;
		padding: 0 5px;
	}
	.ttirl_title {

		background-color: #e5bf90;
		border: 1px solid #60381c;
		padding: 0 5px;
	}
	.ttirl_subtitle {
		background-color: #edddbf;
		border: 1px solid #60381c;
		padding: 0 5px;
	}
	.ttirl_subtitleinfo {
		background-color: #c1dbed;
		border: 1px solid #073e61;
		padding: 0 5px;
	}
	 .ttirlsmall {
		font-size: 80%;
	}

</style>';
			$bufferout= str_replace($this->showDebugWindowBodyTag, $this->showDebugWindowBodyTag  . $debuginfo . '</div>', $bufferout);

		}

		$hassomework=TRUE;
		do {
			$bufferout= str_replace("\r\n\r\n", "\r\n", $bufferout);
			$bufferout= str_replace("\n\n", "\n", $bufferout);
			$bufferout= str_replace("\t\n", "\n", $bufferout);
			$bufferout= str_replace(" \n", "\n", $bufferout);
			$bufferout= str_replace("\t\r\n", "\r\n", $bufferout);
			$bufferout= str_replace(" \r\n", "\r\n", $bufferout);
			if ((str_replace("\t\r\n", '', $bufferout)== $bufferout ) && (str_replace(" \r\n", '', $bufferout)== $bufferout ) &&
					(str_replace(" \n", '', $bufferout)== $bufferout ) && (str_replace("\n\n", '', $bufferout) == $bufferout) &&
					(str_replace("\t\n", '', $bufferout) == $bufferout) && (str_replace("\r\n\r\n", '', $bufferout) == $bufferout)) {
				$hassomework=FALSE;
			}

		} while ($hassomework==TRUE);

	 	If ($this->dontmod == 1) {
	 		return($bufferin);
	 	} else {
			return($bufferout);
		}

	}

	/**
	 * checks number of selectors, rules and @medias in a file for reporting
	 *
	 * @param	string		$entryname:
	 * @param	string		$filecontents:
	 * @param	[type]		$mediacorrectrules: ...
	 * @return	void		writes $this->foldingCSSreport
	 */
	private function foldingCSSreportentry($entryname, $filecontents, $mediacorrectrules = FALSE) {
		$this->foldingCSSreport[$this->iFCSSRep][$entryname] = array();
		if (str_replace(',@,', '', $filecontents) != $filecontents) {
			$filecontents = $this->crunchcss($filecontents);
			$filecontents = str_replace('}}', '}', $filecontents);
			$CSStotalrulesarro = explode('}', $filecontents);
			$CSStotalrulesarr = array();
			$v = 0;
			foreach ($CSStotalrulesarro as $CSSrule) {
				$rulearr = explode(',@,', $CSSrule);
				$rule = $rulearr[1];
				$CSStotalrulesarr[$v] = $rule;
				$v++;
			}

		} else {
			$filecontents = $this->crunchcss($filecontents);
			$filecontents = str_replace('}}', '}', $filecontents);
			$CSStotalrulesarr = explode('}', $filecontents);
		}

		$totalrules = count($CSStotalrulesarr);
		$CSStotalatmediaarr = explode('@media', $filecontents);
		$totalatmedia = count($CSStotalatmediaarr) - 1;
		if ($mediacorrectrules == TRUE) {
			$totalrules = $totalrules - $totalatmedia;
		}

		$CSStotalselectors = 0;
		$onkeyframe = 0;
		foreach ($CSStotalrulesarr as $CSStotalrulesel) {
			//@media @-...-keyframes split into two elements - we count 1 selector per @media @-...-keyframes instruction
			if (str_replace('-keyframes', '', $CSStotalrulesel) != $CSStotalrulesel) {
				$CSStotalselectors++;
				$onkeyframe = 1;
			} elseif ($onkeyframe == 1) {
				$onkeyframe = 0;
			} else {
				$CSStotalrulesarr2 = explode('{', $CSStotalrulesel);
				if (count($CSStotalrulesarr2) > 1 ) {
					$CSStotalrulesarrsels = explode(',', $CSStotalrulesarr2[count($CSStotalrulesarr2)-2]);
					$CSStotalselectors = $CSStotalselectors + count($CSStotalrulesarrsels);
				}

			}

		}

		$totalselectors = $CSStotalselectors;
		$this->foldingCSSreport[$this->iFCSSRep][$entryname]['selectors'] = $totalselectors;
		$this->foldingCSSreport[$this->iFCSSRep][$entryname]['rules'] = $totalrules -1;
		$this->foldingCSSreport[$this->iFCSSRep][$entryname]['atmedia'] = $totalatmedia;
	}

	/**
	 * Merges individual above/below CSS-Files into common CSS-files in subfolder /merged
	 *
	 * @param	string		$soucedirectory:
	 * @param	string		$filename:
	 * @param	string		$foldingmd5:
	 * @param	string		$filecontent:
	 * @param	string		$filecontentbelowthefold:
	 * @param	[type]		$filecontentoPosabove: ...
	 * @param	[type]		$filecontentoPosbelow: ...
	 * @return	void		writes the CSS-Files
	 */
	private function mergeCSS($soucedirectory, $filename, $foldingmd5, $filecontent, $filecontentbelowthefold, $filecontentoPosabove, $filecontentoPosbelow) {
	// scans for CSS-Files with same name-root and merges them into subfolder /merged
		$foldingmd5 = '-' . $foldingmd5;
		$soucedirectory .= 'merged' . DIRECTORY_SEPARATOR;
		$filenameroot = str_replace($foldingmd5 . '.css', '', $filename);
		$cssabovefiles = array();
		$cssbelowfiles = array();
		$ia = 0;
		$ib = 0;
		/// read path to sessiondirectory in .tempfile
		if (!is_dir($soucedirectory)) {
			//createdir
			if (DIRECTORY_SEPARATOR == '\\') {
				// windows
				$filefromroot= str_replace('/', '\\', $this->typo3tempsubfolder . '/css/merged');
			} else {
				$filefromroot = $this->typo3tempsubfolder .  '/css/merged';
			}

			if (substr($filefromroot, 0, 1) != DIRECTORY_SEPARATOR) {
				$filefromroot = DIRECTORY_SEPARATOR . $filefromroot;
			}

			mkdir(realpath(str_replace($this->extensionrelwinpath . '\Classes\Controller', '',
			str_replace($this->extensionrelpath . '/Classes/Controller', '', dirname(__FILE__)))) . $filefromroot);
		}

		if (is_dir($soucedirectory)) {
			$d = dir($soucedirectory);
			if ($d != FALSE){
				// dir the files
				$i=0;
				while (FALSE !== ($entry = $d->read())) {
					if (str_replace('ctrl', '', $entry) == $entry) {
						if (str_replace($filenameroot, '', $entry) != $entry) {
							if (str_replace('below', '', $entry) != $entry) {
								$cssbelowfiles[$ib] = $entry;
								$ib++;
							} else {
								$cssabovefiles[$ia] = $entry;
								$ia++;
							}

						}

					}

				}

				$d->close();
			}

		}

		if (($ib+$ia) == 0) {
			//first file, no merge needed
			$this->lenoutputcssbelow = $this->lenoutputcssbelow + strlen($filecontentbelowthefold);
			$this->lenoutputcssabove = $this->lenoutputcssabove + strlen($filecontent);
			file_put_contents($soucedirectory . str_replace('.css', 'below.css', str_replace($foldingmd5 , '', $filename)), $filecontentbelowthefold);
			file_put_contents($soucedirectory . str_replace($foldingmd5 , '', $filename), $filecontent);
			file_put_contents($soucedirectory . str_replace('.css', 'abovectrl.txt', str_replace($foldingmd5 , '', $filename)), $filecontentoPosabove);
			file_put_contents($soucedirectory . str_replace('.css', 'belowctrl.txt', str_replace($foldingmd5 , '', $filename)), $filecontentoPosbelow);
			return '';
		} else {


			$oldfilecontentsabove = '';
			if (file_exists($soucedirectory . str_replace('.css', 'abovectrl.txt', $cssabovefiles[0]))) {
				$oldfilecontentsabove = file_get_contents($soucedirectory . str_replace('.css', 'abovectrl.txt', $cssabovefiles[0]));
			}

			$oldfilecontentsbelow = '';
			if (file_exists($soucedirectory . str_replace('.css', 'belowctrl.txt', $cssabovefiles[0]))) {
				$oldfilecontentsbelow = file_get_contents($soucedirectory . str_replace('.css', 'belowctrl.txt', $cssabovefiles[0]));
				// $cssabovefiles[0] is no joke ! it's just in order to get the right filename
			}

			$dtf = array();
			$dtf['func'] = 2;
			$dtf['filecontentoPosabove'] = gzencode($filecontentoPosabove, 5);
			$dtf['filecontentoPosbelow'] = gzencode($filecontentoPosbelow, 5);
			$dtf['oldfilecontentsabove'] = gzencode($oldfilecontentsabove, 5);
			$dtf['oldfilecontentsbelow'] = gzencode($oldfilecontentsbelow, 5);
			$dtf['makefoldingCSSreport'] = $this->makefoldingCSSreport;
			$dtf['foldingCSSreport'] = rawurlencode(base64_encode(serialize($this->foldingCSSreport)));
			$dtf['iFCSSRep'] = $this->iFCSSRep;
			$dtf['countUnionMetaInitialElements'] = $this->countUnionMetaInitialElements;
			$dtf['countUnionMetaMovedSelectors'] = $this->countUnionMetaMovedSelectors;
			$dtf['countUnionMetaNewElements'] = $this->countUnionMetaNewElements;
			$dtf['countUnionMetabeforeDrop'] = $this->countUnionMetabeforeDrop;
			$dtf['countUnionMetaafterDrop'] = $this->countUnionMetaafterDrop;
			$dtf['pruneHTMLBaseToDisk'] = $this->pruneHTMLBaseToDisk;
			$dtf['pruneHTMLBase'] = $this->pruneHTMLBase;
			$dtf['checkDupesOnFoldingMerge'] = $this->checkDupesOnFoldingMerge;

			$dtanswer = $this->apiCall($this->secret, $dtf);
			If ($dtanswer != '') {

				$dta = array();
				$dta = unserialize(base64_decode(rawurldecode($dtanswer)));
				if (is_array($dta) == FALSE) {
					$dta = explode('@', $dtanswer);
					if (count($dta) == 2) {
						echo '<div style="position:absolute; z-index:999;">Answer in merge step from API-Server '. $this->donationserver .': ' . $dta[1] . '</div><br />';
					} else {
						echo '<div style="position:absolute; z-index:999;">Answer in merge step from API-Server '. $this->donationserver .': ' . $dtanswer . '</div><br />';
					}

					return 'ko';
				} else {
					$cssbelow = gzdecode($dta['cssbelow']);
					$cssabove = gzdecode($dta['cssabove']);
					$cssaboveiPos = gzdecode($dta['cssaboveiPos']);
					$cssbelowiPos = gzdecode($dta['cssbelowiPos']);
					$this->foldingCSSreport = unserialize(base64_decode(rawurldecode($dta['foldingCSSreport'])));
					$this->countUnionMetaInitialElements = $dta['countUnionMetaInitialElements'];
					$this->countUnionMetaMovedSelectors = $dta['countUnionMetaMovedSelectors'];
					$this->countUnionMetaNewElements = $dta['countUnionMetaNewElements'];
					$this->countUnionMetabeforeDrop = $dta['countUnionMetabeforeDrop'];
					$this->countUnionMetaafterDrop = $dta['countUnionMetaafterDrop'];
					$this->pruneHTMLBase = $dta['pruneHTMLBase'];

					$this->lenoutputcssbelow = $this->lenoutputcssbelow + strlen($cssbelow);
					$this->lenoutputcssabove = $this->lenoutputcssabove + strlen($cssabove);
					file_put_contents($soucedirectory . str_replace('.css', 'below.css', str_replace($foldingmd5 , '', $filename)), $cssbelow);
					file_put_contents($soucedirectory . str_replace($foldingmd5 , '', $filename), $cssabove);
					file_put_contents($soucedirectory . str_replace('.css', 'abovectrl.txt', str_replace($foldingmd5 , '', $filename)), $cssaboveiPos);
					file_put_contents($soucedirectory . str_replace('.css', 'belowctrl.txt', str_replace($foldingmd5 , '', $filename)), $cssbelowiPos);
					return '';
				}

			} else {
				echo '<div>Empty answer in merge step from API-Server '. $this->donationserver .'</div><br />';
				return 'ko';
			}

		}

	}

	/**
	 * creates and returns a md5-string based on tags, classes, ids and input types
	 * creates $this->bufferinclasses, $this->bufferintags ...
	 *
	 * @param	string		$bufferin
	 * @return	string		md5-string
	 */
	protected function htmlFoldMeta($bufferin) {
		$bufferintags = array();
		$bufferinarrbasezero = explode('<body', $bufferin);
		if (count($bufferinarrbasezero)>0) {
			$bufferinz = $bufferinarrbasezero[1];
		} else {
			$bufferinarrbasezero = explode('<BODY', $bufferin);
			if (count($bufferinarrbasezero)>0) {
				$bufferinz = $bufferinarrbasezero[1];
			} else {
				echo "HTML-error toctoc_indexreloaded: No <body>-Tag found";
				exit;
			}

		}

		$bufferinarrbase = explode('<', $bufferinz);
		foreach ($bufferinarrbase as $taginput) {
			$taginputdetailarr = explode('>', $taginput);
			$taginputdetail = str_replace('/', '', $taginputdetailarr[0]);
			if (str_replace('!', '', $taginputdetail) == $taginputdetail) {
				if (str_replace(':', '', $taginputdetail) == $taginputdetail) {
					$tagarr = explode(' ', $taginput);
					if (strlen(trim($tagarr[0])) < strlen($taginputdetail)) {
						If ((str_replace('=', '', trim($tagarr[0])) == trim($tagarr[0])) && (str_replace('>', '', trim($tagarr[0])) == trim($tagarr[0]))) {
							if (trim($tagarr[0]) != '') {
								$bufferintags[strtolower(trim($tagarr[0]))] = 1;
							}

						}

					} else {
						If ((str_replace('=', '', trim($taginputdetail)) == trim($taginputdetail)) && (str_replace('>', '', trim($taginputdetail)) == trim($taginputdetail))) {
							if (trim($taginputdetail) != '') {
								$bufferintags[strtolower($taginputdetail)] = 1;
							}

						}

					}

				}

			}

		}

		foreach ($this->tagsToKeepAboveTheFold as $tagToKeepAboveTheFold) {
			$bufferintags[$tagToKeepAboveTheFold] = 1;
		}

		ksort($bufferintags);
		$this->bufferintags = $bufferintags;
		// make array with all classes found below <body>
		$bufferinclasses = array();
		$bufferinarrbase = explode(' class="', $bufferinz);
		foreach ($bufferinarrbase as $taginput) {
			$classesarr = explode('"', $taginput);
			$classesstr = $classesarr[0];
			$classarr = explode(' ', $classesstr);
			foreach ($classarr as $classinput) {
				If ((str_replace('=', '', trim($classinput)) == trim($classinput)) && (str_replace('>', '', trim($classinput)) == trim($classinput))) {
					If (str_replace('/', '', trim($classinput)) == trim($classinput)) {
						if (trim($classinput) != '') {
							$bufferinclasses[trim($classinput)] = 1;
						}

					}

				}

			}

		}

		foreach ($this->classesToKeepAboveTheFold as $tagToKeepAboveTheFold) {
			$bufferinclasses[$tagToKeepAboveTheFold] = 1;
		}

		ksort($bufferinclasses);
		$this->bufferinclasses = $bufferinclasses;
		$bufferinputtypes = array();
		$bufferinarrbase = explode('type="', $bufferinz);
		foreach ($bufferinarrbase as $taginput) {
			If ((str_replace('/', '', trim($taginput)) == trim($taginput)) && (str_replace('button', '', trim($taginput)) == trim($taginput)) && (str_replace('checkbox', '', trim($taginput)) == trim($taginput))) {
				$classesarr = explode('"', $taginput);
				$classesstr = $classesarr[0];
				If ((str_replace('=', '', trim($classesstr)) == trim($classesstr)) && (str_replace('>', '', trim($classesstr)) == trim($classesstr))) {
					If (str_replace('/', '', trim($classinput)) == trim($classinput)) {
						if (trim($classesstr) != '') {
							$bufferinputtypes[trim($classesstr)] = 1;
						}
					}

				}
			}

		}

		ksort($bufferinputtypes);
		$this->bufferinputtypes = $bufferinputtypes;

		// make array with all ids found below <body>
		$bufferinids = array();
		$bufferinidsnocms = array();
		$bufferinarrbase = explode(' id="', $bufferinz);
		foreach ($bufferinarrbase as $taginput) {
			$classesarr = explode('"', $taginput);
			$classesstr = $classesarr[0];
			If ((str_replace('=', '', trim($classesstr)) == trim($classesstr)) && (str_replace('>', '', trim($classesstr)) == trim($classesstr))) {
				$bufferinids[trim($classesstr)] = 1;
				if (preg_match('/\\d/', $classesstr) == 0) {
					if ((intval(substr($classesstr,1)) == 0) && (substr($classesstr,0,1) != 'c')){
						if (intval(substr(trim($classesstr),(strlen(trim($classesstr))-2))) == 0) {
							if (trim($classesstr) != '') {
								$bufferinidsnocms[trim($classesstr)] = 1;
							}
						}

					}

					if ((intval(substr($classesstr,1)) > 0) && (substr($classesstr,0,1) != 'c')){
						if (intval(substr(trim($classesstr),(strlen(trim($classesstr))-2))) == 0) {
							if (trim($classesstr) != '') {
								$bufferinidsnocms[trim($classesstr)] = 1;
							}

						}

					}

				}

			}

		}

		foreach ($this->IDsToKeepAboveTheFold as $tagToKeepAboveTheFold) {
			$bufferinids[$tagToKeepAboveTheFold] = 1;
			$bufferinidsnocms[$tagToKeepAboveTheFold] = 1;
		}

		ksort($bufferinids);
		ksort($bufferinidsnocms);
		$this->bufferinids = $bufferinids;

		// no ids from content elements
		$ret = implode('', array_keys($bufferintags)) . implode('', array_keys($bufferinclasses)) .
				implode('', array_keys($bufferinputtypes)) . implode('', array_keys($bufferinidsnocms));
		if ($this->pruneHTMLBaseToDisk == TRUE) {
			$this->pruneHTMLBase = 'found tags: ' . implode(',', array_keys($bufferintags)) . "\n" . 'classes: ' . implode(',', array_keys($bufferinclasses)) . "\n" .
				'input types: ' . implode(',', array_keys($bufferinputtypes)) . "\n" . 'ids without numbers: ' . implode(',', array_keys($bufferinidsnocms));
		}

		$ret = md5($ret);
		return $ret;
	}

	/**
	 * splits $filecontent into an array, one holding CSS for above the fold, the other below the fold
	 *
	 * @param	string		$filecontent: all CSS
	 * @return	array		$filecontents, [0] = $filecontentabovethefold;[1] = $filecontentbelowthefold;
	 */
	protected function splitCSSBelowAboveTheFold($filecontent) {

		$dtf = array();
		$dtf['func'] = 1;
		$dtf['filecontent'] = gzencode($filecontent, 5);
		/* remove comments */
		$filecontent = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $filecontent);
		// and other clean outs
		$filecontent = str_replace("\t", '', $filecontent);
		$filecontent = str_replace("\r", '', $filecontent);
		$filecontent = str_replace("\n", '', $filecontent);
		$filecontent = str_replace('  ', ' ', $filecontent);
		$filecontent = str_replace(': ', ':', $filecontent);
		// clean. lets  folding report
		if ($this->makefoldingCSSreport == TRUE) {
			$this->foldingCSSreportentry('splitCSSAllStart', $filecontent);
		}

		$dtf['makefoldingCSSreport'] = $this->makefoldingCSSreport;
		$dtf['bufferinclasses'] = rawurlencode(base64_encode(serialize($this->bufferinclasses)));
		$dtf['bufferinids'] = rawurlencode(base64_encode(serialize($this->bufferinids)));
		$dtf['bufferintags'] = rawurlencode(base64_encode(serialize($this->bufferintags)));
		$dtf['bufferinputtypes'] = rawurlencode(base64_encode(serialize($this->bufferinputtypes)));
		$keepAboves = ',';
		foreach ($this->tagsToKeepAboveTheFold as $keepAbove) {
			$keepAboves .= $keepAbove . ',';
		}

		foreach ($this->classesToKeepAboveTheFold as $keepAbove) {
			$keepAboves .= '.' . $keepAbove . ',';
		}

		foreach ($this->IDsToKeepAboveTheFold as $keepAbove) {
			$keepAboves .= '#' . $keepAbove . ',';
		}

		if ($keepAboves == ',') {
			$keepAboves = '';
		}

		$dtf['keepAboves'] = rawurlencode(base64_encode($keepAboves));
		$dtanswer = $this->apiCall($this->secret, $dtf);

		If ($dtanswer != '') {
			$dta = array();
			$dta = unserialize(base64_decode(rawurldecode($dtanswer)));
			if (is_array($dta) == FALSE) {
				$dta = explode('@', $dtanswer);
				if (count($dta) == 2) {
					echo '<div style="position:absolute; z-index:999;">Answer in folding step from API-Server '. $this->donationserver .': ' . $dta[1] . '</div><br />';
				} else {
					echo '<div style="position:absolute; z-index:999;">Answer in folding step from API-Server '. $this->donationserver .': ' . $dtanswer . '</div><br />';
				}

				return '';
			} else {
				$cssabove = gzdecode($dta['cssabove']);
				$cssbelow = gzdecode($dta['cssbelow']);

				$oPosabove = gzdecode($dta['oPosabove']);
				$oPosbelow = gzdecode($dta['oPosbelow']);

				$filecontents[0] = $cssabove;
				$filecontents[1] = $cssbelow;
				$filecontents[2] = $this->crunchCSS($oPosabove);
				$filecontents[3] = $this->crunchCSS($oPosbelow);
				return $filecontents;
			}
		} else {
			echo '<div>Empty answer in folding step from API-Server '. $this->donationserver .'</div><br />';
			return '';
		}

	}

	/**
	 * Crunches CSS
	 *
	 * @param	string		$buffer: ...
	 * @param	boolean		$minimal: ...
	 * @return	string		...
	 */
	protected function crunchcss($buffer, $minimal = FALSE) {
		/* remove comments */
		$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
		if ($minimal == FALSE) {
		/* remove tabs, spaces, new lines, etc. */
			$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
			/* remove unnecessary spaces */
			$buffer = str_replace('{ ', '{', $buffer);
			$buffer = str_replace(' }', '}', $buffer);
			$buffer = str_replace('; ', ';', $buffer);
			$buffer = str_replace(', ', ',', $buffer);
			$buffer = str_replace(' {', '{', $buffer);
			$buffer = str_replace('} ', '}', $buffer);
			$buffer = str_replace(': ', ':', $buffer);
			$buffer = str_replace(' :', ':', $buffer);
			$buffer = str_replace(' ,', ',', $buffer);
			$buffer = str_replace(' ;', ';', $buffer);
		} else  {
			$buffer = str_replace("\r\n", "\n", $buffer);
		}

		return $buffer;
	}

	/**
	 * Is Input already compressed?
	 *
	 * @param	string		$buffer: ...
	 * @return	boolean		...
	 */
	protected function isCompressed($buffer) {
		/* remove comments */
		$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
		$buffer = str_replace(array("\t", "\r", "\n"), '', $buffer);
		$buffercomp = str_replace(' ','', $buffer);
		$ret = FALSE;
		if ((strlen($buffercomp)/strlen($buffer)) > 0.999) {
			$ret = TRUE;
		}

		return $ret;
	}

	/**
	 * Compress JS
	 *
	 * @param	string		$buffer: ...
	 * @param	boolean		$doMinify: ...
	 * @param	boolean		$minimal: ...
	 * @return	string		...
	 */
	protected function compressjs($buffer, $doMinify, $minimal = FALSE) {
		$buffer = str_replace ('/*<![CDATA[*/', 'ttithisiscdata=1;', $buffer);
		$buffer = str_replace ('/*]]>*/', 'ttithiswascdata=0;', $buffer);
		$buffer = str_replace(array("\t", '  ', '    ', '     '), '', $buffer);
		$buffer = preg_replace(array('(( )+\))', '(\)( )+)'), ')', $buffer);
		if ($doMinify == TRUE) {
			$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
			if ($minimal == FALSE) {
				$this->libJSmin = new \JSMinTtirl;
				$buffer = $this->libJSmin->minify($buffer);
			} else {
				$buffer = str_replace("\r\n", "\n", $buffer);
			}

			$buffer = str_replace ('ttithisiscdata=1;', "\n" . '/*<![CDATA[*/' . "\n", $buffer);
			$buffer = str_replace ('ttithiswascdata=0;', "\n" . '/*]]>*/' . "\n", $buffer);
		} else {
			$buffer = str_replace ('ttithisiscdata=1;', '/*<![CDATA[*/', $buffer);
			$buffer = str_replace ('ttithiswascdata=0;', '/*]]>*/', $buffer);
		}

		return $buffer;
	}

	/**
	 * Checks for @import instructions, reads the file and inserts text in inut/output
	 *
	 * @param	string		$writecsstext: ...
	 * @param	string		$checkpath: ...
	 * @param	array		$checkpatharr: ...
	 * @param	int		$countcheckpatharr: ...
	 * @return	string		$writecsstext..
	 */
	protected function handleCssAtImportFiles($writecsstext, $checkpath, $checkpatharr, $countcheckpatharr) {
		// now first the @imports ... liek @import "example.css" all; @import
		$writecsstextout = '';
		if ($writecsstext != '') {
			$hypos = '';
			$writecsstextarr = array();
			$writecsstextarr = explode('@import', $writecsstext);
			$writecsstextarrcount=count($writecsstextarr);
			$initialcss = $writecsstextarr[0];
			for ($q=1;$q<$writecsstextarrcount;$q++) {
				$hypos='';
				$writecsstextqarr = array();
				$atimporttoreplace = '';
				$writecsstextqarr = explode(';', $writecsstextarr[$q]);
				$writecsstextqarr[0] = str_replace('#url(', 'url(', $writecsstextqarr[0]);
				$fullimportelement= $writecsstextqarr[0] . ';';
				$remainingcss = '';
				if (count($writecsstextqarr) ==2) {
					if ($writecsstextqarr[1] !='') {
						$remainingcss = $writecsstextqarr[1];
					}
				}

				if (substr(ltrim($writecsstextqarr[0]), 0, 1) == '\'') {
					$hypos = '\'';
					$writecsstextqarr[0] = substr(ltrim($writecsstextqarr[0]), 1);
				}

				if (substr(ltrim($writecsstextqarr[0]), 0, 1) == '"') {
					$hypos = '"';
					$writecsstextqarr[0] = substr(ltrim($writecsstextqarr[0]), 1);
				}

				$writecsstextqarr[0] = ltrim($writecsstextqarr[0]);
				if ($hypos=='') {
					$strposspace = strpos($writecsstextqarr[0], ' ');
					$writecsstextarr2 = array();
					If ($strposspace > 1) {
						$writecsstextarr2[0] = substr($writecsstextqarr[0], 0, $strposspace);
						$writecsstextarr2[1] = substr($writecsstextqarr[0], $strposspace+1);
					} else {
						$writecsstextarr2[0] = $writecsstextqarr[0];
						$writecsstextarr2[1] = '';
					}

				} else {
					$writecsstextarr2 = explode($hypos, $writecsstextqarr[0]);
				}

				$urltocheck = $writecsstextarr2[0];

				$urltocheckout = str_replace('https://', '', $urltocheck);
				$urltocheckout = str_replace('http://', '', $urltocheckout);

				if ($urltocheckout == $urltocheck)  {
					$urltocheck = str_replace('url(', '', $urltocheck);
					$urltocheck = str_replace('"', '', $urltocheck);
					$urltocheck = str_replace("'", '', $urltocheck);
					$urltocheck = str_replace(')', '', $urltocheck);
					if (substr($urltocheck, 0, 1) != '/') {

						$checkuppatharr = explode('../', $urltocheck);

						$countcheckuppatharr = count($checkuppatharr);
						if ($countcheckuppatharr > 0) {
							$outurltocheck = $checkuppatharr[$countcheckuppatharr-1];
							$outurltocheckpart1 = '';
							for ($p=0;$p<=$countcheckpatharr-$countcheckuppatharr;$p++) {
								$outurltocheckpart1 .= $checkpatharr[$p] . '/';
							}

							$urltocheck = $outurltocheckpart1 . $outurltocheck;
						} else {
							$urltocheck = $checkpath .'/' . $urltocheck;
						}

						$writecsstextarr2[0] = $urltocheck;

						$atimporttoreplace = '@import' . $fullimportelement;
					} else {
						$atimporttoreplace = '@import' . $fullimportelement;
					}

				} else {
					$atimporttoreplace = '@import' . $fullimportelement;
				}
				//read $urltocheck

				if (DIRECTORY_SEPARATOR == '\\') {
					// windows
					$filefromroot = str_replace('/', '\\', $urltocheck);
				} else {
					$filefromroot = $urltocheck;
				}

				if (substr($filefromroot, 0, 1) != DIRECTORY_SEPARATOR) {
					$filefromroot = DIRECTORY_SEPARATOR . $filefromroot;
				}

				$rawfilestrarr=explode('?', realpath(str_replace($this->extensionrelwinpath . '\Classes\Controller', '',
						str_replace($this->extensionrelpath . '/Classes/Controller', '', dirname(__FILE__)))) . $filefromroot);
				$rawfilestr=$rawfilestrarr[0];
				$fileimport = str_replace(':\\', ':\\\\', $rawfilestr);

				//return $fileimport;
				if (file_exists($fileimport)) {
					$writecsstextout .= file_get_contents($fileimport) . "\n";
				} else {
					$writecsstextout .= $atimporttoreplace . "\n";
				}

				$writecsstextout .= $remainingcss;

			}

			$writecsstextout = $initialcss . $writecsstextout;
		}
		return $writecsstextout;
	}

	/**
	 * Modified function for static version numbers on files, based on the filemtime
	 *
	 * @param	string		$file Relative path to file including all potential query parameters (not htmlspecialchared yet)
	 * @param	boolean		$forceQueryString If settings would suggest to embed in filename, this parameter allows us to force ...
	 * @return	string		Relative path with version filename including the timestamp
	 */
	protected function createVersionNumberedFilename($file, $forceQueryString = FALSE) {
		$lookupFile = explode('?', $file);

		$path = realpath(str_replace($this->extensionrelwinpath . '\Classes\Controller', '',
				str_replace($this->extensionrelpath . '/Classes/Controller', '', dirname(__FILE__)))) . $lookupFile[0];


		$mode = $this->createVersionNumberedFilenamemode;
		$modequerystring = FALSE;
		if ($mode === 'embed') {
			$modequerystring = TRUE;
		} else {
			if ($mode === 'querystring') {
				$modequerystring = FALSE;
			} else {
				$doNothing = TRUE;
			}

		}

		if ($forceQueryString == TRUE) {
			$modequerystring = FALSE;
		}

		if (!file_exists($path)) {
			// File not found, return filename unaltered
			$fullName = $file;
		} else {
			if (($modequerystring == FALSE) || ($forceQueryString== TRUE)) {
				// If use of .htaccess rule is not configured,
				// we use the default query-string method
				if ($lookupFile[1]) {
					$separator = '&';
				} else {
					$separator = '?';
				}

				$fullName = $file . $separator . filemtime($path);
			} else {
				// Change the filename
				$name = explode('.', $lookupFile[0]);
				$extension = array_pop($name);
				array_push($name, filemtime($path), $extension);
				$fullName = implode('.', $name);
				// append potential query string
				$fullName .= $lookupFile[1] ? '?' . $lookupFile[1] : '';
			}

		}

		return $fullName;
	}


	/**
	 * Used to determine pagename outside TYPO3
	 * Url-name of the page like 'home.html?L=2&no_cache=1&purge_cache=0&objecttype=someobjecttype&id=4546'
	 * removes all numers in querystring, as well as no_cache=1,purge_cache=1,L=0
	 *
	 * @return	string		name like 'home.html?L=&purge_cache=&objecttype=someobjecttype&id='
	 */
	protected function currentPageName() {
		if (!isset($_SERVER['REQUEST_URI'])) {
			$serverrequri = $_SERVER['PHP_SELF'];
		} else {
			$serverrequri = $_SERVER['REQUEST_URI'];
		}

		$slcurrentPageNamearr = explode('?', $slcurrentPageName);
		if (count($slcurrentPageNamearr) > 1) {
			$slcurrentPageNamearr[1] = preg_replace('/[0-9]+/', '', $slcurrentPageNamearr[1]);
			$slcurrentPageName = implode('?', $slcurrentPageNamearr);
		}

		$slcurrentPageName=str_replace('?&no_cache=1', '', $serverrequri);
		$slcurrentPageName=str_replace('?no_cache=1', '', $slcurrentPageName);
		$slcurrentPageName=str_replace('&no_cache=1', '', $slcurrentPageName);
		$slcurrentPageName=str_replace('?&purge_cache=1', '', $slcurrentPageName);
		$slcurrentPageName=str_replace('?purge_cache=1', '', $slcurrentPageName);
		$slcurrentPageName=str_replace('&purge_cache=1', '', $slcurrentPageName);
		$slcurrentPageName=str_replace('?&L=0', '', $slcurrentPageName);
		$slcurrentPageName=str_replace('&L=0', '', $slcurrentPageName);
		$slcurrentPageName=str_replace('?L=0', '', $slcurrentPageName);
		if (strpos($slcurrentPageName, '+') > 0) {
			if (strpos($slcurrentPageName, '.') > strpos($slcurrentPageName, '+')) {
				$tmppagename = substr($slcurrentPageName, 0, (strpos($slcurrentPageName, '+') - 1)) . substr($slcurrentPageName, strpos($slcurrentPageName, '.'));
			}

			$slcurrentPageName = $tmppagename;
		}

		return $slcurrentPageName;
	}

	/**
	 * API call for folding
	 *
	 * @param	string		$secret
	 * @param	array		$datain: ...
	 * @return	void
	 */
	protected function apiCall($secret, $datain) {
		$infomessage = '';
		if (!extension_loaded('curl')) {
			$infomessage = 'Curl, PHP-Problem: Curl extension is required!';
			$alertmsg = 1;
		} else {
			$curip = $_ENV['SERVER_ADDR'];
			$curipres = $_ENV['SERVER_NAME'];

			if (trim($curip) == '') {
				$curip = isset($_SERVER['SERVER_ADDR'])?$_SERVER['SERVER_ADDR']:gethostbyname(gethostname());
			}
			if (trim($curipres) == '') {
				$curipres = isset($_SERVER['SERVER_NAME'])?$_SERVER['SERVER_NAME']:gethostname();
			}

			if (trim($curip) == '') {
				$curip = isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:gethostname();
			}

			if (trim($curip) == '') {
				$curip = gethostname();
			}

			$langreq = 'en';
			if (strlen($GLOBALS['BE_USER']->uc['lang']) > 0) {
				$langreq = $GLOBALS['BE_USER']->uc['lang'];
			}
			$datastr = rawurlencode(base64_encode(serialize($datain)));
			$dataarr = array(
					'secret' => $secret,
					'remoteadr' => $curip,
					'lang' => $langreq,
					'extensionkey' => $this->donExtkey,
					'extension' => $this->donExtension,
					'version' => $this->donExtversion,
					'runtimeTtIrl' => $this->runtimeTtIrl,
					'data' => $datastr,
			);
			$toctoccommentsuseragent = 'TocTocInexReloadedExternalhit/1.1 (+https://www.toctoc.ch/en/home/toctoc-indexreloaded/)';
			$urltofetch = 'https://'.$this->donationserver.'/index.php?eID=toctoc_donationsttirl';

			$ch = curl_init($urltofetch);
			curl_setopt($ch, CURLOPT_USERAGENT, toctoccommentsuseragent);
			curl_setopt($ch, CURLOPT_URL, $urltofetch);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FAILONERROR, 0);
			curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
			curl_setopt($ch, CURLOPT_FILETIME, 1);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_TRANSFERTEXT, 1);
			curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 7);
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($dataarr));

			$data = curl_exec($ch);
			$curl_errno = curl_errno($ch);

			if ($data != '') {

				if ($curl_errno > 0) {
					$curl_errmsg =  curl_error($ch);
					curl_close($ch);
					$infomessage = 'Curl, error reading: ' . $curl_errmsg;
					$alertmsg = 1;
				} else {

					$infohttpcode = intval(curl_getinfo($ch, CURLINFO_HTTP_CODE));
					// checking mime types
					if ($infohttpcode < 400)  {
						curl_close($ch);
						$infomessage = '';
					} else {
						$infomessage = 'Curl, returned code ' . $infohttpcode . ' for URL: ' . $urltofetch;
						$alertmsg = 1;
						curl_close($ch);
					}
				}

			} else {
				curl_close($ch);
				$infomessage = 'no data received for inputdata ' . http_build_query($dataarr);
			}

		}

		if ((trim($data) == '') && (trim($infomessage) == '')) {
			$infomessage = 'Curl, tx_donations not installed on ' . $donationserver;
		}

		if (trim($data) != '') {
			$ret = trim($data);
			return $ret;
		} else {
			print $infomessage; exit;
		}

	}
	/**
	 * Function to get the client IP address
	 *
	 * @return	string		client IP address
	 */
	private function get_client_ip() {
		$ipaddress = '';
		if (getenv('HTTP_CLIENT_IP'))
			$ipaddress = getenv('HTTP_CLIENT_IP');
		else if(getenv('HTTP_X_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		else if(getenv('HTTP_X_FORWARDED'))
			$ipaddress = getenv('HTTP_X_FORWARDED');
		else if(getenv('HTTP_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		else if(getenv('HTTP_FORWARDED'))
			$ipaddress = getenv('HTTP_FORWARDED');
		else if(getenv('REMOTE_ADDR'))
			$ipaddress = getenv('REMOTE_ADDR');
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}
}
?>