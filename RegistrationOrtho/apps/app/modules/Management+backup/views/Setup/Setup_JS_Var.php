
<script type="text/javascript">
	//const base_path_url = '<?=LOCALURL;?>Management/';
	const base_path_url = './';

	var localTab = {
		'Counter' : '',  
	}

	const localTabIndex = {
		'tabcounter' : 'Counter', 
	}

	const dataAttr = {
		Setup: "setup",
		TabAction: "tabaction",
		Counter: "tabcounter", 
	};

	const dataAttribute = {
		Name : {
			Setup: dataAttr['Setup'],
			TabAction: dataAttr['TabAction'],
			Counter: dataAttr['Counter'],
		},
		Semi : {
			Setup: "[data-"+ dataAttr['Setup'],
			TabAction: "[data-"+ dataAttr['TabAction'],
			Counter: "[data-"+ dataAttr['Counter'],
		},
		Full : {
			Setup: "[data-"+ dataAttr['Setup'] +"]",
			TabAction: "[data-"+ dataAttr['TabAction'] +"]",
			Counter: "[data-"+ dataAttr['Counter'] +"]",
		}
	};

</script>