<?php
/**
 * @author Saureen Adani <saureenp@gmail.com>
 */
Class LogParser
{
    const BUFFER_SIZE = 10240;
    const SEPARATOR = "\n";
    const LINES_TO_BE_PRINTED = 10;
    
    /**
     * constructor of the class
     * @param array $vars file path, start position of the file pointer, end position of file pointer, start line number, end line number, action
     */
    public function __construct($vars)
    {
        $this->handle = fopen($vars['file_path'], 'r');
        $this->filesize = filesize($vars['file_path']);
        $this->start_pos = $vars['start_pos'];
        $this->end_pos = $vars['end_pos'];
        $this->start_line_num = $vars['start_line_num'];
        $this->end_line_num = $vars['end_line_num'];
        $this->action = $vars['action'];
    }


	/**
	 * Moves the start pos & end pos of the file pointer in forward direction and adjusts start line number and end line number
	 * @return array contains line number as index of the array and line content as the value.
	 */
    public function loadForward(){
    	$results = array();
    	$linescounter = self::LINES_TO_BE_PRINTED;
    	if($this->action == 'load' or $this->action == 'begin'){
	    	$this->start_pos = $this->end_pos = 0;
	    	$this->start_line_num = $this->end_line_num = 1;
    	}else if($this->action == 'next'){
    		$this->start_pos = $this->end_pos;
    		$this->start_line_num = $this->end_line_num;
    	}
    	fseek($this->handle, $this->start_pos);
    	//echo fread($this->handle,2);
		$end_of_file = false;
		while($linescounter > 0){
			$char = $line = "";
			while($char != self::SEPARATOR){
				if(feof($this->handle)){
					$end_of_file = true;
					$this->end_pos--;
					break;
				}
				$this->end_pos++;
				$char = fgetc($this->handle);
				$line = $line . $char;
			}
			if($end_of_file){break;}

			$results[$this->end_line_num] = trim($line);
			$this->end_line_num ++;
			$linescounter --;
		}
		return $results;
    }    

    /**
	 * Moves the start pos & end pos of the file pointer in backward direction and adjusts start line number and end line number
	 * @return array contains line number as index of the array and line content as the value.
     */
    public function loadBackward(){
    	$results = array();
    	$linescounter = self::LINES_TO_BE_PRINTED;
    	$beginning_of_file = false;

	    if($this->action == 'prev'){

			$this->end_pos = $this->start_pos;
			$this->end_line_num = $this->start_line_num;

			$this->start_pos = $this->start_pos - 2; //set pointer to character before newline
			$this->start_line_num = $this->start_line_num - 1; //set line number to that of pointer pos

			fseek($this->handle, $this->start_pos);
		}else if($this->action == 'end'){

	    	$total_lines_in_file = $this->getLines();
	    	fseek($this->handle , -2, SEEK_END);

	    	$this->start_pos = ftell($this->handle);
	    	$this->start_line_num = $total_lines_in_file;

	    	$this->end_pos = ftell($this->handle) + 2; //set pointer to character before EOF
	    	$this->end_line_num = $this->start_line_num + 1; //set line number to that of pointer pos
		}

		while($linescounter > 0){
			$char = $line = "";
			while($char != self::SEPARATOR){
				if(fseek($this->handle, $this->start_pos) == -1){
					$beginning_of_file = true;
					$this->start_pos = 0; // reset
					fseek($this->handle, $this->start_pos); // reset file pointer
					break;	
				}
				$this->start_pos--;
				$char = fgetc($this->handle);
			}

			$line = fgets($this->handle);
			$results[$this->start_line_num] = trim($line);
			if($beginning_of_file){break;}
			$this->start_line_num --;
			$linescounter --;
		}
		if(!$beginning_of_file){
			$this->start_pos = $this->start_pos + 2; // reset
			$this->start_line_num = $this->start_line_num + 1; // reset
		}
		return array_reverse($results, true);
    }

    /**
     * Counts the number of lines in the provided file
     * @todo optimize the file read functionality
     * @return int Returns total count of lines in a file
     */
    public function getLines(){
    	$total_lines = 0;
    	while(!feof($this->handle)){
    		$total_lines += substr_count(fread($this->handle, self::BUFFER_SIZE), self::SEPARATOR);
    	}
    	return $total_lines;
    }

    /**
     * Closes an open file pointer
     * @return [type] [description]
     */
    public function closeFile(){
    	fclose($this->handle);
    }
}

?>