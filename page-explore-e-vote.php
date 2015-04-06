<?php get_header(); ?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="font-roboto red">Propostas de debate em votação:</h2>
    </div>
    <div class="col-md-12  mt-lg">
      <span>Filtrar por:</span>
      <input type="button" class="btn" value="Direito do Consumidor">
      <input type="button" class="btn" value="Direito de Trânsito">
      <input type="button" class="btn" value="Política Penitenciária">
      <input type="button" class="btn" value="Segurança Pública">
      <input type="button" class="btn" value="Sociedade da Informação">
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-md-4  mt-lg">
      <div class="proposal">
        <figure class="img-responsive">
          <img src="http://lorempixel.com/output/business-q-c-400-300-9.jpg">
          <figcaption>
          <h5 class="font-roboto red">Título da proposta</h5>
          <small>Nome do criador</small>
          <span class="proposal-details">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever.Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever  dummy text ever.</span>
          <div class="proposal-footer">
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
                <span class="proposal-stats-label">discordam</span>
              </li>
              <li class="proposal-date">
                <div class="proposal-stats-date">
                  <div class="days">29 dias</div>
                </div>
                <div class="proposal-stats-label">para encerrar</div>
              </li>
            </ul>
          </div>
          <button class="btn btn-danger btn-sm btn-block" type="submit">Ver proposta</button>
          </figcaption>
        </figure>
      </div>
    </div>
  </div>
  <div class="row text-center">
    <button type="button" class="btn btn-danger">Mostrar mais propostas</button>
  </div>
</div>
<div class="container mt-lg divider-top">
  <h4 class="font-roboto">Este debate começou aqui:</h4>
  <div class="well well-sm clearfix pd-0">
    <div class="col-sm-4 pl-0 pr-0">
      <a href="#">
        <img class="img-full" src="http://lorempixel.com/output/business-q-c-400-300-9.jpg">
      </a>
    </div>
    <div class="col-sm-8 mb-md mt-md">
      <h4 class="font-roboto red">Título do debate</h4>
      <small>Criado por: Nome do criador</small>
      <p>
      Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever.Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever dummy text ever dummy text ever dummy text ever. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever.Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
      </p>
      <button class="btn btn-danger btn-sm" type="submit">Participar do debate</button>
    </div>
  </div>
  
</div>
<?php get_footer(); ?>