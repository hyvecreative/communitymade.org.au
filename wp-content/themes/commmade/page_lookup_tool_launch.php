<?php
/*
Template Name: lookup tool launch
*/
?><?php get_header(); ?>


<main>
<article>
	
<div class="container-fluid page-feature clean-header">

	<div class="container page-container">
		<div class="row">
				<div class="col-12 pg-feature-text" style="display: flex; align-items: flex-end;">
						<h1 data-aos="fade-up"><?php the_title(); ?></h1>
				</div>
		</div>
	</div>
		
</div>

<!-- begin introduction -->

<div class="container-fluid">
	<div id="content" class="container page-content">
		<div class="row">
            <div class="col-12">
            <?php if ( get_field('show_modified_date') ) : ?>
                    <div class="mod-date">
                        Last updated: <?php echo get_the_modified_date( 'j F Y' ); ?>
                    </div>
            <?php endif; ?>
                </div>
        </div>
        
		<div class="row gutter-lg" style="min-height: 800px;">
            
             
            
			<div class="col-lg-6" style="margin-top: .5rem;">
                
                <?php the_field('look_up_left_top'); ?>
                
                <div id="advisor-lookup" class="advisor-lookup">
                    <div class="advisor-form"><input type="text" id="search" placeholder="Name of the adviser or advice company">
                    <button id="advisorBtn" class="btn">Search</button>
                    </div>
                    <div id="results"></div>
                </div>
                
                <?php the_field('look_up_left_bottom'); ?>
                
            </div>
            
            <div class="col-lg-6">

				
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<?php the_content(__('(more...)')); ?>

				<?php endwhile; else: ?>
				<p><?php _e('Sorry, no pages are available.2'); ?></p>
				<?php endif; ?>

			</div>
	
	</div>
	</div>
</div>

	
</article>
</main>

<!-- list html anchors -->
<script>
document.addEventListener("DOMContentLoaded", function() {
  // Select all anchor links inside page-content that link to an ID
  const anchors = document.querySelectorAll(".page-content a[href^='#']");

  anchors.forEach(anchor => {
    anchor.addEventListener("click", function(e) {
      e.preventDefault(); // Prevent default jump

      const targetId = this.getAttribute("href").substring(1); // remove #
      const targetElement = document.getElementById(targetId);

      if (targetElement) {
        const navOffset = 130; // 90px nav + 30px extra
        const elementPosition = targetElement.getBoundingClientRect().top;
        const offsetPosition = elementPosition + window.pageYOffset - navOffset;

        window.scrollTo({
          top: offsetPosition,
          behavior: "smooth" // smooth scroll
        });
      }
    });
  });
});
</script>

<script>
fetch('/wp-content/themes/superback/data/advisers.json')
    .then(r => r.json())
    .then(data => {

        const searchField = document.querySelector('#search');
        const results = document.querySelector('#results');
        const btn = document.querySelector('#advisorBtn');

        function runSearch() {
            const q = searchField.value.toLowerCase().trim();

            // Hide results if nothing typed
            if (!q) {
                results.innerHTML = '';
                results.style.display = 'none';
                return;
            }

            // Show results container once search runs
            results.style.display = 'block';

            // Filter matches
            const matches = data.filter(row =>
                row.adv_rep_num.toLowerCase().includes(q) ||
                row.adv_rep_name.toLowerCase().includes(q)
            );

            // No results
            if (matches.length === 0) {
                results.innerHTML = `
                    <div class="no-results" style="color: red;">
                        No advisers found matching "<strong>${q}</strong>".<br>
                        Try checking the spelling.
                    </div>
                `;
                return;
            }

            // Display results
            results.innerHTML = matches.map(m => `
                <div class="record">
                    <strong>${m.adv_rep_name}</strong> (${m.adv_rep_num})<br>
                    <strong>Works for:</strong> ${m.appoint_name} (${m.appoint_num})<br>
                    <strong>Start and end dates:</strong> ${m.start_date} → ${m.end_date}<br>
                    <strong style="color: red;">Complain to AFCA about:</strong><br>
                    ${m.afsl_name} (${m.afsl_num})
                </div>
            `).join('');
        }

        // Button click
        btn.addEventListener('click', runSearch);

        // Enter key
        searchField.addEventListener('keydown', e => {
            if (e.key === 'Enter') runSearch();
        });

    });
</script>




    
<?php get_footer(); ?>





