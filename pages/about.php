<?php

include_once 'header.php';

$activeEvents = App::getRepository('Event')->getActiveEvents();
$categories = App::getRepository('Category')->getAllCategories();

?>

<div class="content">

    <div class="row">

        <div id="main-content" class="span10">

            <h4>About</h4>

            <p>Tech Adda is the platform for sharing technical ideas and viewpoints. The site gives details of events past, present and future, the sessions, and speakers at each, and allows all attendees to register and leave feedback - for the sessions and for the event itself.</p>

        </div>

        <?php include_once 'right-sidebar.php'; ?>

    </div>

</div>

<?php include_once 'footer.php'; ?>