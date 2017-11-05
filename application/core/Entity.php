<?php
class Entity extends CI_Model {

    // If this class has a setProp method, use it, else modify the property directly
    public function __set($key, $value) {
        $this->form_validation->set_rules('task', 'Task', 'alpha_numeric_spaces|max_length[64]');
        $this->form_validation->set_rules('priority', 'Priority', 'integer|less_than[4]');
        $this->form_validation->set_rules('size', 'Size', 'integer|less_than[4]');
        $this->form_validation->set_rules('group', 'Group', 'integer|less_than[5]');

        if ($this->form_validation->run() == true) {
            // if a set* method exists for this key, 
            // use that method to insert this value. 
            // For instance, setName(...) will be invoked by $object->name = ...
            // and setLastName(...) for $object->last_name = 
            $method = 'set' . str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $key)));
            if (method_exists($this, $method))
            {
                    $this->$method($value);
                    return $this;
            }

            // Otherwise, just set the property value directly.
            $this->$key = $value;
            return $this;
        }
        
    }
}
