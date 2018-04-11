    <section id="main-slider" class="no-margin">
        <div class="carousel slide">
            <ol class="carousel-indicators">
                <li data-target="#main-slider" data-slide-to="0" class="active"></li>
                <li data-target="#main-slider" data-slide-to="1"></li>
                <li data-target="#main-slider" data-slide-to="2"></li>
            </ol>

            <div class="carousel-inner">

                <div class="item active" style="background-image: url(<?=base_url()?>style/images/slider/bg1.jpg)">
                    <div class="container">
                        <div class="row slide-margin">

                            <div class="col-sm-6">
                                <div class="carousel-content">
                                    <h1 class="animation animated-item-1">Profitez de vacances en famille</h1>
                                    <h2 class="animation animated-item-2">Avec des animations pour les grands et les petits</h2>
                                    <a class="btn-slide animation animated-item-3" href="animation">Voir Plus</a>
                                </div>
                            </div>

                            <div class="col-sm-6 hidden-xs animation animated-item-4">
                                <div class="slider-img">
                                    <img src="<?=base_url()?>style/images/slider/img1.png" class="img-responsive">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="item" style="background-image: url(<?=base_url()?>style/images/slider/bg2.jpg)">
                    <div class="container">
                        <div class="row slide-margin">
                            <div class="col-sm-6">

                                <div class="carousel-content">
                                    <h1 class="animation animated-item-1">Des prix abordables toute l'année</h1>
                                    <h2 class="animation animated-item-2">Dans un village vacance à taille humaine</h2>
                                    <a class="btn-slide animation animated-item-3" href="prix">Voir Plus</a>
                                </div>
                            </div>

                            <div class="col-sm-6 hidden-xs animation animated-item-4">
                                <div class="slider-img">
                                    <img src="<?=base_url()?>style/images/slider/img2.png" class="img-responsive">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="item" style="background-image: url(<?=base_url()?>style/images/slider/bg3.jpg)">
                    <div class="container">
                        <div class="row slide-margin">

                            <div class="col-sm-6">
                                <div class="carousel-content">
                                    <h1 class="animation animated-item-1">Laissez-vous encadrer par une équipe de qualité</h1>
                                    <h2 class="animation animated-item-2">Ils sont là pour répondre à tous vos besoins</h2>
                                    <a class="btn-slide animation animated-item-3" href="a_propos">Voir Plus</a>
                                </div>
                            </div>

                            <div class="col-sm-6 hidden-xs animation animated-item-4">
                                <div class="slider-img">
                                    <img src="<?=base_url()?>style/images/slider/img3.png" class="img-responsive">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>

        <a class="prev hidden-xs" href="#main-slider" data-slide="prev">
            <i class="fa fa-chevron-left"></i>
        </a>

        <a class="next hidden-xs" href="#main-slider" data-slide="next">
            <i class="fa fa-chevron-right"></i>
        </a>
    </section>
    <script type="text/javascript">
        $('.carousel').carousel()
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
