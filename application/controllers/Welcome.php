<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends Application
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/
	 * 	- or -
	 * 		http://example.com/welcome/index
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$tasks = $this->XML_Tasks->all();   // get all the tasks

		// count how many are not done
		$count = 0;
		foreach($tasks as $task) {
		    if ($task->status != 2) $count++;
		}
		// and save that as a view parameter
		$this->data['remaining_tasks'] = $count;

		// process the array in reverse, until we have five
		$count = 0;
		foreach(array_reverse($tasks) as $task) {
			$task->priority = $this->app->priority($task->priority);
		    $display_tasks[] = (array) $task;
		    $count++;
		    if ($count >= 5) break;
		}

		$this->data['display_tasks'] = $display_tasks;

		$this->data['pagebody'] = 'homepage';
		$this->render(); 
	}

	function makePrioritizedPanel($tasks)
	{
	    // extract the undone tasks
	    foreach ($tasks as $task)
	    {
	        if ($task->status != 2)
	            $undone[] = $task;
	    }

	    // order them by priority
		usort($undone, "orderByPriority");

		// substitute the priority name
		foreach ($undone as $task)
	    	$task->priority = $this->app->priority($task->priority);

	     // and then pass them on
	    $parms = ['display_tasks' => $converted];
	    return $this->parser->parse('by_priority', $parms, true);
    }

    // return -1, 0, or 1 of $a's priority is higher, equal to, or lower than $b's
	function orderByPriority($a, $b)
	{
	    if ($a->priority > $b->priority)
	        return -1;
	    elseif ($a->priority < $b->priority)
	        return 1;
	    else
	        return 0;
	}

}
