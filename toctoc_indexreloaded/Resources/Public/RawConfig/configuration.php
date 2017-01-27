<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2016 - 2017 Gisele Wendl <gisele.wendl@toctoc.ch>
*  All rights reserved
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

$ret = array (
// Dont modify index.php at all
	'dontmod' => 1, 
// Dont modify JS-files
	'dontmodJS' => 0,
// Dont modify CSS-files
	'dontmodCSS' => 0,
// Exclude list: parts of JS or CSS-filenames, that should be excluded when dontmod=0, dontmodjs=0 or/and dontmodcss=0 for inline scripts/styles a part of the text is ok for identification
	'excludesarr' => 'css/print.css, addthis_config',
// Include list: parts of JS or CSS-filenames, that must be included when dontmod=0, dontmodjs=0 or/and dontmodcss=0. includes overwrite the excludes. This good for more detailed filtering
	'includesarr' => '',
// Force creation of new files: You can force new files (CSS and JS) with URL-Parameter ?forceNewFiles=1 as well
	'forceNewFiles' => 0,
// in production mode URL-Parameters ?forceNewFiles=1, ?dontModIndex=1 and ?showDebugWindow =1 are disabled
	'productionMode' => 0,
// Deactivate on pages: List of pages that should not be touched by toctoc_indexreloaded
	'deactivateOnPages' => '',
// Enable file processing
	'optProcessfiles' => 1,
// Enable JS-file processing
	'optProcessjsfiles' => 1,
// Load last JS file asynchronous. Must be set to 0 when code in last JS file attemps to make document.write
	'asynchLastJS' => 1,
// Enable CSS-file processing
	'optProcesscssfiles' => 1,
// Exclude list for Processing: parts of JS or CSS-filenames, that should be excluded for processing, for inline scripts/styles a part of the text is ok for identification
	'excludesProcessing' => 'var pageid =, tx-tc-shrrr-',
// Include list for Processing: parts of JS or CSS-filenames, that must be included for processing anyway. includes overwrite the excludes. This good for more detailed filtering
	'includesProcessing' => '',
// CSS will be compressed
	'doCrunchCSS' => 1,
// Enable minify of JS-files with JSMin.php - modified PHP implementation of Douglas Crockford's JSMin
	'optMinifyjsfiles' => 1,
 // Exclude list: parts of JS-filenames, that must not be minified
	'noMinifyjsList' => '',
// Split CSS into CSS above the fold and CSS below the fold (requires APIKey)
	'generateCSSbelowTheFold' => 0,
// The tags in this list always remain in the CSS above the fold
	'tagsToKeepAboveTheFold' => 'code, i, b, blockquote',
// The class names in this list always remain in the CSS above the fold
	'classesToKeepAboveTheFold' => 'tx-tc-login-form-iframe, tx-tc-login-form-iframe-forgotpw',
// The CSS-Ids in this list always remain in the CSS above the fold
	'IDsToKeepAboveTheFold' => '',
// When generateCSSbelowTheFold' => 1, then merge new CSS into existing CSS (above and below the fold)
	'mergeCSSbelowTheFold' => 0,
// When mergeCSSbelowTheFold = 1, after many calculations of above- and below-CSS then normally the merged output becomes stable. Avoid recalculations by setting this option to 1
	'freezeFolding' => 0,
// When mergeCSSbelowTheFold = 1, above-the-fold CSS is stored in files and loaded as file links. Alternatively you can force this CSS to be loaded inline into the HTML of the page
	'inlineCSSaboveTheFold' => 0,
// When mergeCSSbelowTheFold = 1, then check CSS for duplicates (same rule, same selector) and eliminate them in CSS-output.
	'checkDupesOnFoldingMerge' => 0,
// Show the debug window by default: You can force the debug window with URL-Parameter ?showDebugWindow=1 as well. SYS.devIPmask must match your IP.
	'showDebugWindow' => 0,
// The html of the debug windows is appended to this tag
	'showDebugWindowBodyTag' => '<body>',
// Show options used in the debug window
	'showOptionsInDebugWindow' => 0,
// Create a little report on activities during creation of above/below the fold-CSS in the debug window
	'CSSFoldingReport' => 0,
// directory for Output JS and CSS Files		
	'tempsubfolder' => 'temp/TocTocIndexReloaded',
// APIKey provided by toctoc.ch
	'APIKey' => '',
// API-Server: Server hosting the APIkeys, normally www.toctoc.ch
	'APIServer' => 'www.toctoc.ch',
// The debug-windows only shows up if your IP matches this debugIP
	'DebugIP' => '',
);

return $ret;
?>