<?php

include_once 'header.php';

if (!empty($_POST)) {

    $eventId = App::getRepository('Event')->create($_POST);

    $_SESSION['flash']['type']    = 'success';
    $_SESSION['flash']['message'] = 'Successfully added event!.';
    header('Location: ' . ViewHelper::url('?page=event&id=' . $eventId, true));
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

            <h2>Submit an event!</h2>

            <p class="align-justify">Submit your event here to be included on Tech Adda. The site is aimed at events with sessions, where organisers are looking to use this as a tool to gather feedback.</p>

            <div class="post-comment">
				<?php if(isset ($_SESSION['user'])){ ?>
					<form id="add-event" action="<?php ViewHelper::url('?page=add-event') ?>" class="form-stacked" method="post">

						<div class="clearfix">
							<label for="xlInput3">Event Title:*</label>
                            <label for="title" generated="false" class="error"></label>
							<div class="input">
								<input class="xxlarge" id="title" name="title" size="30" type="text">
							</div>
						</div>

						<div class="clearfix">
							<label for="xlInput3">Event Description:*</label>
                            <label for="summary" generated="false" class="error"></label>
							<div class="input">
								<textarea class="xxlarge" id="summary" name="summary" rows="7" cols="50"></textarea>
							</div>
						</div>

						<div class="clearfix">
							<label for="xlInput3">Category:*</label>
                            <label for="category_id" generated="false" class="error"></label>
							<div class="input">
                                <input class="xxlarge" id="category_id" name="category_id" size="30" type="text">
							</div>
						</div>

						<div class="clearfix">
							<label for="xlInput3">Venue:</label>
							<div class="input">
								<input class="xlarge" id="location" name="location" size="30" type="text">
							</div>
						</div>

						<div class="clearfix">
							<label for="xlInput3">URL:</label>
                            <label for="href" generated="false" class="error"></label>
							<div class="input">
								<input class="xlarge" id="href" name="href" size="30" type="text">
							</div>
						</div>

						<div class="clearfix">
							<label for="xlInput3">From:*</label>
                            <label for="start_date" generated="false" class="error"></label>
							<div class="input">
								<input class="small" id="start_date" name="start_date" size="30" type="text">
								<span class="help-block">Please enter date in this format: mm/dd/yyyy.</span>
							</div>
						</div>

						<div class="clearfix">
							<label for="xlInput3">To:*</label>
                            <label for="end_date" generated="false" class="error"></label>
							<div class="input">
								<input class="small" id="end_date" name="end_date" size="30" type="text">
								<span class="help-block">Please enter date in this format: mm/dd/yyyy.</span>
                                
							</div>
						</div>

						<div class="clearfix">
							<label for="xlInput3">Logo:</label>
							<div class="input">
								<input class="xlarge" id="logo" name="logo" size="30" type="text">
								<span class="help-block">The logo should be of dimension 90x90.</span>
							</div>
						</div>

						<input type="submit" class="btn primary" value="Submit" />

					</form>
					<script type="text/javascript">
                      $(document).ready(function(){
                          $("form#add-event").validate({
                            rules: {
                              title: "required",
                              summary: "required",
                              category_id: {
                                required: true
                              },
                              href: {
                                url: true
                              },
                              start_date: {
                                required: true,
                                date: true
                              },
                              end_date: {
                                required: true,
                                date: true
                              }
                            },
                            ignore: ""
                          });

                          $( "#start_date" ).datepicker({
                            changeMonth: true,
                            changeYear: true,
                            showOn: "both",
                            buttonImage: "<?php echo ViewHelper::url("assets/images/icons/calendar.gif") ?>"
                          });
                          $( "#end_date" ).datepicker({
                            changeMonth: true,
                            changeYear: true,
                            showOn: "both",
                            buttonImage: "<?php echo ViewHelper::url("assets/images/icons/calendar.gif") ?>"
                          });
                        });
                        $("input#category_id").tokenInput(<?php echo json_encode($categories_for_tokenizer); ?>, {
                            theme: "facebook",
                            preventDuplicates: true,
                            propertyToSearch: 'name',
                            hintText: "Type category name here, from result select one/multiple",
                            animateDropdown: true});
                    </script>
				<?php } else{ ?>
                    <p>Please sign in with <a href="<?php ViewHelper::url('?page=login&type=yahoo') ?>">Yahoo</a> or <a href="<?php ViewHelper::url('?page=login&type=google') ?>">Google</a> to create a new event.</p>
                <?php } ?>
            </div>

        </div>

        <div class="span4">

            <div class="widget">

                <h4>Categories</h4>

                <ul>
                    <?php foreach ($categories as $category): ?>
                    <li><a href="<?php ViewHelper::url('?page=cat&id=' . $category['category_id']) ?>"><?php echo $category['title'] ?></a></li>
                    <?php endforeach; ?>
                </ul>

            </div>

            <div class="widget">

                <h4>Submit your event</h4>

                <p>Arranging an event that is not listed here? Let us know! We love to get the word out about events the community would be interested in.</p>
                <p style="text-align: center;"><a href="<?php ViewHelper::url('?page=add-event') ?>" class="btn success">Submit your event!</a></p>


            </div>

        </div>

    </div>

</div>

<?php include_once 'footer.php'; ?>