<?php

class CategoryRepository
{
    /**
     * @var Sparrow
     */
    protected $db;

    public function __construct(Sparrow $db)
    {
        $this->db = $db;
    }

    public function getAllCategories()
    {
        return $this->db->from('categories')
                    ->many();
    }

    public function getCategoryById($categoryId)
    {
        return $this->db->from('categories')
                    ->where('category_id = ', $categoryId)
                    ->one();
    }
	
	public function getCategoriesInEvents($eventID)
	{
		return $this->db
				->from('categories')
				->join('categories_events', array(
					'categories_events.category_id' => 'categories.category_id',
					'event_id' => $eventID,
					))
				->many();
	}
}