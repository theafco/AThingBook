/*
function openDialog (title,href)
{
	var dlg = dijit.byId("Dialog");
	dlg.onDownloadEnd = function(){
		nodes = dojo.query('.viewListItem .title');
		nodes.connect('onclick', showEditor);
	}
	//if(dlg.get("href") != href){ //prevent reloading dialog
		dlg.set("title",title);
		dlg.set("href",href);
	//}

	dlg.show();
}
*/

/**
 * Open dojo dialog with dojo-options
 * @param json options
 */
function openWidgetDialog(options){
	var dlg = new dojox.widget.Dialog(options);
	//destroy dialog after close
	this._userClosedDialogHandle = dojo.connect(dlg, "hide", this, 
			function(e){
				dlg.destroyRecursive();
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

function stopAsync (node, xhr)
{
	if (node) {
		dojo.removeClass(node, 'asyncStarting');
	}
	if  (xhr) {
		xhr.cancel();
	}
}

function startAsync (args,statusNode,useMultipart)
{
	var xhr;
	//show loader
	if (statusNode) {
		dojo.addClass(statusNode, 'asyncStarting');
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

function ajaxErrorHandler(response){
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
var _quantity = null;
function makeOrder(e){
	var node = e.target
	var href = dojo.attr(node,'ajaxUrl');
	var params = dojo.attr(node,'params');
	var options = {
			title:'สั่งซื้อสินค้า',
			href:href,
			draggable:false,
			//easing:dojo.fx.easing.bounceOut,
			//sizeMethod:'combine',
			//showTitle:false,
			dimensions:[300,300],
			//sizeDuration:600
		};
	dlg = openWidgetDialog(options);
	dojo.connect(dlg,'onDownloadEnd',function(){
		var form = dijit.byId('orderForm');
		//TODO get SEND from FORM
		//var send = dojo.filter(form.getDescendants(), function(d){ return d.attr('name') == 'send'});
		var send = dijit.byId('send');
		//console.debug(send);
		dojo.connect(form, 'onSubmit',function(e){
			var args = {
				form:form.domNode,
				handleAs:'json',
				load:function(response,ioArgs){
					if(response.code == 0){
						_quantity = dijit.byId('quantity').value;
						dlg.destroyRecursive();
					} else {
						send.cancel();
					}
					alert(response.message);
				},
				error:function(response,ioArgs){
					send.cancel();
					ajaxErrorHandler(response);
				},
			};
			startAsync(args);
			stopEvent(e);
		});
	});
	return dlg;
}

function editQuantity(e){
	var node = e.target.parentNode;
	dlg = makeOrder(e);
	dojo.connect(dlg,'onUnload',function(e){
		qtyNode = dojo.query('.value',node)[0];
		qtyNode.innerHTML = _quantity;
	});
	return;
}