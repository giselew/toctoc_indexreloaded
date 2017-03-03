.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _administration-files:

Files
-----

Normally the files *toctoc_indexreloaded* creates are in folder typo3temp/TocTocIndexReloaded. Subfolder **/js** contains the JavaScript files and Subfolder **/css** the CSS files.

JavaScript files
^^^^^^^^^^^^^^^^

The JavaScript-Files in the output regroup files and inline-JS. With the filename itself, *toctoc_indexreloaded* decides at run time if the output needs to be rebuilt.

For files, the filetime of the original file is coded into the output filename. For inline JS, the length and sequence position is reflected in the output filename.


The filename for - in PHP - is built in this part of code


::

    'f' . round($lastfiletime, 0) . $tmpmd5str . $g . '.js';

      
where

::

    $lastfiletime =($lastfiletime+$filetime)/2;

      
**$filetime** is filetime of a JavaScript-File

and


::

    $tmpmd5str .= 'i' . strlen($scripts[$i]['script']) . '_';

      
**$g** represents the sequence number of the output file

Result, example: f1287611455i732_i62_5.js

CSS files
^^^^^^^^^

The CSS-Files in the output regroup CSS-files and inline-CSS. With the filename itself, *toctoc_indexreloaded* decides at run time if the output needs to be rebuilt.

For files, the filetime of the original file is coded into the output filename. For inline CSS the length and sequence position is reflected in the output filename.

At the base, same like for the JS-Files. The processing options for CSS are more sophisticated than for JS. That's why filenames for CSS are a bit more complex.


The filename for - in PHP - is built in this part of code


::

    'f' . md5($tmpfilename . $tmpmd5str) . '-' . $cfgstrCSS . $g . 
    $foldingmd5filename . '.css';

      
where

::

    $tmpfilename .= '-' . $filetime;
    
      
**$filetime** is filetime of a CSS-file

and


::

     $tmpmd5str .= 's'. strlen($cascadingss[$i]['css']) . '_';

      
**$cfgstrCSS** allows to use different setups and so to separate the output CSS, when switching options. The options which are considered are generateCSSbelowTheFold, doCrunchCSS.

Different CSS generates for logged in users or not logged in users.

**$g** represents the sequence number of the output file

**$foldingmd5filename** identifies an element cloud of a webpage, which then serves for the creation of above- and below-the-fold-CSS.

When it comes to distinguish above- and below-the-fold-CSS string 'below' appends at the end of the below-CSS-filename

Result, example: fd1147d055b748aa68d0ef5ef7e06265c-sca1-427e7662e80c64a9786e819c607e9ceebelow.css

**Merged CSS**

Merged CSS is stored in subfolder /merged in folder css.

Filenames of merged CSS files miss the **$foldingmd5filename**. When a new pair of above- below-CSS is created, then this new pair gets merged with the existing pair in subfolder /merged
