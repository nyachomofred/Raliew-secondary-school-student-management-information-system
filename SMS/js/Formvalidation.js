// JavaScript Document

function allnumeric(a){
	var numbers=/^[0-9]+$/;
	if(a.value.match(numbers)){
    return true;}else{
	alert('Please input numeric chars only');
	return false;
	
	}
	
	}
