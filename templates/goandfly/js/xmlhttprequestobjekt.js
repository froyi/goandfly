function erzXMLHttpRequestObject(){
  var resObjekt = null;
  try {
      resObjekt = new ActiveXObject("Msxml2.XMLHTTP.4.0");
  }
  catch(Error){
  	try {
    resObjekt = new ActiveXObject("Microsoft.XMLHTTP");
 	}
  	catch(Error){
    	try {
      		resObjekt = new XMLHttpRequest();
      	}
      	catch(Error){
        	alert("Erzeugung des XMLHttpRequest-Objekts ist nicht möglich");
      	}
    }
  }
  return resObjekt;
}
function ErzeugeAJAXObjekt(){
  this.erzXMLHttpRequestObject = erzXMLHttpRequestObject;
}
o = new ErzeugeAJAXObjekt();
resObjekt = o.erzXMLHttpRequestObject();









