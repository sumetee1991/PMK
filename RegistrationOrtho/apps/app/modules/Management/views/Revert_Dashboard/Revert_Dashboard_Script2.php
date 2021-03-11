<script type = "text/javascript">
	var lastaction = [];
	var manageTable;
	const removeID = {
		'QueueCate': '#li_queuecategory',
	}
	//const base_path_url = '<?=LOCALURL;?>Management/';
	const base_path_url = '.././';
	const RowIDPrefix = "Queue_";
	const WorklistCompAllUID = '16';
	const WorklistUID = '<?=$Data['JSConstant']['WorklistUID'];?>';
	const const_groupprocessid = "<?=$Data['JSConstant']['GroupprocessUID'];?>";
	const initPageFunction = "<?=$Data['JSConstant']['InitModel'];?>";
	const defaultDataTable = {
		Name: "#dataTable",
		Filter: "#SearchHN_DT",
	}

	<?php if( isset($Data['SelectedgroupprocessUID']) && $Data['SelectedgroupprocessUID'] == 2 ){ ?>
		const tableColumns = {
			Number: '0',
			QueueNumber: '1',
			QueueType: '2',
			FullName: '3',
			HN: '4',
			PID: '5',
			Birthdate: '6',
			Btn_Revert: '7',
		};
	<?php }else{ ?>
		const tableColumns = {
			Number: '0',
			QueueNumber: '1',
			QueueType: '2',
			FullName: '3',
			PID: '4',
			Birthdate: '5',
			Btn_Revert: '6',
		};
	<?php } ?>

	const TabSpanID = {
		'Counter': '#span_Counter',
		'QueueCate': '#span_QueueCategory',
	};
	var localTab = {
		'Counter': '',
		'QueueCate': '',
	};
	var SetupVar = new Object();

	function checkDuplicate(DataTable, Column, Value) {
		var CheckStatus = false;
		DataTable.column(Column).nodes().each(function (node, index, dt) {
			ColumnValue = DataTable.cell(node).data();
			if (ColumnValue.replace(/\s/g, '') == Value.replace(/\s/g, '')) {
				CheckStatus = true;
			}
		});
		return CheckStatus;
	}

	function AddQueueRow(SelectTable, Data) {
		if (!checkDuplicate(SelectTable, tableColumns['QueueNumber'], '<span class="font_queuenumber">'+Data['queueno']+'</span>')) {
			tableNumber += 1;
			var checkDisabled = (Data['active'] == 'N' ? 'disabled' : '');
			var Button = {
				Revert: '<button class="button block small c_green" data-q_revert="' + Data['queueno'] + '" data-patientuid="' + Data['patientuid'] + '" data-worklistuid="' + WorklistUID + '" ' + checkDisabled + '>Revert</button>',
			};
			var spanQueueNumber = '<span class="font_queuenumber">'+Data['queueno']+'</span>';
			<?php if( isset($Data['SelectedgroupprocessUID']) && $Data['SelectedgroupprocessUID'] == 2 ){ ?>
				var spanHN = '<span class="font_queuenumber">'+Data['hn']+'</span>';
				var addTableRow = {
					0: tableNumber,
					1: spanQueueNumber,
					2: Data['patienttypename'],
					3: Data['payorname'],
					4: Data['patientname'],
					5: spanHN,
					6: Data['call_counter'],
					7: Data['lastworklist'],
					8: (Data['active'] == 'N' ? ' ' : Button['Revert']),
				}

			<?php }else{ ?>
				var addTableRow = {
					0: tableNumber,
					1: spanQueueNumber,
					2: Data['patienttypename'],
					3: Data['payorname'],
					4: Data['patientname'],
					5: Data['call_counter'],
					6: Data['lastworklist'],
					7: (Data['active'] == 'N' ? ' ' : Button['Revert']),
				}

			<?php } ?>
			var dataTableRowID = RowIDPrefix + Data['queueno'];
			addDTRow(SelectTable, addTableRow, dataTableRowID);
		}
	}

	function checkLocalStorage() {
		if (!(!(localStorage.getItem('Counter') === null) && !(localStorage.getItem('locatedata_' + const_groupprocessid) === null))) {
			if (localStorage.getItem('Counter')) {
				$('#Counter_Alert').remove();
			}
			if (localStorage.getItem('locatedata_' + const_groupprocessid)) {
				$('#Category_Alert').remove();
			}
			$('#Modal_Alert_Setup').modal({
				backdrop: 'static',
				keyboard: false
			});
			var WarningText;
			WarningText = '<div class="row" style="font-size:1.5rem">';
			WarningText += '<div class="col">ไม่สามารถใช้งานได้ : คุณยังไม่ได้ตั้งค่าหน้า Management</div>';
			WarningText += '<div class="col">';
			WarningText += (!localStorage.getItem('Counter') ? '<div class="row">"โปรดตั้งค่าเคาน์เตอร์ประจำเครื่อง" <a href="' + base_path_url + 'Setup/" target="_blank" ><button class="button small c_darkblue" >ตั้งค่า</button></a></div>' : '');
			WarningText += (!localStorage.getItem('locatedata_' + const_groupprocessid) ? '<div class="row">"โปรดตั้งค่าประเภทคิว คลิกเลือกประเภทด้านล่าง"</div>' : '');
			WarningText += '</div>';
			$('#ManagementTab').html(WarningText);
			var originalSetItem = localStorage.setItem;
			localStorage.setItem = function (key, value) {
				var event = new Event('itemInserted');
				event.value = value; // Optional..
				event.key = key; // Optional..
				document.dispatchEvent(event);
				originalSetItem.apply(this, arguments);
			};
			var localStorageSetHandler = function (e) {
				var keyStorage = 'locatedata_' + const_groupprocessid;
				if (e.key == keyStorage || e.key == 'Counter') {
					location.reload();
				}
			};
			$(window).on('storage', function (e) {
				var storageEvent = e.originalEvent;
				if (storageEvent.key == 'Counter') {
					location.reload();
				}
			});
			return false;
		} else {
			if (localStorage.getItem('Counter')) {
				$('#Counter_Alert').remove();
			}
			if (localStorage.getItem('locatedata_' + const_groupprocessid)) {
				$('#Category_Alert').remove();
			}
			return true;
		}
	}

	function updateTabText() {
		importLocalStorage(localTab, function () {
			Object.keys(localTab).forEach(function (key) {
				$(TabSpanID[key]).text(localTab[key]);
			});
			var RequestData = base_path_url + 'GetCounterInfo/' + localStorage.getItem('Counter');
			$.getJSON(RequestData, function (data) {
				if (data[0]) {
					$(TabSpanID['Counter']).text(data[0].countername);
				}
			});
		});
	}

	function importLocalStorage(Var, callback) {
		if (checkLocalStorage()) {
			var RequestData = base_path_url + 'GetCategoryDetailData_JSON2';
			$.getJSON(RequestData, function (data) {
				var queryResult = new Object;
				Object.keys(data).forEach(function (key) {
					queryResult[data[key]['uid']] = data[key]['name'] + ' (' + data[key]['code'] + ')';
				});
				SetupVar['QueueCate'] = queryResult;
				Object.keys(Var).forEach(function (key) {
					Var[key] = localStorage.getItem(key);
				});
				Var['QueueCate'] = '';
				localQueueCate = JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'];
				localQueueCate.forEach(function (Value, Index) {
					Var['QueueCate'] += (!Var['QueueCate'] == '' ? ',' : '');
					Var['QueueCate'] += SetupVar['QueueCate'][Value];
				});
				if (callback) {
					callback();
				}
			});
		}
	}

	function initQueue(urlpath, Counter, QueueCategory, DataTable, callback) {
		DataTable.clear().draw();
		tableNumber = 0;
		$.getJSON(urlpath, function (data) {
			console.log("Init Queue Management", data);
			for (var key in data) {
				if (QueueCategory.includes(data[key]['queuecategoryuid'])) {
					AddQueueRow(DataTable, data[key]);
				}
			}
			if (callback) {
				callback();
			}
		});
	}


	function refreshQueue(GroupprocessUID,Counter,QueueCategory,DOMELE,Table,WorklistUID,callback){

		var map = [{
			keyword: ',',
			replacement: '_'
		}, ];
		var localQueueCate = QueueCategory;
		var strQueueCate = JSON.stringify(localQueueCate).replace('[', '').replace(']', '');
		map.forEach(function(value, index) {
			strQueueCate = strQueueCate.replace(new RegExp(value.keyword, 'g'), value.replacement);
		});

		var requestURL = base_path_url + 'ManagementViews_Revert2' + '/' + GroupprocessUID + '/' + strQueueCate + '/' + WorklistUID;
		$.get( requestURL, function( data ) {
            $(DOMELE).html(data['html']);
            if( $(Table).length ){
	            var manageTable = $(Table).DataTable({
					ordering: false,
					scrollY: true,
					paging: true,
					pageLength: 100,
					dom: 'rtp',
				});
            }
            if(callback){
            	callback;
            }
            return manageTable;
        });
	}
	$(document).ready(function () {
		$('.sidenav_url').each(function (index) {
			$(this).attr('href', '../' + $(this).attr('href'));
		});
		/* Remove Tab Reserved for using in future*/
			Object.keys(removeID).forEach(function (key) {
				$(removeID[key]).remove();
			});
		/* Remove Tab */
			updateTabText();
			<?= Modules::run('Websocket/SocketConnection'); ?>
			var manageTable = $('#dataTable').DataTable({
				ordering: false,
				scrollY: false,
				paging: true,
				dom: 'rtp',
			});
			
			$(window).on('resize', function() {
				$('#dataTable').DataTable().draw();
				//manageTable.draw();
			});
		/*Location Queuecategory*/
			var RequestData = base_path_url + 'locationAvailable_JSON2' + '/' + const_groupprocessid;
			$.getJSON(RequestData, function (data) {
				/* Add Button */
					//QueueCategory
					$('#queuecateRow').html('');
					$('#queuecateRow_Alert').html('');
					data['Category'].forEach(function (Value, Index) {
						var CategoryData = {
							'ID': Value['uid'],
							'Code': Value['code'],
							'Name': Value['name'],
						};
						var btnCol = '';
						btnCol += '<a data-locationqueuecate="' + CategoryData['ID'] + '" data-buttonaction="locationqueuecate"><button>' + CategoryData['Name'] + ' (' + CategoryData['Code'] + ')</button></a>';
						$('#queuecateRow').append(btnCol);
						$('#queuecateRow_Alert').append(btnCol);
					});
				/* Add Button */
				/* Add Active From LocalStorage */
					const localAttr = {
						locationqueuecate: 'QueueCate',
					};
					if (localStorage.getItem('locatedata_' + const_groupprocessid)) {
						var localStorageData = JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid));
						localStorageData['QueueCate'].forEach(function (Value, Index) {
							if (!$('[data-locationqueuecate="' + Value + '"]').hasClass('active')) {
								$('[data-locationqueuecate="' + Value + '"]').addClass('active');
							}
						});
					}
				/* Add Active From LocalStorage */
				$(document).on("click", '[data-buttonaction]', function (e) {
					$(this).toggleClass('active');
					var targetAction = $(this).data('buttonaction');
					var targetValue = $(this).data(targetAction);
					if (!localStorage.getItem('locatedata_' + const_groupprocessid)) {
						var localData = {
							'UID': const_groupprocessid,
							'QueueCate': '',
						};
					} else {
						var localData = JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid));
					}
					var activeText = new Object;
					var targetSelector = document.querySelectorAll('[data-buttonaction]');
					targetSelector.forEach(function (Value, Index) {
						if ($(targetSelector[Index]).hasClass('active')) {
							var targetAttr = $(targetSelector[Index]).data('buttonaction');
							var targetData = localAttr[targetAttr];
							if (!activeText[targetData]) {
								activeText[targetData] = [];
							}
							activeText[targetData].push($(targetSelector[Index]).data(targetAttr));
						}
					});
					Object.keys(activeText).forEach(function (key) {
						localData[key] = activeText[key];
					});
					localStorage.setItem("locatedata_" + const_groupprocessid, JSON.stringify(localData));
					location.reload();
				});
			});
			var originalSetItem = localStorage.setItem;
			localStorage.setItem = function (key, value) {
				var event = new Event('itemInserted');
				event.value = value; // Optional..
				event.key = key; // Optional..
				document.dispatchEvent(event);
				originalSetItem.apply(this, arguments);
			};
			var localStorageSetHandler = function (e) {
				var keyStorage = 'locatedata_' + const_groupprocessid;
				if (e.key == keyStorage || e.key == 'Counter') {
					location.reload();
				}
			};
			document.addEventListener("itemInserted", localStorageSetHandler, false);
			$(window).on('storage', function (e) {
				var storageEvent = e.originalEvent;
				var keyStorage = 'locatedata_' + const_groupprocessid;
				if ((storageEvent.key == keyStorage) && (storageEvent.oldValue != storageEvent.newValue)) {
					location.reload();
				} else if ((storageEvent.key == 'Counter') && (storageEvent.oldValue != storageEvent.newValue)) {
					updateTabText();
				}
			});
		/*Location QueueCategory*/
		var map = [{
			keyword: ',',
			replacement: '_'
		}, ];
		var localQueueCate = JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'];
		var strQueueCate = JSON.stringify(localQueueCate).replace('[', '').replace(']', '');
		map.forEach(function (value, index) {
			strQueueCate = strQueueCate.replace(new RegExp(value.keyword, 'g'), value.replacement);
		});
		//var localQueueCate = JSON.parse(localStorage.getItem('locatedata_'+const_groupprocessid))['QueueCate'];
		//var strQueueCate = JSON.stringify(localQueueCate).replace('[','').replace(']','').replace(',','_');
		var RequestData = base_path_url + initPageFunction + '/' + const_groupprocessid + '/' + strQueueCate + '/' + WorklistUID;
		//var RequestData = base_path_url+initPageFunction+'/'+const_groupprocessid+'/'+localStorage.getItem('QueueCate')+'/'+WorklistUID;
		
		//Disabled//initQueue(RequestData, localStorage.getItem('Counter'), JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'], manageTable, function () {

		manageTable = refreshQueue(const_groupprocessid,localStorage.getItem('Counter'),JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'],'#dataTable_Container','#dataTable',WorklistUID,function(){});


			var remove_queue_state = false;
			var remove_queue_data;
			midSocket.on('remove_queue', function (data) {
				console.log("midSocket Get Response : remove_queue");var stillworking = ( (lastaction['remove_queue'] !== undefined) ? lastaction['remove_queue'] : false );
				if( stillworking == false ){
					lastaction['remove_queue'] = true;
					remove_queue_state = true;
					while(remove_queue_state == true){
						remove_queue_state = false;
						//socket on
							console.log("remove_queue Data ", data);
							//initQueue(RequestData, localStorage.getItem('Counter'), JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'], manageTable);

							manageTable = refreshQueue(const_groupprocessid,localStorage.getItem('Counter'),JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'],'#dataTable_Container','#dataTable',WorklistUID,function(){

							});
						//socket on
						lastaction['remove_queue'] = false;
					}
				}else{
					console.log("Still Busy on Last Response");
					remove_queue_state = true;
					remove_queue_data = data;
				}
				/*
						//socket on
							console.log("remove_queue Data ", data);
							//initQueue(RequestData, localStorage.getItem('Counter'), JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'], manageTable);

							manageTable = refreshQueue(const_groupprocessid,localStorage.getItem('Counter'),JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'],'#dataTable_Container','#dataTable',WorklistUID,function(){

							});
						//socket on
				*/


				/*  //Temporary Comment
					console.log("midSocket Get Response : remove_queue");
					console.log("remove_queue Data ", data);
					var targetQueueNumber = data.queueno;
					var getQueueURL = base_path_url + 'GetQueueInfo/' + targetQueueNumber;
					if (data.worklistuid == WorklistUID) {
						$.getJSON(getQueueURL, function (data) {
							for (var key in data) {
								console.log(data)
								if (JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'].includes(data[key]['queuecategoryuid']) && (data[key]['groupprocessuid'] == const_groupprocessid)) {
									AddQueueRow(manageTable, data[key]);
								}
							}
						});
					}
				*/
				/*
				var Found = localStorage
				.getItem("locatedata_" + const_groupprocessid)
				.some(function(ai) {
				return data.cateid.includes(ai);
				});
				if( Found ){
				var targetQueueNumber = data.queueno;
				var getQueueURL = base_path_url+'GetQueueInfo/'+targetQueueNumber;
				$.getJSON( getQueueURL, function( data ) {
				for(var key in data){
				if( JSON.parse(localStorage.getItem('locatedata_'+const_groupprocessid))['QueueCate'].includes(data[key]['queuecategoryuid']) && (data[key]['<?=$Data['JSCondition']['ColumnCondition'];?>'] == WorklistUID) ){
				AddQueueRow(manageTable,data[key]);
				}
				}
				});
				}
				*/
			});
			// -- (From Filter) Receive Data Row From Socket --
			midSocket.on('manage_getqueue_puid', function(data) {
				console.log("midSocket Get Response : manage_getqueue_puid");
				console.log("manage_getqueue_puid Data ", data);

				manageTable = refreshQueue(const_groupprocessid,localStorage.getItem('Counter'),JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'],'#dataTable_Container','#dataTable',function(){

				});
            });
            
            midSocket.on('remove_queue_puid', function(data) {
				console.log("midSocket Get Response : remove_queue_puid");
				console.log("manage_getqueue_puid Data ", data);

				manageTable = refreshQueue(const_groupprocessid,localStorage.getItem('Counter'),JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'],'#dataTable_Container','#dataTable',function(){

                });
            });
            
			midSocket.on('manage_getqueue_row', function(data) {
				console.log("midSocket Get Response : manage_getqueue_row");
				console.log("manage_getqueue_row Data ", data);

				manageTable = refreshQueue(const_groupprocessid,localStorage.getItem('Counter'),JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'],'#dataTable_Container','#dataTable',function(){

				});
            });
            
			// var manage_getqueue_row_state = false;
			// var manage_getqueue_row_data;
			// midSocket.on('manage_getqueue_row', function (data) {
			// 	console.log("midSocket Get Response : manage_getqueue_row");
			// 	var stillworking = ( (lastaction['manage_getqueue_row'] !== undefined) ? lastaction['manage_getqueue_row'] : false );
			// 	if( stillworking == false ){
			// 		lastaction['manage_getqueue_row'] = true;
			// 		manage_getqueue_row_state = true;
			// 		while(manage_getqueue_row_state == true){
			// 			manage_getqueue_row_state = false;
			// 				//socket on
			// 					console.log("manage_getqueue_row Data ", data);
			// 					//Object.keys(data.data.queueno).forEach(function (key){
			// 					//var targetQueueNumber = data.data.queueno[key];
			// 					//initQueue(RequestData, localStorage.getItem('Counter'), JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'], manageTable);
								
			// 					manageTable = refreshQueue(const_groupprocessid,localStorage.getItem('Counter'),JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'],'#dataTable_Container','#dataTable',WorklistUID,function(){

			// 					});
			// 				//socket on
			// 			lastaction['manage_getqueue_row'] = false;
			// 		}
			// 	}else{
			// 		console.log("Still Busy on Last Response");
			// 		manage_getqueue_row_state = true;
			// 		manage_getqueue_row_data = data;
			// 	}
			// 	/*  
			// 		//socket on
			// 			console.log("manage_getqueue_row Data ", data);
			// 			//Object.keys(data.data.queueno).forEach(function (key){
			// 			//var targetQueueNumber = data.data.queueno[key];
			// 			//initQueue(RequestData, localStorage.getItem('Counter'), JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'], manageTable);
						
			// 			manageTable = refreshQueue(const_groupprocessid,localStorage.getItem('Counter'),JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'],'#dataTable_Container','#dataTable',WorklistUID,function(){

			// 			});
			// 		//scoket on
			// 	*/
			// });
		//});
		$(window).on('storage', function (e) {
			var storageEvent = e.originalEvent;
			Object.keys(localTab).forEach(function (tabkey) {
				if ((storageEvent.key == tabkey) && (storageEvent.oldValue != storageEvent.newValue)) {
					location.reload();
				}
			});
		});
		$(defaultDataTable['Filter']).on("keyup", function () {
			$(this).change();
		});
		$(defaultDataTable['Filter']).on("change", function () {
			//manageTable.search($(this).val()).draw();
			$('#dataTable').DataTable().search($(this).val()).draw();
		});
		$(document).on("click", '[data-sidenav]', function () {
			var target = $(this).data('sidenav');
			$(this).toggleClass('active');
			$(target).hasClass('active') ? $(target).removeClass('active') : $(target).addClass('active');
		});
		$(document).on("click", '[data-q_revert]', function () {
			var thisButton = this;
			var target_Queueno = $(this).data('q_revert');
			var target_Patientuid = $(this).data('patientuid');
			var target_Worklistuid = $(this).data('worklistuid');
			var revertCompURL = base_path_url + 'RemoveTR/tr_processcontrol';
			var revertCompData = {
				'queueno': target_Queueno,
				'patientuid': target_Patientuid,
				'worklistuid': WorklistUID,
			};
			//Revert Complete
			console.log($('#dataTable').DataTable());
			postAJAX(revertCompURL, revertCompData, function (data) {
				console.log("Revert Result : ", data);
				// Remove Row 
				var targetID = target_Queueno;
				var targetRow = "#" + RowIDPrefix + targetID;
				//removeDTRow(manageTable, $(targetRow));
				//removeDTRow(manageTable, $(thisButton).parents('tr'));
				removeDTRow($('#dataTable').DataTable(), $(thisButton).parents('tr'));
				var getNewQueueURL = baseurlMid + '/api/manage/get_new_queue';
				var AddNewQueueData = {
					'queueno': target_Queueno,
				};
				// Trigger after revert complete
				postAJAX(getNewQueueURL, AddNewQueueData);
				
				var revertAllURL = base_path_url + 'RemoveTR/tr_processcontrol';
				var revertAllData = {
					'queueno': target_Queueno,
					'patientuid': target_Patientuid,
					'worklistuid': WorklistCompAllUID,
				};
				//Revert CompleteAll
				postAJAX(revertAllURL, revertAllData, function (data) {
					console.log("Revert Comp Result : ", data);
					var getNewQueueURL = baseurlMid + '/api/manage/get_new_queue';
					var AddNewQueueData = {
						'queueno': target_Queueno,
					};
					// Trigger after revert complete all
					postAJAX(getNewQueueURL, AddNewQueueData);
				});
			});

				
		});
	}); 
</script>