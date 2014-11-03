<?php

#Example

Events::add('event.t.manager', function($ci_instance, $parm){
	echo $parm;
});

Events::add('event.t.manager2', function($ci_instance, $parm){
	echo $parm;
});

//Events::fire('event.*', array('*' => 'test'));
Events::fire('event.*', array('event.t.manager' => 'test 1', 'event.t.manager2' => 'test2'));

/*
	Events::add('event.manager', function($ci_instance, $parm){
		echo $parm;
	});
	
	Events::add('event.manager2', function($ci_instance, $parm){
		echo $parm;
	});
	
	Events::fire('*', array(
			'event.manager' => 'Hello',
			'event.manager2' => 'World'
		)
	);
	*/
	/*var_dump(Events::has('event.manager'));
	
	echo '<br />';
	
	Events::remove('event.manager');
	var_dump(Events::has('event.manager'));*/
	
	//Events::runAll('');
	//Events::fire('event.manager', 'Hello World!');
 