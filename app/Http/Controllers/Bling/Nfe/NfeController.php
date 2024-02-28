<?php

namespace App\Http\Controllers\Bling\Nfe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NfeController extends AbstractNfeController
{
    
    const URL_BASE_GET_ORDERS_BLING = "https://bling.com.br/Api/v2/";

    function resource(){
        return $this->get('notafiscal/json/');
    }


    function get($resource){

        // ENDPOING PARA REQUISICAO
        $endpoint = self::URL_BASE_GET_ORDERS_BLING . $resource;
   
        $xml = "
        <?xml version='1.0' encoding='UTF-8'?>
        <pedido>
        <cliente>
            <nome>Organisys Software</nome>
            <tipoPessoa>J</tipoPessoa>
            <cpf_cnpj>00000000000000</cpf_cnpj>
            <ie_rg>3067663000</ie_rg>
            <endereco>Rua Visconde de São Gabriel</endereco>
            <numero>392</numero>
            <complemento>Sala 54</complemento>
            <bairro>Cidade Alta</bairro>
            <cep>95.700-000</cep>
            <cidade>Bento Gonçalves</cidade>
            <uf>RS</uf>
            <fone>54 8115-3376</fone>
            <email>teste@teste.com.br</email>
        </cliente>
        <transporte>
            <transportadora>Transportadora XYZ</transportadora>
            <cpf_cnpj>11122233345</cpf_cnpj>
            <ie_rg>1122334455</ie_rg>
            <endereco>Rua Silvio Orlandini, 435</endereco>
            <cidade>Roca Sales</cidade>
            <uf>RS</uf>
            <placa>ILM-1020</placa>
            <uf_veiculo>RS</uf_veiculo>
            <tipo_frete>R</tipo_frete>
            <qtde_volumes>10</qtde_volumes>
            <especie>Volumes</especie>
            <numero>425</numero>
            <peso_bruto>157</peso_bruto>
            <peso_liquido>142</peso_liquido>
            <servico_correios>SEDEX</servico_correios>
            <dados_etiqueta>
                <nome>Endereço de entrega</nome>
                <endereco>Rua Visconde de São Gabriel</endereco>
                <numero>392</numero>
                <complemento>Sala 59</complemento>
                <municipio>Bento Gonçalves</municipio>
                <uf>RS</uf>
                <cep>95.700-000</cep>
                <bairro>Cidade Alta</bairro>
            </dados_etiqueta>
            <volumes>
                <volume>
                    <servico>SEDEX - CONTRATO</servico>
                    <codigoRastreamento></codigoRastreamento>
                </volume>
                <volume>
                    <servico>PAC - CONTRATO</servico>
                    <codigoRastreamento></codigoRastreamento>
                </volume>
            </volumes>
        </transporte>
        <itens>
            <item>
                <codigo>000179</codigo>
                <descricao>Garrafa para suco 500ml frasco leitoso com 100 unidades</descricao>
                <un>Cx</un>
                <qtde>1</qtde>
                <vlr_unit>64.19</vlr_unit>
                <tipo>P</tipo>
                <peso_bruto>2.300</peso_bruto>
                <peso_liq>2.300</peso_liq>
            </item>
        </itens>
        <nf_produtor_rural_referenciada>
            <numero>001020</numero>
            <serie>0</serie>
            <ano_mes_emissao>1202</ano_mes_emissao>
        </nf_produtor_rural_referenciada>
        <vlr_frete>15</vlr_frete>
        <vlr_seguro>7</vlr_seguro>
        <vlr_despesas>2.5</vlr_despesas>
        <vlr_desconto>10</vlr_desconto>
        <obs>Testando o campo observações do pedido</obs>
</pedido>
";



$posts = array(
"apikey" => env('KEY_BLING'),
"xml" => rawurlencode($xml),
);

$curl_handle = curl_init();
curl_setopt($curl_handle, CURLOPT_URL, $endpoint);
curl_setopt($curl_handle, CURLOPT_POST, 1);
curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $posts);
curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
$response = curl_exec($curl_handle);
$httpCode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
curl_close($curl_handle);
echo "
<pre>";
print_r(json_decode($response));

}
}