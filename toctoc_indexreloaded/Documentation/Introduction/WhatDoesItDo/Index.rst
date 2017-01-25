.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _introduction-what-does-it-do:

What does it do?
----------------

This extension reloads index.php before it's sent by the server to the client.
It reworks CSS and JS (Javascript) in a sequence of steps. The goal is to reduce load time of the webpages.

In the **first step**, all CSS regroups right above the </head>-tag and JS is sent to the end of the page - above
the </body>-tag. CSS and JS are brought to the right places in HTML.

Then in the **second step** CSS and JS merge in a minimum of CSS and JS-files, normally 1 CSS and 1 JS-file. It reduces drastically the number of requests from clients to
the server for CSS- and JS. The number of linked files reduces and even inline CSS and JS can be externalized along this step.

**3rd step** compresses CSS and JavaScript. The size of data transferred from server to client reduces.

In a **4th step CSS** can be split up in CSS which loads above the <head>-tag and CSS that will load after page load. CSS is organised in files (no inline styles).

Along all steps a debug windows displays, optionally. It's displayed for users in the range of TYPO3s devIPmask (Configuration option in install tool)

There's an option which allows to force creation of new files and a couple of $GET-variables allow to fast interact:

the extension can be turned off, debugwindow can be called and file regeneration may be forced.

There's an option for production mode, which disables all $_GET-variables

For the use of the above- and below-CSS we use a webservice provided by toctoc.ch. If you want to use CSS-folding you need to get an **API-key on www.toctoc.ch**
The API-key is valid for a given time and allows a limited number of calls. 
Checkout https://www.toctoc.ch/de/toctoc-indexreloaded/ for different kinds of API-keys and for more information on how this works.

The location of generated files defines by configuration. However, clean-up of files - if needed - requires use of an outside tool, such as a ftp-client.
It is planned that future versions will include a backend module, which will allow to control files, the API-key and more.
