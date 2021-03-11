<script type = "text/javascript">
	//const base_path_url = '<?=LOCALURL;?>Management/';
	//const base_path_url = '.././';
	const base_path_url = '<?=APPURLMANAGE;?>/Management/';

	const const_groupprocessid = "3";

	const TabSpanID = {
		//'Counter' : '#span_Counter',
		'QueueCate': '#span_QueueCategory',
	}

	var localTab = {
		//'Counter' : '',
		'QueueCate': '',
	}

	var SetupVar = new Object();

	function checkLocalStorage() {
		if (!localStorage.getItem('Counter') && !localStorage.getItem('QueueCate')) {
			var WarningText;
			WarningText = 'ไม่สามารถใช้งานได้ : คุณยังไม่ได้ตั้งค่าหน้า Management ';
			WarningText += '<a href="' + base_path_url + 'Setup/" target="_blank" ><button class="button small c_darkblue" >ตั้งค่า</button></a>';
			$('#ManagementTab').html(WarningText);
			$('#ManagementDashboard').click(false);
			$(window).on('storage', function (e) {
				var storageEvent = e.originalEvent;
				if (localStorage.getItem('Counter') && localStorage.getItem('QueueCate')) {
					location.reload();
				}

			});
			return false;
		}
		return true;
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

			var RequestData = base_path_url + 'GetCategoryDetailData_JSON';
			$.getJSON(RequestData, function (data) {
				var queryResult = new Object;
				Object.keys(data).forEach(function (key) {
					queryResult[data[key]['uid']] = data[key]['name'] + ' (' + data[key]['code'] + ')';
				});
				SetupVar['QueueCate'] = queryResult;

				Object.keys(Var).forEach(function (key) {
					Var[key] = localStorage.getItem(key);
				});
				Var['QueueCate'] = SetupVar['QueueCate'][localStorage.getItem('QueueCate')];
				if (callback) {
					callback();
				}
			});

		}

	}

	function resetFilter() {
		//$(".active").removeClass("active"); 
	}

	function resetPostData(target) {
		$(target).attr('data-patientuid', '');
		$(target).attr('data-refno', '');
		$(target).text('');
	}

	function postAJAX(urlpath,data,callback){
		$.ajax({
	        url: urlpath,
	        method: 'POST',
	        dataType: 'json',
	        data: data,
	        headers: {
	            'Access-Control-Allow-Origin': '*',
	            'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
	            'Access-Control-Allow-Headers': 'Authorization, Origin, X-Requested-With, Content-Type, Accept',
	            'Authorization':'Basic YXJtOjEyMzQ=',
	        }, 
	        success: function(result){
	            console.log('AJAX Result : ' , result);
	            if (callback) {
				    callback(result);
				}
	        },
	        error: function(err){
	        	console.log('AJAX Error');
	            if (callback) {
				    callback(err);
				}
	        },
	    });
	}

	const refreshCount = (URL) => {
		$.getJSON(URL, { "_": $.now() })
			.done(async function(response){
				await response.forEach(element => {
					$('#count_filter_'+element['uid']).text(element['count']);
				});
				return true;
			})
			.fail(function() {
				return false;
			})
	}

	var checkTimeout = false;
	var timeoutResetName;

	$(document).ready(function () {
		refreshCount(base_path_url+'refreshCountClinic');

		$('.sidenav_url').each(function (index) {
			$(this).attr('href', '../' + $(this).attr('href'));
		});

		//updateTabText();
		$('#li_queuecategory').remove();
		$('#li_counter').remove();
		$('#SetupBtn').remove();


		$('#SearchRefNo').focus();
		// Force focus
		$('#SearchRefNo').focusout(function () {
			if( $('#printer_location_row').hasClass('hidden') ){
				$('#SearchRefNo').focus();
			}
		});

		<?= Modules::run('Websocket/SocketConnection'); ?>
		var RequestRefNoURL = base_path_url + 'GetFilterQueueInfo/';
		var RequestRefNoFilterURL = baseurlMid + '/api/manage/filter_insert/';

		<?php if($Data['BuildingUID'] == 0){?>
		$('.filter_style').remove();
		<?php } ?>

		<?php /*
		if (localStorage.getItem('filtercount')) {
			console.log("FILTER DATA");
			var filtercount = JSON.parse(localStorage.getItem('filtercount'));
			if (filtercount['date'] !== 'undefined') {
				console.log("DEFINED DATA DATE");

				var currentDate = new Date().getDate();
				var dataDate = filtercount['date'];

				console.log("currentDate : " + currentDate);
				console.log("dataDate : " + dataDate);

				if(currentDate === dataDate){
					console.log("DATA SAME DATE");

					Object.keys(filtercount).forEach(function (key) {
						var localFilterName = '#count_filter_' + key;
						$(localFilterName).text(parseInt(filtercount[key]));
					});					
				}else{
					console.log("DATA DIFFERENT DATE");

					var filterset = {
						'date':  currentDate,
					};
					localStorage.setItem('filtercount', JSON.stringify(filterset));
					console.log("SET DATE");
				}
			}
			else{
				console.log("NO DATA DATE");
				var currentDate = new Date().getDate();
				var filterset = {
					'date':  currentDate,
				};
				localStorage.setItem('filtercount', JSON.stringify(filterset));
			}
		}else{
			console.log("NO FILTER DATA");
			var currentDate = new Date().getDate();
			var filterset = {
				'date':  currentDate,
			};
			localStorage.setItem('filtercount', JSON.stringify(filterset));
		}*/?>

		$(document).on('keypress', function (e) {
			if (e.which == 13) {
				e.preventDefault();
				$('#SearchRefNo').focus();
				$('[data-searchref]').click();
			}
		});

		$('#li_queuecategory').html('');

		/*
			$(window).on('storage', function (e) {
			    var storageEvent = e.originalEvent;
				if( (storageEvent.key == 'Counter') && (storageEvent.oldValue != storageEvent.newValue) ){
					//updateTabText();
				}
			});
		*/
		$(document).on("click", '#EditFilter', function () {
			$(this).attr('id', 'SaveFilter');
			var printer_locate = ( localStorage.getItem('filter_printer_location') == undefined ? 1 : localStorage.getItem('filter_printer_location') );			
			$('#print_location').val(printer_locate);
			$('.span_limit').toggleClass('active');
			$("button", this).toggleClass('active');
			$("button", this).html('บันทึก <i class="far fa-save"></i>');
			$('[data-tabaction]').attr('disabled', 'disabled');
			$('#printer_location_row').toggleClass('hidden');
			$('[data-editfilter]').toggleClass('hidden');
			$('#container_building').css('height','calc(75% - 9rem)');
		});

		$(document).on("click", '#SaveFilter', function () {
			$(this).attr('id', 'EditFilter');
			localStorage.setItem('filter_printer_location',$('#print_location').val());
			$('.span_limit').toggleClass('active');
			$("button", this).toggleClass('active');
			$("button", this).html('แก้ไขจำนวน <i class="fas fa-pencil-alt"></i>');
			$('#printer_location_row').toggleClass('hidden');
			$('[data-editfilter]').toggleClass('hidden');
			$('[data-tabaction]').removeAttr('disabled');
			$('#container_building').css('height','calc(75% - 6rem)');
			$('#SearchRefNo').focus();
		});

		$(document).on("click", '[data-editfilter]', function () {
			var method = $(this).data('editfilter');
			var target = $(this).data('roomuid');
			var localFilterName = 'count_filter_' + target;
			let roomcount = parseInt( $('#' + localFilterName).text() );
			console.log("edit");
			switch (method) {
				case 'add':
					let addurl = `${base_path_url}add_cliniccount/${target}`;
					$.get({url:addurl})
						.always(function(response){
							$.ajax({
								url: "<?=MIDPREFIX.MIDURL . '/api/manage/refreshClinicCount';?>",
								method: 'GET',
								headers: {
									'Access-Control-Allow-Origin': '*',
									'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
									'Access-Control-Allow-Headers': 'Authorization, Origin, X-Requested-With, Content-Type, Accept',
									'Authorization':'Basic YXJtOjEyMzQ=',
								}, 
								success: function(result){
									console.log('AJAX Result : ' , result);
								},
								error: function(err){
									console.log('AJAX Error : ',err);
								},
							});
							refreshCount(base_path_url+'refreshCountClinic');
						});			
					break;
				case 'subtract':
					let removeurl = `${base_path_url}remove_cliniccount/${target}`;
					$.get({url:removeurl})
						.always(function(response){
							$.ajax({
								url: "<?=MIDPREFIX.MIDURL . '/api/manage/refreshClinicCount';?>",
								method: 'GET',
								headers: {
									'Access-Control-Allow-Origin': '*',
									'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
									'Access-Control-Allow-Headers': 'Authorization, Origin, X-Requested-With, Content-Type, Accept',
									'Authorization':'Basic YXJtOjEyMzQ=',
								}, 
								success: function(result){
									console.log('AJAX Result : ' , result);
								},
								error: function(err){
									console.log('AJAX Error : ',err);
								},
							});
							refreshCount(base_path_url+'refreshCountClinic');
						});
					break;
			}
		})

		$(document).on("click", '[data-sidenav]', function () {
			var target = $(this).data('sidenav');
			$(this).toggleClass('active');
			$(target).hasClass('active') ? $(target).removeClass('active') : $(target).addClass('active');
		});

		$(document).on("click", '[data-tabaction]', async function (e) {
			let thisButtext = $(this).text();
			var targetActionAttr = $(this).data('tabaction');
			var buildinguid = $(this).data('buildinguid');
			var flooruid = $(this).data('flooruid');
			var roomuid = $(this).data('tabfilter');
			var printer_locate = ( localStorage.getItem('filter_printer_location') == undefined ? 1 : localStorage.getItem('filter_printer_location') );
			var openvisit=1;
			let visit_active = $(this).data('visitactive');
			let delay = 0;
			let log_id = null;
			if( (localStorage.getItem('filter_state_refno') && localStorage.getItem('filter_state_refno') != '') || (localStorage.getItem('filter_state_patientuid') && localStorage.getItem('filter_state_patientuid') != '') || (localStorage.getItem('filter_state_patienthn') && localStorage.getItem('filter_state_patienthn') != '')){
				if( true ){ //localStorage.getItem('filter_state_patienthn') && localStorage.getItem('filter_state_patienthn') != ''){
					var opdcode = $(this).data('opdcode');
					var created_user = $('#span_Login').text();
					var hn = localStorage.getItem('filter_state_patienthn');
					var patientHN;
					var yearHN;
					let refno = localStorage.getItem('filter_state_refno');
					let pid = localStorage.getItem('filter_state_patientuid');
					let idcard = localStorage.getItem('filter_state_idcard');
					await hn.split('/').forEach(function (item) {
						if(item.length == 2){
							yearHN = item;
						}else{
							patientHN =item;
						}
					});
					//ติดค้าง API visit_type 
					if( '<?=(defined('VISITAPI') ? VISITAPI : '');?>' != '' && visit_active == 'Y'){
						localStorage.setItem('filter_state_api',true);
						SearchValue = localStorage.getItem('filter_state_patienthn');
						SearchValue = SearchValue.replace('/', '_');
						var functionURL = base_path_url + 'GetFilterQueueInfoHN/';
						var functionURLString = functionURL + SearchValue;
						//await $.getJSON(functionURLString, async function (data) {
							delay = 1;
							let closequeue = localStorage.getItem('filter_state_closequeue_vs');
							if(true){//if (data.length > 0  && data[0].active != 'N'){//&& data[0].closequeue_vs == null) { // && (closequeue == null || (closequeue != null && closequeue.trim() == '')) ){
									var api_url = base_path_url+'visitCurl/';
									var api_visit_post = {
										'p_run_hn': patientHN,
										'p_year_hn': yearHN,
										'p_opd': opdcode,
										'p_user_created': created_user,
										'p_visit_type': "2",
										'refno': refno,
										'pid': pid,
										'idcard': idcard
									};
									let Nametext = $('#TabPatientName').text();
									console.log("APIURL : "+api_url);
									await $.ajax({
										url: api_url,
										method: 'POST',
										dataType: 'json',
										data: api_visit_post,
										headers: {
											'Access-Control-Allow-Origin': '*',
											'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
											'Access-Control-Allow-Headers': 'Authorization, Origin, X-Requested-With, Content-Type, Accept'
										}
									})
										.done(function(data, textStatus, xhr){
											
											console.log("API DATA ",data);
											log_id = data.log_id;
											if(data.code == 200 || data.code == 201 && data.result != "false" ){
												openvisit = 0;
											}else if( (data.code == 400 || data.code == 403) && data.result.includes('ระบบมีการส่งรายชื่อของท่านไปยังห้องตรวจ') ){
												openvisit = 0;
											}else{
												openvisit = 1;
											}
										})
										.fail(function(xhr, error_text, statusText){
											console.log(error_text);
											openvisit = 1;
										})
										.always(function(data, textStatus, xhr){
											console.log(`API CODE : ${xhr.status}`);
										});
									await $('#TabPatientName').html(`${Nametext}<p style="color:${(openvisit==1?'#FF0033':'#00FF33')};">เปิด visit ไปที่ "${thisButtext}" ${(openvisit==1?'ไม่':'')}สำเร็จ</p>`);
									await localStorage.setItem('filter_state_api',false);
									timeoutResetName = await window.setTimeout(function () {
										console.log("reset");
										$('#TabPatientName').text('');
										$('#TabPatientName').attr('data-refno', '');localStorage.setItem('filter_state_refno', '');
										$('#TabPatientName').attr('data-idcard', '');localStorage.setItem('filter_state_idcard', '');
										$('#TabPatientName').attr('data-patientuid', '');localStorage.setItem('filter_state_patientuid', '');
										$('#TabPatientName').attr('data-patienthn', '');localStorage.setItem('filter_state_patienthn', '');
										$('#TabPatientName').attr('data-closequeue', '');localStorage.setItem('filter_state_closequeue_vs', '');
									}, 5000);
									/*
										await postAJAX(api_url, api_visit_post, function (data) {
											console.log(data);
											if(data.result == "false"){
												openvisit = 1;
												// alert('เปิดvisitไม่สำเร็จ');
											}else{
												openvisit = 0;
											}
										});
									*/


								//}
							}
						//});
					}else{
						let Nametext = $('#TabPatientName').text();
						await $('#TabPatientName').html(`${Nametext}<p style="color:black;">แจ้งผู้ป่วยติดต่อ เปิด visit ไปที่ "${thisButtext}" </p>`);
						await localStorage.setItem('filter_state_api',false);
						timeoutResetName = await window.setTimeout(function () {
							console.log("reset");
							$('#TabPatientName').text('');
							$('#TabPatientName').attr('data-refno', '');localStorage.setItem('filter_state_refno', '');
							$('#TabPatientName').attr('data-idcard', '');localStorage.setItem('filter_state_idcard', '');
							$('#TabPatientName').attr('data-patientuid', '');localStorage.setItem('filter_state_patientuid', '');
							$('#TabPatientName').attr('data-patienthn', '');localStorage.setItem('filter_state_patienthn', '');
							$('#TabPatientName').attr('data-closequeue', '');localStorage.setItem('filter_state_closequeue_vs', '');
						}, 5000);
					}
				}

				if ( /*parseInt($('#count_filter_' + roomuid).text()) < parseInt($('#max_count_filter_' + roomuid).text())*/ true) {
					var date = new Date;
					var year = date.getFullYear() + 543;
					var seconds = date.getSeconds();
					var minutes = date.getMinutes();
					var hour = date.getHours();
					var patientuid = localStorage.getItem('filter_state_patientuid');
					var refno = localStorage.getItem('filter_state_refno');
					var hn = localStorage.getItem('filter_state_patienthn');
					var cuser = $('#span_Login').text();
					//var patientuid = $('#TabPatientName').attr('data-patientuid');
					//var refno = $('#TabPatientName').attr('data-refno');

					var postData = {
						refno: refno,
						patientuid: patientuid,
						building: buildinguid,
						floor: flooruid,
						room: roomuid,
						year: year,
						hour: hour,
						minutes: (minutes.length > 1 ? '' : '0') + minutes,
						second: (seconds.length > 1 ? '' : '0') + seconds,
						cuser: cuser,
						openvisit: openvisit,
						log_id: log_id
					};
					var postURL = base_path_url + 'printRoom/';
					console.log("PRINT", postURL,postData);
					await postAJAX(postURL, postData, async function (data) {
						console.log("AJAXDATA",data);
						var printData = {
							refno: data.Refno,
							queueno: data.Queueno,
							queuewithgroup: (typeof data.Queueno !== 'undefined' && data.Queueno.length > 0 ? data.QueuenoGroupprocess : ''),
							locationid: printer_locate,
							building: data.Building,
							//building: 'ศูนย์วิจัยทางชีววิทยาศาสตร์',
							floor: data.Floor,
							room: data.Room,
							//room: 'แผนกมีบุตรยาก/วางแผนครอบครัว',
							time: data.Time,
							year: data.Year,
							openvisit: data.openvisit,
							hn: localStorage.getItem('filter_state_patienthn')
						};
						console.log("PRINTURL");
						var printURL = base_path_url + 'printCurl/';
						console.log("-",printURL,printData);
						await postAJAX(printURL, printData, function (data) {
							
							if( !(localStorage.getItem('filter_state_api') || localStorage.getItem('filter_state_api') == false) ){
								$('#TabPatientName').text('');
							}
							if(delay == 0){
								$('#TabPatientName').attr('data-idcard', '');localStorage.setItem('filter_state_idcard', '');
								$('#TabPatientName').attr('data-patientuid', '');localStorage.setItem('filter_state_patientuid', '');
								$('#TabPatientName').attr('data-refno', '');localStorage.setItem('filter_state_refno', '');
								$('#TabPatientName').attr('data-patienthn', '');localStorage.setItem('filter_state_patienthn', '');
								$('#TabPatientName').attr('data-closequeue', '');localStorage.setItem('filter_state_closequeue_vs', '');
							}
							
						});

					});

					// Add Count 
					if (localStorage.getItem('filtercount')) {
						var filtercount = JSON.parse(localStorage.getItem('filtercount'));
					} else {
						var filtercount = new Object;
					}
					var roomuid = $(this).data('tabfilter');
					var localFilterName = 'count_filter_' + roomuid;
					var localCount = parseInt((filtercount[roomuid] > 0 ? filtercount[roomuid] : 0));
					localCount++;
					filtercount[roomuid] = localCount;
					localStorage.setItem('filtercount', JSON.stringify(filtercount));
					//$('#' + localFilterName).text(localCount);
					// Add Count
				} else {
					console.log("LIMIT");
				}
			}else{
				var date = new Date;
				var year = date.getFullYear() + 543;
				var seconds = date.getSeconds();
				var minutes = date.getMinutes();
				var hour = date.getHours();

				var postData = {
					building: buildinguid,
					floor: flooruid,
					room: roomuid,
					year: year,
					hour: hour,
					minutes: (minutes.length > 1 ? '' : '0') + minutes,
					second: (seconds.length > 1 ? '' : '0') + seconds,
				};
				var postURL = base_path_url + 'printRoom_pure/';
				console.log("PRINTPURE", postURL,postData);
				await postAJAX(postURL, postData, async function (data) {
					console.log("AJAXDATA",data);
					var printData = {
						queuewithgroup: '',
						locationid: printer_locate,
						building: data.Building,
						//building: 'ศูนย์วิจัยทางชีววิทยาศาสตร์',
						floor: data.Floor,
						room: data.Room,
						//room: 'แผนกมีบุตรยาก/วางแผนครอบครัว',
						time: data.Time,
						year: data.Year,
						openvisit: data.openvisit
					};
					console.log("PRINTURL");
					var printURL = base_path_url + 'printCurl/';
					console.log("-",printURL,printData);
					await postAJAX(printURL, printData, function (data) {
						if( !(localStorage.getItem('filter_state_api') && localStorage.getItem('filter_state_api') == true) ){
							$('#TabPatientName').text('');
						}
						$('#TabPatientName').attr('data-idcard', '');localStorage.setItem('filter_state_idcard', '');
						$('#TabPatientName').attr('data-patientuid', '');localStorage.setItem('filter_state_patientuid', '');
						$('#TabPatientName').attr('data-refno', '');localStorage.setItem('filter_state_refno', '');
						$('#TabPatientName').attr('data-patienthn', '');localStorage.setItem('filter_state_patienthn', '');						
						$('#TabPatientName').attr('data-closequeue', '');localStorage.setItem('filter_state_closequeue_vs', '');
					});

				});

				// Add Count 
				if (localStorage.getItem('filtercount')) {
					var filtercount = JSON.parse(localStorage.getItem('filtercount'));
				} else {
					var filtercount = new Object;
				}
				var roomuid = $(this).data('tabfilter');
				var localFilterName = 'count_filter_' + roomuid;
				var localCount = parseInt((filtercount[roomuid] > 0 ? filtercount[roomuid] : 0));
				localCount++;
				filtercount[roomuid] = localCount;
				localStorage.setItem('filtercount', JSON.stringify(filtercount));
				//$('#' + localFilterName).text(localCount);
				// Add Count

			}
			$.ajax({
				url: "<?=MIDPREFIX.MIDURL . '/api/manage/refreshClinicCount';?>",
				method: 'GET',
				headers: {
					'Access-Control-Allow-Origin': '*',
					'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
					'Access-Control-Allow-Headers': 'Authorization, Origin, X-Requested-With, Content-Type, Accept',
					'Authorization':'Basic YXJtOjEyMzQ=',
				}, 
				success: function(result){
					console.log('AJAX Result : ' , result);
				},
				error: function(err){
					console.log('AJAX Error : ',err);
				},
			});
			/*
			var selectedFilter = $(this).data('tabfilter');
			var localStorageName = 'count_filter_' + selectedFilter;
			var localCount = parseInt( (localStorage.getItem(localStorageName) > 0 ? localStorage.getItem(localStorageName) : 0) );
			localCount++; 
			localStorage.setItem(localStorageName,localCount);

			$('#'+localStorageName).text(localCount);
			*/
		});

		$(document).on("click", '[data-clear]', function (e) {
			var targetID = $(this).data('clear');
			$(targetID).val('');
		});

		$(document).on("click", '[data-searchref]', function (e) {
			resetFilter();
			resetPostData('#TabPatientName');
			$('#TabPatientName').css('color','#0000FF');
			var targetID = $(this).data('searchref');
			var SearchValue = $(targetID).val().trim();
			if (SearchValue.indexOf('/') > -1) {
				console.log("HN");
				SearchValue = SearchValue.replace('/', '_');
				var functionURL = base_path_url + 'GetFilterQueueInfoHN/';
				var functionURLString = functionURL + SearchValue;
				secSearchValue = SearchValue;
				SearchValue += '/';
			} else {
				var functionURLString = RequestRefNoURL + SearchValue;
			}

			$.getJSON(functionURLString, function (data) {
				if(checkTimeout == true){
					clearTimeout(timeoutResetName);
				}
				console.log('search',data);
				if (data.length > 0  && data[0].selectvs != null && data[0].closequeue_vs == null && data[0].active != 'N') {
					var patientuid = data[0].patientuid;
					var refno = data[0].refno;
					var fullname = data[0].patientname;
					var hn = data[0].hn;
					var idcard = data[0].idcard;

					//สีเขียว
					$('#TabPatientName').css('color','#00FF33');
					$('#TabPatientName').attr('data-idcard', idcard);localStorage.setItem('filter_state_idcard', idcard);
					$('#TabPatientName').attr('data-patientuid', patientuid);localStorage.setItem('filter_state_patientuid', patientuid);
					$('#TabPatientName').attr('data-refno', refno);localStorage.setItem('filter_state_refno', refno);
					$('#TabPatientName').attr('data-patienthn', hn);localStorage.setItem('filter_state_patienthn', hn);
					$('#TabPatientName').text((fullname != null ? '' + fullname + '' + (hn != null ? ' HN ' + hn + '' : '') : ' - ') + ' คัดกรองอาการเรียบร้อยแล้ว');
					var countpatientfilter = parseInt($('#count_filter_patient_value').text());
					countpatientfilter++;
					$('#count_filter_patient_value').text(countpatientfilter);

					console.log(fullname);
					//$('[data-filter]').removeClass('hidden');

					var postPatientno = $('#TabPatientName').attr('data-patientuid');

					postData = {
						'requestFilter': '1',
						'refno': postPatientno,
						'cuser': $('#span_Login').text(),
						//'filter' : allFilter,
					};
					console.log(`Request : ${RequestRefNoFilterURL}`);
					postAJAX(RequestRefNoFilterURL, postData, function () {
						//resetFilter();
						//resetPostData('#TabPatientName');
						//$('#TabPatientName').attr('data-refno', '');localStorage.setItem('filter_state_refno', '');
						//$('#TabPatientName').attr('data-patientuid', '');localStorage.setItem('filter_state_patientuid', '');
						$('#SearchRefNo').val('');

						if(checkTimeout == true){
							timeoutResetName = window.setTimeout(function () {
								$('#TabPatientName').text('');
								$('#TabPatientName').attr('data-idcard', '');localStorage.setItem('filter_state_idcard', '');
								$('#TabPatientName').attr('data-refno', '');localStorage.setItem('filter_state_refno', '');
								$('#TabPatientName').attr('data-patientuid', '');localStorage.setItem('filter_state_patientuid', '');
								$('#TabPatientName').attr('data-patienthn', '');localStorage.setItem('filter_state_patienthn', '');
							}, 5000);
						}
						//$('[data-filter]').addClass('hidden');
					});

				} else if (data.length > 0 && data[0].active == 'N') {
					var refno = data[0].patientuid;
					var fullname = data[0].patientname;
					var hn = data[0].hn;

					//แดง
					$('#TabPatientName').css('color','#FF0033');
					$('#TabPatientName').attr('data-refno', '');localStorage.setItem('filter_state_refno', '');
					$('#TabPatientName').attr('data-idcard', '');localStorage.setItem('filter_state_idcard', '');
					$('#TabPatientName').attr('data-patientuid', '');localStorage.setItem('filter_state_patientuid', '');
					$('#TabPatientName').attr('data-patienthn', '');localStorage.setItem('filter_state_patienthn', '');
					$('#TabPatientName').text(fullname + " ถูกยกเลิกไปแล้ว");
					$('#SearchRefNo').val('');

					if(checkTimeout == true){
						timeoutResetName = window.setTimeout(function () {
							$('#TabPatientName').text('');
							$('#TabPatientName').attr('data-refno', '');localStorage.setItem('filter_state_refno', '');
							$('#TabPatientName').attr('data-idcard', '');localStorage.setItem('filter_state_idcard', '');
							$('#TabPatientName').attr('data-patientuid', '');localStorage.setItem('filter_state_patientuid', '');
							$('#TabPatientName').attr('data-patienthn', '');localStorage.setItem('filter_state_patienthn', '');
						}, 5000);
					}
				} else if (data.length > 0 && data[0].closequeue_vs != null) {
					var patientuid = data[0].patientuid;
					var refno = data[0].refno;
					var fullname = data[0].patientname;
					var hn = data[0].hn;
					var idcard = data[0].idcard;

					$('#TabPatientName').attr('data-idcard', idcard);localStorage.setItem('filter_state_idcard', idcard);
					$('#TabPatientName').attr('data-patientuid', patientuid);localStorage.setItem('filter_state_patientuid', patientuid);
					$('#TabPatientName').attr('data-refno', refno);localStorage.setItem('filter_state_refno', refno);
					$('#TabPatientName').attr('data-patienthn', hn);localStorage.setItem('filter_state_patienthn', hn);
					$('#TabPatientName').text(fullname + " คัดกรองอาการแล้ว");
					$('#SearchRefNo').val('');

					if(checkTimeout == true){
						timeoutResetName = window.setTimeout(function () {
							$('#TabPatientName').text('');
							$('#TabPatientName').attr('data-idcard', '');localStorage.setItem('filter_state_idcard', '');
							$('#TabPatientName').attr('data-refno', '');localStorage.setItem('filter_state_refno', '');
							$('#TabPatientName').attr('data-patientuid', '');localStorage.setItem('filter_state_patientuid', '');
							$('#TabPatientName').attr('data-patienthn', '');localStorage.setItem('filter_state_patienthn', '');
						}, 5000);
					}
				} else {
					if (SearchValue.indexOf('/') > -1) {
						SearchValue = secSearchValue.replace('/', '_');
						var functionURL_CHECK = base_path_url + 'GetQueueInfo_HN/';
						var functionURLString_CHECK = functionURL_CHECK + SearchValue;
						$('#SearchRefNo').val('');

					} else {
						var functionURL_CHECK = base_path_url + 'GetQueueInfo_PUID/';
						var functionURLString_CHECK = functionURL_CHECK + SearchValue;
					}
					$.getJSON(functionURLString_CHECK, function (data) {
						console.log(data);
						if (data.length > 0) {
							var refno = data[0].refno;
							var patientuid = data[0].patientuid;
							var fullname = data[0].patientname;
							var hn = data[0].hn;
							var active = data[0].active;
							if (active == 'N') {
								//แดง
								$('#TabPatientName').css('color','#FF0033');
								$('#TabPatientName').text('คิว ' + (fullname != null ? '' + fullname + '' + (hn != null ? ' HN ' + hn + '' : '') : ' - ') + ' ถูกยกเลิกแล้ว');
								$('#SearchRefNo').val('');
							} else {				
								$('#TabPatientName').css('color','#00FF33');				
								$('#TabPatientName').text((fullname != null && fullname != ''? '' + fullname + '' + (hn != null && hn != '' ? ' HN ' + hn + '' : '') : '') + ' คัดกรองอาการเรียบร้อยแล้ว');
								$('#SearchRefNo').val('');
								//$('#TabPatientName').text((fullname != null ? '' + fullname + '' + (hn != null ? ' HN ' + hn + '' : '') : ' - ') + ' ไม่ต้องผ่านการคัดกรอง');
								//$('#SearchRefNo').val('');
							}

							if(checkTimeout == true){
								timeoutResetName = window.setTimeout(function () {
									$('#TabPatientName').text('');
									$('#TabPatientName').attr('data-idcard', '');localStorage.setItem('filter_state_idcard', '');
									$('#TabPatientName').attr('data-refno', '');localStorage.setItem('filter_state_refno', '');
									$('#TabPatientName').attr('data-patientuid', '');localStorage.setItem('filter_state_patientuid', '');
									$('#TabPatientName').attr('data-patienthn', '');localStorage.setItem('filter_state_patienthn', '');
								}, 5000);
							}
						} else {
							$('#TabPatientName').text("ไม่พบข้อมูล");
							$('#SearchRefNo').val('');

							if(checkTimeout == true){
								timeoutResetName = window.setTimeout(function () {
									$('#TabPatientName').text('');
									$('#TabPatientName').attr('data-idcard', '');localStorage.setItem('filter_state_idcard', '');
									$('#TabPatientName').attr('data-refno', '');localStorage.setItem('filter_state_refno', '');
									$('#TabPatientName').attr('data-patientuid', '');localStorage.setItem('filter_state_patientuid', '');
									$('#TabPatientName').attr('data-patienthn', '');localStorage.setItem('filter_state_patienthn', '');
								}, 5000);
							}
						}
					});
				}

				$('#SearchRefNo').val('');

			});

		});

		midSocket.on('refresh_cliniccount', function(){
			refreshCount(base_path_url+'refreshCountClinic');
		});

		$(document).on("click", '[data-filter]', function (e) {
			var filterAction = $(this).data('filter');
			switch (filterAction.toLowerCase()) {
				case 'insert':
					/*
					var allFilter = "";
					$('[data-tabfilter]').each(function() {
						if($(this).hasClass('active')){
							var selectedFilter = $(this).data('tabfilter');
							var localStorageName = 'filter_' + selectedFilter;
							var localCount = parseInt( (localStorage.getItem(localStorageName) > 0 ? localStorage.getItem(localStorageName) : 0) );
							allFilter += (!allFilter == "" ? "," : '');
							allFilter += selectedFilter;

							localCount++; 
							localStorage.setItem(localStorageName,localCount);

							$('#'+localStorageName).text(localCount);
						}
					});
					*/
					var postPatientno = $('#TabPatientName').attr('data-patientuid');
					var postRefno = $('#TabPatientName').attr('data-refno');
					var postName = $('#TabPatientName').text().replace('"', '');

					postData = {
						'requestFilter': '1',
						'refno': postPatientno,
						'cuser': $('#span_Login').text(),
						//'filter' : allFilter,
					};
					postAJAX(RequestRefNoFilterURL, postData, function () {
						resetFilter();
						resetPostData('#TabPatientName');
						$('[data-filter]').addClass('hidden');
					});
					break;
				case 'clear':
					resetFilter();
					resetPostData('#TabPatientName');
					$('[data-filter]').addClass('hidden');
					break;
			}
		});

	});
</script>