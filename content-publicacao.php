<div class="container">
    <div class="row mt-md" id="publicacao">
        <div class="col-md-9">
          <h2 class="font-roboto red">Volume <?php echo get_post_meta(get_the_ID(), 'pub_number', true); ?> | <?php the_title(); ?></h2>
           <div class="description">
            <p><mark>Data da publicação: <?php the_date(); ?></mark></p>
            <p><?php the_excerpt(); ?></p>
            <p><?php the_content(); ?></p>
            <p><small><a href="#">Ver autores</a></small></p>
         </div>   
            <div class="row">
               <div id="social-bar" class="col-md-4">
                  <small>
                    <a href="#" class="nounderline">
                        <span class="fa-stack fa-lg">
                          <i class="fa fa-square-o fa-stack-2x"></i>
                          <i class="fa fa-facebook fa-stack-1x"></i>
                        </span>
                     </a>
                      </small>
                      <small>  
                        <a href="#" class="nounderline">
                            <span class="fa-stack fa-lg">
                              <i class="fa fa-square-o fa-stack-2x"></i>
                              <i class="fa fa-twitter fa-stack-1x"></i>
                            </span>
                        </a>
                      </small>  
                      <small>
                        <a href="#" class="nounderline">
                            <span class="fa-stack fa-lg">
                              <i class="fa fa-square-o fa-stack-2x"></i>
                              <i class="fa fa-linkedin fa-stack-1x"></i>
                            </span>
                        </a>
                      </small>  
                </div> 
                <div class="col-md-8 text-right">
                    <div class="btn-group mt-sm" role="group">
                        <a href="<?php echo get_post_meta(get_the_ID(), 'pub_dld_file', true); ?>" target="_blank" class="btn btn-default"><span class="fa fa-download"></span> BAIXAR</a>
                    </div>
                </div>  
            </div><!-- row -->
        	</br>
            <!--div id="pdf" style="border:1px solid red"-->
                <iframe src="<?php echo get_post_meta(get_the_ID(), 'pub_web_file', true); ?>" seamless id="pdf" width="100%" height="600px"></iframe>
            <!--/div-->
                 <div class="btn-group btn-group-justified" role="group" aria-label="">
                  <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default btn-lg"> <i class="fa fa-angle-left"></i> Anterior</button>
                  </div>
                  <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default btn-lg"><i class="fa fa-angle-right"></i> Próxima</button>
                  </div>
                </div>     
        </div>

        <div class="col-md-3">
          <h6>Outras Publicações:</h6> 
          <div class="panel panel-default">
            <div class="panel-body">
                <ul class="list-unstyled">
                    <li>    
                    <!-- card lateral -->
                     <a href="#" class="nounderline">
                       <div class="capa"> 
                        <div class="card"> 
                        <p>Título da publicação</p>       
                        </div>
                       </div>  
                    </a>  
                  <!-- /card lateral -->
                   </li>
                   <li>
                  <!-- card lateral -->
                     <a href="#" class="nounderline">
                       <div class="capa"> 
                        <div class="card"> 
                        <p>Título da publicação</p>       
                        </div>
                       </div>
                    </a>  
                  <!-- /card lateral -->
                   </li>
                   <li>
                 <!-- card lateral -->
                     <a href="#" class="nounderline">
                       <div class="capa"> 
                        <div class="card"> 
                        <p>Título da publicação</p>       
                        </div>
                       </div>  
                    </a>  
                  <!-- /card lateral -->
                   </li>
                   <li>                    
                  <!-- card lateral -->
                     <a href="#" class="nounderline">
                       <div class="capa"> 
                        <div class="card"> 
                        <p>Título da publicação</p>       
                        </div>
                       </div>
                    </a>  
                  <!-- /card lateral -->
                   </li>
                   <li> 
                 <!-- card lateral -->
                     <a href="#" class="nounderline">
                       <div class="capa"> 
                        <div class="card"> 
                        <p>Título da publicação</p>       
                        </div>
                       </div>
                    </a>  
                  <!-- /card lateral -->   
                  </li>
               <button type="button" class="btn btn-link">Ver todas</button> 
              <ul> 
            </div> <!-- panel body -->                                    
          </div> <!-- panel -->
        </div>
    </div>    
</div>    

