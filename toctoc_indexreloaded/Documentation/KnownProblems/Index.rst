.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _known-problems:

Known problems
==============

- JS has to be free of JavaScript-syntax-errors if you want to use compression

- CSS must be well formated and linked as CSS-files (no PHP-files, no exotic calls). If any CSS-file cannot be processed because it's linked in a too "exotic" way, the extension will probably generate wrong results (CSS overwrites and so on will be messed up)

- *toctoc_indexreloaded* expects the double apostroph (") in links to CSS- and JS-files and not the simple apostroph ('). Insisting on the use of (') requires option **tryFixBadCSS** to be enabled (set to 1) and results in a performance loss.
