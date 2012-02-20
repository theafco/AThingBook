<?php
class My_View_Helper_Thumbnail extends Zend_View_Helper_Abstract
{

    private $uploadUrl;
    private $uploadPath;
    
    public function __construct(){
        $configs = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('files');
        $this->uploadUrl = $configs['image_upload_url'];
        $this->uploadPath = $configs['image_upload_path'];
    }
    
    public function thumbnail(){
        return $this;
    }
    
	/**
	 * 
	 * @param string $urlOptions
	 * @return string
	 */
    public function url($urlOptions)
    {
        $relativePath = $this->getRelativePath($urlOptions);
        $absUrl = $this->uploadUrl . $relativePath;
        
        if (!file_exists($this->uploadPath . $relativePath)){
            $absUrl = '/images/no_image.jpg';
        }
        return $absUrl;
    }
    
    /**
     * 
     * @param mixed $url
     * @return boolean
     */
    public function isExist($url)
    {
        $imgUrl = ( (is_array($url)) ? $this->url($url) : $url );
        $info = new SplFileInfo($imgUrl);
        return ( ($info->getFilename() != 'no_image.jpg') ? true : false );
    }
    
    /**
     * Return image dimensions
     * 
     * @param string $imgUrl
     * @return mixed
     */
    public function getDimensions($imgUrl)
    {
        $dim = getimagesize('.' . $imgUrl);
        $dims = array();
        $dims['width'] = $dim[0];
        $dims['height'] = $dim[1];
        $dims['isHorizontal'] = $this->isHorizontal($dims);
        return $dims;
    }
    
    /**
     * Check whether dimensions is horizontal
     * 
     * @param array $dimensions
     * @return boolean
     */
    public function isHorizontal($dimensions)
    {
        return ( ($dimensions['width']>$dimensions['height']) ? true : false );
    }
    
    protected function getRelativePath($urlOptions)
    {
        if (array_key_exists('group', $urlOptions)) {
        	$relativePath .= '/' . $urlOptions['group'];
        }
        
        //         if (array_key_exists('cid', $urlOptions)) {
        //         	$absUrl .= '/' . $urlOptions['cid'];
        //         }
        
        if (array_key_exists('iid', $urlOptions)) {
        	$relativePath .= '/' . $urlOptions['iid'];
        }
        
        $relativePath .= '/thumbnail';
        $relativePath .= '/' . ((array_key_exists('size', $urlOptions)) ? $urlOptions['size']:'medium') . '.jpg';
        
        return $relativePath;
    }
}
?>