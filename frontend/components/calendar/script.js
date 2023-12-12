function renderCalendar(events) {
  var calendarEl = document.getElementById('calendar');

  var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      events: events // Usa los eventos pasados como parámetro
      // Puedes agregar más opciones según sea necesario
  });

  calendar.render();
}
