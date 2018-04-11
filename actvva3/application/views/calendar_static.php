<link href="<?=base_url()?>style/fullcalendar-3.3.1/fullcalendar.css" rel="stylesheet">
<link href="<?=base_url()?>style/fullcalendar-3.3.1/fullcalendar.print.css" rel='stylesheet' media='print'>
<script src="<?=base_url()?>style/fullcalendar-3.3.1/lib/moment.min.js"></script>
<script src="<?=base_url()?>style/fullcalendar-3.3.1/lib/jquery.min.js"></script>
<script src="<?=base_url()?>style/fullcalendar-3.3.1/fullcalendar.min.js"></script>
<script src='<?=base_url()?>style/fullcalendar-3.3.1/locale/fr.js'></script>
<script src="<?=base_url()?>style/fullcalendar-3.3.1/lib/moment.min.js"></script>

<section id="feature" class="transparent-bg">
    <!-- RETURN BUTTON -->
    <div class="container">
        <button type="button" class="btn btn-primary btn-sm" onclick="location.href='<?=base_url()?>index.php/animation'">
              <span class="glyphicon glyphicon-chevron-left"></span> Retour
        </button>
    </div>
    <!-- END RETURN BUTTON -->

    <!-- HEADER -->
    <div class="center wow fadeInDown">
        <h2><?=$header_title ?></h2>
        <p class="lead"><?=$header_subtitle ?></p>
    </div>
    <!-- END HEADER -->
    <div class="container">
        <div id='calendar'></div>
    </div>

    <script type="text/javascript">
    $(document).ready(function() {
        var today = moment().day();
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            editable: true,
            defaultView: 'agendaWeek',
            eventLimit: true, // allow "more" link when too many events
            selectable: true,
            selectHelper: true,
            events: <?=$events?>,
            select: function(start, end) {
                var check = moment(start).format('YYYY-MM-DD');
                var today = moment().format("YYYY-MM-DD");

                if(check < today) {
                    alert("Vous ne pouvez pas créer d'activités dans le passé!");
                } else {
                    var id = "<?=$anim['CODEANIM']?> "+moment(start).format('YYYY-MM-DD');
                    var title = "<?=$anim['CODEANIM']?>";
                    start   =   moment(start).format('YYYY-MM-DD HH:mm:ss');
                    end     =   moment(end).format('YYYY-MM-DD HH:mm:ss');
                    $.ajax({
                        url: '<?php echo base_url("index.php/activite/add_activite"); ?>',
                        data: 'title='+title+'&id='+ id+'&start='+ start +'&end='+ end,
                        type: "POST",
                        success: function(data) {
                            if (!data) {
                                alert('L\'activité a été ajoutée.');
                                $('#calendar').fullCalendar('renderEvent',
                                {
                                    title: title,
                                    id: id,
                                    start: start,
                                    end: end,
                                    color: green
                                }, true); // stick? = true
                            } else {
                                alert(data);
                            }
                        },
                        error: function(date) {
                            alert('Il ne peut pas y avoir deux activités identiques la même journée.');
                        }
                    });
                }

                $('#calendar').fullCalendar('unselect');
			},
            eventDrop: function(event, delta) {
                if (event.color != 'red') {
                    start   =   moment(event.start).format('YYYY-MM-DD HH:mm:ss');
                    end     =   moment(event.end).format('YYYY-MM-DD HH:mm:ss');
                    $.ajax({
                        url: '<?php echo base_url("index.php/activite/modify_activite"); ?>',
                        data: 'start=' + start + '&end=' + end + '&id=' + event.id ,
                        type: "POST",
                        success: function(json) {
                            alert('L\'activité a été modifiée.');
                        },
                        error: function(json) {
                            alert('Il ne peut pas y avoir deux activités identiques la même journée.');
                            location.reload();
                        }
                    });
                } else {
                    location.reload();
                }
            },
            eventResize: function(event, delta) {
                if (event.color != 'red') {
                    start   =   moment(event.start).format('YYYY-MM-DD HH:mm:ss');
                    end     =   moment(event.end).format('YYYY-MM-DD HH:mm:ss');
                    $.ajax({
                        url: '<?php echo base_url("index.php/activite/modify_activite"); ?>',
                        data: 'start='+ start +'&end='+ end +'&id='+ event.id ,
                        type: "POST",
                        success: function(json) {
                            alert('L\'activité a été modifiée.');
                        },
                        error: function(json) {
                            alert('Il ne peut pas y avoir deux activités identiques la même journée.');
                            location.reload();
                        }
                    });
                } else {
                    location.reload();
                }
            },
            eventClick: function(event)
            {
                if (event.color != 'red') {
                    var r = confirm("Voulez-vous vraiment annuler l'activité: " + event.id);
                    if (r===true)
                    {
                        event.color = 'red';
                        $('#calendar').fullCalendar('rerenderEvents', event.id);
                        $.ajax({
                            url: '<?php echo base_url("index.php/activite/cancel_activite"); ?>',
                            data: 'id='+ event.id ,
                            type: "POST",
                            success: function(json) {
                                alert('L\'activité a été annulée.');
                            }
                        });
                    }
                }
            }
        });

    });
    </script>
</section>
