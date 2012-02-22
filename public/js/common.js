//Shared Functions

//Open dojo form widget dialog
function openFormWidgetDialog(options,successCallbak,errorCallback) {
	var dlg = new dojox.widget.Dialog(options);
	
	//destroy dialog after close
	this._userClosedDialogHandle = dojo.connect(dlg, "hide", this, 
			function(e){
				dlg.destroyRecursive();
			});
	
	dojo.connect(dlg,'onDownloadEnd',function(e){
		dojo.query('form',this.domNode).forEach(function(form){
			dojo.connect(form,'onsubmit',function(e){
				okBtn = dijit.byId('ok');
				var args = {
					form:form,
					handleAs:'json',
					load:function(response,ioArgs){
						if(response.code == 0){
							if (typeof(successCallbak)!='undefined'){
								successCallbak();
							}
							dlg.destroyRecursive();
						}
						alert(response.message);
					},
					error:function(response,ioArgs){
						if (typeof(errorCallback)!='undefined'){
							errorCallback();
						}
						okBtn.cancel();
						ajaxErrorHandler(response);
					},
				};
				startAsync(args);
				stopEvent(e);
			});
		});
	});
	
	dlg.show();
	return dlg;
}

function openDialog(options){
	var dlg = new dijit.Dialog(options);
	//destroy dialog after close
	this._userClosedDialogHandle = dojo.connect(dlg, "hide", this, 
			function(e){
				dlg.destroyRecursive();
			});
	//exit when user press ESC
	this._userClosedEscDialogHandle = dojo.connect(dlg.containerNode, 'onkeypress', function (e) {
		 key = e.keyCode;
		 if(key == dojo.keys.ESCAPE) {
		  this._handleCloseDialog();
		 }
		});
	dlg.show();
}

function stopAsync (node, xhr) {
	if (node) {
		dojo.removeClass(node, 'asyncStarting');
	}
	if  (xhr) {
		xhr.cancel();
	}
}

function startAsync (args,asyncNode,useMultipart) {
	var xhr;
	//show loader
	if (asyncNode) {
		dojo.addClass(asyncNode, 'asyncStarting');
	}
	//ajax worker
	if (args) {
		if(useMultipart){
			//please use post method, buggy
			var form = document.createElement('form');
			dojo.attr(form, 'method', 'post');
			//args.form = form;
			xhr = dojo.io.iframe.send(args);
		} else {
			xhr = dojo.xhrPost(args);
		}
	}
	return xhr;
}


function ajaxErrorHandler(response) {
	if (response.dojoType == 'cancel'){ return; }
	console.log('error:' + response);
	alert('ไม่สามารถส่งข้อมูลได้');
	return response;
}

function showEditor (e)
{
	var itemNode = dojo.query(e.target).parents('.viewListItem')[0];
	var id = dojo.attr(itemNode,'itemId');
	var href  =  dojo.attr(itemNode,'ajaxurl');

	if (itemNode){
		var titleNode = dojo.query('.title', itemNode)[0];

		//cancel current request
		stopAsync(dojo.query('.title', showEditor.node)[0] ,showEditor.xhr);

		//hide current editor panel
		if (showEditor.node) {
			hideEditor(showEditor.node);
			delete showEditor.node;
		}

		var args = {
			url: href,
			content: {
				'item' : id
			},
			handleAs: 'text',
			load: function(response, ioArgs) {
				stopAsync (dojo.query('.title', itemNode)[0])
				delete showEditor.xhr
				var editorNode = dojo.query('.editor', itemNode)[0];
				editorNode.innerHTML = response;
				dojo.parser.parse(editorNode);
				//connect events
				dojo.connect(dijit.byId('editor_form'), 'onSubmit',editHandler);
				dojo.connect(dijit.byId('cancel'), 'onClick', cancelHandler);
				//show editor
				dojo.addClass(itemNode, 'openPanel');
				//save previous editor id
				showEditor.node = itemNode;
				return response;
			},
			error: function(response, ioArgs){
				if (response.dojoType == 'cancel'){ return; }
				alert("An error occurred, with response: " + response);
				return response;
		    }
		};

		showEditor.xhr = startAsync(args,titleNode);
	}
	stopEvent(e);
}

function editHandler (e)
{
	var form = e.target;
	var node = dojo.query('.openPanel')[0];

	var args = {
		form: form,
		load: function(response, ioArgs) {
			var data = dojo.fromJson(response);
			if  (data.code == 0) {
				labelNode = dojo.query('div .value', node)[0];
				labelNode.innerHTML = data.message;
			}
			hideEditor (node);
			return response;
		},
		error: function(response, ioArgs){
			ajaxErrorHandler(response,ioArgs);
			return response;
		}
	};
	startAsync (args);
	stopEvent(e);
}

function cancelHandler (e)
{
	var node = dojo.query(e.target).parents('.viewListItem')[0];
	hideEditor(node);
}

function hideEditor (node)
{
	if (node) {
		//destroy dojo widgets
		var widgets = dijit.findWidgets(node);
		dojo.forEach(widgets, function(w) {
			w.destroyRecursive();
		});
		//show pre-edit
		dojo.removeClass(node ,'openPanel');
	}
}

