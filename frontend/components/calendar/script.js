function renderCalendar(events) {
  var initialLocaleCode = 'es';
  var calendarEl = document.getElementById('calendar');

  var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      locale: initialLocaleCode,
      events: events // Usa los eventos pasados como parámetro
      // Puedes agregar más opciones según sea necesario
  });

  calendar.render();
}
