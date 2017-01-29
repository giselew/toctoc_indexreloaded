.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _configuration-onlyoutsidetypo3:

Only outside TYPO3
------------------

The following options are available if you install outside TYPO3

====================================  ==========  =======================================================  =================================
**Property:**                         Data type:  Description:                                             Default:
====================================  ==========  =======================================================  =================================
DebugIP                               string      The debug-windows only shows up if your IP matches 
                                                  this debugIP, '*' allows all 
                                                  In TYPO3 use [SYS][devIPmask] 
------------------------------------  ----------  -------------------------------------------------------  ---------------------------------
forceBaseURL                          string      Forces a baseURL for the site, used to identify links 
                                                  to external files a hosted on same server.
                                                  example 'http://specificsubdomain.toctoc.ch'
====================================  ==========  =======================================================  =================================
