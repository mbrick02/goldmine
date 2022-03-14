<?php
//The main config file
// change for MB: define('BASE_URL', 'http://localhost/trongate_framework/');
$app_dir = "goldmine";
// linux: "http://localhost/". $app_dir ."/"
// win laptop: "http://". $app_dir .":8080/"
// e.g. define('BASE_URL', 'http://localhost:8080/goldmine/');

$user_agent = $_SERVER['HTTP_USER_AGENT'];
if (strpos($user_agent, "Windows") !== false) {
  define('MBBASE_URL', 'http://localhost:8080/'. $app_dir .'/');
} elseif (strpos($user_agent, "Linux")) {
  define('MBBASE_URL', 'http://localhost/'. $app_dir .'/');
} else {
  echo "<h1>Not Win or Linux: No valid trontest base URL - see config</h1>";
  echo "<br />".$user_agent."<br />";
  echo "Win in UserAgent: ".strpos($user_agent, "windows")."<br />";
  echo "Linux in UserAgent: ".strpos($user_agent, "Linux")."<br />";
  die();
}

//The main config file
define('BASE_URL', MBBASE_URL);
// define('BASE_URL', 'http://localhost/goldmine/');
define('ENV', 'dev');
define('DEFAULT_MODULE', 'homepage');
define('DEFAULT_CONTROLLER', 'Homepage');
define('DEFAULT_METHOD', 'index');
define('APPPATH', dirname(dirname(__FILE__)).'/');
define('REQUEST_TYPE', $_SERVER['REQUEST_METHOD']);
define('MODULE_ASSETS_TRIGGER', '_module');
