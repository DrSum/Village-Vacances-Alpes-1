<section id="portfolio">
    <div class="container">

        <!-- PORTFOLIO HEADER -->
        <div class="center wow fadeInDown">
            <h2>Animations</h2>
            <p class="lead">Choisissez l'animation qui vous plait.</p>
        </div>
        <!-- END PORTFOLIO HEADER -->

        <!-- FILTER -->
        <ul class="portfolio-filter text-center">
            <li><a class="btn btn-default active" href="#" data-filter="*">Toutes</a></li>
            <?php foreach ($type_anims as $type_anim): ?>
                <li><a class="btn btn-default" href="#" data-filter=".<?=$type_anim['CODETYPEANIM'] ?>"><?=$type_anim['NOMTYPEANIM'] ?></a></li>
            <?php endforeach; ?>
        </ul>
        <!-- END FILTER -->

        <div class="row">
            <div class="portfolio-items">
                <!-- LIST ANIMATIONS -->
                <?php foreach ($anims as $anim): ?>
                    <div class="portfolio-item <?=$anim['CODETYPEANIM'] ?> col-xs-12 col-sm-4 col-md-3">
                        <div class="recent-work-wrap">
                            <img class="img-responsive" src="<?=base_url()?>style/images/portfolio/full/item1.png" alt="">
                            <div class="overlay">
                                <div class="recent-work-inner">
                                    <h3><a href="#" onclick="check_age(<?=$anim['CODEANIM']?>)"><?=$anim['NOMANIM'] ?></a></h3>
                                    <a class="preview" href="#" onclick="check_age('<?=$anim['CODEANIM']?>')"><i class="fa fa-eye"></i> Activités</a>
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
    <script type="text/javascript">
        function check_age(cd) {
            $.ajax({
                url: "<?=base_url("index.php/activite/check_age")?>",
                type: "POST",
                data: 'cd='+ cd,
                success: function(data) {
                    data = jQuery.parseJSON(data);
                    if (data == "true") {
                        window.location.href = "<?=base_url()?>index.php/activite/index/"+cd;
                    } else {
                        alert(data);
                    }
                }
            });
            return false;
        }
    </script>

</section>
