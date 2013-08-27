<?php


class BingMe{
	private $filename = null;
	private $words = array();
	private $minwords = 0;
	private $maxwords = 0;
	private $possibilities = 0;
	private $prefixes = array(
		"http://www.bing.com/search?setmkt=en-US&q=",
		"http://www.bing.com/images/search?q=",
		"http://www.bing.com/videos/search?q=",
		// "http://www.bing.com/maps/default.aspx?mkt=en&q=",
		"http://www.bing.com/news/search?q=",
		//"http://www.bing.com/events/search?q=",
		//"http://www.bing.com/friendsphotos/search?q="
		"http://www.bing.com/explore?q="
	);
	private $sepChar = '+';

	public function __construct($filepath){

		if(file_exists($filepath)){
			$this->filepath = "wordlist.csv";
			$this->words = explode("\n", file_get_contents($filepath, true));
			$this->possibilities = count($this->words);
		} else {
			die("$filepath does not exist.");
		}
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

	private function validateInt($arg){
		return (gettype($arg) == "integer");
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

	private function getPrefix(){
		$index = rand(0, count($this->prefixes) - 1);
		return $this->prefixes[$index];
	}

	private function getPhrase(){
		$phrase = "";
		for ($i = 0; $i < rand($this->minwords,$this->maxwords); $i++){
			if($i != 0){
				$phrase .= $this->sepChar;
			}
			$phrase .= str_replace(array("\n", "\r"), '', $this->words[rand(0, $this->possibilities - 1)])	;
		}
		return $phrase;
	}

	public function parse($string){

		$phrase = $this->getPhrase();

		$map = array(
			'/@link/'  => $this->getPrefix() . $phrase,
			'/@text/'  => preg_replace('/\\' . $this->sepChar . '/', ' ', $phrase)
			);

		foreach($map as $find => $replace){
			$string = preg_replace($find, $replace, $string);
		}

		return $string;
	}
}
