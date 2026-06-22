<?php


// Gravity Forms remove TabIndex
add_filter("gform_tabindex", fn() => false);

// Gravity Forms remove Scroll to submit
add_filter("gform_confirmation_anchor", fn() => false);

?>