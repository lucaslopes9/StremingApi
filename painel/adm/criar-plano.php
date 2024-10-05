<?php
include("conexao.php");
include_once("functions.php");
include_once(Idioma(1));
if(ProtegePag() == true){
global $_TRA;

$ColunaAcesso = array('PagamentoPagSeguro', 'PagamentoPayPal', 'PagamentoMercadoPago', 'PagamentoContaBancaria');
$VerificarAcesso = VerificarAcesso('pagamentos', $ColunaAcesso);
$PagamentoPagSeguro = $VerificarAcesso[0];
$PagamentoPayPal = $VerificarAcesso[1];
$PagamentoMercadoPago = $VerificarAcesso[2];
$PagamentoContaBancaria = $VerificarAcesso[3];

if( ($PagamentoPagSeguro == 'S') || ($PagamentoPayPal == 'S') || ($PagamentoMercadoPago == 'S') || ($PagamentoContaBancaria == 'S') ){ 
	
$CadUser = InfoUser(2);

$SQL = "SELECT id, nomeplano, tipoperfil, tipoplano, dias, valor, perfil, quantidade FROM planos WHERE CadUser = :CadUser";
$SQL = $painel_geral->prepare($SQL);
$SQL->bindParam(':CadUser', $CadUser, PDO::PARAM_STR);
$SQL->execute();
?>

	<!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                	<li><?php echo $_TRA['Pagamentos']; ?></li>
                    <li class="active"><?php echo $_TRA['CriarPlano']; ?></li>
                </ul>
                <!-- END BREADCRUMB -->  
                
                <!-- PAGE TITLE -->
          <div class="page-title">                    
          <h2><span class="fa fa-wrench"></span> <?php echo $_TRA['CriarPlano']; ?></h2>
          </div>
                <!-- END PAGE TITLE -->   
 
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">                
                
                    <div class="row">
                        <div class="col-md-12">
                        
                        <div class="panel panel-default">
                                <div class="panel-heading">
                                <?php
                                	echo "<button type=\"button\" onclick=\"AdicionarForma();\" class=\"btn btn-info active\">".$_TRA['Adicionar']."</button>";
								?>
                                    <ul class="panel-controls">
                                        <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="fa fa-cog"></span></a>                                            
                                            <ul class="dropdown-menu">
                                                <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> <?php echo $_TRA['esconder']; ?></a></li>
                                                <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span> <?php echo $_TRA['atualizar']; ?></a></li>
                                            </ul>                                        
                                        </li>
                                    </ul>
                                </div>
                                <div class="panel-body">
                                                                
                                    <div class="table-responsive">
                               <table id="Tabela" class="table datatable">
                               <thead>
                               		<tr>
                                    	<th width="150"><?php echo $_TRA['TipodePerfil']; ?></th>
                                        <th>Nome do Plano</th>
                                        <th><?php echo $_TRA['TipodePlano']; ?></th>
                                        <th><?php echo $_TRA['dias']; ?></th>
                                        <th><?php echo $_TRA['Valor']; ?></th>
                                        <th><?php echo $_TRA['Perfil']; ?></th>
                                        <th><?php echo $_TRA['Quantidade']; ?></th>
                                        <th><?php echo $_TRA['opcoes']; ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <?php
								while($Ln = $SQL->fetch()){
									
									$dias = $Ln['dias'];
									$sdias = $dias > 1 ? $_TRA['dias'] : $_TRA['dia'];
																		
									if($Ln['tipoperfil'] == "SAT"){
										$tipoperfil = $_TRA['satelite'];
									}
									else{
										$tipoperfil = $_TRA['cabo'];
									}
									
									if($Ln['tipoplano'] == "N"){
										$tipoplano = $_TRA['normal'];
										$quantidade = $_TRA['nao'];
									}
									else{
										$tipoplano = $_TRA['prepago'];
										$quantidade = $Ln['quantidade'];
									}
									
									if(empty($Ln['nomeplano'])){
										$nomeplano = "-";
									}
									else{
										$nomeplano = $Ln['nomeplano'];
									}
									
									$valor = number_format($Ln['valor'], 2, ',', '');
						
										echo "
                                        <tr>
											<td>".$tipoperfil."</td>
											<td>".$nomeplano."</td>
                                        	<td>".$tipoplano."</td>
											<td>".$dias." ".$sdias."</td>
											<td>".VerRepDin()." ".$valor."</td>
											<td>".SelecionarPerfilAdminRev($Ln['perfil'])."</td>
											<td>".$quantidade."</td>
                                       	    <td><div class=\"form-group\">";
											
								echo "<a class=\"label label-info\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"\" data-original-title=\"".$_TRA['info']."\" onclick=\"InformacoesForma('".$Ln['id']."');\"><i class=\"fa fa-info-circle\"></i></a>&nbsp;";
								
								echo "<a class=\"label label-warning\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"\" data-original-title=\"".$_TRA['editar']."\" onclick=\"EditarForma('".$Ln['id']."');\"><i class=\"fa fa-pencil\"></i></a>&nbsp;";
								
								echo "<a onclick=\"DeletarForma('".$Ln['id']."');\" class=\"label label-danger\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"\" data-original-title=\"".$_TRA['excluir']."\"><i class=\"fa fa-trash-o\"></i></a>&nbsp;";
								
									echo "</div>
										</td>
                                      </tr>
										";
										}
										?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>                             
                            </div>



                        </div>
                    </div>                                
                    
                </div>
                <!-- PAGE CONTENT WRAPPER -->      
        

		<div id="StatusGeral"></div>        
<!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap.min.js"></script>  
        <!-- END PLUGINS -->

        <!-- START THIS PAGE PLUGINS-->        
        <script type='text/javascript' src='js/plugins/icheck/icheck.min.js'></script>
        <script type="text/javascript" src="js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>  
        <script type='text/javascript' src='js/plugins/maskedinput/jquery.maskedinput.min.js'></script>  
        <script type="text/javascript" src="js/plugins/datatables/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="js/DataTables<?php echo Idioma(2); ?>.js"></script>  
        <!-- END THIS PAGE PLUGINS-->        

        <!-- START TEMPLATE -->
        <?php include_once("js/settings".Idioma(2).".php"); ?> 
        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/actions.js"></script>
        <!-- END TEMPLATE -->
        
        <script type='text/javascript'> 
		function InformacoesForma(id){
							
				panel_refresh($(".page-container"));
 						
				$.post('ScriptModalInfoCriarPlano.php', {id: id}, function(resposta) {
					
				setTimeout(panel_refresh($(".page-container")),500);
					
				$("#StatusGeral").html('');
				$("#StatusGeral").html(resposta);
				});
		}
		 
		function DeletarForma(id){
			 		
 				var titulo = '<?php echo $_TRA['excluir']; ?>?';
				var texto = '<?php echo $_TRA['tcqdeop']; ?>?';
				var tipo = 'danger';
				var url = 'EnviarDeletarCriarPlano';
				var fa = 'fa fa-trash-o';  
			
				$.post('ScriptAlertaJS.php', {id: id, titulo: titulo, texto: texto, tipo: tipo, url: url, fa: fa}, function(resposta) {
					$("#StatusGeral").html('');
					$("#StatusGeral").html(resposta);
				});
		}

		function EditarForma(id){  
 							
				panel_refresh($(".page-container")); 
				$.post('ScriptModalCriarPlanoEditar.php', {id: id}, function(resposta) {
				
				setTimeout(panel_refresh($(".page-container")),500);	
					$("#StatusGeral").html('');
					$("#StatusGeral").html(resposta);
				});
				
		}

		function AdicionarForma(){ 
			
				panel_refresh($(".page-container")); 
 						
				$.post('ScriptModalCriarPlano.php', function(resposta) {
					
				setTimeout(panel_refresh($(".page-container")),500);
					$("#StatusGeral").html('');
					$("#StatusGeral").html(resposta);
				});
				
		}

		</script>

    <!-- END SCRIPTS -->    
<?php
}else{
	echo Redirecionar('index.php');
}
}else{
	echo Redirecionar('login.php');
}	
?>