jQuery(document).ready(function() {
  let today = new Date();
  jQuery('.datetimepicker').datetimepicker(
    {
      startDate: today,
      minDate: today,
      format:'Y-m-d H:i:s',
    }
  );
});
