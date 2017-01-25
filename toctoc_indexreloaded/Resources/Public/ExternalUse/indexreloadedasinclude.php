<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2015 - 2017 Gisele Wendl <gisele.wendl@toctoc.ch>
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
class IncIndexReloaded {
// path to the directory hosting toctoc_indexreloaded
protected $relativePathToExtension = 'external/plugins';
	public function contentPostProc($buffer, $userUid = 0, $relativePathToExtension = '')	{
	// if your system leaves off a userid, then set it now (must be integer number)
	$userUid = 0;
	
	/* 
	 * code
	 */
	
	require_once(str_replace('/', DIRECTORY_SEPARATOR, $this->relativePathToExtension . '/toctoc_indexreloaded/Classes/Controller/IndexReloaded.php'));
	$IndexReloaded = new GiseleWendl\ToctocIndexreloaded\Controller\IndexReloaded;
	$bufferout = $IndexReloaded->contentPostProc($content, $userUid, $relativePathToExtension);
	return $bufferout;
	/* 
	 * end code
	 * }
	 */
	}
}
?>