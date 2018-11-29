var dropdown = document.querySelector('.dropdown');
dropdown.addEventListener('click', function(){
	var child = dropdown.childNodes;
	var childClass = child[3].classList;
	console.log(childClass);
	if(childClass.contains('open')){
		childClass.remove('open');
	}
	else{
		childClass.add('open');
	}
});

var accordion = document.getElementsByClassName('accordion');
var i;

for(i=0; i < accordion.length; i++){
	accordion[i].onclick = function(){
		this.classList.toggle('active');
		var accordionMenu = this.childNodes[3];
		if(accordionMenu.style.maxHeight){
			accordionMenu.style.maxHeight = null;
		}else{
			accordionMenu.style.maxHeight = accordionMenu.scrollHeight + "px";
		}
	}
}

var idParent = document.getElementById("id_parent");
var menuLevel = document.getElementById("menu-level");
var menuType = document.getElementById("menu-type");
var idBerita = document.getElementById("id_berita");
var idKategori = document.getElementById("id_kategori");
var inputURL = document.getElementById("input-url");

if(idParent != null){
	idParent.onchange = function(){
		if(menuLevel.value == "mainmenu"){
			idParent.childNodes[1].removeAttribute("selected");
			idParent.childNodes[1].setAttribute("selected", true);
		}
	}	
}

if(menuLevel != null){
	menuLevel.onchange = function(){
		if(menuLevel.value == "mainmenu"){
			idParent.childNodes[1].removeAttribute("selected");
			idParent.childNodes[1].setAttribute("selected", true);
		}
	}	
}

if(menuType != null){
	menuType.onchange = function(){
		console.log(menuType.value);
		if(menuType.value == "category"){
			idBerita.childNodes[1].removeAttribute("selected");
			idBerita.childNodes[1].setAttribute("selected", true);
			inputURL.value = "";
			inputURL.disabled = true;
		}else if(menuType.value == "single"){
			idKategori.childNodes[1].removeAttribute("selected");
			idKategori.childNodes[1].setAttribute("selected", true);
			inputURL.value = "";
			inputURL.disabled = true;
		}
		else if(menuType.value == "custom"){
			inputURL.disabled = false;
		}
		else{
			idBerita.childNodes[1].removeAttribute("selected");
			idBerita.childNodes[1].setAttribute("selected", true);
			idKategori.childNodes[1].removeAttribute("selected");
			idKategori.childNodes[1].setAttribute("selected", true);
			inputURL.value = "";
			inputURL.disabled = true;
		}
	}	
}


if(idBerita != null){
	idBerita.onchange = function(){
		if(menuType.value != "single"){
			idBerita.childNodes[1].removeAttribute("selected");
			idBerita.childNodes[1].setAttribute("selected", true);
		}
	}
}

if(idKategori != null){
	idKategori.onchange = function(){
		if(menuType.value != "category"){
			idKategori.childNodes[1].removeAttribute("selected");
			idKategori.childNodes[1].setAttribute("selected", true);
		}
	}
}



function MenuTrigger(){
	var menuTrigger = document.getElementsByClassName("menu-trigger");
	for(var i=0; i < menuTrigger.length; i++){
		menuTrigger[i].onclick = function(e){
			console.log("click");
			var getMenuAnimate = e.target.parentElement.parentElement.nextElementSibling;
			if(getMenuAnimate.style.maxHeight){
				getMenuAnimate.style.maxHeight = null;
			}else{
				var menuAnimate = document.getElementsByClassName("menu-animate").length;
				for(var x = 0; x < menuAnimate.length; x++){
					menuAnimate[x].style.maxHeight = null;
				}
				getMenuAnimate.style.maxHeight = getMenuAnimate.scrollHeight + "px";
			}
		}
	}
}

MenuTrigger();

var canvasBtn = document.querySelector(".trigger-canvas");
canvasBtn.addEventListener('click', function(e){
	e.preventDefault();
	var body = document.querySelector('body');
	var bodyClass = body.classList;
	if(bodyClass.contains('off-canvas')){
    	bodyClass.remove('off-canvas');
    }else{
    	bodyClass.add('off-canvas');
    }
});

