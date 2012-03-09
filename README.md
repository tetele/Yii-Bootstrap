YII BOOTSTRAP
=============

Yii-Bootstrap is the Yii wrapper for the lovely Bootstrap UI toolkit from Twitter. It includes a theme and several widgets for template generation.


Installation
------------

Match the directory structure to that of your Yii application, by uploading `themes/bootstrap` to `/path/to/your/app/themes` and `protected/extensions/bootstrap-theme` to `ext` (`/path/to/your/app/protected/extensions`).

After that, you will have to do the following modifications to your application's files

Add these lines to your base controller class (usually found in `protected/components/Controller.php`

``` php
<?php
public function init() {
	$this->attachBehavior('bootstrap', new BController($this));
	...
}
?>
```

And the following lines in the application config

``` php
<?php
return array( // this row should already exist
	...
	'theme'=>'bootstrap',
	...
	'import' => array(
		...
		'ext.bootstrap-theme.widgets.*',
		'ext.bootstrap-theme.helpers.*',
		'ext.bootstrap-theme.behaviors.*',
	),
	...
	'modules' => array(
		...
		'gii' => array(
			...
			'generatorPaths'=>array(
				'ext.bootstrap-theme.gii',
			),
		),
		...
	),
	...
);
?>
```


Usage
-----

You can now extend the base application by overwriting the files in `themes/bootstrap` or add new functionality using [gii](http://www.yiiframework.com/doc/guide/1.1/en/topics.gii). Code generators have been set up in order to make all new views look Bootstrap-themed.


Bug tracker
-----------

Have a bug? Please create an issue here on GitHub!

https://github.com/tetele/Yii-Bootstrap/issues


Author
------

**Tudor Sandu**

+ http://twitter.com/tetele
+ http://github.com/tetele


Copyright and license
---------------------

Copyright (c) 2011, Tudor Sandu. All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:
+ Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
+ Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
