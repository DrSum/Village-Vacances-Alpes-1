<section id="portfolio">
    <div class="container">

        <!-- PORTFOLIO HEADER -->
        <div class="center wow fadeInDown">
            <h2>Animations</h2>
            <p class="lead">Visualiser, Ajouter, Modifier, Supprimer les animations.</p>
        </div>
        <!-- END PORTFOLIO HEADER -->

        <!-- SUCCESS MESSAGE -->
        <div class="form_status">
            <div id="fade" class="center">
                <?php if(isset($success)) : ?>
                    <p class="text-success"><?=$success?></p>
                <?php endif; ?>
            </div>
        </div>
        <!-- END SUCCESS MESSAGE -->

        <!-- FILTER -->
        <ul class="portfolio-filter text-center">
            <li><a class="btn btn-default active" href="#" data-filter="*">Toutes</a></li>
            <?php foreach ($type_anims as $type_anim): ?>
                <li><a class="btn btn-default" href="#" data-filter=".<?=$type_anim['CODETYPEANIM'] ?>"><?=$type_anim['NOMTYPEANIM'] ?></a></li>
            <?php endforeach; ?>
            <li><a class="btn btn-default preview" onclick="location.href='<?=base_url()?>index.php/animation/add_categorie'">Ajouter</a></li>
        </ul>
        <!-- END FILTER -->

        <div class="row">
            <div class="portfolio-items">

                <!-- 1ST ITEM - ADD ITEM-->
                <div class="portfolio-item col-xs-12 col-sm-4 col-md-3">
                    <div class="recent-work-wrap">
                        <a href="<?=base_url()?>index.php/animation/add_animation">
                            <img class="img-responsive" src="<?=base_url()?>style/images/portfolio/full/add.png" alt="">
                        </a>
                    </div>
                </div>
                <!-- END 1ST ITEM - ADD ITEM -->

                <!-- LIST ANIMATIONS -->
                <?php foreach ($anims as $anim): ?>
                    <div class="portfolio-item <?=$anim['CODETYPEANIM'] ?> col-xs-12 col-sm-4 col-md-3">
                        <div class="recent-work-wrap">
                            <img class="img-responsive" src="<?=base_url()?>style/images/portfolio/full/item1.png" alt="">
                            <div class="overlay">
                                <div class="recent-work-inner">
                                    <h3><a href="<?=base_url()?>index.php/animation/modify_animation<?=$anim['CODEANIM']?>"><?=$anim['NOMANIM'] ?></a></h3>
                                    <a class="preview" href="<?=base_url()?>index.php/animation/modify_animation/<?=$anim['CODEANIM']?>"><span class="glyphicon glyphicon-pencil"></span> Modifier</a><br />
                                    <a class="preview" href="<?=base_url()?>index.php/animation/delete_animation/<?=$anim['CODEANIM']?>"><span class="glyphicon glyphicon-remove"></span> Supprimer</a><br />
                                    <a class="preview" href="<?=base_url()?>index.php/activite/index/<?=$anim['CODEANIM']?>"><i class="fa fa-eye"></i> Activités</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <!-- END LIST ANIMATIONS -->

            </div>
        </div>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

</section>
