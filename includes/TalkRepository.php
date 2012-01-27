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
}