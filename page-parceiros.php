<?php get_header(); ?>
<div id="main-parceiros">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="red font-roboto">Parceiros</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-md-8">
        <p>Parcerias estabelecidas pela SAL/MJ com instituições acadêmicas, centros de pesquisa, ONG’s e também com demais entes públicos para a consecução dos objetivos próprios do Projeto Pensando o Direito.</p>
        <ul class="list-group">
          <li href="#" class="list-group-item" onclick="window.open('http://www.ajd.org.br/index.php', '_blank');">
            <div class="row">
              <div class="col-sm-3 text-center">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logos/logo-jpd.jpg" class="img-full img-thumbnail logos-parceiros">
              </div>
              <div class="col-sm-9">
                <h4 class="list-group-item-heading">Associação dos Juízes para a Democracia</h4>
                <div class="list-group-item-text">
                  <p>A AJD, entidade civil sem fins lucrativos ou interesses corporativistas, tem objetivos estatutários que se concretizam na defesa intransigente dos valores próprios do Estado Democrático de Direito, na defesa abrangente da dignidade da pessoa humana</p>
                </div>
              </div>
            </div>
          </li>
          <li href="#" class="list-group-item" onclick="window.open('http://carceraria.org.br/', '_blank');">
            <div class="row">
              <div class="col-sm-3 text-center">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logos/logo-pastoral-carc.jpg" class="img-full img-thumbnail logos-parceiros">
              </div>
              <div class="col-sm-9">
                <h4 class="list-group-item-heading">Pastoral Carcerária</h4>
                <div class="list-group-item-text">
                  <p>A Pastoral Carcerária é a presença de Cristo e de sua Igreja no mundo dos cárceres onde procura desenvolver todos os trabalhos que essa presença vem a exigir. - See more at: http://carceraria.org.br/quem-somos#sthash.ISF2Ksdh.dpuf</p>
                </div>
              </div>
            </div>
          </li>
          <li href="#" class="list-group-item" onclick="window.open('http://www.soudapaz.org/', '_blank');">
            <div class="row">
              <div class="col-sm-3 text-center">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logos/logo-sou-da-paz.jpg" class="img-full img-thumbnail logos-parceiros">
              </div>
              <div class="col-sm-9">
                <h4 class="list-group-item-heading">Pastoral Carcerária</h4>
                <div class="list-group-item-text">
                  <p>O Sou da Paz analisa dados disponíveis sobre violência e criminalidade, realiza pesquisas para identificar dinâmicas criminais e conhece como as instituições têm lidado com estes problemas.</p>
                </div>
              </div>
            </div>
          </li>
        </ul>
      </div>
      <?php get_sidebar(); ?>
    </div>
  </div>
</div>
<?php get_footer(); ?>