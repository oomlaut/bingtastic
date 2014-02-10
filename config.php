<?php

define("PATH", __DIR__);

set_include_path(get_include_path() . PATH_SEPARATOR . PATH . "/libs/");

if(file_exists(PATH . "/data/wordlist.csv")){
	define("DATA_FILE", PATH . "/data/wordlist.csv");
}