function SaveMenu(){

	var saveMenu = document.getElementsByClassName("save-menu");
	console.log(saveMenu);
	for (var i = 0 ; i < saveMenu.length; i++) {
		var menuParent = document.getElementsByClassName("menu-wrapper")[0];
		var menu = document.getElementsByClassName("menu");

		saveMenu[i].onclick = function(e){
			console.log("click");
			var form = e.target.parentElement.parentElement.parentElement;
			var method = form.getAttribute('method');
			var url = form.getAttribute("action");
			var parent = e.target.parentElement.parentElement.parentElement.parentElement;
			

			var data = new FormData(form);

			data.append("lipos",parent.id);
			

			
			if(form[1].value == "up"){
				if(parent.id == 1){
					return false;
				}
				else{
					var previousMenu = parent.previousElementSibling.id;
					var menuTemp = menu[previousMenu-1].innerHTML;
					var menuToMove = menu[parent.id-1].innerHTML;
					menu[previousMenu-1].innerHTML = menuToMove;
					menu[parent.id-1].innerHTML = menuTemp;

					data.append("prevpos", previousMenu);
				}
			}
			else if(form[1].value == "down"){
				if(parent.id == parent.length){
					return false;
				}else{
					var nextMenu = parent.nextElementSibling.id;
                	console.log(nextMenu-1);
                	console.log(menu);
					var menuTemp = menu[parseInt(nextMenu)-1].innerHTML;
                	
					var menuToMove = menu[parent.id-1].innerHTML;

					menu[nextMenu-1].innerHTML = menuToMove;
					menu[parent.id-1].innerHTML = menuTemp;
					console.log(menuToMove,menuTemp);
					data.append("nextpos", nextMenu);
				}

			}
			MenuTrigger();
			sendAjax(method, url, data, menuResponse, false);		
		}
	}
}

SaveMenu();

function getRes(response){
	console.log(response);
	return response;
}

function menuResponse(response){
	console.log(response);
	var moduleMessage = document.getElementById("module-message");
	moduleMessage.innerHTML = response;
	SaveMenu();
}



function sendAjax(method = "post", url = "", data = "", callback=getRes, ctp = true){
	xhttp = new XMLHttpRequest();
	xhttp.open(method, url, true);
	var response;
	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			callback(xhttp.response);
		}
	}
	if (ctp == true){
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	}
	xhttp.send(data);
}

var inputGaleriId = document.getElementById('input-galery');
var addInputGaleri = document.getElementById('add-input-galeri');
if( inputGaleriId != null){
	var inputInner = inputGaleriId.innerHTML;		
}
var btnIframe = document.getElementsByClassName('iframe-btn');
//console.log(btnIframe[0].href, inputInner);
if(addInputGaleri != null){
	addInputGaleri.addEventListener('click', function(e){
		e.preventDefault();
		var html = "";
		var inputWrapper = document.getElementById('input-wrapper');
		var inputGaleri = document.getElementsByClassName('input-galeri');
		var jlhInput = inputGaleri.length;
		inputWrapper.innerHTML += inputInner;
		for(var i = 0 ; i < btnIframe.length; i++){
			btnIframe[i].href = btnIframe[i].href.substr(0, btnIframe[i].href.length-1) + (i+1);
			var x = inputGaleri[i].id;
			x = x.substr(0, x.length-1) + (i+1);
			inputGaleri[i].id = x; 
		}
		console.log(btnIframe);
		fancy();
	});

}

function fancy(){
	$('.iframe-btn').fancybox({	
		'width'		: 900,
		'height'	: 600,
		'type'		: 'iframe',
        'autoScale'    	: false
    });
}

var saveGaleri = document.getElementById('save-galeri');
if(saveGaleri != null){
	saveGaleri.addEventListener('click', function(e){
		e.preventDefault();
		var formGaleri = document.getElementById('form-galeri');
		var action = formGaleri.action;
		data = new FormData(formGaleri);
		sendAjax('POST', action, data, galeriAjaxCallback);
	});
}


function galeriAjaxCallback(response){
	var msgWrapper = document.getElementById('message-wrapper');
	msgWrapper.innerHTML = response
	console.log(response);
}

var imgWrapper = document.getElementsByClassName('open-gallery-detail');

