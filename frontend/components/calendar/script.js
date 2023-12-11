$(document).ready(function() {
  var calendarEl = document.getElementById('calendar');

  var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      // Aquí puedes agregar más opciones y eventos según sea necesario
  });

  calendar.render();
});