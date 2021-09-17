<?php 
require_once 'crest.php';

/**
*  Returns the date in ISO8601 format
* @var $day integer, specifies how many days to add to the current date
* @return date format ISO8601
*/

function dateISO(int $day = 0){
	if ($day == 0) {
		$date = time();
	}else{
		$date = strtotime('+'.$day.' day');
	}
	return date(DateTime::ISO8601, $date);
}

/**
* 
* 
*/
class invoice{
	private id_deal;
	private id_company;
	private id_contact;
	private id_mycompany;
	private order_topic;
	private date_pay_before;
	private user_description;
	private quantity;
	private price;
	private qrcode;
	
	public function __construct(int $day = 0, string $id){
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


		$this->id_deal = $id;
		$this->id_company = $result['find_deal']['COMPANY_ID'];
		$this->id_contact = $result['find_deal']['CONTACT_ID'];
		$this->id_mycompany = $result['find_deal']['UF_CRM_1631861994'];
		$this->order_topic = $result['get_company']['UF_CRM_1594794891'] .' счёт за период '. $result['get_company']['UF_CRM_1619766058'];
		$this->date_pay_before = dateISO($day);
		$this->user_description = 'Отгрузка в период '. $result['get_company']['UF_CRM_1619766058'] .' на общий вес: '. $result['get_company']['UF_CRM_1614603075'] .' кг.';
		$this->quantity = '';
		$this->price = '';
		$this->qrcode = '';
	};

	public function getQRcode(){

	}
}


?>