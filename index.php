<?php
require('clases/clase_calculadora_ip.php');

$_POST['ip'] = empty($_POST['ip']) ? null : $_POST['ip'];
$_POST['mascara'] = empty($_POST['mascara']) ? null : $_POST['mascara'];
$_POST['subnet'] = empty($_POST['subnet']) ? null : $_POST['subnet'];
$_POST['calcular'] = empty($_POST['calcular']) ? null : $_POST['calcular'];

$objCalculadoraIP = new CalculadoraIP;
$subNets = new CalculadoraIP;

if(!$_POST['calcular']){
	unset($objCalculadoraIP);	 
}else{

	$objCalculadoraIP->ip = $_POST['ip'];
	$objCalculadoraIP->mascara = $_POST['mascara'];
	$objCalculadoraIP->Calcular();

	$resultado = '';

	$resultado .= "\n\n";
	$resultado .= 'Mask    : '.$objCalculadoraIP->InserirPontosEmIps($objCalculadoraIP->mascara_binaria)."   ".$objCalculadoraIP->IPBinarioParaDecimal($objCalculadoraIP->mascara_binaria)."\n";
	$resultado .= 'IP      : '.$objCalculadoraIP->InserirPontosEmIps($objCalculadoraIP->ip_binario)."   ".$objCalculadoraIP->IPBinarioParaDecimal($objCalculadoraIP->ip_binario)."\n";
	$resultado .= 'Red     : '.$objCalculadoraIP->InserirPontosEmIps($objCalculadoraIP->endereco_de_rede)."   ".$objCalculadoraIP->IPBinarioParaDecimal($objCalculadoraIP->endereco_de_rede)."/".$objCalculadoraIP->cidr."\n";
	$resultado .= 'Mask Inv: '.$objCalculadoraIP->InserirPontosEmIps($objCalculadoraIP->mascara_inversa)."   ".$objCalculadoraIP->IPBinarioParaDecimal($objCalculadoraIP->mascara_inversa)."\n";
	if($objCalculadoraIP->cidr!=31 && $objCalculadoraIP->cidr!=32){
		$resultado .= 'IP Broad: '.$objCalculadoraIP->InserirPontosEmIps($objCalculadoraIP->endereco_de_broadcast)."   ".$objCalculadoraIP->IPBinarioParaDecimal($objCalculadoraIP->endereco_de_broadcast)."\n";
	}
	if($objCalculadoraIP->cidr!=32){
		$resultado .= 'IP Min  : '.$objCalculadoraIP->InserirPontosEmIps($objCalculadoraIP->gateway1)."   ".$objCalculadoraIP->IPBinarioParaDecimal($objCalculadoraIP->gateway1)."\n";
		$resultado .= 'IP Max  : '.$objCalculadoraIP->InserirPontosEmIps($objCalculadoraIP->gateway2)."   ".$objCalculadoraIP->IPBinarioParaDecimal($objCalculadoraIP->gateway2)."\n\n";
	}
	
    $resultado .= 'Clase   : '.$objCalculadoraIP->classe."\n";
    $resultado .= 'CIDR    : '.$objCalculadoraIP->cidr."\n\n";

    /*$resultado .= 'Mask    : '.$objCalculadoraIP->IPBinarioParaDecimal($objCalculadoraIP->mascara_binaria)."\n";
	$resultado .= 'IP      : '.$objCalculadoraIP->IPBinarioParaDecimal($objCalculadoraIP->ip_binario)."\n";
	$resultado .= 'Red     : '.$objCalculadoraIP->IPBinarioParaDecimal($objCalculadoraIP->endereco_de_rede)."/".$objCalculadoraIP->cidr."\n";
	$resultado .= 'Mask Inv: '.$objCalculadoraIP->IPBinarioParaDecimal($objCalculadoraIP->mascara_inversa)."\n";
	$resultado .= 'IP Broad: '.$objCalculadoraIP->IPBinarioParaDecimal($objCalculadoraIP->endereco_de_broadcast)."\n";
	$resultado .= 'IP Min  : '.$objCalculadoraIP->IPBinarioParaDecimal($objCalculadoraIP->gateway1)."\n";
	$resultado .= 'IP Max  : '.$objCalculadoraIP->IPBinarioParaDecimal($objCalculadoraIP->gateway2)."\n\n";*/

	$resultado .= 'SubNets : '.$objCalculadoraIP->qtd_subnets_str.' ou '.$objCalculadoraIP->qtd_subnets."\n";
	$resultado .= 'IPs     : '.$objCalculadoraIP->qtd_ips_str.' ou '.$objCalculadoraIP->qtd_ips."\n";
	$resultado .= 'Hosts   : '.$objCalculadoraIP->qtd_hosts_str.' ou '.$objCalculadoraIP->qtd_hosts."\n\n";

	if(!empty($_POST['subnet'])){

		if($_POST['subnet']>($objCalculadoraIP->cidr) && $_POST['subnet']<32){

			$resultado .= 'SUBNETS DE '.$objCalculadoraIP->cidr.' a '.$_POST['subnet']."\n\n";
			
			$maxSubNet=1;
			$IpLimiteMin=$objCalculadoraIP->IPBinarioParaDecimal($objCalculadoraIP->endereco_de_rede);
			$IpLimiteMax=$objCalculadoraIP->endereco_de_broadcast;
			$cont=1;
			$contHost=0;


			while ($maxSubNet<>0) {
				
				$subNets->ip =$IpLimiteMin;
				$subNets->mascara = $_POST['subnet'];
				$subNets->Calcular();

				$resultado .= $cont.'. '."\n";
				$resultado .= "	Red      :  ".$subNets->IPBinarioParaDecimal($subNets->endereco_de_rede)."/".$subNets->cidr." \n";
				$resultado .= "	HostMin  :  ".$subNets->IPBinarioParaDecimal($subNets->gateway1)." \n";
				$resultado .= "	HostMax  :  ".$subNets->IPBinarioParaDecimal($subNets->gateway2)." \n";
				$resultado .= "	Broadcast:  ".$subNets->IPBinarioParaDecimal($subNets->endereco_de_broadcast)." \n";
				$resultado .= "	Host     :  ".$subNets->qtd_hosts_str.' ou '.$subNets->qtd_hosts."\n\n";
				
				$contHost+=$subNets->qtd_hosts;
				if($IpLimiteMax==$subNets->endereco_de_broadcast ){
					$maxSubNet=0;
				}else{
				  $IpLimiteMin=$subNets->SgteRed($subNets->endereco_de_broadcast);
				  $cont++;

				}
					
								
			}

			$resultado .= "SubNets  :  ".$cont." \n";
			$resultado .= "Host     :  ".$contHost." \n";
			

		}else{
			$resultado .= 'SUBNET INVALIDA';
		}
	}

	$msg = $objCalculadoraIP->msg;
	unset($objCalculadoraIP);
}

require('template/index_template.php');

?>