function deleteListItem (e)
{
	if (confirm('ยืนยันการลบรายการที่เลือก')) {

		var url = dojo.attr(e.target,'ajaxurl');
		var itemId = dojo.attr(e.target, 'itemId');

		var args = {
			url: url,
			form: form,
			content: {
				item: itemId
			},
			load: function(response, ioArgs) {
				var data = dojo.fromJson(response);
					if (data.code == 0) {	
						dojo.query(e.target).parents('.resultTableListItem').forEach(
							function(node) {
								dojo.addClass(node, 'deletedListItem');
							}
						);
					} else {
						alert(data.message);
					}
			},
			error: function(response,ioArgs) {
				ajaxErrorHandler(response);
			}
		};
		startAsync(args);
	}
	stopEvent(e);
}

function stopEvent(e) {
	e.preventDefault();
	e.stopPropagation();
}

//Cart Functions
function makeOrder(e){
	var node = e.target
	var params = dojo.fromJson(dojo.attr(node,'params'));
	var options = {
			title:'สั่งซื้อสินค้า',
			href:params.url,
			//draggable:false,
			//easing:dojo.fx.easing.bounceOut,
			//sizeMethod:'combine',
			//showTitle:false,
			dimensions:[300,300],
			//sizeDuration:600
		};
	dlg = openFormWidgetDialog(options);
	return dlg;
}

function editQuantity(e){
	var selectNode = e.target
	var cellNode = selectNode.parentNode;
	var params = dojo.fromJson(dojo.attr(selectNode,'params'));

	var options = {
			title:'แก้ไขจำนวนสินค้า',
			href:params.url,
			dimensions:[300,200],
		};
	dlg = openFormWidgetDialog(options,function(e){
		dojo.query('[field=unitQuantity]',cellNode).forEach(function(node){
			node.innerHTML = dijit.byId('quantity').value;
		});
		refreshOrderTable();
	});
}

function refreshOrderTable() {
	var tableNode = dojo.byId('viewCart');
	dojo.require("dojo.currency");
	
	var totalPrice = 0;
	var itemNodes = dojo.query('.item',tableNode);
	itemNodes.forEach(function(node){
		dojo.query('[field=unitPrice],[field=unitQuantity],[field=unitTotalPrice]',node).forEach(function(node){
			
			fieldName = dojo.attr(node,'field');
			
			if (fieldName == 'unitQuantity') {
				qty = parseInt(node.innerHTML);
			} else if (fieldName == 'unitPrice') {
				unitPrice = parseInt(node.innerHTML);
			} else if (fieldName == 'unitTotalPrice') {
				//update unit total price
				var unitTotalPrice = unitPrice * qty;
				node.innerHTML = dojo.currency.format(unitTotalPrice);
				totalPrice += unitTotalPrice;
			}
		});	
		
	});
	
	if (itemNodes.length != 0) {
		dojo.require("dojo.NodeList-html");
		dojo.query('[field=totalPrice]',tableNode).html(dojo.currency.format(totalPrice));	
	} else {
		dojo.empty(mainContentContainer);
		mainContentContainer.innerHTML = '<h3>ไม่พบสินค้าในตะกร้า</h3>';
	}
}

function deleteOrderItem(e) {
	
	if (!confirm('ยืนยันการลบรายการที่เลือก')) {
		stopEvent(e);
		return;
	}
	
	var selectNode = e.target;
	var cellNode = selectNode.parentNode;
	var rowNode = cellNode.parentNode;
	var params = dojo.fromJson(dojo.attr(selectNode,'params'));
	
	startAsync({
		url:params.url,
		content:{item:params.item},
		handleAs:'json',
		load:function(response){
			if (response.code == 0) {
				dojo.destroy(rowNode);
				refreshOrderTable();
			} else {
				alert(response.message);
			}
		},
		error:function(response){
			alert(response);
		}
	},cellNode);
}

/** admin **/
//User
function viewUserItem(e) {
	selectNode = e.target;
	rowNode = selectNode.parentNode;
	
	params = dojo.fromJson(dojo.attr(rowNode,'params'));

	var args = {
			title:'ข้อมูลผู้ใช้',
			href:params.url,
			modal:true,
			dimensions:[500,450],
	};
	openFormWidgetDialog(args);
}

function deleteUserItem(e) {
	if (!confirm('ยืนยันการลบรายการที่เลือก')) {
		stopEvent(e);
		return;
	}
	selectNode = e.target;
	cellNode = selectNode.parentNode;
	rowNode = cellNode.parentNode;
	params = dojo.fromJson(dojo.attr(selectNode,'params'));

	startAsync({
		url:params.url,
		content:{item:params.item},
		handleAs:'json',
		load:function(response){
			if (response.code == 0) {
				dojo.destroy(rowNode);
			}
			alert(response.message);
		},
		error:function(response){
			alert(response);
		}
	},cellNode);
	
	stopEvent(e);
}