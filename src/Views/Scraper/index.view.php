<?php if(empty($user_id)): ?>
    <p>Please specify a userid to fetch their data.</p>
<?php endif; ?>
<p><?php echo implode(", ", $protocol) ?></p>