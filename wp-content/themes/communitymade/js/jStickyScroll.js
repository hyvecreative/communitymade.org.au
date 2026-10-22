// Editing Instructions
// 1. Change '#your_div_id' to whatever the ID attribute of your DIV is
// 2. Change '175' to whatever the height of your header is, if you have no header, set to 0

/********************************
*   (C) 2009 - Thiago Barbedo   *
*   - tbarbedo@gmail.com        *
*********************************/
window.onscroll = function()
{
    if( window.XMLHttpRequest ) {
        if (document.documentElement.scrollTop > 175 || self.pageYOffset > 175) {
            $('#contentpeople').css('position','fixed');
            $('#contentpeople').css('top','0');
        } else if (document.documentElement.scrollTop < 175 || self.pageYOffset < 175) {
            $('#contentpeople').css('position','absolute');
            $('#contentpeople').css('top','175px');
        }
    }
}