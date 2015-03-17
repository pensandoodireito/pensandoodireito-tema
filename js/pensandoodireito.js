/**
 * Created by DiRaOL on 11/03/15.
 */
jQuery(document).ready(function() {
    <!-- invoke the tooltip on any element with the class tooltiped -->
    //jQuery('.tooltiped').tooltip(); // Was meant to be used on the sidebar-publicacao

    <!-- invoke the date picker on any element with the class date-pick -->
    Date.firstDayOfWeek = 7;
    jQuery('.datePick').datepicker({
        dateFormat : 'dd/mm/yy'
    });
});