<?php 
Class Functions {
	
	public $err = "";
	
	function devslashes($in) {
		return $in;
		if ($this->isDev()) {return $in;} else {return stripslashes($in);}
	}
	
	function isDev() {
		if ($_SERVER['REMOTE_ADDR']=='127.0.0.1') {return true;}else{return false;}
	}
	
	function getDataURI($path) {
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$data = file_get_contents($path);
		$base64 = 'data:image/'.$type.';base64,'.base64_encode($data);
		return $base64;
	}
	
	function friendlyURL($string){
		$string = preg_replace("`\[.*\]`U","",$string);
		$string = preg_replace('`&(amp;)?#?[a-z0-9]+;`i','-',$string);
		$string = htmlentities($string, ENT_COMPAT, 'utf-8');
		$string = preg_replace( "`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);`i","\\1", $string );
		$string = preg_replace( array("`[^a-z0-9]`i","`[-]+`") , "-", $string);
		return strtolower(trim($string, '-'));
	}
	
	function birthday ($birthday) {
		list($year,$month,$day) = explode("-",$birthday);
		$year_diff  = date("Y") - $year;
		$month_diff = date("m") - $month;
		$day_diff   = date("d") - $day;
		if ($month_diff < 0) $year_diff--;
		elseif (($month_diff==0) && ($day_diff < 0)) $year_diff--;
		return $year_diff;
	}

	function loggedIn() {
		if (_USERNAME != '') {
			return true;
		} else {
			return false;
		}
	}

	function loggedInCDP() {
		if (_USERNAME != '') {
			return true;
		} else {
			return false;
		}
	}
	
	function loggedInTA() {
		if (isset($_SESSION['actingshowcase_ta_username'])) {
			if ($_SESSION['actingshowcase_ta_username'] != '') {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
		
	}
	
	function isLoggedInUser($username) {
		if ($this->loggedIn($username)) {
			if (_USERNAME == $username) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	function isLinkedFB ($uid) {
		if ($this->loggedIn()) {
			$sql="SELECT fbid FROM signup WHERE fbid='".$uid."' AND username = '"._USERNAME."'";
			$res=mysql_query($sql);
			$row=mysql_fetch_array($res);
			$row_count=mysql_num_rows($res);
			if ($row_count > 0) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	
	function get_days($date_in) {
		$start_ts = ($date_in);
		$end_ts = strtotime(date("d-m-Y"));
		$diff = $end_ts - $start_ts;
		return intval($diff / 86400);
	}
	
	function checkEmail($email, $strict = false) {
		$regex = $strict? 
			'/^([.0-9a-z_-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,4})$/i' : 
			'/^([*+!.&#$�\'\\%\/0-9a-z^_`{}=?~:-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,4})$/i' ; 
		if (preg_match($regex, trim($email), $matches)) { 
			return array($matches[1], $matches[2]); 
		} else { 
			return false; 
		}
	}
	
	function checkPassword ($pwd) {
		$error="";
		if( strlen($pwd) < 6 ) {$error = "Password too short. Must be at least 6 characters.";}
		elseif( strlen($pwd) > 20 ) {$error = "Password too long. Must be no longer than 20 characters.";}
		elseif( !preg_match("#[0-9]+#", $pwd) ) {$error = "Password must include at least one number!";}
		elseif( !preg_match("#[a-zA-Z]+#", $pwd) ) {$error = "Password must include at least one letter!";}
		//elseif( !preg_match("#[a-z]+#", $pwd) ) {$error = "Password must include at least one lowercase letter!";}
		//elseif( !preg_match("#[A-Z]+#", $pwd) ) {$error = "Password must include at least one uppercase letter!";}
		//elseif( !preg_match("#\W+#", $pwd) ) {$error = "Password must include at least one symbol!";}
		if($error!=""){
			return $error;
		} else {
			return "";
		}
	}

	function checkUsername ($username) {
		$error="";
		if( strlen($username) < 6 ) {$error = "Username too short. Must be at least 6 characters.";}
		elseif( strlen($username) > 20 ) {$error = "Username too long. Must be no longer than 20 characters.";}
		elseif( !preg_match("#[0-9a-zA-Z_\-]+#", $username) ) {$error = "Username can only include letters, numbers, dash ( - ), and underscore ( _ )!";}
		elseif( preg_match("#\W+#", $username) && !preg_match("#[-]+#", $username) ) {$error = "Username can only include letters, numbers, and underscore ( _ )!";}
		if($error!=""){
			return $error;
		} else {
			return "";
		}
	}

	function checkValidDate($month,$day,$year) {
		$year_diff = date("Y") - $year;
		if ($year_diff < 13) {return false;}
		if ($year_diff > 13) {return true;}
		if ($year_diff == 13) {
			$month_diff = date("n") - $month;
			if ($month_diff<0) {return false;}
			if ($month_diff>0) {return true;}
			if ($month_diff == 0) {
				$day_diff = date("j") - $day;
				if ($day_diff < -1) {return false;}else{return true;}
			}
		}
	}
	
	function replaceCRLF($strIn) {
		if (strstr($strIn,"\r")) { return str_replace("\r","<br>",$strIn); }
		if (strstr($strIn,"\n")) { return str_replace("\n","<br>",$strIn); }
		return $strIn;
	}
    
    function addZero($num) {
        if ($num < 10) { $num = "0".$num; };return $num;		
    }

    function createRandomPassword($range = 7) { 
        $chars = "abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!";
        srand((double)microtime()*1000000);
        $i = 0;
        $pass = '' ;

        while ($i <= $range) {
            $num = rand() % strlen($chars);
            $tmp = substr($chars, $num, 1);
            $pass = $pass . $tmp;
            $i++;
        }
        return $pass;
    }
	
	function getUID($username) {
		$sql="SELECT UID FROM signup WHERE username = '".$username."'";
		$res=mysql_query($sql);
		$row=mysql_fetch_array($res);
		return $row['UID'];
	}
	
	function userFolder($username) {
		$letterfolder = strtolower(substr($username,0,1));
		$folder = "users/".$letterfolder."/".$username;
		return $folder;
	}
	
	function cdpFolder($username) {
		$letterfolder = strtolower(substr($username,0,1));
		$folder = "casting/".$letterfolder."/".$username;
		return $folder;
	}
	
	function getUserFolder($username) {
		$letterfolder = strtolower(substr($username,0,1));
		$folder = "users/".$letterfolder."/".$username;
		return $folder;
	}
	
	function makeUserFolder($username) {
		if(!is_dir("users")) {
			mkdir("./users", 0777);
		}
	
		// MAKE FIRST LETTER FOLDERS
		$letterfolder = strtolower(substr($username,0,1));
		if (!is_dir("./users/".$letterfolder)) {
			mkdir("./users/".$letterfolder, 0777);
		}
		
		// MAKE THE users FOLDER IF NOT EXIST
		if(!is_dir(_DOCROOT."/users/".$letterfolder."/".$username) ){
			mkdir(_DOCROOT."/users/".$letterfolder."/".$username, 0777);
		}
		// MAKE photo DIRECTORY
		if (!is_dir(_DOCROOT."/users/".$letterfolder."/".$username."/photos")) {
			mkdir(_DOCROOT."/users/".$letterfolder."/".$username."/photos", 0777);
		}
		// MAKE video DIRECTORY
		if (!is_dir(_DOCROOT."/users/".$letterfolder."/".$username."/videos")) {
			mkdir(_DOCROOT."/users/".$letterfolder."/".$username."/videos", 0777);
		}
		// MAKE video thumbs DIRECTORY
		if (!is_dir(_DOCROOT."/users/".$letterfolder."/".$username."/vthumbs")) {
			mkdir(_DOCROOT."/users/".$letterfolder."/".$username."/vthumbs", 0777);
		}
	}
	
	function makeCastingFolder($username) {
		if(!is_dir("casting")) {
			mkdir("./casting", 0777);
		}
	
		// MAKE FIRST LETTER FOLDERS
		$letterfolder = strtolower(substr($username,0,1));
		if (!is_dir("./casting/".$letterfolder)) {
			mkdir("./casting/".$letterfolder, 0777);
		}
		
		// MAKE THE casting FOLDER IF NOT EXIST
		if(!is_dir("./casting/".$letterfolder."/".$username) ){
			mkdir("./casting/".$letterfolder."/".$username, 0777);
		}
		// MAKE photo DIRECTORY
		if (!is_dir("./casting/".$letterfolder."/".$username."/photos")) {
			mkdir("./casting/".$letterfolder."/".$username."/photos", 0777);
		}
		// MAKE video DIRECTORY
		if (!is_dir("./casting/".$letterfolder."/".$username."/videos")) {
			mkdir("./casting/".$letterfolder."/".$username."/videos", 0777);
		}
		// MAKE video thumbs DIRECTORY
		if (!is_dir("./casting/".$letterfolder."/".$username."/vthumbs")) {
			mkdir("./casting/".$letterfolder."/".$username."/vthumbs", 0777);
		}
	}
	
	function makeTAFolder($username) {
		if(!is_dir("talentagent")) {
			mkdir("./talentagent", 0777);
		}
	
		// MAKE FIRST LETTER FOLDERS
		$letterfolder = strtolower(substr($username,0,1));
		if (!is_dir("./talentagent/".$letterfolder)) {
			mkdir("./talentagent/".$letterfolder, 0777);
		}
		
		// MAKE THE talentagent FOLDER IF NOT EXIST
		if(!is_dir("./talentagent/".$letterfolder."/".$username) ){
			mkdir("./talentagent/".$letterfolder."/".$username, 0777);
		}
		// MAKE photo DIRECTORY
		if (!is_dir("./talentagent/".$letterfolder."/".$username."/photos")) {
			mkdir("./talentagent/".$letterfolder."/".$username."/photos", 0777);
		}
		// MAKE video DIRECTORY
		if (!is_dir("./talentagent/".$letterfolder."/".$username."/videos")) {
			mkdir("./talentagent/".$letterfolder."/".$username."/videos", 0777);
		}
		// MAKE video thumbs DIRECTORY
		if (!is_dir("./talentagent/".$letterfolder."/".$username."/vthumbs")) {
			mkdir("./talentagent/".$letterfolder."/".$username."/vthumbs", 0777);
		}
	}
	
	function cacheModule($orig_file, $minutes=5, $username='') {
		if(isset($_GET['nocache']) && $_GET['nocache'] == 'true') {
			$minutes = 0.01;
		}
		global $config;
		$cached_file = explode("/",$orig_file);
		$cache_path = "cache/";
		if (!is_dir($cache_path)) {
			mkdir($cache_path);
		}
		if ($username != '') {
			$cache_path .= $username.'/';
			if (!is_dir($cache_path)) {
				mkdir($cache_path);
			}
		}
		foreach ( $cached_file as $cache_bit ) {
			if ($cache_bit != '') {
				if (strpos($cache_bit,".php")) {
					$cache_path .= str_replace(".php",".html",$cache_bit);
				} else {
					$cache_path .= $cache_bit."/";
					if (!is_dir($cache_path)) {
						mkdir($cache_path);
					}
				}
			}
		}
		
		$cachefile = $cache_path;
		$cachetime = $minutes * 60; 
		if ( file_exists($cachefile) && $cachetime == 0 ) {
			include(_DOCROOT.'/'.$cachefile);
			echo "<!-- Cached ".date('jS F Y H:i', filemtime($cachefile))." -->";
		} elseif (file_exists($cachefile)  && $cachetime != 0 && (time() - $cachetime < filemtime($cachefile)) ) {
			include(_DOCROOT.'/'.$cachefile);
			echo "<!-- Cached ".date('jS F Y H:i', filemtime($cachefile))." -->";
		} else {
			ob_start();
			include(_DOCROOT.'/'.$orig_file); 
			$fp = fopen(_DOCROOT.'/'.$cachefile, 'w');
			fwrite($fp, ob_get_contents());
			fclose($fp);
			ob_end_flush(); 
		}
	}
	
	function cacheDynamicModule($orig_file, $minutes=5, $options = array()) {
		//var_dump($orig_file,$options);
		if(isset($_GET['nocache']) && $_GET['nocache'] == 'true') {
			$minutes = 0.01;
		}
		global $config;
		$cached_file = explode("/",$orig_file);
		$cache_path = "cache/";
		if (!is_dir($cache_path)) {
			mkdir($cache_path);
		}
		if ($options['username'] != '') {
			$cache_path .= $options['username'].'/';
			if (!is_dir($cache_path)) {
				mkdir($cache_path);
			}
		}
		foreach ( $cached_file as $cache_bit ) {
			if ($cache_bit != '') {
				if (strpos($cache_bit,".php")) {
					$cache_path .= str_replace(".php",".html",$cache_bit);
				} else {
					$cache_path .= $cache_bit."/";
					if (!is_dir($cache_path)) {
						mkdir($cache_path);
					}
				}
			}
		}
		
		$cachefile = $cache_path;
		$cachetime = $minutes * 60; 
		if ( file_exists(_DOCROOT.'/'.$cachefile) && $cachetime == 0 ) {
			include(_DOCROOT.'/'.$cachefile);
			echo "<!-- Cached ".date('jS F Y H:i', filemtime(_DOCROOT.'/'.$cachefile))." -->";
		} elseif (file_exists(_DOCROOT.'/'.$cachefile)  && $cachetime != 0 && (time() - $cachetime < filemtime($cachefile)) ) {
			include(_DOCROOT.'/'.$cachefile);
			echo "<!-- Cached ".date('jS F Y H:i', filemtime(_DOCROOT.'/'.$cachefile))." -->";
		} else {
			ob_start();
			include(_DOCROOT.'/'.$orig_file); 
			$fp = fopen(_DOCROOT.'/'.$cachefile, 'w');
			fwrite($fp, ob_get_contents());
			fclose($fp);
			ob_end_flush(); 
		}
	}
	
	function burstCache($file) {
		if (is_file(_DOCROOT.'/'.$file)) {
			unlink(_DOCROOT.'/'.$file);
		}
	}
	
	var $imageSizes = array(
		array('small',40,50),
		array('medium',120,150),
		array('large',272,340)
	);
	
	var $attachmentSizes = array(
		array('thumb',75,75)
	);
	
	function makeIfNoExist($folderIn) {
		global $config;
		global $functions;
		$folderArray = explode("/",$folderIn);
		$folderPath = _DOCROOT;
		foreach($folderArray as $folderBit) {
			$folderPath = $folderPath.'/'.$folderBit;
			if (!is_dir($folderPath)) {
				mkdir($folderPath);
			}
		}
	}
	
	function resizeAttachment($sizes, $auditionid, $filename) {
		require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
		$fn = new Functions();
		
		$upload_folder = strtolower('chatdocs/'.$auditionid.'/'.strtolower($filename[0]));
		$upload_folder_with_root = strtolower(_DOCROOT.'/'.$upload_folder);
		$upload_folder_with_file = strtolower($upload_folder.'/'.$filename);
		$upload_folder_with_file_and_root = strtolower(_DOCROOT.'/'.$upload_folder.'/'.$filename);
		$this->makeIfNoExist($upload_folder);
		$ext = strtolower(pathinfo($upload_folder_with_file_and_root, PATHINFO_EXTENSION));
		
		$imageSizes = $sizes;
		if (count($sizes) == 0) {
			$imageSizes = $this->attachmentSizes;
		}
		
		//var_dump($photoFolder);
		//var_dump('is_dir($photoFolder)',is_dir($photoFolder),$photoFolder);
		if (is_dir($upload_folder_with_root)) {
			//$upload_folder_with_file_and_root = $photoFolder.'/orig_'.$photonum.'.jpg';
			if (is_file($upload_folder_with_file_and_root)) {
				list($src_w, $src_h) = getimagesize($upload_folder_with_file_and_root);
				foreach($imageSizes as $imageSize) {
					//var_dump($photonum,$imageSize,'<br>');
					$dst_w = $imageSize[1];
					$dst_h = $imageSize[2];
					$new_name = $imageSize[0];
					$newPhotoFile = strtolower($upload_folder_with_root.'/'.$new_name.'_'.$filename);
					
					$src_ratio = $src_w / $src_h;
					$dst_ratio = $dst_w / $dst_h;
					
					$dst_image = imagecreatetruecolor($dst_w, $dst_h);
					switch ($ext) {
						case "jpg":
							$src_image = imagecreatefromjpeg($upload_folder_with_file_and_root);
							break;
						case "png":
							$src_image = imagecreatefrompng($upload_folder_with_file_and_root);
							break;
						case "gif":
							$src_image = imagecreatefromgif($upload_folder_with_file_and_root);
							break;
					}
					
					// this is to place the image in the center.
					$dst_x = 0;
					$dst_y = 0;
					if ($src_ratio > $dst_ratio) {
						$shrinkRatio = $dst_h / $src_h ;
						$dst_w = $src_w*$shrinkRatio;
						$diffOffset = (($dst_w-$imageSize[1])/2);
						$dst_x = -$diffOffset;
					} elseif ($src_ratio < $dst_ratio) {
						$shrinkRatio = $dst_w / $src_w ;
						$dst_h = $src_h*$shrinkRatio;
						$diffOffset = (($dst_h-$imageSize[2])/2);
						$dst_y = -$diffOffset;
					}

					// dst_ variables can be re-set to the post variables passed in.
					
					$src_x = 0;
					$src_y = 0;
					/* This is from the plugin.
					imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],$targ_w,$targ_h,$_POST['w'],$_POST['h']);     */
					if (isset($_POST['x'])) {
						$src_x=$_POST['x'];
						$src_y=$_POST['y'];
						$src_w=$_POST['w'];
						$src_h=$_POST['h'];
					}
					imagecopyresampled($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
					imagejpeg($dst_image, $newPhotoFile, 75);
				}
			}
		}
	}

	function resizeHeadshot($photonum, $sizes = array(),$username = '') {
		global $config, $dbi;
		require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
		$dbi = new mysqli("127.0.0.1",_DBUSER,_DBPASS,_DBNAME);
		include(_DOCROOT.'/sql-core.php');
		$fn = new Functions();
		
		if ($username == '') {
			if (_ISACTOR) {
				$username = _USERNAME;
				$userfolder = $fn->userFolder($username);
			} elseif (_ISCDP) {
				$username = _USERNAME;
				$userfolder = $fn->cdpFolder($username);
			}
		}
		//$sql = "SELECT * FROM signup WHERE username = '".$username."'";
		$siteFolder = _DOCROOT;
		//var_dump($config);
		$imageSizes = $sizes;
		if (count($sizes) == 0) {
			$imageSizes = $this->imageSizes;
		}
		
		
		
		$photoFolder = $siteFolder.'/'.$userfolder.'/photos/';
		//var_dump($photoFolder);
		//var_dump('is_dir($photoFolder)',is_dir($photoFolder),$photoFolder);
		if (is_dir($photoFolder)) {
			$absPhotoFile = $photoFolder.'/orig_'.$photonum.'.jpg';
			if (is_file($absPhotoFile)) {
				list($src_w, $src_h) = getimagesize($absPhotoFile);
				foreach($imageSizes as $imageSize) {
					//var_dump($photonum,$imageSize,'<br>');
					$dst_w = $imageSize[1];
					$dst_h = $imageSize[2];
					$new_name = $imageSize[0];
					$newPhotoFile = $photoFolder.'/'.$new_name.'_'.$photonum.'.jpg';
					
					$src_ratio = $src_w / $src_h;
					$dst_ratio = $dst_w / $dst_h;
					
					$dst_image = imagecreatetruecolor($dst_w, $dst_h);
					$src_image = imagecreatefromjpeg($absPhotoFile);
					
					// this is to place the image in the center.
					$dst_x = 0;
					$dst_y = 0;
					if ($src_ratio > $dst_ratio) {
						$shrinkRatio = $dst_h / $src_h ;
						$dst_w = $src_w*$shrinkRatio;
						$diffOffset = (($dst_w-$imageSize[1])/2);
						$dst_x = -$diffOffset;
					} elseif ($src_ratio < $dst_ratio) {
						$shrinkRatio = $dst_w / $src_w ;
						$dst_h = $src_h*$shrinkRatio;
						$diffOffset = (($dst_h-$imageSize[2])/2);
						$dst_y = -$diffOffset;
					}

					// dst_ variables can be re-set to the post variables passed in.
					
					$src_x = 0;
					$src_y = 0;
					/* This is from the plugin.
					imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],$targ_w,$targ_h,$_POST['w'],$_POST['h']);     */
					if (isset($_POST['x'])) {
						$src_x=$_POST['x'];
						$src_y=$_POST['y'];
						$src_w=$_POST['w'];
						$src_h=$_POST['h'];
					}
					imagecopyresampled($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
					imagejpeg($dst_image, $newPhotoFile, 75);
					
					
					
				}
				$newPhotoFile = $photoFolder.'/medium_'.$photonum.'.jpg';
				$data_uri = $this->getDataURI($newPhotoFile);
				$sql_du = "UPDATE signup SET uri_headshot = ? WHERE username = ?";
				//var_dump($data_uri,$sql_du,_USERNAME);
				sqlRun($sql_du,"ss",array($data_uri,_USERNAME));
			}
		}
	}

	function showDuration($seconds) {
		$minutes = intval($seconds / 60);
		$remainingSeconds = $seconds % 60;
		if ($remainingSeconds < 10) {
			$remainingSeconds = "0".$remainingSeconds;
		}
		return $minutes.":".$remainingSeconds;
	}
	
	var $videoSizes = array(
		array('medium',150,100),
		array('large',200,130)
	);

	function resizeVideoThumbs($vid, $sizes = array(),$username = '') {
		//var_dump($_SERVER['DOCUMENT_ROOT'].'/config.php');
		require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
		global $config;
		$fn = new Functions();
		
		
		if ($username == '') {
			$username = _USERNAME;
		}

		//$sql = "SELECT * FROM signup WHERE username = '".$username."'";
		$siteFolder = $_SERVER['DOCUMENT_ROOT'].$config['root_folder'];
		
		$videoSizes = $sizes;
		//var_dump($siteFolder);
		
		
		$userfolder = $fn->userFolder($username);

		$photoFolder = $siteFolder.'/'.$userfolder.'/vthumbs/';
		//var_dump($photoFolder);
		//var_dump('is_dir($photoFolder)',is_dir($photoFolder),$photoFolder);
				//var_dump($config);
		if (is_dir($photoFolder)) {
			$absPhotoFile = $photoFolder.'/'.$vid.'.jpg';
			if (is_file($absPhotoFile)) {
				list($src_w, $src_h) = getimagesize($absPhotoFile);
				foreach($videoSizes as $imageSize) {
					//var_dump($vid,$imageSize,'<br>');
					$dst_w = $imageSize[1];
					$dst_h = $imageSize[2];
					$new_name = $imageSize[0];
					$newPhotoFile = $photoFolder.'/'.$new_name.'_'.$vid.'.jpg';
					
					$src_ratio = $src_w / $src_h;
					$dst_ratio = $dst_w / $dst_h;
					
					$dst_image = imagecreatetruecolor($dst_w, $dst_h);
					$src_image = imagecreatefromjpeg($absPhotoFile);
					$dst_x = 0;
					$dst_y = 0;
					if ($src_ratio > $dst_ratio) {
						$shrinkRatio = $dst_h / $src_h ;
						$dst_w = $src_w*$shrinkRatio;
						$diffOffset = (($dst_w-$imageSize[1])/2);
						$dst_x = -$diffOffset;
					} elseif ($src_ratio < $dst_ratio) {
						$shrinkRatio = $dst_w / $src_w ;
						$dst_h = $src_h*$shrinkRatio;
						$diffOffset = (($dst_h-$imageSize[2])/2);
						$dst_y = -$diffOffset;
					}

					$src_x = 0;
					$src_y = 0;
					imagecopyresampled($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
					imagejpeg($dst_image, $newPhotoFile, 75);
				}
			}
		}
	}
	
	function getZipInfo($inZip, $echo = true) {
		$inZip = urlencode($inZip);
		$url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$inZip."&sensor=true";
		$zip_obj = file_get_contents($url);
		
		// echo ( $zip_obj ) ;
		$zip_obj = json_decode($zip_obj);
		
		//var_dump($zip_obj);
		$output = '';
		foreach ($zip_obj->results as $zips) {
			$zipcode="";
			$city="";
			$city2="";
			$state="";
			$country="";
			foreach ($zips->address_components as $add_comp) {
				// var_dump ($add_comp);
				switch ($add_comp->types[0]) {
					case "postal_code":
						$zipcode = $add_comp->long_name;
						// var_dump("postcode: ".$zipcode);
						break;
					case "locality":
						$city = $add_comp->long_name;
						// var_dump("city: ".$city);
						break;
					case "administrative_area_level_2":
						$city2 = $add_comp->long_name;
						// var_dump("city2: ".$city2);
						break;
					case "administrative_area_level_1":
						$state = $add_comp->long_name;
						// var_dump("state: ".$state);
						$state_abbr = $add_comp->short_name;
						// var_dump("state abbr: ".$state_abbr);
						break;
					case "country":
						$country = $add_comp->long_name;
						// var_dump("country: ".$country);
						$country_abbr = $add_comp->short_name;
						// var_dump("country abbr: ".$country_abbr);
						break;
				}
			}
			if ($echo) {
				$output .= '<div><a href="javascript:fillHidden(\''.$city.'\',\''.$state.'\',\''.$zipcode.'\',\''.$country.'\');void(0);">'.$city.' '.$city2.' '.$state.' '.$zipcode.' '.$country.'</a></div>';
			} elseif ($output === '') {
				$output = array(
					"city" => $city,
					"state" => $state,
					"zip" => $zipcode,
					"country" => $country
				);
			}
		}
		if ($echo) {
			echo $output;
		} else {
			return $output;
		}
	}
	
	function g_messageSend($arrayIn) {
		$body = $arrayIn['body'];
		$receiver = $arrayIn['receiver'];
		$date = date("Y-m-d H:i:s");
		
		$auditionid = isset($_GET['auditionid']) ? intval($_GET['auditionid']) : 0;
		if ($auditionid == 0){
			$auditionid = isset($arrayIn['auditionid']) ? $arrayIn['auditionid'] : 0;
		}
		
		$sql = "INSERT INTO pm (
			`body`,
			`sender`,
			`receiver`,
			`date`,
			`audition_id`
		) VALUES (
			?,?,?,?,?
		)";
		// mysql_query($sql);
		sqlRun($sql,'ssssi',array($body,_USERNAME,$receiver,$date,$auditionid));
	}

	function getMainPhotoId() {
		$sql = "SELECT main_photo_id FROM signup WHERE username = '"._USERNAME."'";
		$res = mysql_query($sql);
		$row = mysql_fetch_assoc($res);
		return $row['main_photo_id'];
	}
	
	function getLatLong($location) {
		$url = "http://maps.googleapis.com/maps/api/geocode/json?address=".urlencode(trim($location))."&sensor=true";
		$zip_obj_json = file_get_contents($url);
		$zip_obj = json_decode($zip_obj_json);

		$zip_status = $zip_obj->status;
		if ($zip_status != "OK") {

		} else {

			$latitude = $zip_obj->results[0]->geometry->location->lat;
			$longitude = $zip_obj->results[0]->geometry->location->lng;
			$output = $zip_obj->results[0]->formatted_address;
			
			return array(
				"lat" => $latitude,
				"lng" => $longitude,
				"loc" => $output
			);
			
		}
	}
		
}
?>