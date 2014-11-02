<?php

#Example

/**
	Events::add('event.manager', function($ci_instance, $parm){
		echo $parm;
	});
	
	Events::fire('event.manager', 'Hello World!');
 */