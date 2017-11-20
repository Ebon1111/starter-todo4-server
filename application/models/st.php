 */
	protected function load()
	{
		//---------------------
		if (($this->xml = simplexml_load_file('../data/' . $this->_origin)) !== FALSE) {
			$first = TRUE;
			// var_dump($this->xml->task);
			// for($i = 0; $i < count($this->xml); $i++) {
			
			$data =  json_decode(json_encode((array)$this->xml),true);
			
			$this->_data = [];

			$key = array_keys($data)[0];

			foreach($data[$key] as $child){
				// var_dump((array)$child);
				// echo "<br />";
				// echo "<br />";
				// echo "<br />";
				if ($first) {
					$count = 0;
				
					$this->_fields = array_keys($child);

					$this->_data[@$child['id']] = self::objectConverter($child);
					
					// var_dump($this->_fields);
				} else {
					// $record = new stdClass();
					// for ($i = 0; $i < count($this->_fields); $i++)
					// 	$record->{$this->_fields[$i]} = $child[$i];
					// $key = $record->{$this->_keyfield};
					// $this->_data[$key] = $record;
				}
			}
		}
		// --------------------
		// rebuild the keys table
		// $this->reindex();
	}


	static function objectConverter($array) {
    	$object = new stdClass();

        if (is_array($array) && count($array) > 0) 
        {
            foreach ($array as $key=>$value) 
            {

                $key = strtolower(trim($key));
                
                if (!empty($key)) 
                {
                    $object->$key = XML_Model::objectConverter($value);
                }
            }

            return $object;
        }

        else 
        {

            return false;

        }
	}

