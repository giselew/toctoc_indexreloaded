.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _configuration-basic:

basic
-----

========================  ==========  =======================================================  =====================
**Property:**             Data type:  Description:                                             Default:
========================  ==========  =======================================================  =====================
dontmod                   boolean     Dont modify index.php at all: **Activate**                 1
                                      **the extension by setting this option to 0**
------------------------  ----------  -------------------------------------------------------  ---------------------
dontmodJS                 boolean     Dont modify JS-files:                                    0
                                      Disable modification of JS (JavaScript) by setting 
                                      this option to 1
------------------------  ----------  -------------------------------------------------------  ---------------------
dontmodCSS                boolean     Dont modify CSS-files:                                   0
                                      Disable modification of CSS by setting this 
                                      option to 1
------------------------  ----------  -------------------------------------------------------  ---------------------
excludesarr               string      Exclude list: parts of JS or CSS-filenames, that         addthis_config
                                      should be excluded when dontmod=0, dontmodjs=0 
                                      or/and dontmodcss=0. For inline scripts/styles a 
                                      part of the text is ok for identification
------------------------  ----------  -------------------------------------------------------  ---------------------
includesarr               string      Include list: parts of JS or CSS-filenames, that       
                                      must be included when dontmod=0, dontmodjs=0 or/and 
                                      dontmodcss=0. Includes overwrite the excludes. 
                                      This is used for more detailed filtering
------------------------  ----------  -------------------------------------------------------  ---------------------
forceNewFiles             boolean     Force creation of new files:                             0
                                      You can force new files (CSS and JS) with 
                                      URL-Parameter ?forceNewFiles=1 as well
------------------------  ----------  -------------------------------------------------------  ---------------------
productionMode            boolean     Production mode:                                         0
                                      in production mode URL-Parameters ?forceNewFiles=1, 
                                      ?dontModIndex=1 and ?showDebugWindow =1 are disabled
------------------------  ----------  -------------------------------------------------------  ---------------------
excludesarr               string      Deactivate on pages: List of pages that 
                                      should not be touched by *toctoc_indexreloaded*
========================  ==========  =======================================================  =====================
