
<script type="text/javascript">

	$(document).ready( function () {
		$('#setupTitle').append('<br>คิวเปิดสิทธิ');
		$('#setupTitle_Alert').append('<br>คิวเปิดสิทธิ');
		/* Remove Tab Reserved for using in future*/
			Object.keys(removeID).forEach(function (key){
				$(removeID[key]).remove();
			});
		/* Remove Tab */
		
		tableNumber = TableRowCount;
		updateTabText();
		<?= Modules::run('Websocket/SocketConnection'); ?>

		/*Location Queuecategory*/
			var RequestData = base_path_url+'locationAvailable_JSON2'+'/'+const_groupprocessid;

			$.getJSON( RequestData, function( data ) {
				/* Add Button */
					//QueueCategory
					$('#queuecateRow').html('');
					$('#queuecateRow_Alert').html('');
					data['Category'].forEach(function(Value,Index){
						var CategoryData = {
							'ID': Value['uid'],
							'Code': Value['code'],
							'Name': Value['name'],
						};
						var btnCol = '';
		                btnCol += '<a data-locationqueuecate="'+CategoryData['ID']+'" data-buttonaction="locationqueuecate"><button>'+CategoryData['Name']+' ('+CategoryData['Code']+')</button></a>';
		                $('#queuecateRow').append(btnCol);
						$('#queuecateRow_Alert').append(btnCol);
					});
				/* Add Button */


				/* Add Active From LocalStorage */
					const localAttr = {
						locationqueuecate: 'QueueCate',
					};
					if( localStorage.getItem('locatedata_'+const_groupprocessid) ){
						var localStorageData = JSON.parse(localStorage.getItem('locatedata_'+const_groupprocessid));

						localStorageData['QueueCate'].forEach(function(Value,Index){
							if( !$('[data-locationqueuecate="'+Value+'"]').hasClass('active') ){
								$('[data-locationqueuecate="'+Value+'"]').addClass('active');
							}
						});
					}
				/* Add Active From LocalStorage */		

				$(document).on("click", '[data-buttonaction]', function(e) {
					$(this).toggleClass('active');
					var targetAction = $(this).data('buttonaction');
					var targetValue = $(this).data(targetAction);

					if( !localStorage.getItem('locatedata_'+const_groupprocessid) ){
						var localData = {
							'UID': const_groupprocessid,
							'QueueCate': '',
						};
					}else{
						var localData = JSON.parse(localStorage.getItem('locatedata_'+const_groupprocessid));
					}						
					var activeText = new Object;
					var targetSelector = document.querySelectorAll('[data-buttonaction]');
					targetSelector.forEach(function(Value,Index){
						if( $(targetSelector[Index]).hasClass('active') ){
							var targetAttr = $(targetSelector[Index]).data('buttonaction');
							var targetData = localAttr[targetAttr];

							if(!activeText[targetData]){
								activeText[targetData] = [];
							}
							activeText[targetData].push( $(targetSelector[Index]).data(targetAttr));
						}
					});

					Object.keys(activeText).forEach(function (key){
						localData[key] = activeText[key];
					});

					localStorage.setItem("locatedata_"+const_groupprocessid, JSON.stringify(localData));
				} );
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
		    var keyStorage = 'locatedata_'+const_groupprocessid;
			if(e.key == keyStorage || e.key == 'Counter'){
				location.reload();
			}

		};

		document.addEventListener("itemInserted", localStorageSetHandler, false);
		$(window).on('storage', function (e) {
		    var storageEvent = e.originalEvent;
		    var keyStorage = 'locatedata_'+const_groupprocessid;
			if( (storageEvent.key == keyStorage) && (storageEvent.oldValue != storageEvent.newValue) ){
		    	location.reload();
			}else if( (storageEvent.key == 'Counter') && (storageEvent.oldValue != storageEvent.newValue) ){
				updateTabText();
			}
		});

		var map = [ 
			{keyword: ',', replacement: '_'},
		];

		var localQueueCate = JSON.parse(localStorage.getItem('locatedata_'+const_groupprocessid))['QueueCate'];
		var strQueueCate = JSON.stringify(localQueueCate).replace('[','').replace(']','');
		map.forEach(function(value, index){
			strQueueCate = strQueueCate.replace(new RegExp(value.keyword, 'g'), value.replacement);
		});

		// -- Management -- //
		    // -- Init Management --
			    var manageTable = $(defaultDataTable['Name']).DataTable({
					ordering: false,
					scrollY: true,
					dom: 'rt',
			    });

			    $(window).on('resize', function(){
			    	manageTable.draw();
				});

				var RequestData = base_path_url+initPageFunction+'/'+const_groupprocessid+'/'+strQueueCate;
			    //var RequestData = base_path_url+initPageFunction+'/'+const_groupprocessid+'/'+localStorage.getItem('QueueCate');
		    	initQueue(RequestData,localStorage.getItem('Counter'),JSON.parse(localStorage.getItem('locatedata_'+const_groupprocessid))['QueueCate'],manageTable,function(){

		    		updateWaitingQueue = setInterval(function(){
		    			manageTable.column(tableColumns['WaitingQueue']).nodes().each(function(node,index,dt){
					    	ColumnValue = parseInt(manageTable.cell(node).data());
					    	manageTable.cell(node).data(ColumnValue+1);
					    	manageTable.draw(false);
					    });
		    		}, 60000);

					// -- Management Status Update --
					    midSocket.on('update_queue_action', function( data ){
							console.log("midSocket Get Response : update_queue_action");
							console.log("update_queue_action Data " , data);
							var Found = JSON.parse(localStorage
							  .getItem("locatedata_" + const_groupprocessid))['QueueCate']
							  .some(function(ai) {
							    return data.cateid.includes(ai);
							});

							if( Found ){
							    initQueue(baseurlMid + '/api/manage/queueno',localStorage.getItem('Counter'),JSON.parse(localStorage.getItem('locatedata_'+const_groupprocessid))['QueueCate'],manageTable);
							}
						});

					    midSocket.on('remove_queue', function( data ){
							console.log("midSocket Get Response : remove_queue");
							console.log("remove_queue Data " , data);

							var targetRow = "#" + RowIDPrefix + data.queueno;
							manageTable.row(targetRow).remove().draw();

							var targetQueueNumber = data.queueno;
							var getQueueURL = base_path_url+'GetQueueRegister_RelatedQueueno/'+targetQueueNumber;
							$.getJSON( getQueueURL, function( data ) {
								for(var key in data){
									console.log(data);
									if(  JSON.parse(localStorage.getItem('locatedata_'+const_groupprocessid))['QueueCate'].includes(data[key]['queuecategoryuid']) && (data[key]['groupprocessuid'] == const_groupprocessid) ){
										AddQueueRow(manageTable,data[key]);
									}
								}
							});

							/*
							var Found = JSON.parse(localStorage
							  .getItem("locatedata_" + const_groupprocessid))['QueueCate']
							  .some(function(ai) {
							    return data.cateid.includes(ai);
							});

							if( Found ){
								var targetRow = "#" + RowIDPrefix + data.queueno;
								manageTable.row(targetRow).remove().draw();
							}else{
								var targetQueueNumber = data.queueno;
								var getQueueURL = base_path_url+'GetQueueRegister_RelatedQueueno/'+targetQueueNumber;
								$.getJSON( getQueueURL, function( data ) {
									for(var key in data){
										if(  JSON.parse(localStorage.getItem('locatedata_'+const_groupprocessid))['QueueCate'].includes(data.cateid) && (data[key]['groupprocessuid'] == const_groupprocessid) ){
											AddQueueRow(manageTable,data[key]);
										}
									}
								});
							}
							*/
						});
					//END -- Management Status Update -- 

				    	midSocket.on('remove_queue_puid', function( data ){
							console.log("midSocket Get Response : remove_queue_puid");
							console.log("remove_queue_puid Data " , data);
							console.log('data.data' + data.data);
							console.log('data.patientuid' , data.patientuid);
							console.log('data.data.patientuid' + data.data.patientuid);
							console.log("data['patientuid']" , data['patientuid']);
							console.log("data['patientuid']" + data['patientuid']);

							var targetPUID = data.patientuid;
							var getPUIDInfoURL = base_path_url+'GetQueueInfo_PUID/'+targetPUID;
							$.getJSON( getPUIDInfoURL, function( data ) {

								Object.keys(response).forEach(function (key){
									var targetRow = "#" + RowIDPrefix + response[key]['queueno'];
									manageTable.row(targetRow).remove().draw();
								});
								
								// var targetRow = "#" + RowIDPrefix + data['queueno'];
								// manageTable.row(targetRow).remove().draw();
							});

				    	});

				    // -- (From Filter) Receive  Data Row From Socket --
					    midSocket.on('manage_getqueue_puid', function( data ){
							console.log("midSocket Get Response : manage_getqueue_puid");
							console.log("manage_getqueue_puid Data " , data);
							Object.keys(data.data).forEach(function (key){
								var targetPUID = data.data.patientuid;
								var getPUIDInfoURL = base_path_url+'GetQueueInfo_Register/'+targetPUID;

								$.getJSON( getPUIDInfoURL, function( data ) {
									for(var key in data){
										if(  JSON.parse(localStorage.getItem('locatedata_'+const_groupprocessid))['QueueCate'].includes(data[key]['queuecategoryuid']) && (data[key]['groupprocessuid'] == const_groupprocessid) ){
											AddQueueRow(manageTable,data[key]);
										}
									}
								});

							});
						});
					    //END -- Receive Data Row 
					    // -- Receive Data Row From Socket --
					    midSocket.on('manage_getqueue_row', function( data ){
							console.log("midSocket Get Response : manage_getqueue_row");
							console.log("manage_getqueue_row Data " , data);

							//Object.keys(data.data.queueno).forEach(function (key){
							//	var targetQueueNumber = data.data.queueno[key];
							Object.keys(data.data).forEach(function (key){
								data.data['queueno'].forEach(function(Value,Index){
									console.log(Value);
									var targetQueueNumber = Value;
									var getQueueURL = base_path_url+'GetQueueInfo_Register_Queueno/'+targetQueueNumber;
									$.getJSON( getQueueURL, function( data ) {
										for(var key in data){
											if( JSON.parse(localStorage.getItem('locatedata_'+const_groupprocessid))['QueueCate'].includes(data[key]['queuecategoryuid']) && (data[key]['groupprocessuid'] == const_groupprocessid) ){
												AddQueueRow(manageTable,data[key]);
											}
										}
									});
								});
								/*
								var targetQueueNumber = data.data.queueno;
								var getQueueURL = base_path_url+'GetQueueInfo_Register_Queueno/'+targetQueueNumber;
								$.getJSON( getQueueURL, function( data ) {
									for(var key in data){
										if( JSON.parse(localStorage.getItem('locatedata_'+const_groupprocessid))['QueueCate'].includes(data[key]['queuecategoryuid']) && (data[key]['groupprocessuid'] == const_groupprocessid) ){
											AddQueueRow(manageTable,data[key]);
										}
									}
								});
								*/

							});
						});
				    //END -- Receive Data Row 

				    // -- Update Action --	    
					    midSocket.on('update_action_call', function( data ){
							console.log("midSocket Get Response : update_action_call");
							console.log("update_action_call Data " , data);

							var targetID = data.queueno;
							var targetRow = "#" + RowIDPrefix + data.queueno;
							var targetButton = $('*'+ dataAttribute['Semi']['Call'] +'="'+ targetID +'"]');

							var callCounter = data.counter;
							updateDTCell(manageTable,$(targetButton).parents('tr'),tableColumns['CallChanel'],callCounter);

							var RecallStatus = checkActive(targetButton);
					    	if(RecallStatus == false){
					    		$(targetButton).addClass('active');
						    	//updateWaitingQueue(manageTable,tableColumns['WaitingQueue']);	    		
					    	}

					    	var testURL = base_path_url+'GetWorklistStatus/'+targetID;
							$.getJSON( testURL, function( data ) {
								console.log("Worklist Hold Status" , data);
								var WorklistDescription =  data[0].lastworklist;

								updateDTCell(manageTable,$(targetRow),tableColumns['Status'],WorklistDescription);
							});

						});

					    midSocket.on('update_action_hold', function( data ){
							console.log("midSocket Get Response : update_action_hold");
							console.log("update_action_hold Data " , data);

							var targetID = data.queueno;
							var targetRow = "#" + RowIDPrefix + targetID;
							var targetButton = $('*[data-q_val="'+ targetID +'"]');

							var RecallStatus = checkActive(targetButton);
					    	if(RecallStatus == false){
					    		$(targetButton).addClass('active');
						    	//updateWaitingQueue(manageTable,tableColumns['WaitingQueue']);	    		
					    	}

					    	var testURL = base_path_url+'GetWorklistStatus/'+targetID;
							$.getJSON( testURL, function( data ) {
								console.log("Worklist Hold Status" , data);
								var WorklistDescription =  data[0].lastworklist;

								updateDTCell(manageTable,$(targetRow),tableColumns['Status'],WorklistDescription);
							});
						});
					//END -- Update Action --
		    	});
		    //END -- Init Management --

		    $(defaultDataTable['Filter']).on("keyup",function() {
		    	$(this).change();
			});

			$(defaultDataTable['Filter']).on("change",function() {
				manageTable.search($(this).val()).draw();
			});

	        $(document).on("click", '[data-sidenav]', function() {
	        	var target = $(this).data('sidenav');
	        	$(this).toggleClass('active');
	        	$(target).hasClass('active') ? $(target).removeClass('active') : $(target).addClass('active');
	        });

		    $(document).on("click", dataAttribute['Full']['Clear'], function(e) {
		    	var targetID = $(this).data(dataAttribute['Name']['Clear']);
			    $(targetID).val('').change();
			} );		

			$('#hold-modal').on('show.bs.modal', function (event) {
				var getHoldMessage = base_path_url+'GetHoldMessage/'+const_groupprocessid;
				$.getJSON( getHoldMessage, function( data ) {
					$('#select_HoldMessage').find('option').remove().end();
					for(var key in data){
						var textOption = data[key]['description'];
						$('#select_HoldMessage').append($("<option></option>")
							          .attr("value",data[key]['uid'])
							          .text(textOption)); 
					}
				});

				var relatedData = $(event.relatedTarget).data();
				var modalData = {
					queueno: relatedData['q_val'],
					patientuid: relatedData['puid_val'],
				};
				$('#span_Queueno').html(modalData['queueno']);
				$(dataAttribute['Full']['Hold']).data(dataAttribute['Name']['Hold'],modalData['queueno']);
				$("[data-patientuid]").data('patientuid',modalData['patientuid']);
			});
			$('#hold-modal').on('hidden', function() {
				$(dataAttribute['Full']['Hold']).data(dataAttribute['Name']['Hold'],'');
				$("[data-patientuid]").data('patientuid','');
				clear();
			});

		    $(document).on("click", dataAttribute['Full']['Call'], function(e) {
		    	var targetQueueNumber = $(this).data(dataAttribute['Name']['Call']);
		    	var targetPatientUID = $(this).data('patientuid');
		    	console.log("Call : " + targetQueueNumber);

		    	var PostDataURL = base_path_url+'CallQueue/'+WorklistActionID['Call'];
		    	postData = {
		    		'patientdetailuid': targetPatientUID,
		    		'queueno': targetQueueNumber,
		    		'counter': localStorage.getItem('Counter'),
		    		'groupprocessuid': const_groupprocessid,
		    	};
		    	postAJAX(PostDataURL,postData,function(){

		    		var CallCurl = base_path_url+'Call_Curl/';
			    	CurlData = {
			    		'requestCall': '1',
			    		'queueno': targetQueueNumber,
			    		'counter': localStorage.getItem('Counter'),
			    		'location': const_groupprocessid,
			    	};
			    	postAJAX(CallCurl,CurlData);

			    	console.log("Trigger Call");
			    	var TriggerURL = baseurlMid + '/api/manage/call_queue';
			    	triggerData = {
			    		'requestCall': '1',
			    		'queueno': targetQueueNumber,
			    		'queuecategory':  JSON.parse(localStorage.getItem('locatedata_'+const_groupprocessid))['QueueCate'] ,
			    		'counter': localStorage.getItem('Counter'),
			    	};
			    	postAJAX(TriggerURL,triggerData);

			    });

		    	var RecallStatus = checkActive(this);
		    	if(RecallStatus == false){
		    		$(this).addClass('active');
			    	//updateWaitingQueue(manageTable,tableColumns['WaitingQueue']);	    		
		    	}

			} );

			$(document).on("click", dataAttribute['Full']['Hold'], function(e) {
		    	targetQueueNumber = $(this).data(dataAttribute['Name']['Hold']);
		    	targetPatientUID = $(this).data('patientuid');
		    	console.log("Hold : " + targetQueueNumber);

		    	var PostHoldDataURL = base_path_url+'InsertMessage/';
		    	var postHoldData = {
		    		'patientdetailuid': targetPatientUID,
			    	'groupprocessuid': const_groupprocessid,
		    		'messageuid': $('#formHold').serializeArray()[0].value,
		    	};
		    	postAJAX(PostHoldDataURL,postHoldData,function(){
					var PostDataURL = base_path_url+'HoldQueue/'+WorklistActionID['Hold'];
			    	var postData = {
			    		'patientdetailuid': targetPatientUID,
			    		'queueno': targetQueueNumber,
			    		'counter': localStorage.getItem('Counter'),
			    	};
				    postAJAX(PostDataURL,postData,function(){

			    		var HoldCurl = base_path_url+'Hold_Curl/';
				    	CurlData = {
				    		'requestCall': '1',
				    		'queueno': targetQueueNumber,
				    		'counter': localStorage.getItem('Counter'),
				    		'location': const_groupprocessid,
				    	};
				    	postAJAX(HoldCurl,CurlData);

			    		console.log("Trigger Hold");
				    	var TriggerURL = baseurlMid + '/api/manage/hold_queue';
				    	var triggerData = {
				    		'requestHold': '1',
				    		'queueno': targetQueueNumber,
				    		'queuecategory':  JSON.parse(localStorage.getItem('locatedata_'+const_groupprocessid))['QueueCate'] ,
				    		'counter': localStorage.getItem('Counter'),
				    	};
				    	postAJAX(TriggerURL,triggerData,function(){
				    		$('#hold-modal').modal('hide');
				    	});
			    	
			    	});
		    	});

		    	var targetID = targetQueueNumber;
				var targetRow = "#" + RowIDPrefix + targetID;
				var targetButton = $('*[data-q_val="'+ targetID +'"]');
				if( !$(targetButton).hasClass('active') ){
					$(targetButton).addClass('active');
		    	}
			} );

			$(document).on("click", dataAttribute['Full']['Complete'], function(e) {
		    	var targetQueueNumber = $(this).data(dataAttribute['Name']['Complete']);
		    	var targetPatientUID = $(this).data('patientuid');
		    	console.log("Complete : " + targetQueueNumber);

		    	var PostDataURL = base_path_url+'CompleteQueue/'+WorklistActionID['Complete'];
		    	postData = {
		    		'patientdetailuid': targetPatientUID,
		    		'queueno': targetQueueNumber,
		    		'counter': localStorage.getItem('Counter'),
		    	};
		    	postAJAX(PostDataURL,postData);

		    	var TriggerURL = baseurlMid + '/api/manage/complete_queue';
		    	triggerData = {
		    		'requestComplete': '1',
		    		'queueno': targetQueueNumber,
		    		'worklistuid': WorklistActionID['Complete'],
		    		'queuecategory':  JSON.parse(localStorage.getItem('locatedata_'+const_groupprocessid))['QueueCate'] ,
		    	};
		    	postAJAX(TriggerURL,triggerData);

		    	var RecallStatus = checkActive(this);
		    	if(RecallStatus == false){
		    		$(this).addClass('active');
			    	//updateWaitingQueue(manageTable,tableColumns['WaitingQueue']);	    		
		    	}

		    	removeDTRow(manageTable,$(this).parents('tr'));
			} );

			$(document).on("click", dataAttribute['Full']['CompleteAll'], function(e) {
		    	var targetQueueNumber = $(this).data(dataAttribute['Name']['CompleteAll']);
		    	var targetPatientUID = $(this).data('patientuid');
		    	console.log("CompleteAll : " + targetQueueNumber);

		    	var PostDataURL = base_path_url+'CompleteQueue/'+WorklistActionID['CompleteAll'];
		    	postData = {
		    		'patientdetailuid': targetPatientUID,
		    		'queueno': targetQueueNumber,
		    		'counter': localStorage.getItem('Counter'),
		    	};
		    	postAJAX(PostDataURL,postData);

		    	var TriggerURL = baseurlMid + '/api/manage/complete_queue';
		    	triggerData = {
		    		'requestComplete': '1',
		    		'queueno': targetQueueNumber,
		    		'worklistuid': WorklistActionID['CompleteAll'],
		    		'queuecategory':  JSON.parse(localStorage.getItem('locatedata_'+const_groupprocessid))['QueueCate'] ,
		    	};
		    	postAJAX(TriggerURL,triggerData);

		    	var RecallStatus = checkActive(this);
		    	if(RecallStatus == false){
		    		$(this).addClass('active');
			    	//updateWaitingQueue(manageTable,tableColumns['WaitingQueue']);	    		
		    	}

		    	removeDTRow(manageTable,$(this).parents('tr'));
			} );


			$(document).on("click", dataAttribute['Full']['Cancel'], function(e) {
		    	var targetQueueNumber = $(this).data(dataAttribute['Name']['Cancel']);
		    	var targetPatientUID = $(this).data('patientuid');
		    	console.log("Cancel : " + targetQueueNumber);

		    	var PostDataURL = base_path_url+'CancelQueue/'+WorklistActionID['Cancel'];
		    	postData = {
		    		'patientdetailuid': targetPatientUID,
		    		'queueno': targetQueueNumber,
		    		'counter': localStorage.getItem('Counter'),
		    	}
		    	postAJAX(PostDataURL,postData);

		    	var TriggerURL = baseurlMid + '/api/manage/close_queue';
		    	triggerData = {
		    		'requestClose': '1',
		    		'queueno': targetQueueNumber,
		    		'worklistuid': WorklistActionID['Cancel'],
		    		'queuecategory':  JSON.parse(localStorage.getItem('locatedata_'+const_groupprocessid))['QueueCate'],
		    	}
		    	postAJAX(TriggerURL,triggerData);

		    	//$('*'+ dataAttribute['Semi']['Call'] +'="'+ targetQueueNumber +'"]').attr("disabled",true);
		    	//$('*'+ dataAttribute['Semi']['Hold'] +'="'+ targetQueueNumber +'"]').attr("disabled",true);
		    	//$('*'+ dataAttribute['Semi']['Note'] +'="'+ targetQueueNumber +'"]').attr("disabled",true);
		    	//$('*'+ dataAttribute['Semi']['Complete'] +'="'+ targetQueueNumber +'"]').attr("disabled",true);

		    	var RecallStatus = checkActive(this);
		    	if(RecallStatus == false){
		    		$(this).addClass('active');
			    	//updateWaitingQueue(manageTable,tableColumns['WaitingQueue']);	    		
		    	}

		    	//updateDTCell(manageTable,$(this).parents('tr'),tableColumns['Status'],StatusMessage['Cancel']);
		    	removeDTRow(manageTable,$(this).parents('tr'));
			} );
		//--- Management ---//
	} );
</script>
