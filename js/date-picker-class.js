/**
 * Created by DiRaOL on 11/03/15.
 */
<!-- invoke the date picker on any element with the class date-pick -->
jQuery(document).ready(function() {
    Date.firstDayOfWeek = 7;
    jQuery('.datePick').datepicker({
        dateFormat : 'dd/mm/yy'
    });
});