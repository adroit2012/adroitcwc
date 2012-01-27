<?php

include_once 'header.php';

$event = App::getRepository('Event')->getEventById($_GET['id']);
$talks = App::getRepository('Talk')->getTalksByEvent($_GET['id']);
$categories = App::getRepository('Category')->getAllCategories();

$event_categories = App::getRepository('Category')->getCategoriesInEvent($_GET['id']);
$event_categories_text = array();
foreach ($event_categories as $event_category) {
    $event_categories_text[] = "<a href='".ViewHelper::url('?page=cat&id=' . $event_category['category_id'], true)."'>".$event_category['title']."</a>";
}
$event_categories_text = "Category: " . implode(', ', $event_categories_text);
?>
<div class="content">

    <div class="row">

        <div id="main-content" class="span10">

            <?php ViewHelper::flushMessage(); ?>

            <div id="<?php echo $event['event_id']; ?>" class="row single-event">

                <div class="span2" style="padding: 10px 0 10px 10px;">
                    <?php if (!empty($event['logo'])): ?>
                        <img src="<?php echo $event['logo'] ?>" />
                    <?php else: ?>
                        <img src="http://placehold.it/90x90" />
                    <?php endif; ?>
                </div>

                <div class="span7">
                    <h2><?php echo $event['title'] ?></h2>
                    <div class="meta">
                        <?php echo ViewHelper::formatDate($event['start_date']) ?> - <?php echo ViewHelper::formatDate($event['end_date']) ?> <br />
                        <?php echo $event_categories_text; ?><br />
                        <?php echo $event['location'] ?><br />
                        <p id="attendance-text">
                            <?php if(isset ($_SESSION['user'])){?>
                                <?php if(App::getRepository('Event')->isAttendee($event['event_id'], $_SESSION['user']['user_id'])){?>
                                    <strong>You</strong> and <strong><?php echo (int)$event['total_attending'] > 0 ? ($event['total_attending'] - 1) : $event['total_attending']; ?> other people</strong> attending so far!
                                <?php }else{?>
                                    <strong><?php echo $event['total_attending'] ?> people</strong> attending so far! &nbsp;
                                    <a id="i-am-attending" href="#" class="btn small">I'm attending</a>
                                <?php }?>
                            <?php }else{?>
                                <strong><?php echo $event['total_attending'] ?> people</strong> attending so far! &nbsp;
                                <a id="i-am-attending" href="#" class="btn small">I'm attending</a>
                            <?php }?>
                        </p>
                    </div>
                </div>

            </div>
            <script type="text/javascript">
                attendance_url = '<?php ViewHelper::url('?page=attendance'); ?>';
            </script>
            <script src="<?php echo ViewHelper::url("assets/js/i-am-attending.js") ?>" type="text/javascript"></script>

            <p class="align-justify"><?php echo nl2br($event['summary']) ?></p>
            <p><strong>Event Link:</strong> <br /><a target="_blank" href="<?php echo $event['href'] ?>"><?php echo $event['href'] ?></a></p>

            <h3>Talks</h3>
            <ul>
                <?php foreach ($talks as $talk): ?>
                <li><a href="<?php ViewHelper::url('?page=talk&id=' . $talk['talk_id']) ?>"><?php echo $talk['title'] ?></a></li>
                <?php endforeach; ?>

            </ul>

        </div>

        <?php include_once 'right-sidebar.php'; ?>

    </div>

</div>

<?php include_once 'footer.php'; ?>