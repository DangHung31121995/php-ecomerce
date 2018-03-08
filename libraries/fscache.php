<?php
/*
 * Huy write
 */
class FSCache{
	private $cacheDir = 'cache';  
	private $expiryInterval = CACHE_TIME; 
	  
	public function setCacheDir($val) {
		$this->cacheDir = $val; 
	}  
	public function setExpiryInterval($val) {  
		$this->expiryInterval = $val; 
	}  
	
	public function exists($key) {
		
	}
	
	public function put($key, $content)  {
		$time = time(); //Current Time  
		
		if (! file_exists($this->cacheDir))  
			mkdir($this->cacheDir);  

		$filename_cache = $this->cacheDir . '/' . $key . '.cache'; //Cache filename  
		
		
		file_put_contents ($filename_cache ,  $content); // save the content  
	}
	
	public function get($key)  {
   		$filename_cache = $this->cacheDir . '/' . $key . '.cache'; //Cache filename  
   		if (file_exists($filename_cache) )  
   		{  
   			if((time() - filemtime($filename_cache)) < $this -> expiryInterval){
				return file_get_contents ($filename_cache); 
			} 
  		}  
  		return null;  
  	}  
  	
}
