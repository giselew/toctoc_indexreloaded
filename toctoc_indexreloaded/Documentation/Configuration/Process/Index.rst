.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _configuration-process:

process
-------

====================================  ==========  =======================================================  =================================
**Property:**                         Data type:  Description:                                             Default:
====================================  ==========  =======================================================  =================================
optProcessfiles                       boolean     Enable file processing                                   1       
------------------------------------  ----------  -------------------------------------------------------  ---------------------------------
optProcessjsfiles                     boolean     Enable JS-file processing                                1  
------------------------------------  ----------  -------------------------------------------------------  ---------------------------------
asynchLastJS                          boolean     Load last JS file asynchronous:                          1  
                                                  Must be set to 0 when code in last JS file attemps to 
                                                  make document.write
------------------------------------  ----------  -------------------------------------------------------  ---------------------------------
optProcesscssfiles                    boolean     Enable CSS-file processing                               1  
------------------------------------  ----------  -------------------------------------------------------  ---------------------------------
tryFixBadCSS                          boolean     Try to fix bad CSS: Changes ' to ", removes bad //       0
						  in links, eliminates bad typo in CSS: Check out the 
						  PHP-code for tryFixBadCSS if you want to add your own 
						  cleansing code  
------------------------------------  ----------  -------------------------------------------------------  ---------------------------------
excludesProcessing                    string      Exclude list for Processing:                             var pageid =,tx-tc-shrrr-
                                                  parts of JS or CSS-filenames, that should be excluded 
                                                  for processing, for inline scripts/styles a part 
                                                  of the text is ok for identification
------------------------------------  ----------  -------------------------------------------------------  ---------------------------------
includesProcessing                    string      Include list for Processing:
                                                  parts of JS or CSS-filenames, that must be included 
                                                  for processing anyway. 
                                                  includes overwrite the excludes. 
                                                  This good for more detailed filtering
------------------------------------  ----------  -------------------------------------------------------  ---------------------------------
typo3tempsubfolder                    string      Path to processed files: CSS and JS files will be        typo3temp/TocTocIndexReloaded
                                                  written in this directory
====================================  ==========  =======================================================  =================================
