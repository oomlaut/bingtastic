<?php
// Using Mustache for string interpolation: https://github.com/bobthecow/mustache.php/wiki
require_once("Mustache/autoloader.php");
Mustache_Autoloader::register();

class BingMe{
	private $m = null;
	private $filename = null;
	private $words = array();
	private $minwords = 0;
	private $maxwords = 0;
	private $possibilities = 0;
	private $keys = null;
	private $prefixes = array(
		"browser" => "http://www.bing.com/search?q={{query}}&setmkt=en-US",
		"default" => "http://www.bing.com/search?q={{query}}&go=&qs=n&form=&pq={{query}}&sc=0-0&sp=-1&sk=",
		"images" => "http://www.bing.com/images/search?q={{query}}",
		"videos" => "http://www.bing.com/videos/search?q={{query}}",
		"maps" => "http://www.bing.com/maps/default.aspx?q={{query}}&mkt=en",
		"news" => "http://www.bing.com/news/search?q={{query}}",
		//"events" => "http://www.bing.com/events/search?q={{query}}",
		//"friendphotos" => "http://www.bing.com/friendsphotos/search?q={{query}}",
		"explore" => "http://www.bing.com/explore?q={{query}}"
	);
	private $queryToken = "query";
	private $sepChar = '+';

	public function __construct(){

		// store keys for later use
		$this->setPrefixKeys(array_keys($this->prefixes));

		//register Mustache;
		$this->m = new Mustache_Engine;

	}

	public function __toString(){
		return implode(", ", $this->words);
	}

	public function __get($name){
	    if (isset($this->$name)) {
	        return $this->$name;
	    }
	    return null;
	}

	private function regexNeedle($string){
		return '/' . preg_quote($string) . '/';
	}

	private function validateInt($arg){
		return (gettype($arg) == "integer");
	}

	public function dataSource($filepath){
		if(file_exists($filepath)){
			$this->filepath = "wordlist.csv";
			$this->words = explode("\n", file_get_contents($filepath, true));
			$this->possibilities = count($this->words);
		} else {
			die("$filepath does not exist.");
		}
	}

	public function setWordRange($min = 1, $max = 10){
		if($this->validateInt($min)){
			$this->minwords = $min;
			if($this->validateInt($max)){
				$this->maxwords = $max;
				return true;
			} else {
				throw new Exception('Integer required to set "max" property.');
			}
		} else {
			throw new Exception('Integer required to set "min" property.');
		}

		return false;
	}

	public function setPrefixKeys($array){
		$this->keys = $array;
		return true;
	}

	private function getRandomPrefix(){
		$index = rand(0, count($this->keys) - 1);
		$key = $this->keys[$index];
		return array(
			'key' => $key,
			'url' => $this->prefixes[$key]
		);
	}

	private function getRandomPhrase(){
		$phrase = "";
		for ($i = 0; $i < rand($this->minwords,$this->maxwords); $i++){
			if($i != 0){
				$phrase .= $this->sepChar;
			}
			$phrase .= str_replace(array("\n", "\r"), '', $this->words[rand(0, $this->possibilities - 1)])	;
		}
		return $phrase;
	}

	public function generate($int){
		if($this->validateInt($int)){

			$phrase = $this->getRandomPhrase();
			$prefix = $this->getRandomPrefix();

			$array = array();
			$counter = 0;
			while($counter < $int){
				++$counter;
				$array[] = array(
					'query' => $phrase,
					'type' => $prefix["key"],
					'prefix' => $prefix["url"],
					'link'  => $this->m->render($prefix["url"], array($this->queryToken => $phrase) ),
					'text'  => preg_replace($this->regexNeedle($this->sepChar), ' ', $phrase)
				);
			}
			return $array;
		}

		throw new Exception('Integer required to generate array.');

		return false;
	}

	public function parse($string){
		return $this->m->render($string, $this->generate(1)[0]);
	}
}
