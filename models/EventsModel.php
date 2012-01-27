<?php

/*
 * Model file to map with events database table
 */
class EventsModel
{
	// Class properties
	public $event_id;
	public $user_id;
	public $title;
	public $summary;
	public $logo;
	public $category_id;
	public $location;
	public $href;
	public $start_date;
	public $end_date;
	public $is_active;
	public $total_attending;
	public $create_date;
	
	

	// Class configuration
	static $table = 'events';
	static $id_field = 'event_id';
	static $name_field = 'title';
}
?>
