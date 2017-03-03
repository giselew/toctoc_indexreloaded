.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _administration-debugwindow-in-frontend:

Debug-window in frontend
------------------------

The debug window shows times needed for processing and, if possible, the change of file-sizes and
number of requests.

====================================================================  ====================================================
Debug window in frontend, when the files are forced to be recreated:  Debug window in frontend, when the files are already
                                                                      created:
--------------------------------------------------------------------  ----------------------------------------------------
.. figure:: /Images/debug1.jpg                                        .. figure:: /Images/debug2.jpg
====================================================================  ====================================================


Note in the picture on the left the part **CSS folding**. Selectors new 6702 (903/5799) represents the fresh pair of above- and below-CSS. It merges into Selectors Old (1396/5305). Result is the new merged CSS, Selectors result (1396/5305). Here the option freezeFolding could be enabled, because the folding-process did not change anything in the output CSS.