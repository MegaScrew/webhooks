<?php 
require_once 'function.inc.php';

$my_invoice = new invoice(2, $_REQUEST['id']);

/*
*Стоимость за Кг - UF_CRM_1613731949
*Перевес в кг - UF_CRM_1614603075
*Период за который перевес - UF_CRM_1619766058
*Договор с ИП - UF_CRM_1631861994
*Внутренний номер магазина - UF_CRM_1594794891
*56644 - ИП Сидоров МА
*64954 - ИП Коротеев А.В.
*64952 - ИП Кучаев Д.Н.
*/

$arData = [
	'add_invoice' => [
		'method' => 'crm.invoice.add',
		'params' => [ 
			'ID' => $my_invoice->getIdCompany(), 
			'fields' => [
				'UF_CONTACT_ID' => $my_invoice->getIdContact(),
				'UF_COMPANY_ID' => $my_invoice->getIdCompany(),
                		'UF_MYCOMPANY_ID' => $my_invoice->getIdMyCompany(),
				'UF_DEAL_ID' => $my_invoice->getIdDeal(),                        
                		'ORDER_TOPIC' => $my_invoice->getOrderTopic(),
		                'STATUS_ID' => 'N',
		                'PAY_SYSTEM_ID' => 2,
		                'PERSON_TYPE_ID' => 1,
		                'DATE_PAY_BEFORE' => $my_invoice->getDatePayBefore(),
		                'USER_DESCRIPTION' => $my_invoice->getUserDescription(),
		                'UF_CRM_1631880804' => $my_invoice->getQRcode(),
		                'PRODUCT_ROWS' => [
		                	'0' => [
			                    	'PRODUCT_ID' => 209260,
			                        'QUANTITY' => $my_invoice->getQuantity(),
			                        'PRICE' => $my_invoice->getPrice(),
			                        'MEASURE_CODE' => '166',       
			                        'MEASURE_NAME' => 'кг',
			                        'PRODUCT_NAME' => 'Пищевые отходы 5 класса опасности'
		                    	]
                		]
            		]
        	]
	]
];

// echo '<pre>';
// 	print_r($arData);
// echo '</pre>';

$result = CRest::callBatch($arData);
while($result['error']=="QUERY_LIMIT_EXCEEDED"){
    sleep(1);
    $result = CRest::callBatch($arData);
    if ($result['error']<>"QUERY_LIMIT_EXCEEDED"){break;}
}
// echo '<pre>';
// 	print_r($result);
// echo '</pre>';
?>