
<div class="row anchor-link-wrap">
				<div class="col-lg-5 anchor-link-title">
						<h2>On this page</h2>
				</div>
    
                <div class="col-lg-7 anchor-link-list">
						<?php if (have_rows('anchor_links')): ?>
                            <nav class="anchor-nav">
                                <ul style="margin-bottom: 0;">
                                    <?php while (have_rows('anchor_links')): the_row(); ?>
                                        <?php 
                                            $label = get_sub_field('label');
                                            $anchor = get_sub_field('anchor_id');
                                            $indent = get_sub_field('row_indent');
                                        ?>
                                        <li<?php echo !empty($indent) ? ' class="row-indent"' : ''; ?>>
                                            <a class="li-arrow" href="#<?php echo esc_attr($anchor); ?>">
                                            <?php echo esc_html($label); ?>
                                        </a></li>
                                    <?php endwhile; ?>
                                </ul>
                            </nav>
                        <?php endif; ?>
				</div>
</div>



