<?php

class EventRepository
{
    /**
     * @var Sparrow
     */
    protected $db;

    public function __construct(Sparrow $db)
    {
        $this->db = $db;
    }

    public function getActiveEvents($order = 'ASC')
    {
        $this->db->from('events');
		$this->db->where('is_active = ', 1);
		$order ? $this->db->orderBy('event_id', $order) : "";
		return $this->db->many();
    }
	
	public function getEvents($criteria)
    {
		//if()
        return $this->db->from('events')
                    ->where('is_active = ', 1)
                    ->many();
    }

    public function getActiveEventsByCategory($categoryId)
    {
        return $this->db
				->from('events')
				->join('categories_events', array(
					'categories_events.event_id' => 'events.event_id',
					'category_id' => $categoryId,
					))
				->where('is_active = ', 1)
				->many();
    }

    public function getEventById($eventId)
    {
        return $this->db->from('events')
                    ->where('event_id = ', $eventId)
                    ->one();
    }

    public function create($data)
    {
        $data['user_id'] = $_SESSION['user']['user_id'];

        // make array of selected category id from tokenize input
        $category_ids = explode(',', $data['category_id']);

        /* unset the tokenize input we don't want to use that in event table
         * we have now multiple category
         */
        unset ($data['category_id']);

        $this->db->from('events')
             ->insert($data)
             ->execute();

        $inserted_event_id = $this->db->insert_id;

        //make the insert sql from array of selected category id
        if($inserted_event_id){
            $categories_events_values = array();
            foreach ($category_ids as $category_id){
                $categories_events_values[] = "($category_id, $inserted_event_id)";
            }
            if(count($categories_events_values) > 0 ){
                $values = implode(', ', $categories_events_values);
                $this->db->from('categories_events')
                        ->sql("INSERT INTO categories_events (category_id, event_id) VALUES $values;")
                        ->execute();
            }
        }
        return $inserted_event_id;
    }
	
	public function search($searchString)
	{
		$this->db->reset();
		return $this->db->sql(
			"SELECT *, MATCH(title, summary, location) AGAINST('$searchString')".' AS score '."
			FROM events WHERE 
			MATCH(title, summary, location) AGAINST('$searchString') 
			ORDER BY score DESC"
		)->many();
	}
}