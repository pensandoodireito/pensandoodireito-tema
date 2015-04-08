<?php get_header(); ?>
<div class="container">
  <div class="row">
    <div class="col-lg-12">
      <h3 class=" font-roboto red"><strong>Proposta de debate em votação:</strong></h3>
      <h4>"título da proposta"</h4>
      <p><small>Criada por: Nome do Criador</small></p>
      <p><span class="label label-default">Direito do Consumidor</span></p>
    </div>
  </div>
  <div class="row">
    <div class="col-md-8 col-offset-3">
      <p><strong>RESUMO:</strong> Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo</p>
      
    </div>
  </div>
  <div class="row">
    <div class="col-lg-5 col-md-6">
      <iframe id="ytplayer" type="text/html" width="100%" height="315" src="https://www.youtube.com/embed/EHHmVbNNvHQ?controls=1&autohide=1"
      frameborder="0" allowfullscreen></iframe>
    </div>
    <div class="col-md-6 col-lg-3 text-center">
      <p><strong>Qual a sua opinião sobre abrirmos esta proposta para debate?</strong></p>
      <button type="button" class="btn btn-lg btn-success btn-block"><i class="fa fa-check-circle fa-2x pull-left"></i>Concordo com a <br>abertura deste debate</button>
      <button type="button" class="btn btn-lg btn-danger btn-block">
      <i class="fa fa-times-circle fa-2x pull-left"></i>Discordo da <br> abertura deste debate</button>
      <div class="">
        <small>Resultado parcial da votação:</small>
        <div class="progress">
          <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
          </div>
        </div>
        <ul class="proposal-stats">
          <li>
            <div class="proposal-vote-yes">30%</div>
            <span class="proposal-stats-label">concordam</span>
          </li>
          <li>
            <div class="proposal-vote-no">70%</div>
            <span class="proposal-stats-label">discordam</span></li>
          </ul>
        </div>
      </div>
      <div class="col-lg-4 col-sm-12">
        <div class="detail-box">
          <div class="col-xs-12 col-sm-6 col-lg-12">
            <img class="img-full" src="http://lorempixel.com/output/business-q-c-400-300-9.jpg">
          </div>
          <div class="col-xs-12 col-sm-6 col-lg-12">
            <div class="days countdown"><i class="fa fa-clock-o fa-lg"></i> 09 dias</div>
            <div class="proposal-stats-label">para encerrar a votação</div>
            <span><strong>Compartilhe:</strong></span>
            <div class="form-group ">
              <div class="input-group">
                <div class="input-group-addon">url</div>
                <input class="form-control input-sm" type="text" placeholder="url.com.br">
                <div class="input-group-addon"><a href="#" class="small pull-right"><i class="fa fa-link"></i> copiar link</a></div>
              </div>
            </div>
            <button type="button" class="btn btn-primary btn-block"><i class="fa fa-facebook-square"></i> Facebook</button>
            <button type="button" class="btn btn btn-info btn-block "><i class="fa fa-twitter-square"></i> Twitter</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php get_footer(); ?>