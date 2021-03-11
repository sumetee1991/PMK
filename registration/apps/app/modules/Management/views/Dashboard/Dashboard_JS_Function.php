
<script type="text/javascript">

	function AddQueueRow(SelectTable,Data){
		if(!checkDuplicate(SelectTable,tableColumns['QueueNumber'],'<span class="font_queuenumber">'+Data['queueno']+'</span>') && Data[CheckColumn['Complete']] == null && Data['active'] == 'Y' ){
			tableNumber += 1;
			dtAttr =  dataAttribute['Attr'];
			var CheckActiveClass = {
				'Call': ( Data[CheckColumn['Call']] == null ? '' : 'active' ),
				'Hold': ( Data[CheckColumn['Hold']] == null ? '' : 'active' ),
				'Complete': ( Data[CheckColumn['Complete']] == null ? '' : 'active' ),
				'Cancel': ( Data[CheckColumn['Cancel']] == null ? '' : 'active' ),
				'CompleteAll': ( Data[CheckColumn['Complete']] == null ? '' : 'active' ),
			};

			var btnClass = {
				Call: 'class="' + actionButtonClass['Call'] + ' ' + CheckActiveClass['Call'] + '" ',
				Hold: 'class="' + actionButtonClass['Hold'] + ' ' + CheckActiveClass['Hold'] + '" ',
				Complete: 'class="' + actionButtonClass['Complete'] + ' ' + CheckActiveClass['Complete'] + '" ',
				Cancel: 'class="' + actionButtonClass['Cancel'] + ' ' + CheckActiveClass['Cancel'] + '" ',
				CompleteAll: 'class="' + actionButtonClass['CompleteAll'] + ' ' + CheckActiveClass['CompleteAll'] + '" href="#" ',
				CancelDrop: 'class="' + actionButtonClass['CancelDrop'] + ' ' + CheckActiveClass['Cancel'] + '" href="#" ',
			};
			var btnAttr = {
				Call: dtAttr['Call'] + '="' + Data['queueno'] + '" ' + dtAttr['PatientUID']+'="'+ Data['patientuid'] + '" ',
				Hold: 'data-toggle="modal" data-target="#hold-modal" data-q_val="'+Data['queueno']+'" data-puid_val="'+ Data['patientuid'] +'" ',
				Complete: dtAttr['Complete'] + '="' + Data['queueno'] + '" ' + dtAttr['PatientUID']+'="'+ Data['patientuid'] + '" ',
				Cancel: dtAttr['Cancel'] + '="' + Data['queueno'] + '" ' + dtAttr['PatientUID']+'="'+ Data['patientuid'] + '" ',
				CompleteAll: dtAttr['CompleteAll'] + '="' + Data['queueno'] + '" ' + dtAttr['PatientUID']+'="'+ Data['patientuid'] + '" ',
				CancelDrop: dtAttr['Cancel'] + '="' + Data['queueno'] + '" ' + dtAttr['PatientUID']+'="'+ Data['patientuid'] + '" ',
			};

			var Button = {
				Call: '<button '+btnClass['Call']+btnAttr['Call']+'>'+defaultButtonMessage['Call']+'</button>',
				Hold: '<button '+btnClass['Hold']+btnAttr['Hold']+'>'+defaultButtonMessage['Hold']+'</button>',
				Complete: '<button '+btnClass['Complete']+btnAttr['Complete']+'>'+defaultButtonMessage['Complete']+'</button>',
				Cancel: '<button '+btnClass['Cancel']+btnAttr['Cancel']+'>'+defaultButtonMessage['Cancel']+'</button>',
				CompleteAll: '<button '+btnClass['CompleteAll']+btnAttr['CompleteAll']+'>'+defaultButtonMessage['CompleteAll']+'</button>',
				CancelDrop: '<button '+btnClass['CancelDrop']+btnAttr['CancelDrop']+'>'+defaultButtonMessage['CancelDrop']+'</button>',
			};	
			var OtherButton = '';
			OtherButton += '<button class="none" style="color:#000000" type="button" id="dropdown_Queue_'+Data['queueno']+'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>';

			var DropdownDiv = '';
			DropdownDiv += '<div class="dropdown-menu" style="font-size:1.5rem;" aria-labelledby="dropdown_Queue_'+Data['queueno']+'">';
			DropdownDiv += Button['CancelDrop'];
			DropdownDiv += '</div>';
			
			OtherButton += DropdownDiv;
	
			var map = [ {keyword: 'null', replacement: ''},
						{keyword: 'NULL', replacement: ''}
			];
			Object.keys(Data).forEach(function (key){
				map.forEach(function(value, index){
					Data[key] = String(Data[key]).replace(new RegExp(value.keyword, 'g'), value.replacement);
				});
			});

			//var queueLastTime = Data.lastworklist_cwhen;
			//var currentTime = new Date().getTime();
			//var queueWaitingTime = parseInt( ((currentTime - queueLastTime)/1000)/60 );
			// var queueWaitingTime = lastworklist_waiting.getTime();
			var queueWaitingTime = parseInt(Data.lastworklist_waiting/1000/60);

			var spanQueueNumber = '<span class="font_queuenumber">'+Data['queueno']+'</span>';
			var spanHN = '<span class="font_queuenumber">'+Data['hn']+'</span>';
			var addTableRow = {
				0 : tableNumber,
				1 : spanQueueNumber,
				2 : Data['patienttypename'],
				3 : Data['payorname'],
				4 : queueWaitingTime,
				5 : Data['patientname'],
				6 : spanHN,
				7 : Data['call_counter'],
				8 : Data['lastworklist'],
				9 : Button['Call'],
				10 : Button['Hold'],
				11 : Button['Complete'],
				12 : OtherButton,
			}
			
			var dataTableRowID = RowIDPrefix + Data['queueno'];
		    addDTRow(SelectTable,addTableRow,dataTableRowID);
		}
	}
	
	function checkLocalStorage(){
			
		if( !(!(localStorage.getItem('Counter') === null) && !(localStorage.getItem('locatedata_'+const_groupprocessid) === null)) ){
			if( localStorage.getItem('Counter') ){
				$('#Counter_Alert').remove();
			}
			if( localStorage.getItem('locatedata_'+const_groupprocessid) ){
				$('#Category_Alert').remove();
			}
			$('#Modal_Alert_Setup').modal({backdrop: 'static', keyboard: false});
			var WarningText;
			WarningText = '<div class="row" style="font-size:1.5rem">';
			WarningText += '<div class="col">ไม่สามารถใช้งานได้ : คุณยังไม่ได้ตั้งค่าหน้า Management</div>';
			WarningText += '<div class="col">';
			WarningText += (!localStorage.getItem('Counter') ? '<div class="row">"โปรดตั้งค่าเคาน์เตอร์ประจำเครื่อง" <a href="'+base_path_url+'Setup/" target="_blank" ><button class="button small c_darkblue" >ตั้งค่า</button></a></div>' : '');
			WarningText += (!localStorage.getItem('locatedata_'+const_groupprocessid) ? '<div class="row">"โปรดตั้งค่าประเภทคิว คลิกเลือกประเภทด้านล่าง"</div>' : '');
			WarningText += '</div>';
			$('#ManagementTab').html(WarningText);
			var originalSetItem = localStorage.setItem;

			localStorage.setItem = function(key, value) {
				var event = new Event('itemInserted');

				event.value = value; // Optional..
				event.key = key; // Optional..

				document.dispatchEvent(event);

				originalSetItem.apply(this, arguments);
			};
			
			var localStorageSetHandler = function(e) {
			    var keyStorage = 'locatedata_'+const_groupprocessid;
				if(e.key == keyStorage || e.key == 'Counter'){
					location.reload();
				}

			};
			$(window).on('storage', function (e) {
			    var storageEvent = e.originalEvent;
			    if( storageEvent.key == 'locatedata_'+const_groupprocessid || storageEvent.key == 'Counter' ){
			    	location.reload();
			    }

			});
			return false;
		}else{			
			if( localStorage.getItem('Counter') ){
				$('#Counter_Alert').remove();
			}
			if( localStorage.getItem('locatedata_'+const_groupprocessid) ){
				$('#Category_Alert').remove();
			}
			return true;
		}
	}

	function updateTabText(){
		importLocalStorage(localTab,function(){
			Object.keys(localTab).forEach(function (key){
				$(TabSpanID[key]).text(localTab[key]);
			});

			var RequestData = base_path_url+'GetCounterInfo/'+localStorage.getItem('Counter');
			$.getJSON( RequestData, function( data ) {
				if(data[0]){
					$(TabSpanID['Counter']).text(data[0].countername);
				}
			});

		});
	}

	function importLocalStorage(Var,callback){
		if(checkLocalStorage()){
			var RequestData = base_path_url+'GetCategoryDetailData_JSON';
			$.getJSON( RequestData, function( data ) {
				var queryResult = new Object;
				Object.keys(data).forEach(function (key){
					queryResult[data[key]['uid']] = data[key]['name'] + ' (' + data[key]['code'] +')';
				});
				SetupVar['QueueCate'] = queryResult;

				Object.keys(Var).forEach(function (key){
					Var[key] = localStorage.getItem(key);
				});

				Var['QueueCate'] = '';
				localQueueCate = JSON.parse(localStorage.getItem('locatedata_'+const_groupprocessid))['QueueCate'];
				localQueueCate.forEach(function(Value,Index){
					Var['QueueCate'] += ( !Var['QueueCate'] == '' ? ',' : '');
					Var['QueueCate'] += SetupVar['QueueCate'][Value];
				});
				if (callback) {
					callback();
				}
			});
		}
	}

	function initQueue(urlpath,Counter,QueueCategory,DataTable,callback){
		DataTable.clear().draw();
		tableNumber = 0;

		$.getJSON( urlpath, function( data ) {
			console.log("Init Queue Management",data);
			for(var key in data){
				if( QueueCategory.includes(data[key]['queuecategoryuid']) ){
					AddQueueRow(DataTable,data[key]);
				}
			}
			if (callback) {
				callback();
			}
		});

	}

</script>
