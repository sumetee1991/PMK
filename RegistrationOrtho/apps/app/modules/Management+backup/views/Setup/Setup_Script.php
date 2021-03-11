<script type = "text/javascript">
	$(document).ready(function () {
		var RequestData = base_path_url + 'getSetupData_JSON';

		$(document).on("click", '[data-link]', function (e) {
			$('[data-link], .active').removeClass('active');
			$(this).addClass('active');

			var targetlink = $(this).data('link');
			localStorage.setItem('SetupLink', targetlink);
			if (targetlink != 'Filter') {
				if (!($('#filterDiv').hasClass('div_hidden'))) {
					$('#filterDiv').addClass('div_hidden');
				}
				$('#counterDiv').removeClass('div_hidden');
				$('[data-tabcounter]').prop('href', './' + targetlink);
			} else {
				if (!($('#counterDiv').hasClass('div_hidden'))) {
					$('#counterDiv').addClass('div_hidden');
				}
				if (($('#filterDiv').hasClass('div_hidden'))) {
					$('#filterDiv').removeClass('div_hidden');
				}
			}
			setupActiveTab();
		});

		$.getJSON(RequestData, function (data) {
			var ButtonColumn = '';
			data['Counter'].forEach(function (Value, Index) {
				var CounterData = {
					'ID': Value['counterno'],
					'Name': Value['countername'],
				};
				ButtonColumn += '<div class="colBtn">';
				ButtonColumn += '    <a class="button medium block c_lightblue" data-tabcounter="' + CounterData['ID'] + '" data-tabaction="tabcounter" href="">' + CounterData['Name'] + '</a>';
				ButtonColumn += '</div>';
			});
			$('#counterRow').html(ButtonColumn).promise().done(function () {
				if (localStorage.getItem('SetupLink')) {
					var localSetup = localStorage.getItem('SetupLink');
					$('[data-link="' + localSetup + '"]').click();
				} else {
					$('[data-link="Filter"]').click();
				}
			});
		});

		$(document).on("click", dataAttribute['Full']['TabAction'], function (e) {
			var targetActionAttr = $(this).data(dataAttribute['Name']['TabAction']);
			if (targetActionAttr == dataAttribute['Name']['Counter']) {
				$('[data-' + targetActionAttr + ']').removeClass('active');
			}
			$(this).toggleClass('active');

			saveLocalTabVar(targetActionAttr);
			Object.keys(localTab).forEach(function (key) {
				localStorage.setItem(key, localTab[key]);
			});
		});

		$(document).on("click", '[data-sidenav]', function () {
			var target = $(this).data('sidenav');
			$(this).toggleClass('active');
			$(target).hasClass('active') ? $(target).removeClass('active') : $(target).addClass('active');
		});

		$(document).on("click", dataAttribute['Full']['Setup'], function (e) {
			var setupAction = $(this).data(dataAttribute['Name']['Setup']);
			switch (setupAction.toLowerCase()) {
				case 'save':
					Object.keys(localTab).forEach(function (key) {
						localStorage.setItem(key, localTab[key]);
					});
					window.close();
					break;
				case 'clear':
					setupActiveTab();
					break;
			}
		});


	}); 
</script>