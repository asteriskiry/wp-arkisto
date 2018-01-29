/**
 * Javascriptit admin-sivuille
 **/

/* Päivämäärän valitsin */

jQuery(document).ready(function() {
    jQuery( '.datepicker'  ).datepicker();
    jQuery( '.datepicker'  ).datepicker( "option", "showAnim", "slideDown" );
});

/* Kurssihaku */

function wparkFilter() {
    var input, filter, ul, li, div, i;
    input = document.getElementById('kurssi-input');
    filter = input.value.toUpperCase();
    ul = document.getElementById("kurssichecklist");
    li = ul.getElementsByTagName('li');

    for (i = 0; i < li.length; i++) {
        div = li[i].getElementsByTagName("div")[0];
        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}
