<script type="text/javascript">
	var lastaction = [];
	function refreshQueue(GroupprocessUID,Counter,QueueCategory,DOMELE,Table,callback){

		var map = [{
			keyword: ',',
			replacement: '_'
		}, ];
		var localQueueCate = QueueCategory;
		var strQueueCate = JSON.stringify(localQueueCate).replace('[', '').replace(']', '');
		map.forEach(function(value, index) {
			strQueueCate = strQueueCate.replace(new RegExp(value.keyword, 'g'), value.replacement);
		});

		var requestURL = base_path_url + 'ManagementViews' + '/' + GroupprocessUID + '/' + strQueueCate;
		$.get( requestURL, function( data ) {
            $(DOMELE).html(data['html']);
            if( $(Table).length ){
	            var manageTable = $(Table).DataTable({
					/*
					ordering: false,
					scrollY: true,
					paging: false,
					dom: 'rt',
					*/					
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
	var CompleteAllWorklist = '15';
	$(document).ready(function() {
		$('#setupTitle').append('<br>' + SiteTitle);
		$('#setupTitle_Alert').append('<br>' + SiteTitle);
		/* Remove Tab Reserved for using in future*/
		Object.keys(removeID).forEach(function(key) {
			$(removeID[key]).remove();
		});
		/* Remove Tab */
		tableNumber = TableRowCount;
		updateTabText();
		<?= Modules::run('Websocket/SocketConnection'); ?>
		/*Location Queuecategory*/
		var RequestData = base_path_url + Management_LocationCounter + const_groupprocessid;
		$.getJSON(RequestData, function(data) {
			/* Add Button */
			//QueueCategory
			$('#queuecateRow').html('');
			$('#queuecateRow_Alert').html('');
			data['Category'].forEach(function(Value, Index) {
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
			localAttr = {
				locationqueuecate: 'QueueCate',
			};
			if (localStorage.getItem('locatedata_' + const_groupprocessid)) {
				var localStorageData = JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid));
				localStorageData['QueueCate'].forEach(function(Value, Index) {
					if (!$('[data-locationqueuecate="' + Value + '"]').hasClass('active')) {
						$('[data-locationqueuecate="' + Value + '"]').addClass('active');
					}
				});
			}
			/* Add Active From LocalStorage */
			$(document).on("click", '[data-buttonaction]', function(e) {
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
				targetSelector.forEach(function(Value, Index) {
					if ($(targetSelector[Index]).hasClass('active')) {
						var targetAttr = $(targetSelector[Index]).data('buttonaction');
						var targetData = localAttr[targetAttr];
						if (!activeText[targetData]) {
							activeText[targetData] = [];
						}
						activeText[targetData].push($(targetSelector[Index]).data(targetAttr));
					}
				});
				Object.keys(activeText).forEach(function(key) {
					localData[key] = activeText[key];
				});
				localStorage.setItem("locatedata_" + const_groupprocessid, JSON.stringify(localData));
				location.reload();
			});
		});
		/*Location QueueCategory*/
		var originalSetItem = localStorage.setItem;
		localStorage.setItem = function(key, value) {
			var event = new Event('itemInserted');
			event.value = value; // Optional..
			event.key = key; // Optional..
			document.dispatchEvent(event);
			originalSetItem.apply(this, arguments);
		};
		var localStorageSetHandler = function(e) {
			var keyStorage = 'locatedata_' + const_groupprocessid;
			if (e.key == keyStorage || e.key == 'Counter') {
				location.reload();
			}
		};
		document.addEventListener("itemInserted", localStorageSetHandler, false);
		$(window).on('storage', function(e) {
			var storageEvent = e.originalEvent;
			var keyStorage = 'locatedata_' + const_groupprocessid;
			if ((storageEvent.key == keyStorage) && (storageEvent.oldValue != storageEvent.newValue)) {
				location.reload();
			} else if ((storageEvent.key == 'Counter') && (storageEvent.oldValue != storageEvent.newValue)) {
				updateTabText();
			}
		});
		var map = [{
			keyword: ',',
			replacement: '_'
		}, ];
		var localQueueCate = JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'];
		var strQueueCate = JSON.stringify(localQueueCate).replace('[', '').replace(']', '');
		map.forEach(function(value, index) {
			strQueueCate = strQueueCate.replace(new RegExp(value.keyword, 'g'), value.replacement);
		});
		// -- Management -- //
		// -- Init Management --
		var manageTable = $(defaultDataTable['Name']).DataTable({
			ordering: false,
			scrollY: true,
			paging: true,
			pageLength: 100,
			dom: 'rtp',
		});
		$(window).on('resize', function() {
			$(defaultDataTable['Name']).DataTable().draw();
			//manageTable.draw();
		});
		var RequestData = base_path_url + initPageFunction + '/' + const_groupprocessid + '/' + strQueueCate;

		//manageTable = refreshQueue(const_groupprocessid,localStorage.getItem('Counter'),JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'],'#dataTable_Container','#dataTable',function(){ console.log("REFRESH");

		//initQueue(RequestData, localStorage.getItem('Counter'), JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'], manageTable, function() { 
			console.log("INIT");

		refreshQueue(const_groupprocessid,localStorage.getItem('Counter'),JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'],'#dataTable_Container','#dataTable',function(){});

			updateWaitingQueue = setInterval(function() {
				$(defaultDataTable['Name']).DataTable().column(tableColumns['WaitingQueue']).nodes().each(function(node, index, dt) {
					ColumnValue = parseInt($(defaultDataTable['Name']).DataTable().cell(node).data());
					$(defaultDataTable['Name']).DataTable().cell(node).data(ColumnValue + 1);
					$(defaultDataTable['Name']).DataTable().draw(false);
				});
			}, 60000);
			// -- Management Status Update --
			//var update_queue_action_state = false;
			//var update_queue_action_data;
			midSocket.on('update_queue_action', function(data) {
				//var stillworking = ( (lastaction['update_queue_action'] !== "undefined" && lastaction['update_queue_action'] == false) ? false : true );
				console.log("midSocket Get Response : update_queue_action");
				//if( stillworking == false ){
					lastaction['update_queue_action'] = true;
					console.log("update_queue_action Data ", data);
					var Found = JSON.parse(localStorage
							.getItem("locatedata_" + const_groupprocessid))['QueueCate']
						.some(function(ai) {
							return data.cateid.includes(ai);
						});
					if (Found) {
							manageTable = refreshQueue(const_groupprocessid,localStorage.getItem('Counter'),JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'],'#dataTable_Container','#dataTable',function(){

							});
						/*
						initQueue(baseurlMid + '/api/manage/queueno', localStorage.getItem('Counter'), JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'], manageTable);
						*/
						}
					/*
					while(update_queue_action_state == true){
							update_queue_action_state = false;
							var Found = JSON.parse(localStorage
									.getItem("locatedata_" + const_groupprocessid))['QueueCate']
								.some(function(ai) {
									return update_queue_action_data.cateid.includes(ai);
								});
							if (Found) {
								manageTable = refreshQueue(const_groupprocessid,localStorage.getItem('Counter'),JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'],'#dataTable_Container','#dataTable',function(){

								});
							}
						}
					*/
				/*
					lastaction['update_queue_action'] = false;
				}else{
					console.log("Still Busy on Last Response");
					update_queue_action_state = true;
					update_queue_action_data = data;
				}
				*/
			});

			var remove_queue_state = false;
			var remove_queue_data;

			midSocket.on('remove_queue', function(data) {
				console.log("midSocket Get Response : remove_queue");
				remove_queue_data = data;

				var targetRow = "#" + RowIDPrefix + remove_queue_data.queueno;

				//manageTable.row(targetRow).remove().draw();
				$(defaultDataTable['Name']).DataTable().row(targetRow).remove().draw();
							
				var stillworking = ( (lastaction['remove_queue'] !== undefined) ? lastaction['remove_queue'] : false );
				if( stillworking == false ){
					lastaction['remove_queue'] = true;
					remove_queue_state = true;
					while(remove_queue_state == true){
						remove_queue_state = false;
						//socket on
							console.log("remove_queue Data ", remove_queue_data);

							var targetRow = "#" + RowIDPrefix + remove_queue_data.queueno;

							//manageTable.row(targetRow).remove().draw();
							$(defaultDataTable['Name']).DataTable().row(targetRow).remove().draw();
							manageTable = refreshQueue(const_groupprocessid,localStorage.getItem('Counter'),JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'],'#dataTable_Container','#dataTable',function(){

							});
							var targetQueueNumber = remove_queue_data.queueno;
							var getQueueURL = base_path_url + GetQueue_RelatedQueueno + targetQueueNumber;
							$.getJSON(getQueueURL, function(data) {
								for (var key in data) {
									console.log(data);
									if (JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'].includes(data[key]['queuecategoryuid']) && (data[key]['groupprocessuid'] == const_groupprocessid)) {
										AddQueueRow($(defaultDataTable['Name']).DataTable(), data[key]);
									}
								}
								lastaction['remove_queue'] = false;
							});
						//socket on
					}
				}else{
					console.log("Still Busy on Last Response");
					remove_queue_state = true;
					remove_queue_data = data;
				}
				/*
					//socket on
						console.log("remove_queue Data ", data);

						var targetRow = "#" + RowIDPrefix + data.queueno;

						//manageTable.row(targetRow).remove().draw();
						$(defaultDataTable['Name']).DataTable().row(targetRow).remove().draw();
						manageTable = refreshQueue(const_groupprocessid,localStorage.getItem('Counter'),JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'],'#dataTable_Container','#dataTable',function(){

						});
						var targetQueueNumber = data.queueno;
						var getQueueURL = base_path_url + GetQueue_RelatedQueueno + targetQueueNumber;
						$.getJSON(getQueueURL, function(data) {
							for (var key in data) {
								console.log(data);
								if (JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'].includes(data[key]['queuecategoryuid']) && (data[key]['groupprocessuid'] == const_groupprocessid)) {
									AddQueueRow($(defaultDataTable['Name']).DataTable(), data[key]);
								}
							}
						});
					//socket on
				*/
			});
			//END -- Management Status Update --
			/* OLD remove_queue_puid
			midSocket.on('remove_queue_puid', function(data) {
				console.log("midSocket Get Response : remove_queue_puid");
				console.log("remove_queue_puid Data ", data);
				var targetPUID = data.data;
				var getPUIDInfoURL = base_path_url + GetQueueInfo_PUID + targetPUID;
				$.getJSON(getPUIDInfoURL, function(response) {
					Object.keys(response).forEach(function(key) {
						var targetRow = "#" + RowIDPrefix + response[key]['queueno'];
						$(defaultDataTable['Name']).DataTable().row(targetRow).remove().draw();
					});
				});
			});
			*/
			
            // var remove_queue_puid_state = false;
            // var remove_queue_puid_data;
            
			// midSocket.on('remove_queue_puid', function(data) {
			// 	console.log("midSocket Get Response : remove_queue_puid");
			// 	remove_queue_puid_data = data;

			// 	var stillworking = ( (lastaction['remove_queue_puid'] !== undefined) ? lastaction['remove_queue_puid'] : false );
			// 	if( stillworking == false ){
			// 		lastaction['remove_queue_puid'] = true;
			// 		remove_queue_puid_state = true;
			// 		while(remove_queue_puid_state == true){
			// 			remove_queue_puid_state = false;
			// 			//socket on
			// 				//manageTable.row(targetRow).remove().draw();
			// 				$(defaultDataTable['Name']).DataTable().row(targetRow).remove().draw();
			// 				manageTable = refreshQueue(const_groupprocessid,localStorage.getItem('Counter'),JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'],'#dataTable_Container','#dataTable',function(){

			// 				});
			// 				var targetQueueNumber = remove_queue_puid_data.queueno;
			// 				var getQueueURL = base_path_url + GetQueue_RelatedQueueno + targetQueueNumber;
			// 				$.getJSON(getQueueURL, function(data) {
			// 					for (var key in data) {
			// 						console.log(data);
			// 						if (JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'].includes(data[key]['queuecategoryuid']) && (data[key]['groupprocessuid'] == const_groupprocessid)) {
			// 							AddQueueRow($(defaultDataTable['Name']).DataTable(), data[key]);
			// 						}
			// 					}
			// 					lastaction['remove_queue_puid'] = false;
			// 				});
			// 			//socket on
			// 		}
			// 	}else{
			// 		console.log("Still Busy on Last Response");
			// 		remove_queue_puid_state = true;
			// 		remove_queue_puid_data = data;
            //     }
            // });
            midSocket.on('remove_queue_puid', function(data) {
				console.log("midSocket Get Response : remove_queue_puid");
				console.log("manage_getqueue_puid Data ", data);

				manageTable = refreshQueue(const_groupprocessid,localStorage.getItem('Counter'),JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'],'#dataTable_Container','#dataTable',function(){

                });
            });
			// -- (From Filter) Receive Data Row From Socket --
			midSocket.on('manage_getqueue_puid', function(data) {
				console.log("midSocket Get Response : manage_getqueue_puid");
				console.log("manage_getqueue_puid Data ", data);

				manageTable = refreshQueue(const_groupprocessid,localStorage.getItem('Counter'),JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'],'#dataTable_Container','#dataTable',function(){

				});

				//initQueue(RequestData, localStorage.getItem('Counter'), JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'], manageTable);
				/*	
					//Temporary Comment
					console.log("midSocket Get Response : manage_getqueue_puid");
					console.log("manage_getqueue_puid Data ", data);
					Object.keys(data.data).forEach(function (key) {
						var targetPUID = data.data.patientuid;
						var getPUIDInfoURL = base_path_url + GetQueue_RelatedPUID + targetPUID;
						$.getJSON(getPUIDInfoURL, function (data) {
							for (var key in data) {
								if (JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'].includes(data[key]['queuecategoryuid']) && (data[key]['groupprocessuid'] == const_groupprocessid)) {
									AddQueueRow(manageTable, data[key]);
								}
							}
						});
					});
				*/
			});
			//END -- Receive Data Row
			// -- Receive Data Row From Socket --
			midSocket.on('manage_getqueue_row', function(data) {
				console.log("midSocket Get Response : manage_getqueue_row");
				console.log("manage_getqueue_row Data ", data);

				manageTable = refreshQueue(const_groupprocessid,localStorage.getItem('Counter'),JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'],'#dataTable_Container','#dataTable',function(){

				});

				//initQueue(RequestData, localStorage.getItem('Counter'), JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'], manageTable);

				/*	
					//Temporary Comment
					console.log("midSocket Get Response : manage_getqueue_row");
					console.log("manage_getqueue_row Data ", data);
					Object.keys(data.data).forEach(function (key) {
						data.data['queueno'].forEach(function (Value, Index) {
							console.log(Value);
							var targetQueueNumber = Value;
							var getQueueURL = base_path_url + GetQueueInfo_Queueno + targetQueueNumber;
							$.getJSON(getQueueURL, function (data) {
								for (var key in data) {
									if (JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'].includes(data[key]['queuecategoryuid']) && (data[key]['groupprocessuid'] == const_groupprocessid)) {
										AddQueueRow(manageTable, data[key]);
									}
								}
							});
						});
					});
				*/
			});
			//END -- Receive Data Row
			// -- Update Action --
			midSocket.on('update_action_call', function(data) {
				console.log("midSocket Get Response : update_action_call");
				console.log("update_action_call Data ", data);

				manageTable = refreshQueue(const_groupprocessid,localStorage.getItem('Counter'),JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'],'#dataTable_Container','#dataTable',function(){

				});

				//initQueue(RequestData, localStorage.getItem('Counter'), JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'], manageTable);
			});
			midSocket.on('update_action_hold', function(data) {
				console.log("midSocket Get Response : update_action_hold");
				console.log("update_action_hold Data ", data);

				manageTable = refreshQueue(const_groupprocessid,localStorage.getItem('Counter'),JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'],'#dataTable_Container','#dataTable',function(){

				});

				//initQueue(RequestData, localStorage.getItem('Counter'), JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'], manageTable);
			});
			//END -- Update Action --
		//})
		//END -- Init Management --
		$(defaultDataTable['Filter']).on("keyup", function() {
			$(this).change();
		});
		$(defaultDataTable['Filter']).on("change", function() {
			$(defaultDataTable['Name']).DataTable().search($(this).val()).draw();
		});
		$(document).on("click", '[data-sidenav]', function() {
			var target = $(this).data('sidenav');
			$(this).toggleClass('active');
			$(target).hasClass('active') ? $(target).removeClass('active') : $(target).addClass('active');
		});
		$(document).on("click", dataAttribute['Full']['Clear'], function(e) {
			var targetID = $(this).data(dataAttribute['Name']['Clear']);
			$(targetID).val('').change();
		});
		$('#hold-modal').on('show.bs.modal', function(event) {
			//var getHoldMessage = base_path_url + 'GetHoldMessage/';
			var getHoldMessage = base_path_url+'GetHoldMessage/'+const_groupprocessid;
			$.getJSON(getHoldMessage, function(data) {
				$('#select_HoldMessage').find('option').remove().end();
				for (var key in data) {
					var textOption = data[key]['description'];
					$('#select_HoldMessage').append($("<option></option>")
						.attr("value", data[key]['uid'])
						.text(textOption));
				}
			});
			var relatedData = $(event.relatedTarget).data();
			var modalData = {
				queueno: relatedData['q_val'],
				patientuid: relatedData['puid_val'],
			};
			$('#span_Queueno').html(modalData['queueno']);
			$(dataAttribute['Full']['Hold']).data(dataAttribute['Name']['Hold'], modalData['queueno']);
			$("[data-patientuid]").data('patientuid', modalData['patientuid']);
		});
		$('#hold-modal').on('hidden', function() {
			$(dataAttribute['Full']['Hold']).data(dataAttribute['Name']['Hold'], '');
			$("[data-patientuid]").data('patientuid', '');
			clear();
		});
		$(document).on("click", dataAttribute['Full']['Call'], function(e) {
			var targetQueueNumber = $(this).data(dataAttribute['Name']['Call']);
			var targetPatientUID = $(this).data('patientuid');
			console.log("Call : " + targetQueueNumber);
			var PostDataURL = base_path_url + Management_CallURL + WorklistActionID['Call'];
			postData = {
				'patientdetailuid': targetPatientUID,
				'queueno': targetQueueNumber,
				'counter': localStorage.getItem('Counter'),
				'groupprocessuid': const_groupprocessid,
				'cuser': $('#span_Login').text(),
			};
			postAJAX(PostDataURL, postData, function() {
				var CallCurl = base_path_url + Management_CallCurl;
				CurlData = {
					'requestCall': '1',
					'queueno': targetQueueNumber,
					'counter': localStorage.getItem('Counter'),
					'location': const_groupprocessid,
				};
				postAJAX(CallCurl, CurlData, function() {
					console.log("Trigger Call");
					var TriggerURL = baseurlMid + '/api/manage/call_queue';
					triggerData = {
						'requestCall': '1',
						'queueno': targetQueueNumber,
						'queuecategory': JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'],
						'counter': localStorage.getItem('Counter'),
					};
					postAJAX(TriggerURL, triggerData);

				});
			});
			var RecallStatus = checkActive(this);
			if (RecallStatus == false) {
				$(this).addClass('active');
			}
		});
		$(document).on("click", dataAttribute['Full']['Hold'], function(e) {
			targetQueueNumber = $(this).data(dataAttribute['Name']['Hold']);
			targetPatientUID = $(this).data('patientuid');
			console.log("Hold : " + targetQueueNumber);
			var PostHoldDataURL = base_path_url + Management_HoldInsert;
			var postHoldData = {
				'patientdetailuid': targetPatientUID,
				'groupprocessuid': const_groupprocessid,
				'messageuid': $('#formHold').serializeArray()[0].value,
				'cuser': $('#span_Login').text(),
			};
			postAJAX(PostHoldDataURL, postHoldData, function() {
				var PostDataURL = base_path_url + Management_HoldURL + WorklistActionID['Hold'];
				var postData = {
					'patientdetailuid': targetPatientUID,
					'queueno': targetQueueNumber,
					'counter': localStorage.getItem('Counter'),
					'cuser': $('#span_Login').text(),
				};
				postAJAX(PostDataURL, postData, function() {
					var HoldCurl = base_path_url + Management_HoldCurl;
					CurlData = {
						'requestCall': '1',
						'queueno': targetQueueNumber,
						'counter': localStorage.getItem('Counter'),
						'location': const_groupprocessid,
					};
					postAJAX(HoldCurl, CurlData, function() {
						console.log("Trigger Hold");
						var TriggerURL = baseurlMid + '/api/manage/hold_queue';
						var triggerData = {
							'requestHold': '1',
							'queueno': targetQueueNumber,
							'queuecategory': JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'],
							'counter': localStorage.getItem('Counter'),
						};
						postAJAX(TriggerURL, triggerData, function() {
							$('#hold-modal').modal('hide');
						});
					});
				});
			});
			var targetID = targetQueueNumber;
			var targetRow = "#" + RowIDPrefix + targetID;
			var targetButton = $('*[data-q_val="' + targetID + '"]');
			if (!$(targetButton).hasClass('active')) {
				$(targetButton).addClass('active');
			}
		});
		$(document).on("click", dataAttribute['Full']['Complete'], function(e) {
			var targetQueueNumber = $(this).data(dataAttribute['Name']['Complete']);
			var targetPatientUID = $(this).data('patientuid');
			console.log("Complete : " + targetQueueNumber);
			var PostDataURL = base_path_url + Management_CompleteURL + WorklistActionID['Complete'];
			postData = {
				'patientdetailuid': targetPatientUID,
				'queueno': targetQueueNumber,
				'counter': localStorage.getItem('Counter'),
				'cuser': $('#span_Login').text(),
			};
			postAJAX(PostDataURL, postData, function() {
				var TriggerURL = baseurlMid + '/api/manage/complete_queue';
				triggerData = {
					'requestComplete': '1',
					'queueno': targetQueueNumber,
					'worklistuid': WorklistActionID['Complete'],
					'queuecategory': JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'],
				};
				postAJAX(TriggerURL, triggerData);
			});
			var RecallStatus = checkActive(this);
			if (RecallStatus == false) {
				$(this).addClass('active');
			}
			removeDTRow($(defaultDataTable['Name']).DataTable(), $(this).parents('tr'));
		});
		$(document).on("click", dataAttribute['Full']['CompleteAll'], function(e) {
			var targetQueueNumber = $(this).data(dataAttribute['Name']['CompleteAll']);
			var targetPatientUID = $(this).data('patientuid');
			console.log("CompleteAll : " + targetQueueNumber);

			var complete9 = base_path_url + Management_CompleteURL + '9';
			postData = {
				'patientdetailuid': targetPatientUID,
				'queueno': targetQueueNumber,
				'counter': localStorage.getItem('Counter'),
				'cuser': $('#span_Login').text(),
			};
			postAJAX(complete9, postData);

			var complete10 = base_path_url + Management_CompleteURL + '10';
			postData = {
				'patientdetailuid': targetPatientUID,
				'queueno': targetQueueNumber,
				'counter': localStorage.getItem('Counter'),
				'cuser': $('#span_Login').text(),
			};
			postAJAX(complete10, postData, function() {

				var PostDataCompAllURL = base_path_url + Management_CompleteURL + WorklistActionID['CompleteAll'];
				postDataComp = {
					'patientdetailuid': targetPatientUID,
					'queueno': targetQueueNumber,
					'counter': localStorage.getItem('Counter'),
					'cuser': $('#span_Login').text(),
				};
				postAJAX(PostDataCompAllURL, postDataComp, function() {
					//Trigger In Case of Complete All
					var TriggerURL = baseurlMid + '/api/manage/complete_queue';
					triggerData = {
						'requestComplete': '1',
						'queueno': targetQueueNumber,
						'worklistuid': WorklistActionID['CompleteAll'],
						'queuecategory': JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'],
					};
					postAJAX(TriggerURL, triggerData);

				});

			});
			removeDTRow($(defaultDataTable['Name']).DataTable(), $(this).parents('tr'));
		});
		$(document).on("click", dataAttribute['Full']['Cancel'], function(e) {
			var targetQueueNumber = $(this).data(dataAttribute['Name']['Cancel']);
			var targetPatientUID = $(this).data('patientuid');
			console.log("Cancel : " + targetQueueNumber);
			var PostDataURL = base_path_url + Management_CancelURL + WorklistActionID['Cancel'];
			postData = {
				'patientdetailuid': targetPatientUID,
				'queueno': targetQueueNumber,
				'counter': localStorage.getItem('Counter'),
				'cuser': $('#span_Login').text(),
			}
			postAJAX(PostDataURL, postData, function() {

				var TriggerURL = baseurlMid + '/api/manage/close_queue';
				triggerData = {
					'requestClose': '1',
					'queueno': targetQueueNumber,
					'worklistuid': WorklistActionID['Cancel'],
					'queuecategory': JSON.parse(localStorage.getItem('locatedata_' + const_groupprocessid))['QueueCate'],
				}
				postAJAX(TriggerURL, triggerData);

			});
			removeDTRow($(defaultDataTable['Name']).DataTable(), $(this).parents('tr'));
		});
		//--- Management ---//
	});
</script>