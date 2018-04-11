<section id="feature" class="transparent-bg">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>style/datepicker/css/datepicker.css" />
    <div class="container">

        <!-- HEADER -->
        <div class="center wow fadeInDown">
            <h2><?=$header_title ?></h2>
            <p class="lead"><?=$header_subtitle ?></p>
        </div>
        <!-- END HEADER -->

        <!-- FORM PARAMETERS -->
        <?php
        $attributes_form = array('class'=>'contact-form',
                                 'name'=>'contact-form');
        echo form_open('index.php/'.$destination, $attributes_form);
        ?>
        <!-- END FORM PARAMETERS -->

        <div class="row">

            <div class="col-sm-4">
            </div>

            <!-- CENTER OF FORM -->
            <div class="col-sm-4">

                <!-- SUCCESS MESSAGE -->
                <div class="form_status">
                    <div id="fade" class="center">
                        <?php if(isset($success)) : ?>
                            <p class="text-success"><?=$success?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- END SUCCESS MESSAGE -->

                <?php foreach($form_elements as $form_element): ?>
                    <?=form_label($form_element['label'], $form_element['name'])?>
                    <?php if ($form_element['sur_type'] == 'classic'): ?>
                        <!-- FORM INPUT - CLASSIC -->
                        <div class="form-group">
                            <?=form_input($form_element, set_value($form_element['name']))."<p />" ?>
                        </div>
                        <!-- END FORM INPUT - CLASSIC -->
                    <?php elseif ($form_element['sur_type'] == 'password'): ?>
                        <!-- FORM INPUT - PASSWORD -->
                        <div class="form-group">
                            <?=form_password($form_element)."<p />" ?>
                        </div>
                        <!-- END FORM INPUT - PASSWORD -->
                    <?php elseif($form_element['sur_type'] == 'dropdown'): ?>
                        <!-- FORM INPUT - DROPDOWN -->
                        <div class="form-group">
                            <?php
                            $items = array(''=>'');
                            foreach ($dropdown_elements as $dropdown_element):
                                $items[$dropdown_element['CODETYPEANIM']] = $dropdown_element['NOMTYPEANIM'];
                            endforeach; ?>
                            <?=form_dropdown($form_element, $items)."<p />"?>
                        </div>
                        <!-- END FORM INPUT - DROPDOWN -->
                    <?php elseif($form_element['sur_type'] == 'textarea'): ?>
                        <!-- FORM INPUT - TEXTAREA -->
                        <div class="form-group">
                            <?=form_textarea($form_element, set_value($form_element['name']))."<p />" ?>
                        </div>
                        <!-- END FORM INPUT - TEXTAREA -->
                    <?php elseif($form_element['sur_type'] == 'datepicker'): ?>
                        <!-- FORM INPUT - DATEPICKER -->
                        <div class="form-group">
                            <div id="sandbox-container">
                                <div class="input-group date">
                                    <?=form_input($form_element, set_value($form_element['name']))?><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                </div>
                            </div>
                        </div>
                        <!-- END FORM INPUT - DATEPICKER -->
                    <?php endif; ?>
                <?php endforeach; ?>

                <!-- FORM SUBMIT BUTTON -->
                <div class="center">
                    <div class="form-group">
                        <?=form_submit($form_button_attributes)?>
                    </div>
                </div>
                <!-- END FORM SUBMIT BUTTON -->

                <!-- FAIL MESSAGE -->
                <div class="form_status">
                    <div id="fade" class="center">
                        <p class="text-warning"><?=validation_errors()?></p>
                    </div>
                </div>
                <!-- END FAIL MESSAGE -->

            </div>
            <!-- END CENTER OF FORM -->

            <div class="col-sm-4">
            </div>

        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.0/js/bootstrap-datepicker.min.js"></script>

    <script>
    $('#sandbox-container .input-group.date').datepicker({
        format: "dd-mm-yyyy",
        weekStart: 1,
        language: 'fr',
        todayHighlight: true
    });
  </script>
</section>
