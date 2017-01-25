.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _users-manual-installing-and-setup:

Installing and Setup
--------------------

Installation in TYPO3
---------------------

#.     Install the extension in EM.

In the configuration of the Extension in EM set "Dont modify index.php at all" (dontmod) to 0 to
enable the extension.

If you have problems (JS-errors) try exclude these files from
processing or compression.

Inline JS or linked files **that change** from page to page should be excluded from
processing into *toctoc_indexreloaded* external files. It would create different external files for every page: The 
goal is to get external files serving as much webpages as possible, external files for every page would lead to more data traffic overall.


#.     Alternatively install the extension for use in TypoScript

Add the static template for "TocToc Index Reloaded" to the website root template.

! This disables the options in EM, which are the same like under TypoScript (only API-key and API-server always come from EM

Use different setups if requires for different pages.


Installation in other PHP based solutions
-----------------------------------------

Install the extension by post processing the output of your PHP solution

See files in folder Resources/Public/ExternalUse for more information

Configure the extension using Resources/Public/RawConfig/configuration.php


**IMPORTANT**

- The extension needs to be enabled in configuration 

- CSS folding is not active by default (first please get an API-key on www.toctoc.ch)