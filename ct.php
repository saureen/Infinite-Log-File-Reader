<?php
include('./config.php');
include_once('./inc/LogParser.class.php');

if($_POST['mgr']){

	switch($_POST['mgr']){

		case 1:
			$q = $_POST['q'];
			$params = explode("###", $q);
			$vars['action'] = $params[0];
			$vars['start_pos'] = $params[1];
			$vars['end_pos'] = $params[2];
			$vars['file_path'] = $user_input = $params[3];
			$vars['start_line_num'] = $params[4];
			$vars['end_line_num'] = $params[5];

			$vars['file_path'] = $LOG_DIRECTORY_BASE_PATH."/".trim($vars['file_path'],"/");
			if(!file_exists($vars['file_path'])){
				die('<span id="err2" class="alert">***File \'<u>'.$user_input.'</u>\' not found under \'<u>'.$LOG_DIRECTORY_BASE_PATH.'</u>\'. Please check the config.php to set the correct base path.</span>');
			}
			$LogParser = new LogParser($vars);

			if($vars['action'] == 'begin' or $vars['action'] == 'next' or $vars['action'] == 'load') {
				$results = $LogParser->loadForward();
			}else if($vars['action'] == 'end' or $vars['action'] == 'prev'){
				$results = $LogParser->loadBackward();
			}
			if($results){
				include_once('./templates/PrintLogs.tpl.php');
			}
			$LogParser->closeFile();
			break;
	}
}

?>