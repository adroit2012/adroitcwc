<?php

include_once 'header.php';

$activeEvents = App::getRepository('Event')->getActiveEvents('DESC');
$categories = App::getRepository('Category')->getAllCategories();

?>

<div class="content">

    <div class="row">

        <div id="main-content" class="span10">

            <h4>All Events</h4>

            <div class="events">

                <?php foreach ($activeEvents as $event): ?>

                <div class="row event">

                    <div class="span2">
                        <?php if (!empty($event['logo'])): ?>
                            <img src="<?php echo $event['logo'] ?>" />
                        <?php else: ?>
                            <img src="http://placehold.it/90x90" />
                        <?php endif; ?>
                    </div>

                    <div class="span8">
                        <h3><a href="<?php ViewHelper::url('?page=event&id=' . $event['event_id']) ?>"><?php echo $event['title'] ?></a></h3>
                        <p class="align-justify"><?php echo $event['summary'] ?></p>
                        <p>
                            <a href="<?php ViewHelper::url('?page=event&id=' . $event['event_id'] . '#comments') ?>"><?php echo $event['total_comments'] ?> comments</a> &nbsp;
                            <strong><?php echo $event['total_attending'] ?> attending</strong> &nbsp;
                            <?php if(isset ($_SESSION['user'])){?>
                                <a href="#" class="btn small">I'm attending</a> &nbsp;
                            <?php }?>
                        </p>
                    </div>

                </div>

                <?php endforeach; ?>
				<?php
//				$newEvent = new EventsModel();
//				$eventModel = App::loadModel('events');
//				/* @var $eventModel Sparrow */
//				$newEvent->user_id = 1;
//				$newEvent->category_id = 1;
//				$newEvent->end_date = '12/12/2012';
//				//$eventModel->create_date = '12/12/2012';
//				$newEvent->href = 'http://www.google.com';
//				$newEvent->is_active = 1;
//				$newEvent->location = 'Dhaka';
//				$newEvent->start_date = '12/12/2012';
//				$newEvent->summary = 'hello world!!!!';
//				$newEvent->title = 'hello again';
//				$eventModel->save($newEvent);
				
				?>
            </div>

        </div>

        <?php include_once 'right-sidebar.php'; ?>

    </div>

</div>

<?php include_once 'footer.php'; ?>