for (var i = 0; i < imgWrapper.length; i++) {
	imgWrapper[i].addEventListener('click', function(e){
		e.preventDefault();
		var imgContent = this.parentElement.parentElement.nextElementSibling;		
		if(imgContent.style.top == '0%' || imgContent.style.top == '12%'){
			imgContent.style.top ='100%';
		}else{
			imgContent.style.top ='12%';
		}
		
		
	});
}

var updateGallery = document.getElementsByClassName('update-gallery');
for(var i = 0; i < updateGallery.length; i++){
	updateGallery[i].addEventListener('click', function(e){
			e.preventDefault();
			var action = this.href;
			var id = this.id;
			var imgContent = this.parentElement.parentElement.nextElementSibling;
			var textArea = imgContent.firstElementChild;
			var data = "update=update&id=" + id +"&keterangan=" + textArea.value;
			console.log(data);
			sendAjax('POST', action, data, galeriAjaxCallback);
	});	
}

var deleteGallery = document.getElementsByClassName('delete-gallery');
for(var i = 0; i < deleteGallery.length; i++){
	deleteGallery[i].addEventListener('click', function(e){
		e.preventDefault();
		var action = this.href;
			var id = this.id;
			var imgWrapper = this.parentElement.parentElement.parentElement.parentElement;

			//var textArea = imgContent.firstElementChild;
			console.log(imgWrapper.remove(this));
			var data = "delete=delete&id=" + id ;
			sendAjax('POST', action, data, galeriAjaxCallback);
	});
}

var addWidgetBtn = document.getElementById('add-widget');
if(addWidgetBtn != null){
	addWidgetBtn.addEventListener('click', function(){
		var addFormWidget = addWidgetBtn.parentElement.parentElement.nextElementSibling.firstElementChild;
		console.log(addFormWidget.style);
		if(addFormWidget.style.maxHeight){
			addFormWidget.style.maxHeight = null;
			addFormWidget.style.marginBottom = null;
		}
		else{
			addFormWidget.style.maxHeight = addFormWidget.scrollHeight + "px";
			addFormWidget.style.marginBottom = "10px";
		}
	});
}

var Change = document.getElementsByClassName('on-change');
if(Change != null){
	for(var i = 0; i < Change.length; i++){
		Change[i].addEventListener('change', function(e){
			var form = this.parentElement.parentElement;
			var action = form.action;
			var method = form.method;
			var data = new FormData(form);
			sendAjax(method, action, data, widgetAjaxRes);
		});
	}
}

var Keyup = document.getElementsByClassName('on-keyup');
if(Keyup != null){
	for(var i = 0; i < Keyup.length; i++){
		var _changeInterval = null;
		Keyup[i].addEventListener('keyup', function(e){
			var form = this.parentElement.parentElement;
			var action = form.action;
			var method = form.method;
			var data = new FormData(form);
			clearInterval(_changeInterval);
			_changeInterval = setInterval(function() {
				clearInterval(_changeInterval);
				sendAjax(method, action, data, widgetAjaxRes);
			}, 2000);
			
		});
	}
}

function widgetAjaxRes(response){
	console.log(response);
	if(response == 'true'){
		toast();
	}
}

function toast() {
    var x = document.getElementById("toast");
    x.className = "show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}

$('.btn-load-page').click( function(e) {
	e.preventDefault();
	console.log($(this).data('item'));

});

$('#submit-form-page').click( function (e) {
	e.preventDefault();
	let form = $('#form-page');
	let method = form.attr('method');
	let url = form.attr('action');
	let data = form.serialize();

	console.log( data );
	
	$.ajax({
		type: method,
		url: url,
		data: data,
		success: function( response ) {
			console.log( response );
			location.reload();
		}
	})
});

$('#submit-form-kategori').click( function (e) {
	e.preventDefault();
	let form = $('#form-kategori');
	let method = form.attr('method');
	let url = form.attr('action');
	let data = form.serialize();

	console.log( data );
	
	$.ajax({
		type: method,
		url: url,
		data: data,
		success: function( response ) {
			console.log( response );
			location.reload();
		}
	})
});

// save menu
$('#simpan-menu').click(function(e){
	e.preventDefault();
	var form = $('#form-menu');
	var url = form.attr('action');
	var method = form.attr('method');
	var data = form.serialize();

	$.ajax({
		type: method,
		url: url,
		data: data,
		success: function( response ) {
			console.log( response );
			location.reload();
		}
	})

});