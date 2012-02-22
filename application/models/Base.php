<?php
class Model_Base extends Doctrine_Record
{

    public function createQuery($alias){
    	$q = $this->getTable()->createQuery($alias);
    	$q->addWhere('is_deleted = 0');
    	return $q;
    }
    
    public function delete()
    {
        $this->is_deleted  = true;
        $this->save();
    }
    
    public function findAll($hydrationMode=null){
    	$q = $this->createQuery('r');
    	return $q->execute(array(),$hydrationMode);
    }
    /**
     * 
     * @param integer $value
     * @param integer $hydrationMode
     * 
     * @return Model_*
     */
    public function findOneById($value,$hydrationMode = null){
    	$q = $this->createQuery('r');
    	$q	->	addWhere('r.id = ?', $value)
    	-> limit(1);
    	return $q->fetchOne(array(),$hydrationMode);
    }
    
    public function findLast($limit,$hydrationMode=null){
    	$q = $this->createQuery('r');
    	$q	->addOrderBy('r.id DESC')
    	->limit($limit);
    	return $q->execute(array(),$hydrationMode);
    }
}
?>