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
            <?php ViewHelper::flushMessage(); ?>
            
            <h2><?php echo $talk['title'] ?></h2>
            <div class="meta">
                by <strong><?php echo $talk['speaker'] ?></strong> <br />
                Talk at <a href="<?php ViewHelper::url('?page=event&id=' . $event['event_id']) ?>"><?php echo $event['title'] ?></a>
                <div id="<?php echo $talk['talk_id'] ?>" class="stat">
                    <?php $talk['rating_stars_on'] = round((90 * $talk['rating']) / 5, 1); ?>
                    <div class="statVal">
                        <span class="ui-rater">
                            <span class="ui-rater-starsOff" style="width:90px;"><span class="ui-rater-starsOn" style="width:<?php echo $talk['rating_stars_on'];?>px"></span></span>
                            <span class="ui-rater-rating"><?php echo $talk['rating']; ?></span>&#160;(<span class="ui-rater-rateCount"><?php echo $talk['rate_count']; ?></span>)
                        </span>
                    </div>
                </div>
            </div>
            <p class="align-justify"><?php echo nl2br($talk['summary']) ?></p>
            <script type="text/javascript">
                $(function() {
                    $('#<?php echo $talk['talk_id'] ?>').rater({ postHref: '<?php ViewHelper::url('?page=rate-talk') ?>' });
                });
            </script>
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