<?php

/**
 * Handle file uploads via regular form post (uses the $_FILES array)
 */
class UploadedForm {
    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function save($path) {
        if(!move_uploaded_file($_FILES['file']['tmp_name'], $path)){
            return false;
        }
        return true;
    }
    function getName() {
        return $_FILES['file']['name'];
    }
    function getSize() {
        return $_FILES['file']['size'];
    }
}

class UploadedFile {
    private $allowedExtensions = array();
    private $sizeLimit = 10485760;
    private $file;
	private $fileName = false;
	private $ext = false;
	private $user_file_name = false;

    function __construct(array $allowedExtensions = array(), $sizeLimit = 10485760){
        $allowedExtensions = array_map("strtolower", $allowedExtensions);

        $this->allowedExtensions = $allowedExtensions;
        $this->sizeLimit = $sizeLimit;

        $this->checkServerSettings();
		
		if (isset($_FILES['file'])) {
            $this->file = new UploadedForm();
        } else {
            $this->file = false;
        }
    }

    private function checkServerSettings(){
        $postSize = $this->toBytes(ini_get('post_max_size'));
        $uploadSize = $this->toBytes(ini_get('upload_max_filesize'));

        if ($postSize < $this->sizeLimit || $uploadSize < $this->sizeLimit){
            $size = max(1, $this->sizeLimit / 1024 / 1024) . 'M';
            die("{'error':'increase post_max_size and upload_max_filesize to $size'}");
        }
    }

    private function toBytes($str){
        $val = trim($str);
        $last = strtolower($str[strlen($str)-1]);
        switch($last) {
            case 'g': $val *= 1024;
            case 'm': $val *= 1024;
            case 'k': $val *= 1024;
        }
        return $val;
    }
	
	public function setFileName($name){
		$this->fileName = $name;
	}
	
	public function getFileName(){
		return $this->fileName;
	}
	
	public function getFileExt(){
		return $this->ext;
	}
	
	public function getUserFileName(){
		return $this->user_file_name;
	}

    /**
     * Returns array('success'=>true) or array('error'=>'error message')
     */
    function handleUpload($uploadDirectory, $replaceOldFile = FALSE){
        if (!is_writable($uploadDirectory)){
            return array('error' => Yii::t('Front', "Server error. Upload directory isn't writable."));
        }

        if (!$this->file){
            return array('error' => Yii::t('Front', 'No files were uploaded.'));
        }

        $size = $this->file->getSize();

        if ($size == 0) {
            return array('error' => Yii::t('Front', 'File is empty'));
        }

        if ($size > $this->sizeLimit) {
            return array('error' => Yii::t('Front', 'File is too large'));
        }

        $pathinfo = pathinfo($this->file->getName());
		if($this->getFileName()){
			$filename = $this->getFileName();
			$this->user_file_name = $pathinfo['filename'];
		} else {
			$filename = $pathinfo['filename'];
		}
        $ext = $pathinfo['extension'];
		$this->ext = $pathinfo['extension'];
		
        if($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)){
            $these = implode(', ', $this->allowedExtensions);
            return array('error' => Yii::t('Front', 'File has an invalid extension, it should be one of :ext.', array(':ext' => $these)));
        }

        if(!$replaceOldFile){
            /// don't overwrite previous files that were uploaded
            while (file_exists($uploadDirectory . $filename . '.' . $ext)) {
                $filename .= rand(10, 99);
            }
        }

        if ($this->file->save($uploadDirectory . $filename . '.' . $ext)){
            return array('success'=>true,'filename'=>$filename.'.'.$ext);
        } else {
            return array('error'=> Yii::t('Front', 'Could not save uploaded file. The upload was cancelled, or server error encountered'));
        }

    }
}
