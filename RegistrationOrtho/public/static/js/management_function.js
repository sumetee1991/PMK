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
        	console.log('AJAX Error : ',err);
        },
    });
}

function addDTRow(DataTable,Data,RowID){
	DataTable.row.add(Data).node().id = RowID;
	DataTable.draw(false);
}

function removeDTRow(DataTable,SelectedRow){
	DataTable.row(SelectedRow).remove().draw();
}

function updateDTCell(DataTable,SelectedRow,SelectedColumn,Data){
	DataTable.cell(SelectedRow,SelectedColumn).data(Data);
}

function checkActive(Selector){
	if( !$(Selector).hasClass('active') ){
		return false;
	}
	else{
		return true;
	}
}

function checkDuplicate(DataTable,Column,Value){
	var CheckStatus = false;
    DataTable.column(Column).nodes().each(function(node,index,dt){
    	ColumnValue = DataTable.cell(node).data();
    	if(ColumnValue.replace(/\s/g,'') == Value.replace(/\s/g,'')){
    		CheckStatus = true;
    	}
    });
	return CheckStatus;
}

function updateWaitingQueue(DataTable,Column){
    DataTable.column(Column).nodes().each(function(node,index,dt){
    	ColumnValue = DataTable.cell(node).data();
    	if(ColumnValue > 0){
	        DataTable.cell(node).data(ColumnValue-1);		    		
    	}
    });
}