<?php

class SafeSearch {
	private $filepath = null;
	private $delimiter = ',';
	private $count = null;
	private $words = array();

	public function __construct($filepath = BLACKLIST_FILE){
		if(file_exists($filepath)):
			$this->filepath = $filepath;
			$this->words = explode($this->delimiter, file_get_contents($this->filepath, true));
			$this->quantity = count($this->words);
		else:
			die("Data source not found: $filepath");
		endif;
		return $this;
	}

	public function safe($string){
		return !in_array($string, $this->words);
	}

	public function addWord($word, $saveToFile = false){
		if(!in_array($word, $this->words)):
			$this->words[] = $word;
			sort($this->words);
			if($saveToFile):
				$this->storeWords();
			endif;
		endif;
		return $this;
	}

	public function addWords($array, $saveToFile = false){
		foreach($array as $word){
			$this->addWord($word);
		}
		return $this;
	}

	public function removeWord($needle, $saveToFile = false){
		$tmp = array();
		if(in_array($needle, $this->words)):
			foreach($this->words as $word){
				if($needle !== $word){
					$tmp[] = $word;
				}
			}
			$this->words = $tmp;

			if($saveToFile):
				$this->storeWords();
			endif;
		endif;
		return $this;
	}

	private function storeWords(){
		$string = implode($this->delimiter, $this->words);
		return file_put_contents($this->filepath, $string);
	}
}
