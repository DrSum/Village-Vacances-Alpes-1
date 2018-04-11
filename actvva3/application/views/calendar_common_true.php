<link href="<?=base_url()?>style/fullcalendar-3.3.1/fullcalendar.css" rel="stylesheet">
<link href="<?=base_url()?>style/fullcalendar-3.3.1/fullcalendar.print.css" rel='stylesheet' media='print'>
<script src="<?=base_url()?>style/fullcalendar-3.3.1/lib/moment.min.js"></script>
<script src="<?=base_url()?>style/fullcalendar-3.3.1/lib/jquery.min.js"></script>
<script src="<?=base_url()?>style/fullcalendar-3.3.1/fullcalendar.min.js"></script>
<script src='<?=base_url()?>style/fullcalendar-3.3.1/locale/fr.js'></script>
<script src="<?=base_url()?>style/fullcalendar-3.3.1/lib/moment.min.js"></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<section id="feature" class="transparent-bg">

    <!-- HEADER -->
    <div class="center wow fadeInDown">
        <h2><?=$header_title ?></h2>
        <p class="lead"><?=$header_subtitle ?></p>
    </div>
    <!-- END HEADER -->


    <div id="fullCalModal" class="modal fade">
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
                                            Encadrants
                                            <i class="fa fa-angle-right pull-right"></i>
                                        </a>
                                    </h3>
                                </div>
                                <div id="collapseOne1" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <div class="media accordion-inner">
                                            <form id="myForm" action="<?=base_url()?>index.php/activite/planning_encadrants" method="post">
                                                <div class="media-body">
                                                    <input type="hidden" id="date" name="date"/>
                                                    <input type="hidden" id="id" name="id"/>
                                                    <?php foreach ($encadrants as $encadrant) : ?>
                                                        <div class="checkbox">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" value="<?=$encadrant['NOENCADRANT']?>" name="encadrants[]"><?= $encadrant['PRENOMENCADRANT']." ".$encadrant['NOMENCADRANT'] ?>
                                                            </label>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                                <input class="btn btn-primary btn-lg" type="submit" id="submitButton" value="Valider">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading active">
                                    <h3 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseTwo1" id="participants">
                                            Participants
                                            <i class="fa fa-angle-right pull-right"></i>
                                        </a>
                                    </h3>
                                </div>
                                <div id="collapseTwo1" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="media accordion-inner">
                                            <div class="media-body">
                                                <ul class="list-group" id="list_participants">

                                                </ul>
                                            </div>
                                            <div class="col-md-6" id="total-count">
                                                <h4>Total <span class="label label-info" id="nombre-participants">25</span></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseThree1">
                                                Activer / Desactiver Activité
                                                <i class="fa fa-angle-right pull-right"></i>
                                            </a>
                                        </h3>
                                    </div>
                                    <div id="collapseThree1" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <p><i>Les activités désactivés ne sont pas visibles pour les loisants</i></p>
                                            <input id="activate" data-toggle="toggle" data-width="100" data-on="Activé" data-off="Désactivé" data-onstyle="success" data-offstyle="danger" type="checkbox">
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
                    var inputs = document.getElementsByTagName('input');
                    var id = event.id.split(" ")[0];
                    var date = event.id.split(" ")[1];

                    var planning = [[]];
                    <?php for($i=0; $i< count($planning); $i++) { ?>
                        planning[<?=$i?>] = [];
                        <?php foreach ($planning[$i] as $key => $value) { ?>
                            planning[<?=$i?>]["<?=$key?>"] = "<?=$value?>";
                            <?php
                        }
                    }
                    ?>
                    for(var i = 0; i < inputs.length; i++) {
                        if(inputs[i].type == "checkbox" && inputs[i].name.includes("encadrants")) {
                            inputs[i].checked = false;
                            for (var j=0; j<planning.length; j++) {
                                if(inputs[i].value == planning[j]["NOENCADRANT"] &&
                                id == planning[j]["CODEANIM"] &&
                                date == planning[j]["DATEACT"]) {
                                    inputs[i].checked = true;
                                    $('#myCalendar').fullCalendar('updateEvent', event);
                                }
                            }
                            if(inputs[i].value == event.responsable && !inputs[i].id.includes('encadrants')) {
                                inputs[i].checked = true;
                                inputs[i].disabled='disabled';
                                addHidden(myForm, inputs[i].name, inputs[i].value);
                            }
                        }
                    }

                    $('#activate').change(function() {
                        if ($('#activate').prop('checked') == false) {
                            event.color = 'red';
                        } else {
                            event.color = 'green';
                        }
                        $('#myCalendar').fullCalendar('rerenderEvents');
                    });

                    setToggle(id,date);
                    listParticipants(id, date);
                    countParticipants(id, date);
                    $('#modalTitle').html("Activité '"+event.nom+"' du "+moment(event.start).format('LL'));
                    $('#id').val(id);
                    $('#date').val(date);
                    $('#fullCalModal').modal();
                }
            });

            $('#myForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "<?=base_url("index.php/activite/planning_encadrants")?>",
                    type: "POST",
                    data: $("#myForm").serializeArray(),
                    success: function(data){
                        alert("Modification des encadrants réussie!");
                    },
                });
                return false;
            });

            function addHidden(theForm, key, value) {
                // Create a hidden input element, and append it to the form:
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = key;'name-as-seen-at-the-server';
                input.value = value;
                theForm.appendChild(input);
            }

            function countParticipants(id, date) {
                return $.ajax({
                    url: "<?=base_url("index.php/activite/count_participants")?>",
                    type: "POST",
                    data: 'id='+ id +'&date='+ date,
                    success: function(data) {
                        document.getElementById('total-count').innerHTML = '<h6>Total <span class="label label-info">'+data+'</span></h6>';
                    }
                });
            }

            function listParticipants(id, date) {
                return $.ajax({
                    url: "<?=base_url("index.php/activite/list_participants")?>",
                    type: "POST",
                    data: 'id='+ id +'&date='+ date,
                    success: function(data) {
                        data = jQuery.parseJSON(data);
                        for (i in data) {
                            var innerHTML = document.getElementById('list_participants').innerHTML;
                            document.getElementById('list_participants').innerHTML = innerHTML + '<li class="list-group-item"><div class="media-body">'+ data[i].PRENOMLOISANT +' '+ data[i].NOMLOISANT +'</div></li>';
                        }
                    }
                });
            }

            function activate(id,date) {
                return $.ajax({
                    url: "<?=base_url("index.php/activite/activate_activite")?>",
                    type: "POST",
                    data: 'id='+ id +'&date='+ date,
                });
            }

            function setToggle(id, date) {
                return $.ajax({
                    url: "<?=base_url("index.php/activite/get_etat_activite")?>",
                    type: "POST",
                    data: 'id='+ id +'&date='+ date,
                    success: function(data) {
                        data = jQuery.parseJSON(data);
                        if(data == 1) {
                            $('#activate').bootstrapToggle('on')
                        } else {
                            $('#activate').bootstrapToggle('off')
                        }
                    }
                });
            }

            $('#activate').change(function() {
                $.ajax({
                    url: "<?=base_url("index.php/activite/change_etat_activite")?>",
                    type: "POST",
                    data: $("#myForm").serialize() + "&activate="+$('#activate').prop('checked'),
                });
            });

            $("#fullCalModal").on('hidden.bs.modal',function(){
                document.getElementById('list_participants').innerHTML = "";
                $(this).find("#fullCalModal").html(""); // Just clear the contents.
                $(this).find("#fullCalModal").remove();
                $(this).removeData('bs.modal');
                alert("done");
            });
        });

        </script>
    </section>
