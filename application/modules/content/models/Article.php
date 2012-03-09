<?php

/**
 * Article
 * 
 * @property Model_ArticleCategory category
 * @property Model_User createdBy
 * @property string publish
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Model_Article extends Model_BaseArticle
{
    public function setUp()
    {
        parent::setUp();
        
    	$this->hasOne('Model_ArticleCategory as category',array(
			'local'		=>	'category_id',
			'foreign'	=>	'id',
		));
    	
    	$this->hasOne('Model_User as createdBy',array(
    		'local'		=>	'created_by_id',
    		'foreign'	=>	'id',
    	));
    }
    /**
     * @return string
     */
    function getPublish()
    {
        return ( $this->is_published?'ถูกเผยแพร่':'ไม่เผยแพร่' );
    }
    /**
     *
     * Return lastest article by category in limitation
     *
     * @param int $categoryId
     * @param int $limit
     * @param int $hydrationMode
     *
     * @return mixed
     */
    public function findLastByCategory($categoryId,$limit=null){
    	$q = $this->createQuery('c');
    	$q	->addWhere('c.category_id = ?', $categoryId)
    	->addOrderBy('c.id DESC');
    	if(!empty($limit)) {
	        $q	->limit($limit);
	    }
    	return $q->execute();
    }
}