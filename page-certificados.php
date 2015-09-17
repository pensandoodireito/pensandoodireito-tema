<?php
if (@$_POST['id_certificado']) {

	global $wpdb;

	$certificado = $wpdb->get_row($wpdb->prepare( "SELECT c.id as id, c.nome as nome, e.id as evento_id FROM participantes c INNER JOIN " .
                                                    "evento e ON (e.id = c.evento_id) WHERE c.id=%d",
                                                    $_POST['id_certificado'] ));

	require ( get_stylesheet_directory() . '/inc/fpdf/fpdf.php');
	require ( get_stylesheet_directory() . '/inc/fpdf/fpdi.php');

	$pdf = new FPDI('L','mm',"A4");

	$pdf->setSourceFile( get_stylesheet_directory() . "/certificados/evento_" . $certificado->evento_id .".pdf");

	$pdf->AddPage('L');
	$tplidx = $pdf->importPage(1, '/MediaBox');
	$pdf->useTemplate($tplidx, 0, 0, 297, 210, true);

	$pdf->SetXY(10,85);

	//Informamos a fonte, seu estilo e seu tamanho
	$pdf->SetFont('Arial','',28);

	$pdf->Cell(0,8, iconv("UTF-8", "CP1252",$certificado->nome),0,1,'C');

	$arquivo_certificado = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(" ","_",$certificado->nome)).".pdf";

	$pdf->Output($arquivo_certificado,'D');

    $wpdb->query( $wpdb->prepare("UPDATE participantes SET data_geracao = CURRENT_TIMESTAMP WHERE id=%d", $_POST['id_certificado']));
}

get_header(); ?>

<section>
    <div class="container mt-lg mb-lg">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) :
            the_post(); ?>

                <div class="col-md-8 col-md-offset-1" id="conteudo">
                    <h1 class="red font-roboto mt-lg"><?php the_title(); ?></h1>
                    <?php the_content('Leia mais...'); ?>
                </div>
            <?php endwhile;
        endif; ?>

        <div class="box-escolha-nome col-md-8 col-md-offset-1">
		    <form method="POST">
			    <p>
                <label for="nome_certificado">Digite seu nome: </label></p>
                <p><input class="form-control" type="text" name="nome_certificado"/></p>

                <p id="resumo-certificado"></p>
                <p class="text-center">
                    <input type="hidden" name="id_certificado"/>
			        <button class="btn btn-primary" id="botao-emitir-certificado" type="submit" style="display:none;">Emitir certificado</button>
                </p>
		    </form>
	    </div>
    </div>
</section>
<?php get_footer();?>
