<?php
require_once 'phpThumb/ThumbLib.inc.php';

class My_Controller_Action_Helper_Image extends Zend_Controller_Action_Helper_Abstract
{
    
	public function createThumbnail($path,$fileInfo,$dimenstion)
    {
         
        //$thumbnail->addFilter('Rename', array('target'=>$path . '/' . $filename . '.jpg','overwrite'=>true));
        $thumb = PhpThumbFactory::create($fileInfo['thumbnail']['tmp_name']);
        $dim = $thumb->getCurrentDimensions();
        
        //adjust image dimensions
        $newDim = array();
        foreach ($dimenstion as $key=>$value) {
            
            if ($dim['width'] > $dim['height']) {
                
                $newDim[$key]['width'] = $value['width'];
                $newDim[$key]['height'] = $value['height'];
                
            } elseif ($dim['width'] < $dim['height']) {
                
                $newDim[$key]['width'] = $value['height'];
                $newDim[$key]['height'] = $value['width'];
                
            }
            
        }

        if (count($newDim)) {
            
            //Create directory, if not exists
            if (!file_exists($path)) {
            	if(!mkdir($path,null,true)) {
            		throw new Zend_Exception('Cannot create ' . $path . ' directory.');
            	}
            }
            
            //Create thumbnail
            foreach ($newDim as $key=>$value) {
                $thumb = PhpThumbFactory::create($fileInfo['thumbnail']['tmp_name']);
                $thumb->adaptiveResize($value['width'], $value['height'])->save($path . '/' . $key . '.jpg');
            }
            
        }
    }
}
?>