# Search Category

Search Category is a plugin for the Vanilla community forum software that extends the standard search capabilities.

Features:

1. Category drop down selector in the search results page to filter search results.
2. Google-like search query syntax ([See this forum post](http://vanillaforums.org/discussion/17907/searching)).

This application is licensed under the Apache 2.0 license.

## Installation

There are two ways to download this application:

1. **[Download the latest stable release](http://vanillaforums.org/addon/searchcategory-plugin).**
2. Clone the repository into the `plugins` directory of Vanilla.

Once you have added the plugin to your Vanilla installation, you need to activate it in the admin dashboard. The category dropdown selector will appear in the search result page of your forum.
If you want to activate the Google-like search query syntax you have to edit the conf/config.php file of your Vanilla installation and modify the SEARCH-MODE setting like this:

`$Configuration['Garden']['Search']['Mode'] = 'google';`

------------------------------

Copyright © 2014 Franco Solerio.
