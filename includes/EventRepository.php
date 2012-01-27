<?php

class EventRepository {

    /**
     * @var Sparrow
     */
    protected $db;

    public function __construct(Sparrow $db) {
        $this->db = $db;
    }

    public function getActiveEvents($order = 'ASC') {
        $this->db->from('events');
        $this->db->where('is_active = ', 1);
        $order ? $this->db->orderBy('event_id', $order) : "";
        return $this->db->many();
    }

    public function getUpcomingEvents($order = 'ASC') {
        $this->db->from('events');
        $this->db->where(array('is_active = ' => 1, 'start_date >=' => date('Y-m-d')));
        $order ? $this->db->orderBy('start_date', $order) : "";
        return $this->db->many();
    }

    public function getEvents($criteria) {
        //if()
        return $this->db->from('events')
                ->where('is_active = ', 1)
                ->many();
    }

    public function getActiveEventsByCategory($categoryId) {
        return $this->db
                ->from('events')
                ->join('categories_events', array(
                    'categories_events.event_id' => 'events.event_id',
                    'category_id' => $categoryId,
                ))
                ->where('is_active = ', 1)
                ->many();
    }

    public function getEventById($eventId) {
        return $this->db->from('events')
                ->where('event_id = ', $eventId)
                ->one();
    }

    public function create($data) {
        $data['user_id'] = $_SESSION['user']['user_id'];

        // make array of selected category id from tokenize input
        $category_ids = explode(',', $data['category_id']);

        /* unset the tokenize input we don't want to use that in event table
         * we have now multiple category
         */
        unset($data['category_id']);

        $this->db->from('events')
                ->insert($data)
                ->execute();

        $inserted_event_id = $this->db->insert_id;

        //make the insert sql from array of selected category id
        if ($inserted_event_id) {
            $categories_events_values = array();
            foreach ($category_ids as $category_id) {
                $categories_events_values[] = "($category_id, $inserted_event_id)";
            }
            if (count($categories_events_values) > 0) {
                $values = implode(', ', $categories_events_values);
                $this->db->from('categories_events')
                        ->sql("INSERT INTO categories_events (category_id, event_id) VALUES $values;")
                        ->execute();
            }
        }

        $fileDir = str_replace("\\", "/", APPPATH);
        $filename = $_FILES["logo"]["name"];
        $ext = explode(".", $filename);
        $new_file_name = time() . "." . $ext[1];

        move_uploaded_file($_FILES["logo"]["tmp_name"], $fileDir . '/upload/' . $new_file_name);

        $this->db->from('events')
                ->where(array('event_id' => $inserted_event_id))
                ->update(array('logo' => $new_file_name))
                ->execute();

        return $inserted_event_id;
    }

    public function search($searchString) {
        $this->db->reset();
        return $this->db->sql(
                "SELECT *, MATCH(title, summary, location) AGAINST('$searchString' IN BOOLEAN MODE)" . ' AS score ' . "
			FROM events WHERE 
			MATCH(title, summary, location) AGAINST('$searchString' IN BOOLEAN MODE) 
			ORDER BY score DESC"
        )->many();
    }

    public function addAttendee($event_id, $user_id) {
        $this->db->from('attendees')
                ->insert(array('event_id' => $event_id, 'user_id' => $user_id))
                ->execute();
        $total_attending = $this->getTotalAttending($event_id);
        $total_attending += 1;
        $this->setTotalAttending($event_id, $total_attending);
        return $total_attending;
    }

    public function getTotalAttending($event_id) {
        $event = $this->db->from('events')
                ->select('total_attending')
                ->where('event_id = ', $event_id)
                ->one();
        return (int) $event['total_attending'];
    }

    public function setTotalAttending($event_id, $total_attending) {
        $this->db->from('events')
                ->where(array('event_id' => $event_id))
                ->update(array('total_attending' => $total_attending))
                ->execute();
    }

    public function isAttendee($event_id, $user_id) {
        $attendee = $this->db->from('attendees')
                ->where(array('event_id' => $event_id, 'user_id' => $user_id))
                ->one();
        return empty($attendee) ? false : true;
    }


    public function getWhoIsAttending($event_id){
        $this->db->reset();
        $this->db->select('attendees.event_id, users.user_id, users.email, users.name');
        $this->db->from('attendees');
        $this->db->join('users', array('attendees.user_id' => 'users.user_id' ));
        $this->db->where(array('event_id' => $event_id));
        return $this->db->many();
    }
}