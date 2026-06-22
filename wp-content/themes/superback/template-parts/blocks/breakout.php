<?php
$heading = get_field('break_heading');
$content = get_field('break_content');
?>

<div class="container">
    <div class="row breakout-block">
                    <div class="col-12 breakout-inner">

            <?php if ($heading) : ?>
                <h2 data-aos="fade-down" data-aos-delay="100"><?php echo esc_html($heading); ?></h2>
            <?php endif; ?>

            <?php echo $content; ?>

        </div>
    </div>
</div>






