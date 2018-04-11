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

    <div id="modalDiv" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">close</span>
                    </button>
                    <h4 id="modalTitle" class="modal-title"></h4>
                </div>

                <div class="modal-body">
                    <div class="accordion">
                        <div class="panel-group" id="accordion1">

                            <div class="panel panel-default">
                                <div class="panel-heading active">
                                    <h3 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne1">
                                            Détails
                                            <i class="fa fa-angle-right pull-right"></i>
                                        </a>
                                    </h3>
                                </div>
                                <div id="collapseOne1" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <div class="media accordion-inner">
                                            <div class="media-body">
                                                <ul class="list-group" id="details_activite">
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseTwo1" id="participants">
                                            Encadrants
                                            <i class="fa fa-angle-right pull-right"></i>
                                        </a>
                                    </h3>
                                </div>
                                <div id="collapseTwo1" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="media accordion-inner">
                                            <div class="media-body">
                                                <ul class="list-group" id="list_encadrants"></ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseThree1">
                                            S'inscrire
                                            <i class="fa fa-angle-right pull-right"></i>
                                        </a>
                                    </h3>
                                </div>
                                <div id="collapseThree1" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <p id="etatInscription"></p>
                                        <div id="inscriptionActivite"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="container">
        <div id="myCalendar"></div>
    </div>

    <script type="text/javascript">
    $(document).ready(function() {
        $('#myCalendar').fullCalendar({
            events: <?=$events?>,
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            defaultView: 'agendaWeek',
            eventClick:  function(event) {
                var id = event.id.split(" ")[0];
                var date = event.id.split(" ")[1];
                document.getElementById('inscriptionActivite').innerHTML = "<button class='btn-lg btn-block btn btn-primary' type='button' name='"+event.id+" incscription'><div id='btText'>Inscription</div></button>";

                $("button").click(function() {
                    var button = document.getElementsByName(event.id+' incscription');
                    $.ajax({
                        url: "<?=base_url("index.php/activite/register_activite")?>",
                        type: "POST",
                        data: 'id='+ id +'&date='+ date,
                        success: function(data) {
                            alert(data);
                        },
                        error: function(data) {
                            alert(data);
                        }
                    });
                });

                detailsActivite(id, date);
                listEncadrants(id, date);
                $('#modalTitle').html("Activité '"+event.nom+"' du "+moment(event.start).format('LL'));
                $('#modalDiv').modal();
            },
        });

        function detailsActivite(id, date) {
            return $.ajax({
                url: "<?=base_url("index.php/activite/details_activite")?>",
                type: "POST",
                data: 'id='+ id +'&date='+ date,
                success: function(data) {
                    document.getElementById('details_activite').innerHTML = "";
                    data = jQuery.parseJSON(data);
                    for (i in data) {
                         document.getElementById('details_activite').innerHTML =  document.getElementById('details_activite').innerHTML + '<li class="list-group-item"><div class="media-body">'+ i +': '+ data[i] +'</div></li>';
                    }
                }
            });
        }

        function listEncadrants(id, date) {
            return $.ajax({
                url: "<?=base_url("index.php/activite/encadrants_participants")?>",
                type: "POST",
                data: 'id='+ id +'&date='+ date,
                success: function(data) {
                    document.getElementById('list_encadrants').innerHTML = "";
                    data = jQuery.parseJSON(data);
                    for (i in data) {
                        if ('RESPONSABLE' in data[i]) {
                            document.getElementById('list_encadrants').innerHTML =  document.getElementById('list_encadrants').innerHTML + '<li class="list-group-item"><div class="media-body"><b>'+ data[i].PRENOMENCADRANT +' '+ data[i].NOMENCADRANT +'</b></div></li>';
                        } else {
                            document.getElementById('list_encadrants').innerHTML =  document.getElementById('list_encadrants').innerHTML + '<li class="list-group-item"><div class="media-body">'+ data[i].PRENOMENCADRANT +' '+ data[i].NOMENCADRANT +'</div></li>';
                        }
                    }
                }
            });
        }
    });
    </script>
</section>
