<?php
/**
 * REST server for ferry schedule operations.
 * This one manages ports.
 *
 * ------------------------------------------------------------------------
 */
require APPPATH . '/third_party/restful/libraries/Rest_controller.php';
class Job extends Rest_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('ferryschedule');
	}
	// Handle an incoming GET ... 	returns a list of ports
	function index_get()
	{
		$this->response($this->ferryschedule->getPorts(), 200);
	}
	// The other REST methods are not handled, since we are not doing maintenance


	// // Handle an incoming GET - cRud
	// function index_get($key=null)
	// {
	//     $this->response('ok', 200);
	// }

	// // Handle an incoming PUT - crUd
	// function index_put($key=null)
	// {
	//     $this->response('ok', 200);
	// }

	// // Handle an incoming POST - Crud
	// function index_post($key=null)
	// {
	//     $this->response('ok', 200);
	// }

	// // Handle an incoming DELETE - cruD
	// function index_delete($key=null)
	// {
	//     $this->response('ok', 200);
	// }

	// Handle an incoming GET ... return a menu item or all of them
	function index_get($key=null)
	{
	    if (!$key)
	    {
	        $this->response($this->tasks->all(), 200);
	    } else
	    {
	        $result = $this->tasks->get($key);
	        if ($result != null)
	            $this->response($result, 200);
	        else
	            $this->response(array('error' => 'Todo item not found!'), 404);
	    }
	}

	// Handle an incoming POST - add a new todo item
	function index_post($key=null)
	{
	    $record = array_merge(array('id' => $key), $_POST);
	    $this->tasks->add($record);
	    $this->response(array('ok'), 200);
	}

	// Handle an incoming PUT - update a todo item
	function index_put($key=null)
	{
	    $record = array_merge(array('id' => $key), $this->_put_args);
	    $this->tasks->update($record);
	    $this->response(array('ok'), 200);
	}

	// Handle an incoming DELETE - delete a todo item
	function item_delete($key=null)
	{
	    $this->tasks->delete($key);
	    $this->response(array('ok'), 200);
	}

}


