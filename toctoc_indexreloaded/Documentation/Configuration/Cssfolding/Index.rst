.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _configuration-cssfolding:

cssfolding
----------

=====================================================  ==========  =======================================================  =====================================================
**Property:**                                          Data type:  Description:                                             Default:
=====================================================  ==========  =======================================================  =====================================================
generateCSSbelowTheFold                                boolean     Split CSS into CSS above the fold and CSS 	            0
                                                                   below the fold 
                                                                   (Requires API key provided by toctoc.ch)
-----------------------------------------------------  ----------  -------------------------------------------------------  -----------------------------------------------------
tagsToKeepAboveTheFold                                 string      The tags in this list always remain in the CSS above     code,i,b,blockquote      
                                                                   the fold 
-----------------------------------------------------  ----------  -------------------------------------------------------  -----------------------------------------------------
classesToKeepAboveTheFold                              string      The class names in this list always remain in the CSS    tx-tc-login-form-iframe,
                                                                   above the fold                                           tx-tc-login-form-iframe-forgotpw, 
                                                                   (Ext:toctoc_comments uses the present defaults)          tx-tc-sharrrearea-popup, sharrre
-----------------------------------------------------  ----------  -------------------------------------------------------  -----------------------------------------------------
IDsToKeepAboveTheFold                                  string      The CSS-Ids in this list always remain in the CSS      
                                                                   above the fold          
-----------------------------------------------------  ----------  -------------------------------------------------------  -----------------------------------------------------
mergeCSSbelowTheFold                                   boolean     Merge CSS: When generateCSSbelowTheFold = 1,             0
                                                                   then merge new CSS into existing CSS 
                                                                   (above and below the fold)
-----------------------------------------------------  ----------  -------------------------------------------------------  -----------------------------------------------------
freezeFolding                                          boolean     Freeze folding: When generateCSSbelowTheFold = 1, 	    0
                                                                   after many calculations of above- and below-CSS 
                                                                   then normally the merged output becomes stable. 
                                                                   Avoid recalculations by setting this option to 1
-----------------------------------------------------  ----------  -------------------------------------------------------  -----------------------------------------------------
inlineCSSaboveTheFold                                  boolean     Inline CSS above the fold: Also,when	                    0 
                                                                   mergeCSSbelowTheFold = 1, above-the-fold CSS 
                                                                   is stored in files and loaded as file links. 
                                                                   Alternatively you can force this CSS 
                                                                   to be loaded inline into the HTML of the page
-----------------------------------------------------  ----------  -------------------------------------------------------  -----------------------------------------------------
checkDupesOnFoldingMerge                               boolean     Check dupes while merging:                               0 
                                                                   When mergeCSSbelowTheFold = 1, then check CSS for 
                                                                   duplicates (same rule, same selector) and 
                                                                   eliminate them in CSS-output. 
=====================================================  ==========  =======================================================  =====================================================