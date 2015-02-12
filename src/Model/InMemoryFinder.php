<?php

namespace Model;

class InMemoryFinder implements FinderInterface{
	
	private $tableau = array('TEST',
							'KOOL',
							'AND',
							'THE GANG',
							);
	
	/**
     * Returns all elements.
     *
     * @return array
     */
    public function findAll(){
		return $this->tableau;
	}

    /**
     * Retrieve an element by its id.
     *
     * @param  mixed      $id
     * @return null|mixed
     */
    public function findOneById($id){
		if(isset($this->tableau[$id]))
			return $this->tableau[$id];
		return null;
	}
    
}
