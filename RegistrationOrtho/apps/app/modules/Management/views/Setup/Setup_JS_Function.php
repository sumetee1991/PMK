
<script type="text/javascript">

	function initSetup(){
		/*
		if(!localStorage.getItem('Counter')){
			console.log("NO Counter");
			localStorage.setItem('Counter','1');
		}
		*/
	}

	function setupLocalTabVar(){
		Object.keys(localTab).forEach(function (key){
			localTab[key] = localStorage.getItem(key);
		});
	}

	function saveLocalTabVar(targetAttr){
		var SelectorText = "";
		SelectorTarget = document.querySelectorAll('[data-'+targetAttr+']');
			SelectorTarget.forEach(function(Value,Index){
				if( SelectorTarget[Index].classList.contains('active') ){
					SelectorText += (!SelectorText == "" ? "," : '');
					SelectorText += $(SelectorTarget[Index]).data(targetAttr);
				}
			});
		localTab[localTabIndex[targetAttr]] = SelectorText;
	}

	function setupActiveTab(){
		$(dataAttribute['Full']['Counter']+".active").removeClass("active"); 
		Object.keys(localTab).forEach(function (key){
			if( !(localStorage.getItem(key) === null) ){
				var localSplit = localStorage.getItem(key).split(",");
				localSplit.forEach(function(Value,Index){
					$(dataAttribute['Semi'][key]+'="'+Value+'"]').addClass('active');
				});
			}
		});
	}

</script>