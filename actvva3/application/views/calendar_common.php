<link href="<?=base_url()?>style/fullcalendar-3.3.1/fullcalendar.css" rel="stylesheet">
<link href="<?=base_url()?>style/fullcalendar-3.3.1/fullcalendar.print.css" rel='stylesheet' media='print'>
<script src="<?=base_url()?>style/fullcalendar-3.3.1/lib/moment.min.js"></script>
<script src="<?=base_url()?>style/fullcalendar-3.3.1/lib/jquery.min.js"></script>
<script src="<?=base_url()?>style/fullcalendar-3.3.1/fullcalendar.min.js"></script>
<script src='<?=base_url()?>style/fullcalendar-3.3.1/locale/fr.js'></script>
<script src="<?=base_url()?>style/fullcalendar-3.3.1/lib/moment.min.js"></script>

<section id="feature" class="transparent-bg">

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
                                            Encadrants
                                            <i class="fa fa-angle-right pull-right"></i>
                                        </a>
                                    </h3>
                                </div>
                                <div id="collapseOne1" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <div class="media accordion-inner">
                                            <form id="myForm">
                                                <div id="encadrantsSelectForm" class="media-body"></div>
                                                <input class="btn btn-primary btn-lg btn-lg btn-block" type="submit" id="submitButton" value="Valider">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
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
                                                <ul class="list-group" id="list_participants"></ul>
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
                                            <p><i>Les activités désactivées ne sont pas visibles pour les loisants</i></p>
                                            <p id="etatActivite"></p>
                                            <div id="testButton"></div>
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
                editable: true,
                defaultView: 'agendaWeek',
                eventLimit: true, // allow "more" link when too many events
                selectHelper: true,
                eventDrop: function(event, delta) {
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
                },
                eventResize: function(event, delta) {
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
                },
                eventClick:  function(event) {
                    var inputs = document.getElementsByTagName('input');
                    var id = event.id.split(" ")[0];
                    var date = event.id.split(" ")[1];

                    //CREATE CHECKBOXES AND NAME THEM AFTER ID/DATE OF EVENT
                    document.getElementById('encadrantsSelectForm').innerHTML = "<input type='hidden' id='date' name='date'/><input type='hidden' id='id' name='id'/>";
                    <?php foreach ($encadrants as $encadrant): ?>
                    document.getElementById('encadrantsSelectForm').innerHTML += "<div class='checkbox'><label class='form-check-label'><input type='checkbox' value='<?=$encadrant['NOENCADRANT']?>' name='"+event.id+" encadrants[]'><?= $encadrant['PRENOMENCADRANT'].' '.$encadrant['NOMENCADRANT'] ?></label></div>";
                    <?php endforeach; ?>
                    document.getElementById('testButton').innerHTML = "<button class='btn-lg btn-block btn btn-primary' type='button' name='"+event.id+" activateButton'><div id='btText'>test</div></button>"

                    //CONVERT PHP ARRAY TO JS ARRAY
                    var planning = [[]];
                    <?php for($i=0; $i< count($planning); $i++) : ?>
                        planning[<?=$i?>] = [];
                        <?php foreach ($planning[$i] as $key => $value) : ?>
                            planning[<?=$i?>]["<?=$key?>"] = "<?=$value?>";
                        <?php endforeach; ?>
                    <?php endfor; ?>

                    //CHECK BOXES AND DISABLE RESPONSABLE
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

                    //ACTIVATE DEACTIVATE EVENT
                    $("button").click(function() {
                        var button = document.getElementsByName(event.id+' activateButton');
                        $.ajax({
                            url: "<?=base_url("index.php/activite/change_etat_activite")?>",
                            type: "POST",
                            data: 'id='+ id +'&date='+ date + '&activate=' + button.value,
                        });
                        if (event.color =='green') {
                            event.color = 'red';
                            button.value = 2;
                            document.getElementById('btText').innerHTML = "Activer";
                            document.getElementById('etatActivite').innerHTML = "Etat : Désactivée";
                        } else {
                            event.color = 'green';
                            button.value = 1;
                            document.getElementById('btText').innerHTML = "Désactiver";
                            document.getElementById('etatActivite').innerHTML = "Etat : Activée";
                        }
                        $('#myCalendar').fullCalendar('rerenderEvents');
                    });

                    setToggle(event, id,date);
                    listParticipants(id, date);
                    countParticipants(id, date);
                    $('#modalTitle').html("Activité '"+event.nom+"' du "+moment(event.start).format('LL'));
                    $('#id').val(id);
                    $('#date').val(date);
                    $('#modalDiv').modal();
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

            function addHidden(form, key, value) {
                // Create a hidden input element, and append it to the form:
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = key;'name-as-seen-at-the-server';
                input.value = value;
                form.appendChild(input);
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

            function setToggle(myEvent, id, date) {
                //INIT BUTTON VALUE
                return $.ajax({
                    url: "<?=base_url("index.php/activite/get_etat_activite")?>",
                    type: "POST",
                    data: 'id='+ id +'&date='+ date,
                    success: function(data) {
                        data = jQuery.parseJSON(data);
                        var button = document.getElementsByName(myEvent.id+' activateButton');
                        button.id = id+'_'+date+'_activateButton';
                        console.log(button);
                        if(data == 1) {
                            button.value = 1;
                            document.getElementById('btText').innerHTML = "Désactiver";
                            document.getElementById('etatActivite').innerHTML = "Etat : Activée";
                        } else {
                            button.value = 2;
                            document.getElementById('etatActivite').innerHTML = "Etat : Désactivée";
                            document.getElementById('btText').innerHTML = "Activer";
                        }
                    }
                });
            }

            $("#modalDiv").on('hidden.bs.modal',function(){
                //DELETE FORM INPUT CHECKBOXES
                var inputs = document.getElementsByTagName('input');
                $('input[name="belotte 2017-05-24 encadrants[]"]').remove();
                for(var i = 0; i < inputs.length; i++) {
                    if(inputs[i].type == "checkbox" && inputs[i].name.includes("encadrants")) {
                        $('input[name="'+inputs[i].name+'"]').remove();
                    }
                }
            });
        });

        </script>
    </section>
