<?php get_header(); 

global $wp_query;
$args = array_merge( $wp_query->query_vars, array( 'posts_per_page' => -1 ) );
query_posts( $args );

?>
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
        <?php while(have_posts()): the_post();

                $parceiro_link = get_post_meta(get_the_ID(),'parceiro_link', true);
            ?>


          <li class="list-group-item">
            <div class="row">
              <div class="col-sm-3 text-center">
                  <a href="<?php echo $parceiro_link; ?>" alt="<?php the_title(); ?>">
                    <?php the_post_thumbnail('thumbnail', array('class' => 'img-full img-thumbnail logos-parceiros')); ?>
                  </a>
              </div>
              <div class="col-sm-9">
                <h4 class="list-group-item-heading"><a href="<?php echo $parceiro_link; ?>" alt="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
                <div class="list-group-item-text">
                  <?php the_content(); ?>
                </div>
              </div>
            </div>
          </li>

        <?php endwhile; ?>

        </ul>
      </div>
      <?php get_sidebar(); ?>
    </div>
  </div>
</div>
<?php get_footer(); ?>
