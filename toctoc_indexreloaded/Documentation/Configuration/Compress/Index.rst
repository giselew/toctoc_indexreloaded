.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _configuration-compress:

compress
--------

==============================  ==========  =======================================================  ===============
**Property:**                   Data type:  Description:                                             Default:
==============================  ==========  =======================================================  ===============
doCrunchCSS                     boolean     CSS compression: CSS will be compressed                  1
------------------------------  ----------  -------------------------------------------------------  ---------------
optMinifyjsfiles                boolean     Enable minify of JS-files with JSMin.php - modified      1
                                            PHP implementation of Douglas Crockford's JSMin  
                                            
                                            **Note: JS must be free of syntax-errors**  
------------------------------  ----------  -------------------------------------------------------  ---------------
noMinifyjsList                  string      Exclude list: parts of JS-filenames, that must 
                                            not be minified 
==============================  ==========  =======================================================  ===============
