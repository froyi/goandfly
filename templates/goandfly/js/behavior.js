/* GLOBALE VARIABLEN */
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
var toggle = 0; /* toggleMenue() --> um zu sehen, ob das Menü aufgeklappt wurde, oder geschlossen wurde */
var tagListe = new Array(12);


/* Menü toggle */
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function toggleMenue()
{
	if(toggle == 0)
	{
		/* öffne das Menü */
		$("#navigationBig").fadeIn(500);
		toggle = 1;
	}
	else
	{
		/* schließ das Menü */
		$("#navigationBig").fadeOut(500);
		toggle = 0;
	}
		
}

/* SHOW VERLAUF & LEISTUNGEN */
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function showVerlauf(id)
{
	var laenge = document.getElementById("reiseverlaufDetail").getElementsByClassName("verlauf").length;
	
	for(var i = 0; i < laenge; i ++)
	{
		document.getElementById("reiseverlaufDetail").getElementsByClassName("verlauf").item(i).style.display = "none";
	}
	document.getElementById("verlauf"+id).style.display = "inherit";	
}
function showReiseverlauf()
{
	document.getElementById("reiseverlaufDetail").style.height = "auto";
	document.getElementById("reiseverlaufMehr").style.display = "none";
}
function showLeistungen()
{
	document.getElementById("reiseSidebarLeistungenContainer").style.height = "auto";
	document.getElementById("leistungenMehr").style.display = "none";
}
function showTermine()
{
	document.getElementById("reiseTerminContainer").style.height = "auto";
	document.getElementById("termineMehr").style.display = "none";
}

/* Regionen toggle */
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function toggleRegionen(kontinentenId)
{
	/* Inhalt ausblenden */
	document.getElementById("regionenAusgabe").innerHTML = "";
	
	/* alle wieder weiß machen und nur gewähltes Element in rot darstellen */
	lengthKontinente = document.getElementById("navigationBig").getElementsByClassName("left").item(0).getElementsByTagName("p").length;
	for(var i= 0; i< lengthKontinente; i++)
	{
		document.getElementById("navigationBig").getElementsByClassName("left").item(0).getElementsByTagName("p").item(i).style.color = "white";
	}
	document.getElementById("kontinent_"+kontinentenId).style.color = "#C90019";
	
	/* neuen Inhalt laden */
	resObjekt.open('get','ajax.php/toggleRegionen.ajax.php?kontinentenId='+kontinentenId,true);
	resObjekt.onreadystatechange = tR;
  	resObjekt.send(null);
}
function tR()
{
	if (resObjekt.readyState == 4)
	{
		/* neuen Inhalt in das div schreiben */
		document.getElementById("regionenAusgabe").innerHTML = resObjekt.responseText;
	}
}

/* Regionsbild bei hover in der Navigation zeigen */
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function showNavigationRegion(bild, regionenId)
{
	document.getElementById("navigationBild").src = "img/kategorie/"+bild;
	if(bild == "kanada.png" || bild == "usa.png" || bild == "antarktischehalbinsel.png" || bild == "rossmeer.png" || bild == "suedgeorgien.png" ||  bild == "nordostkanada.png" ||  bild == "groenland.png" ||  bild == "spitzbergen.png" ||  bild == "nordmeer.png" ||  bild == "nordpol.png")
	{
		// Nordamerika
		document.getElementById("navigationBild").style.width = "320px"; 
	}
	else if(bild == "mexiko.png" || bild == "panama.png" || bild == "costarica.png" || bild == "mayas.png" || bild == "karibik.png" )
	{
		// Mittelamerika
		document.getElementById("navigationBild").style.width = "300px"; 
	}
	else if(bild == "kolumbien.png" || bild == "equador.png" || bild == "peru.png" || bild == "chile.png" || bild == "argentinien.png" || bild == "brasilien.png" || bild == "nordafrika.png" || bild == "ostafrika.png" || bild == "suedafrika.png" || bild == "westafrika.png" || bild == "indischerozean.png"    )
	{
		// Südamerika
		document.getElementById("navigationBild").style.width = "229px"; 
	}
	else if(bild == "oman.png" || bild == "israel.png" || bild == "iran.png")
	{
		// Südamerika
		document.getElementById("navigationBild").style.width = "270px"; 
	}
	else if(bild == "zentralasien.png" || bild == "bhutan.png" || bild == "nepal.png" || bild == "china.png" || bild == "srilanka.png" || bild == "japan.png")
	{
		// Südamerika
		document.getElementById("navigationBild").style.width = "340px"; 
	}
	else if(bild == "australien.png" || bild == "neuseeland.png" || bild == "suedsee.png" || bild == "hawaii.png")
	{
		// Australien
		document.getElementById("navigationBild").style.width = "350px"; 
	}
	else
	{
		// alle restlichen Regionen
		document.getElementById("navigationBild").style.width = "530px"; 
	}
	/* neuen Inhalt für die Beschreibung laden */
	resObjekt.open('get','ajax.php/showRegionenInformationen.ajax.php?regionenId='+regionenId,true);
	resObjekt.onreadystatechange = sNR;
  	resObjekt.send(null);	
}
function sNR()
{
	if (resObjekt.readyState == 4)
	{
		/* neuen Inhalt in das div schreiben */
		document.getElementById("kontinentInformation").innerHTML = resObjekt.responseText;
	}
}

/* Kontinent bei hover auf der Weltkarte zeigen    */
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function toggleKontinent(kontinent)
{
	document.getElementById("world_map").src = kontinent;
	
}

/* Tags bei Klick färben und Filter anwenden       */
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
function tags(id, re_id)
{
	// Variablen deklarieren
	var tagId = "tag"+id;
	/*alert(tagListe);*/
	if(tagListe[id-1] == 1)
	{
		// dieser Tag ist schon ausgewählt, es muss aus dem Array gelöscht und der Inhalt neu geladen werden, sowie die Färbung wieder in weiß geändert werden
		document.getElementById(tagId).style.color = "#FFFFFF";
		tagListe[id-1] = '';
		resObjekt.open('get','ajax.php/tagIndex.ajax.php?tagListe='+tagListe+'&re_id='+re_id,true);
		resObjekt.onreadystatechange = ts;
  		resObjekt.send(null);
	}
	else
	{
		// dieser Tag wurde noch nicht gewählt, er wird an das Array gehangen und der Inhalt neu geladen werden, sowie die Färbung auf rot setzen
		document.getElementById(tagId).style.color = "#c90019";
		tagListe[id-1] = 1;
		resObjekt.open('get','ajax.php/tagIndex.ajax.php?tagListe='+tagListe+'&re_id='+re_id,true);
		resObjekt.onreadystatechange = ts;
  		resObjekt.send(null);
	}
	
}

function ts()
{
	if (resObjekt.readyState == 4)
	{
		/* neuen Inhalt in das div schreiben */
		document.getElementById("main").innerHTML = resObjekt.responseText;
	}
}

function tagList(tagL)
{
	if(tagL != 0)
	{
		tagListe = tagL.split(",");	
		for(var i=0; i<= tagListe.length-1; i++)
		{
			tagId = "tag"+(i+1);
			if(tagListe[i] == "1")
			{
				document.getElementById(tagId).style.color = "#c90019";
			}
			else
			{
				document.getElementById(tagId).style.color = "#FFFFFF";
			}
		}
	}
}

/* toggle Admin                                    */
/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

function toggleAdmin(id)
{
	var toggle = document.getElementById(id);

	if(toggle.style.display == "none")
	{
		toggle.style.display = "block";
	}
	else
	{
		toggle.style.display = "none";
	}
}