<section id="feature" class="transparent-bg">
    <div class="container">

        <div class="center wow fadeInDown">
            <h2>Ajouter une catégorie d'animation</h2>
            <p class="lead"> Remplissez les champs et validez afin de créer une nouvelle catégorie d'animation </p>
        </div>

        <div class="row">
            <?php
            $attributes_form = array('class'=>'contact-form', 'name'=>'contact-form');
            echo form_open('index.php/animation/add_categorie', $attributes_form);
            ?>

            <div class="row">

                <div class="col-sm-4"></div>

                <div class="col-sm-4">
                    <div class="form_status">
                        <div id="fade" class="center">
                            <?php if(isset($success)) : ?>
                                <p class="text-success"><?=$success?></p>
                            <?php else: ?>
                                <p class="text-warning"><?= validation_errors() ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php
                        $attributes_code = array('name'=>'code_type_animation',
                        'class'=>'form-control',
                        'required'=>'required',
                        'oninvalid'=>"setCustomValidity('Veuillez renseigner le code du type d\'animation.')",
                        'oninput'=>"setCustomValidity('')");
                        echo form_label('Code Type Animation*', 'code_type_animation');
                        echo form_input($attributes_code)."<p />";
                        ?>
                    </div>

                    <div class="form-group">
                        <?php
                        $attributes_nom = array('name'=>'nom_type_animation',
                        'class'=>'form-control',
                        'required'=>'required',
                        'oninvalid'=>"setCustomValidity('Veuillez renseigner le nom du type d\'animation.')",
                        'oninput'=>"setCustomValidity('')");
                        echo form_label('Libellé *', 'nom_type_animation');
                        echo form_input($attributes_nom)."<p />";
                        ?>
                    </div>

                    <div class="center">
                        <div class="form-group">
                            <?php
                            $attributes_button = array('name'=>'submit', 'value'=>'Ajouter', 'class'=>'btn btn-primary btn-lg');
                            echo form_submit($attributes_button);
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4"></div>

            </div>

            <?php
            echo form_close();
            ?>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
</section>
