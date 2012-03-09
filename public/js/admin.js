//show item view dialog
function viewResultTableItem(e) {
	selectNode = e.target;
	itemNode = findParent(selectNode,'item');
	viewResultTableItem.selectedItem = itemNode;
	params = getParams(itemNode);
	
	viewResultTableItem.dialog = openWidgetDialog({
			href:params.url,
			modal:true,
			dimensions:[500,470],
		},function(e){
			dojo.query('#viewList .editable').connect('onclick',viewListEditor);
			dojo.query('#viewList .closeIcon').connect('onclick',deleteResultTableItem);
		});
}
//delete item
function deleteResultTableItem(e) {
	if (!confirm('ยืนยันการลบรายการที่เลือก')) {
		stopEvent(e);
		return;
	}
	selectNode = e.target;
	cellNode = selectNode.parentNode;
	itemNode = cellNode.parentNode;
	params = getParams(selectNode);
	
	startAsync({
		url:params.url,
		handleAs:'json',
		load:function(response){
			if (response.code == 0) {
				dojo.destroy(itemNode);
			}
			alert(response.message);
		},
		error:function(response){
			hideAsyncNotify(cellNode);
			alert(response);
		}
	},cellNode);
	
	stopEvent(e);
}
//open field editor
function viewListEditor(e)
{
	selectNode = findParent(e.target,'value-element');
	titleNode = findParent(selectNode,'title');
	itemNode = findParent(titleNode,'item');
	params = getParams(titleNode);

	//singleton editor panel
	clearPanel = function(node){
		closeEditor(node);
		delete viewListEditor.xhr
		delete viewListEditor.itemNode;
	}
	if (typeof viewListEditor.itemNode !== 'undefined') {
		stopAsync(viewListEditor.xhr,viewListEditor.itemNode);
		clearPanel(viewListEditor.itemNode);
	}
	//open editor
	if (params.options.wyciwyg === true) {
		openWYCISWYGEditor(params);
	} else {
	var args = {
		url: params.url,
		content:params.content,
		load: function(response, ioArgs) {
			dojo.addClass(itemNode,'openPanel');
			dojo.query('.editor', itemNode).forEach(function(node){
				node.innerHTML = response;
				dojo.parser.parse(node);
				editorForm = getEditorForm();
				
				//on save button clicked
				dojo.connect(editorForm,'onsubmit',function(e){
					viewListEditor.xhr = startAsync({
						form:editorForm,
						handleAs:'json',
						load:function(response) {
							if (response.code == 0) {
								clearPanel(itemNode);
								dojo.require("dojo.NodeList-html");
								dojo.query('.value',titleNode).html(response.message);
								dojo.query('[field="' + dojo.attr(itemNode,'field') + '"]',viewResultTableItem.selectedItem).html(response.message);
							} else {
								enableSaveButton();
								alert(response.message);
							}
						},
						error:function(response) {
							if (response.dojoType == 'cancel'){ return; }
							enableSaveButton();
							alert(response);
						}
					});
					stopEvent(e);
				});
				
				//on cancel button clicked
				dojo.connect(dijit.byId('cancel'),'onClick',function(e){
					stopAsync(viewListEditor.xhr,selectNode);
					clearPanel(itemNode);
				});
			});
		},
		error: function(response, ioArgs){
			if (response.dojoType == 'cancel'){ return; }
			clearPanel(itemNode);
			alert(response);
	    }
	};
	viewListEditor.itemNode = itemNode;
	viewListEditor.xhr = startAsync(args,selectNode);
	
	}//if
	stopEvent(e);
}
//close editor panel
function closeEditor(itemNode) {
	dojo.removeClass(itemNode, 'asyncStarting');
	editorForm = getEditorForm();
	if (editorForm) {
		dijit.byNode(editorForm).destroyRecursive();	
	}
	dojo.removeClass(itemNode,'openPanel');
}
//enable save button
function enableSaveButton() {
	saveBtn = dijit.byId('save');
	saveBtn.cancel();
}
//Return json parameters
function getParams(node){
	if (node) {
		return dojo.fromJson(dojo.attr(node,'params'));
	}
}
//Return dijit editor form
function getEditorForm() {
	return dojo.byId('editorForm');
}

var WYCISWYGEditor = null;
var xhrWYCISWYGEditor = null;
var dlgWYCISWYGEditor = null;
function openWYCISWYGEditor(params) {
	dlgWYCISWYGEditor = openWidgetDialog({
			href:params.url,
			modal:true,
			sizeToViewport:true,
		},function(e) {
			editorForm = getEditorForm();
			dojo.query('textarea',editorForm.domNode).forEach(function(node){
				id = dojo.attr(node,'id');
				WYCISWYGEditor = CKEDITOR.replace(id);
			});
			//on save button clicked
			dojo.connect(editorForm,'onsubmit',function(e){
				xhrWYCISWYGEditor = startAsync({
					form:editorForm,
					handleAs:'json',
					load:function(response) {
						enableSaveButton();
						alert(response.message);
					},
					error:function(response) {
						if (response.dojoType == 'cancel'){ return; }
						enableSaveButton();
						alert(response);
					}
				});
				stopEvent(e);
			});
			//on cancel button clicked
			dojo.connect(dijit.byId('cancel'),'onClick',function(e){
				closeWYCISWYGEditor();
			});
	});

	dojo.connect(dlg,'onCancel',function(e){
		destroyWYCISWYGEditor();
	});
}
//Safety close editor
function closeWYCISWYGEditor() {
	if (xhrWYCISWYGEditor) {
		stopAsync(xhrWYCISWYGEditor);
		xhrWYCISWYGEditor = null;
	}
	destroyWYCISWYGEditor();
	dlgWYCISWYGEditor.destroyRecursive();
}
//Remove CKEDITOR from textarea
function destroyWYCISWYGEditor() {
	if (WYCISWYGEditor) { 
		WYCISWYGEditor.destroy(true); 
		WYCISWYGEditor = null;
	}
}