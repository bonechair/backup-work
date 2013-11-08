var IE = /*@cc_on!@*/false;
function clearInput(obj,set,id){
	if((obj.value == "Password" || obj.value == "Password again") && (obj.id == "password-field" || obj.id == "cpassword-field")){
			obj.value = "";
			obj.style.color = "#333";
			obj.style.fontStyle = "normal";
		if(!IE){
			if(obj.getAttribute('type')=='text'){ 
				obj.setAttribute('type','password');
			}
		}
	}
	if(obj.value == set && obj.id == id){
		obj.value = "";
		obj.style.color = "#333";
		obj.style.fontStyle = "normal";
	}
}
function initInput(obj,set){
	if(obj.value == ""){
		obj.value = set;
		obj.style.color = "#999";
		obj.style.fontStyle = "italic";
	}
}
function initInputPassword(obj,set){
	if(obj.value == ""){
		obj.value = set;
		if(!IE){
			obj.setAttribute('type','text');
		}
		obj.style.color = "#999";
		obj.style.fontStyle = "italic";
	}
}