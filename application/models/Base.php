<?php
class Model_Base extends Doctrine_Record
{
    protected $_filters = array();

    public function createQuery($alias){
    	$q = $this->getTable()->createQuery($alias);
    	$q	->addWhere('is_deleted = 0')
    		->addOrderBy('id DESC');
    	return $q;
    }
    
    public function delete()
    {
        $this->is_deleted  = true;
        $this->save();
    }
    /**
     * Return all records
     * @param boolean $descendant
     * @throws Doctrine_Record_Exception
     */
    public function findAll(){
    	$q = $this->createQuery('r');
    	return $q->execute();
    }
    /**
     * 
     * @param integer $value
     * @param integer $hydrationMode
     * 
     * @return Model_*
     */
    public function findOneById($value)
    {
    	$q = $this->createQuery('r');
    	$q	->	addWhere('r.id = ?', $value)
    	-> limit(1);
    	return $q->fetchOne();
    }
    /**
     * 
     * @param string $key
     * @param string $value
     */
    public function findOneBy($key,$value)
    {
        $q = $this->createQuery('r');
        $q	->	addWhere("r.$key = ?", $value)
        	-> limit(1);
        return $q->fetchOne();
    }
    
    public function findLast($limit){
    	$q = $this->createQuery('r')
    		->limit($limit);
    	return $q->execute();
    }
    
}
?>