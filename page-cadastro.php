<?php get_header(); ?>
<div id="cadastro">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="font-roboto red">Cadastre-se</h1>
            </div>
        </div>
        <div class="row mt-md">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div id="form-cadastro">
                            <form>
                                <div class="form-group">
                                    <label for="nomeUser">Nome de <span class="red">usuário</span>:</label>
                                    <input type="text" class="form-control" id="nomeUser"
                                           placeholder="Nome de usuário">
                                </div>
                                <div class="form-group mt-md">
                                    <label for="nomeApres">Nome de <span class="red">apresentação:</span></label>
                                    <input type="text" class="form-control" id="nomeApres"
                                           placeholder="Nome de apresentação">
                                </div>
                                <div class="form-group mt-md">
                                    <label for="email">E-mail</label>
                                    <input type="text" class="form-control" id="email"
                                           placeholder="Seu e-mail">
                                </div>
                                <div class="form-group mt-md">
                                    <label for="senha">Sua senha:</label>
                                    <input type="password" class="form-control" id="senha"
                                           placeholder="Sua senha">
                                </div>
                                <button type="submit" class="btn btn-danger mt-md">Cadastrar</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body bg-success pt-lg text-center">
                        <h3 class="font-roboto text-success"><i class="fa fa-check "></i> Cadastro realizado com
                            sucesso!
                        </h3>

                        <p class="mt-md h4"><strong>Agora verifique seu e-mail.</strong></p>

                        <p>Você receberá um e-mail de confirmação, basta clicar no link e você poderá participar de
                            qualquer debate do projeto! Obrigado!</p>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body bg-danger pt-lg text-center">
                        <h3 class="font-roboto red"><i class="fa fa-exclamation-circle"></i> Ooops!</h3>

                        <p class="mt-md h4"><strong>Ocorreu um erro durante o seu cadastro.</strong></p>

                        <p>Tente novamente em alguns instantes</p>
                    </div>
                </div>

            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-sm-4 col-xs-12">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/oquee/oquee-001.png"
                             class="img-adptive"
                             alt="Proteção de Dados Pessoais">
                    </div>
                    <div class="col-sm-8 col-xs-12">
                        <h3 class="font-roboto red">Mais de <strong>2397</strong> participantes!</h3>
                        <ul class="list-unstyled text-left h5">
                            <li class="mt-sm text-success"><i class="fa fa-check "></i> <strong>contribua</strong>
                                com suas ideias e opiniões
                            </li>
                            <li class="mt-sm text-success"><i class="fa fa-check"></i> fique por dentro das
                                <strong>leis em elaboração</strong></li>
                            <li class="mt-sm text-success"><i class="fa fa-check"></i> <strong>participe</strong>
                                do processo legislativo
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row mt-md">
                    <div class="col-md-12">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion"
                                           href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Por que devo me cadastrar?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
                                     aria-labelledby="headingOne">
                                    <div class="panel-body">
                                        <p>Porque esta é mais uma oportunidade de diálogo aberta pelo governo para ouvir
                                            a
                                            sociedade sobre temas importantes.</p>

                                        <p>Após realizar o seu cadastro, você poderá
                                            comentar os debates públicos abertos no site, concordar ou discordar de
                                            outros
                                            comentários, criar novas pautas e responder à pautas criadas por outros
                                            usuários.</p>

                                        <p>Por isso, ao se cadastrar, você será uma parte importante do processo,
                                            e sua opinião pode influenciar leis, decretos, portarias, e outras peças
                                            normativas sobre assuntos relevantes ao nosso país.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingTwo">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                           data-parent="#accordion" href="#collapseTwo" aria-expanded="false"
                                           aria-controls="collapseTwo">
                                            O que são "debates"?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel"
                                     aria-labelledby="headingTwo">
                                    <div class="panel-body">
                                        Na plataforma, os "debates" podem ser projetos, anteprojetos de lei, textos de
                                        decreto ou portarias que estão abertos à participação social para sua
                                        consolidação. Eles se destinam a coletar opiniões diversas e qualificadas sobre
                                        os temas em discussão.
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingThree">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                           data-parent="#accordion" href="#collapseThree" aria-expanded="false"
                                           aria-controls="collapseThree">
                                            Quem promove esta iniciativa?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel"
                                     aria-labelledby="headingThree">
                                    <div class="panel-body">
                                        Esta plataforma é uma iniciativa da Secretaria de Assuntos
                                        Legislativos do Ministério da Justiça e do projeto Pensando o Direito.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<?php get_footer(); ?>