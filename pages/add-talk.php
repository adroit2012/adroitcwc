<?php

include_once 'header.php';

if (!empty($_POST) && isset ($_SESSION['user'])) {

    $talkId = App::getRepository('Talk')->create($_POST);

    $_SESSION['flash']['type']    = 'success';
    $_SESSION['flash']['message'] = 'Successfully added talk!.';
    header('Location: ' . ViewHelper::url('?page=talk&id=' . $talkId, true));
    exit;
}

$categories = App::getRepository('Category')->getAllCategories();
$categories_for_tokenizer = array();
foreach ($categories as $category) {
    $categories_for_tokenizer[] = array('id' => $category['category_id'], 'name' => $category['title']);
}

?>

<div class="content">

    <div class="row">

        <div id="main-content" class="span10">

            <h2>Add a new talk!</h2>

            <p class="align-justify">Create your talk here to be included on Event. The site is aimed at events with sessions, where organizers are looking to use this as a tool to gather feedback.</p>

            <div class="post-comment">
				<?php if(isset ($_SESSION['user'])){ ?>
					<form id="add-talk" action="<?php ViewHelper::url('?page=add-talk') ?>" class="form-stacked" method="post">

						<div class="clearfix">
							<label for="xlInput3">Talk Title:*</label>
                            <label for="title" generated="false" class="error"></label>
							<div class="input">
								<input class="xxlarge" id="title" name="title" size="30" type="text">
							</div>
						</div>

						<input type="hidden" name="event_id" value="<?php echo $_REQUEST['id'] ?>">
						<div class="clearfix">
							<label for="xlInput3">Talk Description:*</label>
                            <label for="summary" generated="false" class="error"></label>
							<div class="input">
								<textarea class="xxlarge" id="summary" name="summary" rows="7" cols="50"></textarea>
							</div>
						</div>

						<div class="clearfix">
							<label for="xlInput3">speaker:</label>
							<label for="speaker" generated="false" class="error"></label>
							<div class="input">
								<input class="xlarge" id="speaker" name="speaker" size="30" type="text">
							</div>
						</div>

						<div class="clearfix">
							<label for="xlInput3">Slide Link:</label>
                            <label for="slide_link" generated="false" class="error"></label>
							<div class="input">
								<input class="xlarge" id="slide_link" name="slide_link" size="30" type="text">
							</div>
						</div>

						<input type="submit" class="btn primary" value="Submit" />

					</form>
					<script type="text/javascript">
                      $(document).ready(function(){
                          $("form#add-talk").validate({
                            rules: {
                              title: "required",
                              summary: "required",
                              slide_link: {
                                url: true
                              }
                            },
                            ignore: ""
                          });
					  });
                    </script>
				<?php } else{ ?>
                    <p>Please sign in with <a href="<?php ViewHelper::url('?page=login&type=yahoo') ?>">Yahoo</a> or <a href="<?php ViewHelper::url('?page=login&type=google') ?>">Google</a> to create a new event.</p>
                <?php } ?>
            </div>

        </div>

        <?php include_once 'right-sidebar.php'; ?>

    </div>

</div>

<?php include_once 'footer.php'; ?>