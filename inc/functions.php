<?php

function loadStuff() {
	global $path;
	
	$masters = array(
		"controllers" => loadAllDir($path."controllers"),
		"views" => loadAllDir($path."views"),
		"models" => loadAllDir($path."models"),
		"helpers" => loadAllDir($path."helpers")
	);

        GLBL::$controllers = new StdClass();
        GLBL::$models = new StdClass();
        GLBL::$views = new StdClass();
	GLBL::$helpers = new StdClass();

        foreach($masters['controllers'] As $key => $value) {
                GLBL::$controllers->$key = $value;
        }
        foreach($masters['models'] As $key => $value) {
                GLBL::$models->$key = $value;
        }
        foreach($masters['views'] As $key => $value) {
                GLBL::$views->$key = $value;
        }
	foreach($masters['helpers'] As $key => $value) {
		GLBL::$helpers->$key = $value;
	}
}

function loadAllDir($dir) {
	$od = opendir($dir);
	$classBuilder = array();
	
	while(false !== ($file = readdir($od))) {
		
		if(is_file($dir."/".$file)) {
			include($path.$dir."/".$file);	
		}
	}

	return (object) $classBuilder;
}
?>
