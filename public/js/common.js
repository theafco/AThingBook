//Shared Functions
//Open dojo widget dialog
function openWidgetDialog(options,onDownloadEnd) {
	dlg = new dojox.widget.Dialog(options);
	
	//destroy dialog after close
	dojo.connect(dlg, 'onCancel', dlg, 
			function(e){
				this.destroyRecursive();
			});
	
	dojo.connect(dlg,'onDownloadEnd',function(e){
		onDownloadEnd(e);
	});
	dlg.show();

	return dlg;
}
//Open dojo form widget dialog
function openFormWidgetDialog(options,successCallback,errorCallback) {

	onDownloadEnd = function(e){
		dojo.query('form',this.domNode).forEach(function(form){
			dojo.connect(form,'onsubmit',function(e){
				okBtn = dijit.byId('ok');
				var args = {
					form:form,
					handleAs:'json',
					load:function(response,ioArgs){
						if(response.code == 0){
							if (typeof(successCallbak)!='undefined'){
								successCallback();
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
	};
	
	openWidgetDialog(options,onDownloadEnd);
	return dlg;
}

function ajaxErrorHandler(response){
	if (response.dojoType == 'cancel'){ return; };
	alert(response);
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

function stopAsync(xhr,asyncNode) {
	//hide loader
	if (typeof asyncNode !== 'undefined') {
		hideAsyncNotify(asyncNode);
	}
	if (typeof xhr !== 'undefined') {
		xhr.cancel();
	}
}

function showAsyncNotify(node) {
	dojo.addClass(node, 'asyncStarting');
}

function hideAsyncNotify(node) {
	dojo.removeClass(node, 'asyncStarting');
}

function startAsync (args,asyncNode) {
	var xhr;
	//show loader
	if (asyncNode) {
		showAsyncNotify(asyncNode);
	}
	//ajax worker
	if (args) {
		if (typeof args.form !== 'undefined') {
			enctype = dojo.attr(args.form,'enctype');
			if(enctype == 'multipart/form-data'){
				//please use post method, buggy
//				var form = document.createElement('form');
//				dojo.attr(form, 'method', 'post');
				//args.form = form;
				dojo.require('dojo.io.iframe');
				xhr = dojo.io.iframe.send(args);
			} else {
				xhr = dojo.xhrPost(args);
			}
		} else {
			xhr = dojo.xhrPost(args);
		}
	}
	return xhr;
}

function stopEvent(e) {
	e.preventDefault();
	e.stopPropagation();
}

function findParent(node,cls) {
	while(true) {
		if (dojo.hasClass(node,cls)) {
			return node;
		}
		node = node.parentNode;
	}
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

/**** user authentication ****/
function processLogin(e) {
	if (!e){e = window.event;}
	
	form = e.target;
	$responseMsgNode = dojo.query('.responseMessage',form)[0];
	
	dojo.empty($responseMsgNode);
	
	if (login.xhr) {
		stopAsync(login.xhr);
		delete login.xhr;
	}
	
	login.xhr = startAsync({
		form:form,
		handleAs:'json',
		load:function(response){
			if (response.code == 0){
				history.go(0);
			} else {
				$responseMsgNode.innerHTML = response.message;
			}
		},
		error:function(response){
			ajaxErrorHandler(response);
		}
	});
	stopEvent(e);
}