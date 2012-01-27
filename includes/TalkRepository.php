<?php

class TalkRepository
{
    /**
     * @var Sparrow
     */
    protected $db;

    public function __construct(Sparrow $db)
    {
        $this->db = $db;
    }

    public function getTalksByEvent($eventId)
    {
        return $this->db->from('talks')
                    ->where('event_id = ', $eventId)
                    ->many();
    }

    public function getTalkById($talkId)
    {
        return $this->db->from('talks')
                    ->where('talk_id = ', $talkId)
                    ->one();
    }
	
	public function search($searchString)
	{
		$this->db->reset();
		return $this->db->sql(
			"SELECT *, MATCH(title, summary, speaker) AGAINST('$searchString' IN BOOLEAN MODE)".' AS score '."
			FROM talks WHERE 
			MATCH(title, summary, speaker) AGAINST('$searchString' IN BOOLEAN MODE) 
			ORDER BY score DESC"
		)->many();
	}

    public function rateTalk($talk_id, $rating){
        $this->db->reset();
        $talk = $this->getTalkById($talk_id);
        $new_rate_count = (int)$talk['rate_count'] + 1;
        $new_rating = ((double)($talk['rating'] * $talk['rate_count']) + (double)$rating) / $new_rate_count;
        $new_rating = round($new_rating, 1);
        $this->db->reset();
        $this->db->from('talks')
                 ->where(array('talk_id' => $talk_id))
                 ->update(array('rating' => $new_rating, 'rate_count' => $new_rate_count))
                 ->execute();
        $talk['rate_count'] = $new_rate_count;
        $talk['rating'] = $new_rating;
        return $talk;
        
    }
}