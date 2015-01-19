<?php
// Using Mustache for string interpolation: https://github.com/bobthecow/mustache.php/wiki
require_once("Mustache/Autoloader.php");
Mustache_Autoloader::register();

// Use SafeSearch functionality in this class
require_once("SafeSearch.class.php");

class BingMe{

	private $defaults = array(
	                          'q' => 45,
	                          'minwords' => 2,
	                          'maxwords' => 4
	                          );
	private $m;
	private $filename;
	private $words;
	private $q;
	private $minwords;
	private $maxwords;
	private $possibilities;
	private $keys;

	private $delimiter = "\n";
	private $useCookie = true;
	private $cookieName = 'bingtastic';
	private $safeSearch = true;

	private $prefixes = array(
		"default" => "http://www.bing.com/search?q={{query}}&go=&qs=n&form=&pq={{query}}&sc=0-0&sp=-1&sk="
		,"omnibar" => "http://www.bing.com/search?q={{query}}&setmkt=en-US"
		,"images" => "http://www.bing.com/images/search?q={{query}}"
		,"videos" => "http://www.bing.com/videos/search?q={{query}}"
		,"maps" => "http://www.bing.com/maps/default.aspx?q={{query}}&mkt=en"
		,"news" => "http://www.bing.com/news/search?q={{query}}"
		// ,"events" => "http://www.bing.com/events/search?q={{query}}"
		// ,"friendphotos" => "http://www.bing.com/friendsphotos/search?q={{query}}"
		// ,"explore" => "http://www.bing.com/explore?q={{query}}"
	);
	private $queryToken = "query";
	private $sepChar = '+';

	public function __construct($filepath = null, $useCookie = true){

		if(file_exists($filepath)){
			$this->words = $this->buildWordList($filepath);
			$this->possibilities = count($this->words);
		} else {
			die("Data source not found: $filepath");
		}

		// store keys for later use
		$this->setPrefixKeys(array_keys($this->prefixes));

		// register Mustache;
		$this->m = new Mustache_Engine;

		// initialize private values
		$this->setQ();
		$this->setWordRange();

		// to use cookies or not to use cookies...
		if($useCookie){
			$this->getCookie();
		}


		return $this;

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

	private function regexNeedle($string = null){
		return '/' . preg_quote($string) . '/';
	}

	private function validateInt($arg = null){
		return (gettype($arg) == "integer");
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

	private function buildWordList($path = null){
		$data = file_get_contents($path, true);
		$list = explode($this->delimiter, $data);

		if(!$this->safeSearch){
			return $list;
		}

		$ss = new SafeSearch();
		$approved = array();
		foreach($list as $word){
			if($ss->safe($word)){
				$approved[] = $word;
			}
		}
		return $approved;
	}

	public function setQ($int = null){

		if(isset($int) && $this->validateInt($int)){
			$this->q = $int;
		} else {
			$this->q = $this->defaults['q'];
		}

		return $this;
	}

	public function setPrefixKeys($array){
		$this->keys = $array;
		return $this;
	}

	public function safeSearch($safeSearch = true){
		// store safeSearch option
		$this->safeSearch = $safeSearch;

		return $this;
	}

	public function setWordRange($min = null, $max = null){
		$this->minwords = ($this->validateInt($min)) ? $min : $this->defaults['minwords'];
		$this->maxwords = ($this->validateInt($max)) ? $max : $this->defaults['maxwords'];

		return $this;
	}

	public function generate($int){
		if(!$this->validateInt($int)){
			throw new Exception('Integer required to generate array.');
			return false;
		}
		$array = array();
		$counter = 0;
		while($counter < $int){
			++$counter;

			$phrase = $this->getRandomPhrase();
			$prefix = $this->getRandomPrefix();

			$array[] = array(
				'type' => $prefix["key"],
				'query' => $phrase,
				'text'  => preg_replace($this->regexNeedle($this->sepChar), ' ', $phrase),
				'template' => $prefix["url"],
				'url'  => $this->m->render($prefix["url"], array($this->queryToken => $phrase) )
			);
		}
		return $array;
	}

	public function parse($string){
		return $this->m->render($string, $this->generate(1)[0]);
	}

	public function setCookie(){
		if(!$this->useCookie){
			return;
		}

		$data = array(
		                  'q'    => $this->q,
		                  'minwords' => $this->minwords,
		                  'maxwords' => $this->maxwords
		                  );

		setcookie($this->cookieName, serialize($data));
	}

	public function getCookie(){
		if(!$this->useCookie){
			return;
		}

		$cookie = $_COOKIE[$this->cookieName];

		if(!isset($cookie)){
			$this->setCookie();
			return;
		}

		foreach (unserialize($cookie) as $key => &$value){
			$this->{$key} = $value;
		}

		return;
	}

	public function resetCookie(){
		if(!$this->useCookie){
			return;
		}

		setcookie($this->cookieName, serialize(json_encode($this->defaults)));
		return true;
	}
}
