<section id="steps-section-<?php echo esc_attr($block['id']); ?>" class="steps-section <?php echo esc_attr($block['className'] ?? ''); ?>">
    <?php if( get_field('steps_heading') ): ?>
        <h2 class="steps-heading"><?php the_field('steps_heading'); ?></h2>
    <?php endif; ?>

    <?php if( get_field('steps_sub_heading') ): ?>
        <h3 class="steps-subheading"><?php the_field('steps_sub_heading'); ?></h3>
    <?php endif; ?>

    <div class="steps-innerblocks">
        <?php
        // Render saved inner blocks
        if( !empty($block['inner_content']) ) {
            echo apply_filters('the_content', $block['inner_content']);
        }
        ?>
    </div>
</section>

