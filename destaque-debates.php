<section id="destaque-home-debates">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h3 class="font-roboto red">Debates Abertos</h3>
            </div>
            <div class="col-md-6 text-right">
                <p class="mt-sm">
                <strong class="mt-xs ml-md"><a href="#">Veja todos os debates</a></strong>
                </p>
            </div>
        </div>
        <div class="row" id="debates-home">
            <?php
            $list_sites = wp_get_sites();
            foreach ($list_sites as $site) {
            // Excluí o site principal da lista
            if ($site['blog_id'] == 1) continue;
            $blog_settings = get_blog_option($site['blog_id'], 'participacao_settings');
            $blog_details = get_blog_details($site['blog_id']);
            ?>
            <div class="col-sm-4 debate-box">
                <div class="">
                    <div class="text-center">
                        <a href="<?php echo $blog_details->siteurl; ?>"><img src="<?php echo $blog_settings['logo']; ?>" class="img-full" alt="<?php echo $blog_details->blogname; ?>"></a>
                    </div>
                    <div class="description">
                        <strong class="red"><a href="<?php echo $blog_details->siteurl; ?>"><?php echo $blog_details->blogname; ?></a></strong>
                        <p><small><?php echo $blog_settings['participacao_site_excerpt']; ?></small></p>
                    </div>
                </div>
            </div>
            <?php } ?>
            <!-- Debate fixo link direto para o delibera -->
            <div class="col-sm-4 debate-box">
                <div class="">
                    <div class="text-center">
                        <a href="<?php echo get_post_type_archive_link('pauta'); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icone-debates.png" class="img-full" alt="Debate"></a>
                    </div>
                    <div class="description">
                        <strong class="red"><a href="<?php echo get_post_type_archive_link('pauta'); ?>">Comece um debate</a></strong>
                        <p><small>Tem algum assunto que quer ver debatido? Faça sua <a href="<?php echo get_post_type_archive_link('pauta'); ?>">sugestão aqui</a>.</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>