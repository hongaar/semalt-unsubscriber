semalt-unsubscriber
===================

Use for mass unsubscribing from semalt and make the web a better place.

![semalt architecture](https://raw.githubusercontent.com/nabble/semalt-unsubscriber/master/architecture.png)

Usage
-----

```
chmod u+x run.php && ./run.php
```

Options
-------

To boot 5 parallel processes (instead of default 10):

```
./run.php 5
```

If you're not getting any results, change `$currentServer` in file `unsub.php` to a number which results in an active server address. Check by making a request to _http://server[NUMBER].openfrost.com/get_link.php?newagent=1_.

Requirements
------------

 - Linux
 - cURL
 - PHP
 - [Composer](http://getcomposer.org)