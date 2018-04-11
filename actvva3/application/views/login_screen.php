<section id="feature" class="transparent-bg">
    <div class="container">

        <div class="center wow fadeInDown">
            <h2>Connexion</h2>
            <p class="lead"> Remplissez les champs afin d'accéder à votre compte </p>
        </div>

        <?php
        $attributes_form = array('class'=>'contact-form', 'name'=>'contact-form');
        echo form_open('index.php/login', $attributes_form);
        ?>

        <div class="row">

            <div class="col-sm-4"></div>

            <div class="col-sm-4">
                <div class="form_status">
                    <p class="text-warning"><?= validation_errors() ?></p>
                </div>

                <div class="form-group">
                    <?php
                    $attributes_user = array('name'=>'username',
                                             'class'=>'form-control',
                                             'required'=>'required',
                                             'oninvalid'=>"setCustomValidity('Veuillez renseigner votre nom d\'utilisateur.')",
                                             'oninput'=>"setCustomValidity('')");
                    echo form_label('Username *', 'username');
                    echo form_input($attributes_user)."<p />";
                    ?>
                </div>

                <div class="form-group">
                    <?php
                    $attributes_password = array('name'=>'password',
                                                 'class'=>'form-control',
                                                 'required'=>'required',
                                                 'oninvalid'=>"setCustomValidity('Veuillez renseigner votre mot de passe.')",
                                                 'oninput'=>"setCustomValidity('')");
                    echo form_label('Password *', 'password');
                    echo form_password($attributes_password)."<p />";
                    ?>
                </div>

                <div class="center">
                    <div class="form-group">
                        <?php
                        $attributes_button = array('name'=>'submit', 'value'=>'Se Connecter', 'class'=>'btn btn-primary btn-lg');
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

</section>
