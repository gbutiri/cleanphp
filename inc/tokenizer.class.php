<?php Class Tokenizer {		public $dataIn = "";        function __construct($linkIn, $link = true) {        if ($link) {			$this->dataIn = @file_get_contents($linkIn);        } else {            $this->dataIn = $linkIn;        }    }		public function eraseTo($target) {        $token_pos = strpos($this->dataIn,$target);        $token_found = false;		if ($token_pos === false) {            $token_found = false;			$this->dataIn = substr_replace($this->dataIn, "", 0, strlen($this->dataIn));		} else {            //var_dump($token_pos);            $token_found = true;			$this->dataIn = substr_replace($this->dataIn, "", 0, $token_pos+strlen($target));        }        return $token_found;	}		public function getTo($target) {        $token_pos = strpos($this->dataIn,$target);		if ($token_pos === false) {            return substr($this->dataIn, 0, strlen($this->dataIn));        } else {			return substr($this->dataIn, 0, $token_pos);		}	}    	public function getToEnd() {		return substr($this->dataIn, 0, strlen($this->dataIn));	}        public function find($target) {        $token_pos = strpos($this->dataIn,$target);        return $token_pos;    }    	}?>