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
    <?php if(!empty($who_is_attending)): ?>
    <div class="widget">

		<h4>Who's attending</h4>
        <ul class="media-grid">
            <?php foreach ($who_is_attending as $attendee):?>
                <li>
                  <a data-placement="below" rel='twipsy' title='<?php echo $attendee['name'] ? $attendee['name'] : $attendee['email'] ?>' href="#">
                    <?php echo App::getRepository('User')->getGravatar($attendee['email'], 30) ;?>
                  </a>
                </li>
            <?php endforeach;?>
         </ul>
        <script type="text/javascript">
            $('ul.media-grid li a').twipsy();
        </script>
	</div>
    <?php endif; ?>

</div>