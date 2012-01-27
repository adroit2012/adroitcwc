<?php

include_once 'header.php';

$activeEvents = App::getRepository('Event')->search($_REQUEST['search']);
$activeTalk = App::getRepository('Talk')->search($_REQUEST['search']);
$categories = App::getRepository('Category')->getAllCategories();

?>

<div class="content">

    <div class="row">

        <div id="main-content" class="span10">
            <?php ViewHelper::flushMessage(); ?>
            
            <h4>Search Result</h4>

			<div class="events">
			<?php if(isset ($activeEvents) && !empty ($activeEvents)) { ?>

                <?php foreach ($activeEvents as $event): ?>

                <div class="row event">

                    <div class="span2">
                        <?php if (!empty($event['logo'])): ?>
                            <img width="90px" height="90" src="<?php ViewHelper::url("upload/".$event['logo']); ?>" />
                        <?php else: ?>
                            <img src="http://placehold.it/90x90" />
                        <?php endif; ?>
                    </div>

                    <div class="span8">
                        <h3><a href="<?php ViewHelper::url('?page=event&id=' . $event['event_id']) ?>"><?php echo $event['title'] ?></a></h3>
                        <p class="align-justify"><?php echo $event['summary'] ?></p>
                    </div>

                </div>

                <?php endforeach; ?>
				
			<?php } ?>
			<?php if(isset ($activeTalk) && !empty ($activeTalk)){ ?>

                <?php foreach ($activeTalk as $talk): ?>

                <div class="row event">

                    <div class="span2">
                        <?php if (!empty($talk['logo'])): ?>
                            <img src="<?php echo $talk['logo'] ?>" />
                        <?php else: ?>
                            <img src="http://placehold.it/90x90" />
                        <?php endif; ?>
                    </div>

                    <div class="span8">
                        <h3><a href="<?php ViewHelper::url('?page=talk&id=' . $talk['talk_id']) ?>"><?php echo $talk['title'] ?></a></h3>
                        <p class="align-justify"><?php echo $talk['summary'] ?></p>
                    </div>

                </div>

                <?php endforeach; ?>
			<?php } ?>
			<?php if(empty ($activeEvents) && empty ($activeTalk)){ ?>
			<div class="alert-message block-message notice">
                <p>Sorry, no active events or talks found with your search criteria.</p>
            </div>
			<?php } ?>
			</div>

        </div>

        <?php include_once 'right-sidebar.php'; ?>

    </div>

</div>

<?php include_once 'footer.php'; ?>