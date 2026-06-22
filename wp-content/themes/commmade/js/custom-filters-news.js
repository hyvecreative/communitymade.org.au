jQuery(function($){
  $( "#filter-posts" ).click(function(){
    $selectedCategory = $( "#categories" ).find( 'option:selected' ).val();
    var $pageURL = [location.protocol, '//', location.host, location.pathname].join('');
    if ($selectedCategory != "all")
    {
      $pageURL += "/?cat=" + $selectedCategory;
    }
    $pageURL += "#results";
    $("#filter-posts").attr("href", $pageURL);
  })
});
