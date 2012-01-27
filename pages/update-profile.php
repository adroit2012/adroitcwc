<?php
if (!empty($_POST) && isset ($_SESSION['user'])) {

    //$eventId = App::getRepository('Event')->create($_POST);

    $updated_name = App::getRepository('User')->updateProfile($_SESSION['user']['user_id'], $_POST['full-name']);
    $_SESSION['user']['name'] = $updated_name;

    $_SESSION['flash']['type']    = 'success';
    $_SESSION['flash']['message'] = 'Name Successfully updated!.';
    //header('Location: ' . ViewHelper::url('?page=home', true));
    //exit;
}

$categories = App::getRepository('Category')->getAllCategories();
$categories_for_tokenizer = array();
foreach ($categories as $category) {
    $categories_for_tokenizer[] = array('id' => $category['category_id'], 'name' => $category['title']);
}
include_once 'header.php';
?>

<div class="content">

    <div class="row">

        <div id="main-content" class="span10">
            <?php ViewHelper::flushMessage(); ?>
            
            <h2>Update Profile</h2>
            
            <div class="post-comment">
				<?php if(isset ($_SESSION['user'])){ ?>
					<form id="add-event" action="<?php ViewHelper::url('?page=update-profile') ?>" class="form-stacked" method="post">

						<div class="clearfix">
							<label for="xlInput3">User Full Name:</label>
                            <label for="title" generated="false" class="error"></label>
							<div class="input">
                                <input class="xxlarge" id="title" name="full-name" size="30" type="text" value="<?php echo $_SESSION['user']['name'];?>">
							</div>
                        </div>

						<input type="submit" class="btn primary" value="Submit" />

					</form>
			
                <?php } ?>
            </div>

        </div>

        <?php include_once 'right-sidebar.php'; ?>

    </div>

</div>

<?php include_once 'footer.php'; ?>