<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2015 - 2016 Gisele Wendl <gisele.wendl@toctoc.ch>
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

// place this file in the directory with your current website-default-document, let's say index.php
// make indexreloaded the new defaultdocument

/*
 * options and data retrieval
*/
$currentDefaultDocument = 'indexorig.php';
// path to the directory hosting toctoc_indexreloaded
$relativePathToExtension = 'external/plugins';
		
// data retrieval
$content = require($currentDefaultDocument);

// if your system leaves off a userid, then set it now (must be integer number)
$userUid = 0;
/*
 * end options and data retrieval
*/

/* 
 * code
 */

require_once(str_replace('/', DIRECTORY_SEPARATOR, $relativePathToExtension . '/toctoc_indexreloaded/Classes/Controller/IndexReloaded.php'));
$IndexReloaded = new GiseleWendl\ToctocIndexreloaded\Controller\IndexReloaded;
$bufferout = $IndexReloaded->contentPostProc($content, $userUid, $relativePathToExtension);
echo $bufferout;
/* 
 * end code
 */
?>