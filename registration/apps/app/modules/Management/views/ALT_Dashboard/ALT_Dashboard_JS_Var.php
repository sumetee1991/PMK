
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

	const const_groupprocessid = '1';
	const initPageFunction = "initManagement_NewHN";

	const WorklistActionID = {
		'Call':'12',
		'Hold':'13',
		'Complete':'10',
		'Cancel':'15',
		'CompleteAll':'16',
	}

	const CheckColumn = {
		'Call': 'callnewhn',
		'Hold': 'holdnewhn',
		'Complete': 'closqueue_registerhn',
		'Cancel': 'cancelqueue_registerhn',
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
		CallChanel: '6',
		Status: '7',
		Btn_Call: '8',
		Btn_Hold: '9',
		Btn_Complete: '10',
		Btn_Cancel: '11',
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
	const Management_LocationCounter = 'locationAvailable_JSON/';
	const GetQueueInfo_PUID = 'GetQueueInfo_PUID/';
	const GetQueueInfo_Queueno = 'GetQueueInfo_NewHN_Queueno/';
	const GetQueue_RelatedQueueno = 'GetQueueInfo_NewHN_Queueno/'; //
	const GetQueue_RelatedPUID = 'GetQueueInfo_NewHN/';

	const WorklistStatusURL = 'GetWorklistStatus/';
	const Management_CallURL = 'CallQueue/';
	const Management_CallCurl = 'Call_Curl/';
	const Management_HoldURL = 'HoldQueue/';
	const Management_HoldCurl = 'Hold_Curl/';
	const Management_HoldInsert = 'InsertMessage/';
	const Management_CompleteURL = 'CompleteQueue/';
	const Management_CancelURL = 'CancelQueue/';
</script>