<?php

include_once 'header.php';

$talk = App::getRepository('Talk')->getTalkById($_GET['id']);
$event = App::getRepository('Event')->getEventById($talk['event_id']);
$comments = App::getRepository('Comment')->getCommentsByTalk($talk['talk_id']);
$categories = App::getRepository('Category')->getAllCategories();

?>

<div class="content">

    <div class="row">

        <div id="main-content" class="span10">

            <h2><?php echo $talk['title'] ?></h2>
            <div class="meta">
                by <strong><?php echo $talk['speaker'] ?></strong> <br />
                Talk at <a href="<?php ViewHelper::url('?page=event&id=' . $event['event_id']) ?>"><?php echo $event['title'] ?></a>
            </div>

            <p class="align-justify"><?php echo nl2br($talk['summary']) ?></p>

            <h3>Comments</h3>

            <div class="comments">
                <?php foreach ($comments as $comment): ?>
                <div class="comment">
                    <div class="meta"><strong><?php echo empty($comment['name']) ? $comment['email'] : $comment['name'] ?></strong> on <em><?php echo ViewHelper::formatDate($comment['create_date']) ?></em> said:</div>
                    <?php echo nl2br($comment['body']) ?>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="post-comment">
              <?php if(isset ($_SESSION['user'])){ ?>
                <h4>Write a comment:</h4>
                <form id="add-comment" action="<?php ViewHelper::url('?page=comment') ?>" class="form-stacked" method="post">

                    <textarea class="xxlarge" id="body" name="body" rows="7" cols="50"></textarea>
                    <span class="help-block">Please be polite in your comment as this is a social site.</span> <br />

                    <input type="hidden" value="<?php echo $talk['talk_id'] ?>" name="talk_id" />
                    <input type="submit" class="btn primary" value="Submit" />

                </form>
                <script type="text/javascript">
                  $(document).ready(function(){
                      $("form#add-comment").validate({
                        rules: {
                          body: "required"
                        }
                      });
                    });
                </script>
                <?php } else{ ?>
                  Please sign in with <a href="<?php ViewHelper::url('?page=login&type=yahoo') ?>">Yahoo</a> or <a href="<?php ViewHelper::url('?page=login&type=google') ?>">Google</a> to make a comment.
                <?php } ?>
            </div>

        </div>

        <?php include_once 'right-sidebar.php'; ?>

    </div>

</div>

<?php include_once 'footer.php'; ?>