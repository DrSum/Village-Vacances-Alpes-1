<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?=base_url()?>style/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url()?>style/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?=base_url()?>style/css/animate.min.css" rel="stylesheet">
    <link href="<?=base_url()?>style/css/prettyPhoto.css" rel="stylesheet">
    <link href="<?=base_url()?>style/css/main.css" rel="stylesheet">
    <link href="<?=base_url()?>style/css/responsive.css" rel="stylesheet">

    <title>VVA | <?=$title?></title>
</head>

<?php
if (!isset($page)) $page = "";
if (!isset($active)) $active = "";
?>

<body <?=($page == "Homepage") ? 'class="homepage"' : '' ?>>
    <header id="header">
        <nav class="navbar navbar-inverse" role="banner">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?=base_url()?>index.php/welcome"><img src="<?=base_url()?>style/images/logo.png" alt="logo"></a>
                </div>

                <div class="collapse navbar-collapse navbar-right">
                    <ul class="nav navbar-nav">

                        <li class=<?=($active == "Accueil") ? '"active"' : "" ?>><a href="<?=base_url()?>index.php/welcome">Accueil</a></li>

                        <!-- TEST TYPE USER -->
                        <?php if($this->session->connected == TRUE): ?>

                            <?php if($this->session->type == 'lo'): ?>
                                <li class=<?=($active == "Liste Animations") ? '"active"' : "" ?>>
                                    <a href="<?=base_url()?>index.php/animation">Catalogue</a>
                                </li>
                                <li class=<?=($active == "Planning") ? '"active"' : "" ?>>
                                    <a href="<?=base_url()?>index.php/activite">Mon Planning</a>
                                </li>

                            <!-- DROPDOWN ANIMATION MENU -->
                            <?php elseif($this->session->type == 'en'): ?>
                                <li class="dropdown<?=(strpos($active, "Animation") == TRUE) ? " active" : "" ?>">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Animations <i class="fa fa-angle-down"></i></a>
                                    <ul class="dropdown-menu">
                                        <li class=<?=($active == "Ajouter Catégorie d\'Animation") ? '"active"' : "" ?>>
                                            <a href="<?=base_url()?>index.php/animation/add_categorie">Ajouter Catégorie</a>
                                        </li>
                                        <li class=<?=($active == "Ajouter Animation") ? '"active"' : "" ?>>
                                            <a href="<?=base_url()?>index.php/animation/add_animation">Ajouter Animation</a>
                                        </li>
                                        <li class=<?=($active == "Liste Animations") ? '"active"' : "" ?>>
                                            <a href="<?=base_url()?>index.php/animation">Liste Animations</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class=<?=($active == "Activité") ? '"active"' : "" ?>>
                                    <a href="<?=base_url()?>index.php/activite">Mon Planning</a>
                                </li>
                            <?php endif; ?>
                            <!-- END DROPDOWN ANIMATION MENU -->

                        <?php endif; ?>
                        <!-- END TEST TYPE USER -->

                        <li class=<?=($active == "A Propos") ? '"active"' : "" ?>>
                            <a href="<?=base_url()?>index.php/a_propos">À Propos</a>
                        </li>

                        <li class=<?=($active == "Contact") ? '"active"' : "" ?>>
                            <a href="<?=base_url()?>index.php/contact">Contact</a>
                        </li>

                        <!-- TEST CONNECTE/PAS_CONNECTE -->
                        <?php if($this->session->connected == FALSE): ?>
                            <li class=<?=($active == "Login") ? '"active"' : "" ?>>
                                <a href="<?=base_url()?>index.php/login">Se Connecter <i class="fa fa-sign-in"></i></a>
                            </li>
                        <?php else: ?>
                            <li>
                                <a href="<?=base_url()?>index.php/welcome/disconnect">Se Déconnecter <i class="fa fa-sign-out"></i></a>
                            </li>
                        <?php endif; ?>
                        <!-- END TEST CONNECTE/PAS_CONNECTE -->

                    </ul>
                </div>
            </div>
        </nav>
    </header>
