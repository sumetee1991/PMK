
<script type="text/javascript">
	const removeID = {
		'QueueCate' : '#li_queuecategory',		
	}
	//const base_path_url = '<?=LOCALURL;?>Management/';
	const base_path_url = './';

	const defaultDataTable = {
		Name: "#dataTable",
		Filter: "#SearchHN_DT",
	}

	const RowIDPrefix = "Queue_";

	const const_groupprocessid = "2";
	const initPageFunction = "initManagement";
	
	const WorklistActionID = {
		'Call':'7',
		'Hold':'8',
		'Complete':'24',
		'Cancel':'14',
		'CompleteAll':'14',
	}

	const CheckColumn = {
		'Call': 'callqueue',
		'Hold': 'holdqueue',
		'Complete': 'closqueue_register',
		'Cancel': 'cancelqueue_register',
		'CompleteAll': 'closqueue_register',
	};

	const dataAttr = {
		PatientUID: "patientuid",
		Clear: "clear", 
		Call: "q_call", 
		Hold: "q_hold", 
		Complete: "q_complete", 
		Cancel: "q_cancel", 
		CompleteAll: "q_completeall",
	};

	const dataAttribute = {
		Name : {
			PatientUID: dataAttr['PatientUID'],
			Clear: dataAttr['Clear'], 
			Call: dataAttr['Call'], 
			Hold: dataAttr['Hold'], 
			Complete: dataAttr['Complete'], 
			Cancel: dataAttr['Cancel'], 
			CompleteAll: dataAttr['CompleteAll'], 
		},
		Attr : {
			PatientUID: "data-"+dataAttr['PatientUID'],
			Clear: "data-"+dataAttr['Clear'], 
			Call: "data-"+dataAttr['Call'], 
			Hold: "data-"+dataAttr['Hold'], 
			Complete: "data-"+dataAttr['Complete'], 
			Cancel: "data-"+dataAttr['Cancel'], 
			CompleteAll: "data-"+dataAttr['CompleteAll'], 
		},
		Semi : {
			PatientUID: "[data-"+ dataAttr['PatientUID'],
			Clear: "[data-"+ dataAttr['Clear'],
			Call: "[data-"+ dataAttr['Call'], 
			Hold: "[data-"+ dataAttr['Hold'], 
			Complete: "[data-"+ dataAttr['Complete'], 
			Cancel: "[data-"+ dataAttr['Cancel'], 
			CompleteAll: "[data-"+ dataAttr['CompleteAll'], 		
		},
		Full : {
			PatientUID: "[data-"+ dataAttr['PatientUID'] +"]", 
			Clear: "[data-"+ dataAttr['Clear'] +"]", 
			Call: "[data-"+ dataAttr['Call'] +"]", 
			Hold: "[data-"+ dataAttr['Hold'] +"]", 
			Complete: "[data-"+ dataAttr['Complete'] +"]", 
			Cancel: "[data-"+ dataAttr['Cancel'] +"]", 
			CompleteAll: "[data-"+ dataAttr['CompleteAll'] +"]", 	
		}
	};

	const tableColumns = {
		Number: '0',
		QueueNumber: '1',
		QueueType: '2',
		QueuePayor: '3',
		WaitingQueue: '4',
		FullName: '5',
		HN: '6',
		CallChanel: '7',
		Status: '8',
		Btn_Call: '9',
		Btn_Hold: '10',
		Btn_Complete: '11',
		Btn_Cancel: '12',
	};

	var tableNumber = 0;

	const defaultButtonClass = "button block small ";
	const colorButtonClass = {
		Call: "c_green ",
		Hold: "c_yellow ",
		Complete: "static_blue ",
		Cancel: "c_red ",
	}
	const defaultButtonMessage = {
		Call: "Call ",
		Hold: "Hold ",
		Complete: '<i class="fas fa-check"></i>',
		Cancel: '<i class="fas fa-trash-alt"></i>',
		CompleteAll: 'เสร็จสิ้นทั้งหมด',
		CancelDrop: 'ยกเลิกคิว',
	}

	const actionButtonClass = {
		Call: defaultButtonClass + colorButtonClass['Call'],
		Hold: defaultButtonClass + colorButtonClass['Hold'],
		Complete: defaultButtonClass + colorButtonClass['Complete'],
		Cancel: "none " + colorButtonClass['Cancel'],
		CompleteAll: 'dropdown-item ',
		CancelDrop: 'dropdown-item ',
	}

	const TabSpanID = {
		'Counter' : '#span_Counter',
		'QueueCate' : '#span_QueueCategory',
	}

	var localTab = {
		'Counter' : '',
		'QueueCate' : '',
	}

	var SetupVar = new Object();
</script>
<script>
	const SiteTitle = '<?=( isset($Data['TitleText']) ? $Data['TitleText'] : '' );?>';
	const Management_LocationCounter = 'locationAvailable_JSON2/';
	const GetQueueInfo_PUID = 'GetQueueInfo_PUID/';
	const GetQueueInfo_Queueno = 'GetQueueInfo_Register_Queueno/';
	const GetQueue_RelatedQueueno = 'GetQueueRegister_RelatedQueueno/';
	const GetQueue_RelatedPUID = 'GetQueueInfo_Register/';

	const WorklistStatusURL = 'GetWorklistStatus/';
	const Management_CallURL = 'CallQueue/';
	const Management_CallCurl = 'Call_Curl/';
	const Management_HoldURL = 'HoldQueue/';
	const Management_HoldCurl = 'Hold_Curl/';
	const Management_HoldInsert = 'InsertMessage/';
	const Management_CompleteURL = 'CompleteQueue/';
	const Management_CancelURL = 'CancelQueue/';
</script>