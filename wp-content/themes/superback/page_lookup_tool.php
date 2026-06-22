<?php
/*
Template Name: lookup tool
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
fetch('/wp-content/themes/superback/data/advisers.json')
    .then(r => r.json())
    .then(data => {

        // Preserve original data order
        data.forEach((row, i) => row.__index = i);

        const searchField = document.querySelector('#search');
        const results = document.querySelector('#results');
        const btn = document.querySelector('#advisorBtn');

        // --- Levenshtein distance ---
        function levenshtein(a, b) {
            const m = a.length, n = b.length;
            if (m === 0) return n;
            if (n === 0) return m;

            const matrix = Array.from({ length: m + 1 }, () => []);

            for (let i = 0; i <= m; i++) matrix[i][0] = i;
            for (let j = 0; j <= n; j++) matrix[0][j] = j;

            for (let i = 1; i <= m; i++) {
                for (let j = 1; j <= n; j++) {
                    const cost = a[i - 1] === b[j - 1] ? 0 : 1;
                    matrix[i][j] = Math.min(
                        matrix[i - 1][j] + 1,
                        matrix[i][j - 1] + 1,
                        matrix[i - 1][j - 1] + cost
                    );
                }
            }
            return matrix[m][n];
        }

        function fuzzyMatch(token, word) {
            if (word.includes(token)) return true;

            const distance = levenshtein(token, word);

            if (word.length <= 5) return distance <= 1;
            return distance <= 2;
        }

        function runSearch() {
            const q = searchField.value.toLowerCase().trim();

            if (!q) {
                results.innerHTML = '';
                results.style.display = 'none';
                return;
            }

            results.style.display = 'block';

            const tokens = q.split(/\s+/);

            let matches = data.filter(row => {
                const name = row.adv_rep_name.toLowerCase();
                const rep = row.adv_rep_num.toLowerCase();
                const nameWords = name.split(/\s+/);

                // Adviser number always allowed
                if (rep.includes(q)) return true;

                let hits = 0;
                tokens.forEach(token => {
                    if (nameWords.some(word => fuzzyMatch(token, word))) {
                        hits++;
                    }
                });

                return tokens.length === 1
                    ? hits >= 1
                    : hits >= 2;
            });

            // 🔒 Enforce original JSON order
            matches.sort((a, b) => a.__index - b.__index);

            if (matches.length === 0) {
                results.innerHTML = `
                    <div class="no-results" style="color: red;">
                        No advisers found matching "<strong>${q}</strong>".<br>
                        Try checking the spelling.
                    </div>
                `;
                return;
            }

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

        btn.addEventListener('click', runSearch);

        searchField.addEventListener('keydown', e => {
            if (e.key === 'Enter') {
                e.preventDefault();
                runSearch();
            }
        });

    })
    .catch(err => {
        console.error('Adviser lookup failed:', err);
    });
</script>






    
<?php get_footer(); ?>





