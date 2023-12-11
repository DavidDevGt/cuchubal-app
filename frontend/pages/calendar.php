<head>
    <!-- FULL CALENDAR -->
    <script src="js/libs/index.global.min.js"></script>
    <script src="components/calendar/script.js"></script>
    <link rel="stylesheet" href="components/calendar/styles.css">
</head>

<div class="container mt-5">
    <h2>Calendario</h2>
    <?php include 'components/calendar/calendar.php'; ?>
</div>

<script>
    $(document).ready(function() {
        var userId = 2;
        $.ajax({
            url: '../backend/user/' + userId + '/payment-schedule',
            type: 'GET',
            success: function(data) {
                console.log('Eventos obtenidos:', data);
                var eventosFormateados = data.map(function(evento) {
                    var className = '';
                    switch (evento.status) {
                        case 'pendiente':
                            className = 'event-pendiente';
                            break;
                        case 'completado':
                            className = 'event-completado';
                            break;
                        case 'cancelado':
                            className = 'event-cancelado';
                            break;
                    }
                    return {
                        title: evento.amount + " - " + evento.status,
                        start: evento.scheduledDate,
                        end: evento.paymentDate, // Opcional
                        className: className, // Agrega la clase aquí
                        extendedProps: {
                            notes: evento.notes,
                            paymentMethod: evento.paymentMethod,
                            paymentConfirmed: evento.paymentConfirmed
                        }
                    };
                });
                renderCalendar(eventosFormateados); // Llama a la función renderCalendar con los eventos formateados
            },
            error: function(error) {
                console.error('Error al cargar los eventos:', error);
            }
        });
    });

    function renderCalendar(events) {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: events, // Usar los eventos pasados como parámetro
            eventRender: function(info) {
                // Aquí puedes implementar la lógica para mostrar tooltips o detalles adicionales
                var tooltip = new Tooltip(info.el, {
                    title: info.event.extendedProps.notes,
                    placement: 'top',
                    trigger: 'hover',
                    container: 'body'
                });
            },
            // Aquí puedes agregar más opciones según sea necesario
        });

        calendar.render();
    }
</script>