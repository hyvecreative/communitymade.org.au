<?php /* Template For News */ ?>
<?php get_header(); $enteredCat = htmlspecialchars($_GET["cat"]); $ID = 222; ?>


<div class="section-page-banner post-page campaigns-hub ideas-hub">
	<div class="container no-gutter">
		<div class="row row-eq-height no-gutter">
			<div class="col-lg-6 no-gutter left-column" style="background-image:url('<?php the_field( 'feature_image', $ID ); ?>');">
        <img class="visible-xs" src="<?php if (get_field( 'feature_image_wide', $ID )) { the_field( 'feature_image_wide', $ID ); } else { the_field( 'feature_image', $ID ); } ?>" alt="Image" />
			</div>
			<div class="col-lg-6 no-gutter right-column">
				<div class="vert-align-parent">
					<div class="vert-align-child">
						<h1><?php echo get_the_title( $ID ); ?><span>.</span></h1>
						<p><?php echo the_field( 'actions_intro_paragraph', $ID ); ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="share-this blog-post">
		<p>Share this content <a class="twitter-share" href="https://twitter.com/intent/tweet?text=Check%20out%20this%20page%20<?php the_permalink(); ?>" target="_blank"><i class="fab fa-twitter"></i></a> <a class="facebook-share" href="http://www.facebook.com/share.php?u=<?php the_permalink(); ?>" target="_blank"><i class="fab fa-facebook-f"></i></a></p>
	</div>
</div>


<div class="section-listing blog-page news-blog">
	<div class="container">
		<div id="results" class="row first-row">
			<div class="col-md-4"><p><span>FILTER</span> THESE RESULTS</p></div>
			<div class="col-md-8">
				<ul class="basic-x">
					<li>
						<select name="categories" id="categories">
							<option value="all" selected>All Categories</option>
							<?php
						    $categories = get_categories( array( 'taxonomy' => 'media_categories', 'orderby' => 'name', 'order' => 'ASC' ) );
						    foreach( $categories as $category ) {
									if ($enteredCat == esc_html( $category->slug ))
									{
										echo '<option selected value="' . esc_html( $category->slug ) . '">' . esc_html( $category->name ) . '</option>';
									}
									else
									{
									  echo '<option value="' . esc_html( $category->slug ) . '">' . esc_html( $category->name ) . '</option>';
									}
						    }
						  ?>
						</select>
					</li>
					<li><a href="/" id="filter-posts" class="button-basic">Go</a></li>
				</ul>
			</div>
		</div>
		<div class="row second-row">
			<?php $queryCat = ''; if (isset($_GET["cat"])) { $queryCat = htmlspecialchars($_GET["cat"]); } ?>
			<?php
			  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			  if ($queryCat != '') {
			    $args = array( 'post_type' => 'media-and-news', 'orderby' => 'date', 'order' => 'DESC', 'paged' => $paged,
												 'tax_query' => array( array( 'taxonomy' => 'media_categories', 'field'    => 'slug', 'terms' => $queryCat )));
			  } else {
			    $args = array( 'post_type' => 'media-and-news', 'orderby' => 'date', 'order' => 'DESC', 'paged' => $paged );
			  }
			  $postlist = new WP_Query( $args );
			  while ( $postlist -> have_posts() ) : $postlist -> the_post();
			    get_template_part( 'template-parts/content', "single-news" );
			  endwhile;
			?>
		</div>
	</div>
</div>


<div class="section-posts-pagination">
  <div class="container">
    <div class="row">
			<div class="col-md-3"></div>
      <div class="col-md-9">
        <?php kriesi_pagination( $postlist->max_num_pages ); ?>
        <?php wp_reset_query(); ?>
      </div>
    </div>
  </div>
</div>


<?php get_footer(); ?>
