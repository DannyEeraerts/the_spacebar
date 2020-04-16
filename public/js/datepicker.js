jQuery(document).ready(function() {
  let today = new Date();
  let min = "01/" + "O1/" + (today.getFullYear() - 100);
  $('.js-datepicker').datepicker({
    format: "dd/mm/yyyy",
    startDate: min,
    endDate: today,
    clearBtn: true,
    calendarWeeks: true,
  });
});