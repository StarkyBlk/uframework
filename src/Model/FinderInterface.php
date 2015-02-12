<?php

namespace Model;

interface FinderInterface
{
	const LIMIT = 20;
	const OFFSET = 0;
	
	
    /**
     * Returns all elements.
     *
     * @return array
     */
    public function findAll($limit = self::LIMIT , $offset = self::OFFSET);

    /**
     * Retrieve an element by its id.
     *
     * @param  mixed      $id
     * @return null|mixed
     */
    public function findOneById($id);
}
