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
                        title: evento.participantName + ' - ' + evento.cuchubalName,
                        start: evento.scheduledDate,
                        end: evento.paymentDate, // Opcional
                        className: className, // Agrega la clase aquí
                        extendedProps: {
                            participantName: evento.participantName,
                            notes: evento.notes,
                            paymentMethod: upperFirstChar(evento.paymentMethod),
                            paymentConfirmed: evento.paymentConfirmed,
                            money: formatToQuetzales(evento.amount),
                            status: upperFirstChar(evento.status)
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
            locale: 'es',
            events: events, // Usar los eventos pasados como parámetro
            eventDidMount: function(info) {
                // Contenido del tooltip
                var tooltipContent = `
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">${info.event.title}</h5>
                <p class="card-text"><strong>Monto:</strong> ${info.event.extendedProps.money}</p>
                <p class="card-text"><strong>Participante:</strong> ${info.event.extendedProps.participantName}</p>
                <p class="card-text"><strong>Notas:</strong> ${info.event.extendedProps.notes || 'N/A'}</p>
                <p class="card-text"><strong>Método de pago:</strong> ${info.event.extendedProps.paymentMethod || 'N/A'}</p>
                <p class="card-text"><strong>Status:</strong> ${info.event.extendedProps.status}</p>
                <p class="card-text"><strong>Confirmado:</strong> ${info.event.extendedProps.paymentConfirmed ? 'Sí' : 'No'}</p>
            </div>
        </div>
    `;

                // Inicializar tooltip de Bootstrap
                var tooltip = new bootstrap.Tooltip(info.el, {
                    title: tooltipContent,
                    placement: 'top',
                    trigger: 'hover',
                    container: 'body',
                    html: true // Permitir HTML en el contenido del tooltip
                });
            },
            // Más opciones y configuraciones de FullCalendar
        });

        calendar.render();
    }
</script>

<style>
    /* Estilo para los tooltips */
    .tooltip .tooltip-inner {
        background-color: #fff;
        color: #333;
        border: 1px solid #ddd;
        max-width: 300px;
        /* o el ancho que prefieras */
        width: auto;
        /* para que se ajuste al contenido */
        padding: 5px;
        box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2);
        /* sombra para darle un efecto elevado */
        border-radius: 0.25rem;
    }

    /* Flecha del tooltip */
    .tooltip .arrow::before {
        border-top-color: #ddd;
    }
</style>