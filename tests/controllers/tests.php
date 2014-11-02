<?php
 
if (!defined('BASEPATH')) exit('No direct script access allowed');
 
/**************************************
 * Test Class for Event Manager Library
 *
 */
class Tests extends CI_Controller
{
	public $data = array();
	
    function __construct()
    {
        parent::__construct();
		
		$this->load->library('events/events');
		$this->load->library('unit_test');
    }
 
    public function index()
	{
		// scenario 1
		$this->data['scenario1']['expected'] = 2;
		$this->data['scenario1']['add'] = Events::add('test.scenario.1', function($ci_instance, $parm){
			$a = 1;
			$b = 1;
			
			return $a+$b;
		});
		
		// scenario 2 
		$this->data['scenario2']['expected'] = false;
		$this->data['scenario2']['add'] = Events::add('test.scenario.2', function($ci_instance, $parm){
			return false;
		});
		
		// scenario 3 
		$this->data['scenario3']['expected'] = true;
		$this->data['scenario3']['add'] = Events::add('test.scenario.3', function($ci_instance, $parm){
			return $parm['php'] == "It's perfect!";
		});
		
		// scenario 4
		$this->data['scenario4']['expected'] = true;
		$this->data['scenario4']['add'] = Events::add('test.scenario.4', function($ci_instance, $parm){
			return is_string($parm);
		});
		
		// scenario 5
		$this->data['scenario5']['expected'] = null;
		$this->data['scenario5']['add'] = Events::add('test.scenario.5', function($ci_instance, $parm){
			$var = $parm;
			// echo can be done if desired
		});
		
		// scenario 6
		$string = 'Hello world!';
		$this->data['scenario6']['expected'] = null;
		$this->data['scenario6']['add'] = Events::add('test.scenario.6', function($ci_instance, $parm) use($string){
			return $string;
		});
		
		// running events
		$this->data['scenario1']['fire'] = Events::fire('test.scenario.1');
		$this->data['scenario2']['fire'] = Events::fire('test.scenario.2');
		$this->data['scenario3']['fire'] = Events::fire('test.scenario.3', array('php' => "It's perfect!"));
		$this->data['scenario4']['fire'] = Events::fire('test.scenario.4', 'Hello World!');
		$this->data['scenario5']['fire'] = Events::fire('test.scenario.5', 'Life is good!');
		$this->data['scenario6']['fire'] = Events::fire('test.scenario.6');
		
		// running tests
		$this->run();
	}

	private function run()
	{
		$result = array();
		
		// running scenarios
		$result[] = $this->unit->run(1+1, $this->data['scenario1']['fire'], 'Scenario 1');
		$result[] = $this->unit->run($this->data['scenario2']['fire'], 'is_false', 'Scenario 2');
		$result[] = $this->unit->run($this->data['scenario3']['fire'], 'is_true', 'Scenario 3');
		$result[] = $this->unit->run($this->data['scenario4']['fire'], 'is_true', 'Scenario 4');
		$result[] = $this->unit->run($this->data['scenario5']['fire'], 'is_null', 'Scenario 5');
		$result[] = $this->unit->run($this->data['scenario6']['fire'], 'is_string', 'Scenario 6');
		
		// print the results
		$this->load->view('tests', array('results' => $result));
	}
}