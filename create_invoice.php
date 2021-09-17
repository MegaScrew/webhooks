<?php 
require_once 'function.inc.php';

/*
*Стоимость за Кг - UF_CRM_1613731949
*Перевес в кг - UF_CRM_1614603075
*Период за который перевес - UF_CRM_1619766058
*Договор с ИП - UF_CRM_1631861994
*Внутренний номер магазина - UF_CRM_1594794891
*56644 - ИП Сидоров МА
*64946 - ИП Коротеев А.В.
*64948 - ИП Кучаев Д.Н.
*/

$arData = [
	'find_deal' => [
		'method' => 'crm.deal.get',
		'params' => [ 'ID' => $_POST['id'], 'select' => ['ID', 'COMPANY_ID', 'CONTACT_ID', 'UF_CRM_1631861994']]
	],
	'get_company' => [
		'method' => 'crm.company.get',
		'params' => [ 'ID' => '$result[find_deal][COMPANY_ID]', 'select' => ['ID', 'UF_CRM_1613731949', 'UF_CRM_1614603075', 'UF_CRM_1619766058']]
	],
	'add_invoice' => [
		'method' => 'crm.invoice.add',
		'params' => [ 
			'ID' => '$result[get_contact][COMPANY_ID]', 
			'fields' => [
				'UF_CONTACT_ID' => '$result[find_deal][CONTACT_ID]',
				'UF_COMPANY_ID' => '$result[find_deal][COMPANY_ID]',
                'UF_MYCOMPANY_ID' => '$result[find_deal][UF_CRM_1631861994]',
				'UF_DEAL_ID' => '$result[find_deal][ID]',                        
                'ORDER_TOPIC' => '$result[get_company][UF_CRM_1594794891] счёт за период $result[get_company][UF_CRM_1619766058]',
                'STATUS_ID' => 'N',
                'PAY_SYSTEM_ID' => 2,
                'PERSON_TYPE_ID' => 1,
                'DATE_PAY_BEFORE' => dateISO(3),
                'USER_DESCRIPTION' => 'Отгрузка в период $result[get_company][UF_CRM_1619766058] на общий вес: $result[get_company][UF_CRM_1614603075] кг.',
                'PRODUCT_ROWS' => [
                	'0' => [
                    	'PRODUCT_ID' => 209260,
                        'QUANTITY' => '$result[get_company][UF_CRM_1614603075]',
                        'PRICE' => '$result[get_company][UF_CRM_1613731949]',
                        'MEASURE_CODE' => '166',       
                        'MEASURE_NAME' => 'кг',
                        'PRODUCT_NAME' => 'Пищевые отходы 5 класса опасности'
                    ]
                ]
            ]
        ]
	]
];

// $result = CRest::callBatch($arData);
// while($result['error']=="QUERY_LIMIT_EXCEEDED"){
//     sleep(1);
//     $result = CRest::callBatch($arData);
//     if ($result['error']<>"QUERY_LIMIT_EXCEEDED"){break;}
// }
// echo '<pre>';
// 	print_r($result);
// echo '</pre>';
?>