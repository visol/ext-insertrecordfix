EXT:insertrecordfix
===================

This extension was developed by Georg Ringer and released only as part of a blog post on http://typo3blogger.de/extension-insertrecordfix-turchen-23/.

It changes the l10n behaviour of the content element "Insert records".

Currently, an "insert records" content element always displays the exact record selected, even if a localized version of the content element is available.

This extension changes the behaviour by a userFunc that searches for available localization and uses them.

A possible drawback is that it is no longer possible to explicitly use a record in the default language if a localized version exists.