<?php
if ( class_exists('fileHand') )
{
   return;
} else {

class fileHand
{
	var $f_err;



	//READ FILE
	function readFs($f_name)
	{
		$handle = @fopen($f_name, "r");
		return @fread($handle, 1024*1024);

	}

	//Write Into file
	function writeFs($f_name,$text)
	{
		$fp = @fopen($f_name,"w+");
		@fwrite($fp,$text);
		@fclose($fp);
		return true;
	}

	// RENAME FILE
	function reaFs($f_name,$f_new)
	{
		if(@is_file($f_name)){
			if(@file_exists($f_new)){
				$this->f_err='Cannot rename file: File with a specified name already exist.'; return false;
			}
			else{
				if(@rename($f_name,$f_new)){
					$this->f_err=null;
					return true;
				}
				else{
					$this->f_err='Cannot rename a directory: Permission denied.';
					return false;
				}
			}
		}
		else{
			$this->f_err='No file to rename.'; 	return false;
		}
	}

	// DELETE FILE

	function delFs($f_name)
	{
		if(@is_file($f_name)){
			if(@file_exists($f_name)){
				if(@unlink("$f_name")){
					$this->f_err=null;
					return true;
				}
				else
				if(@exec("del $f_name")){
					$this->f_err=null;
					return true;
				}
				else
				if(@system("del $f_name")){
					$this->f_err=null;
					return true;
				}
				else{
					$this->f_err='Cannot delete File: Permission denied.';
					return false;
				}
			}
			else{
			$this->f_err='File does not exists.';
			return false;
			}
		}
		else{
			$this->f_err='File does not exists.';
			return false;
		}
	}

	// MOVE FILES
	//				./picture/image.jpg		./gallery/photo.jpg
	function movFs($old_loc,$new_loc)
	{
		$new_dir_1=@pathinfo($new_loc);
		$new_dir_2=$new_dir_1["dirname"];
		$new_dir_3=$new_dir_1["basename"];
		if(@is_file($old_loc)){
			if(@is_dir($new_dir_2)){
				if(@file_exists($new_loc)){
					$this->f_err='File already exists.'; 	return false;
				}
				else{
					if(@copy($old_loc,$new_loc)){
						if($this->delFs($old_loc)){
							$this->f_err=null;
							return true;
						}
						else{
							$this->f_err='File was copied, but not moved.';
							return false;
						}
					}
					else{
						$this->f_err='File cannot be copied/moved.';
						return false;
					}
				}
			}
			else{
				if(@mkdir($new_dir_2, 0700)){
					if(@copy($old_loc,$new_loc)){
							if(@unlink("$old_loc")){
								$this->f_err=null;
								return true;
							}
							else
							if(@exec("del $old_loc")){
								$this->f_err=null;
								return true;
							}
							else if(@system("del $old_loc")){
								$this->f_err=null;
								return true;
							}
							else{
								$this->f_err=null;
								return true;
							}
					}
					else{
						$this->f_err='File cannot be copied/moved.';
						return false;
					}
				}
				else{
					$this->f_err='File already exists.';
					return false;
				}
			}
		}
		else{
			$this->f_err='File does not exists.';
			return false;
		}
	}

	function copFs($old_file,$new_file){

		if(@file_exists($old_file))	{
			if(@copy($oldRoot.$file,$newRoot.$file)){
				$this->f_err=null; return true;
			}
			else{
				$this->f_err='Cannot copy the file.';
				return false;
			}
		}
	}

	// DOWNLOAD FILE
	//	./pictures/photo.jpg		picture.jpg 'Client picture'

	function dowFs($server_file, $client_file)
	{
		// this will get a mime type to be used in as mime-force-download
		$_phase1_mime=@explode('.',"$server_file");
		$_phase2_mime=@count($_phase1_mime)-1;
		$_phase3_mime=@strtolower($_phase1_mime[$_phase2_mime]);
		$size=@filesize($server_file);
		if(is_file($server_file)){
			if(@file_exists($server_file)){

				@header("Content-Type: application/force-download; name$server_file");
				@header( "Content-type: application/$_phase3_mime-force-download" );
				@header( "Content-Description: File Transfert");
				@header("Content-Transfer-Encoding: binary");
				@header( "Content-Disposition: filename=".$client_file);
				@header( "Content-Length: $size");
				@header( "Expires: 0");
				@header( "Cache-Control: no-cache, must-revalidate");
				@header( "Pragma: no-cache");
				@readfile("$server_file");
				@exit;
				$this->f_err=null; return true;
			}
			else{
				$this->f_err='File does not exist.';  return false;
			}
		}
		else{
			$this->f_err='Cannot download a directory/folder: please specify a file.';  return false;
		}
	}

	// GET ERROR MESSAGES
	function get_err()
	{
		return $this->f_err;
	}








}


}
?>