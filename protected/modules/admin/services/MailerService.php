<?php

class MailerService {
    
    public static function getTemplates(){
        $langs = Languages::$languages;
		$files = array();
		$allFiles = array();
		$errors = array();
		$workFiles = array();
		foreach($langs as $lang){
			$files[$lang] = array();
			foreach(glob(YiiBase::getPathOfAlias('application.ext.mailer.views.'.$lang) . '/*.txt') as $file){
				$fileName = array_pop(explode('/', $file));
				$files[$lang][] = $fileName;
				$allFiles[] = $fileName;
			}
		}
		foreach($allFiles as $testFile){
			$goodFile = true;
			foreach($files as $lang => $langfiles){
				if(!in_array($testFile, $langfiles)){
					$errors[$lang] = $testFile;
					$goodFile = false;
				}
			}
			if($goodFile){
				$workFiles[$testFile] = $testFile;
			}
		}
		$workFiles = array_unique($workFiles);
		return array('workFiles' => $workFiles, 'errors' => $errors);
    }
}
