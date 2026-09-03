/*
													- Fun_AJAX.js -
	Contiene le funzioni ajax che riguardano la speaker view 
*/
var t;
var OldFlags='';

function GetFlags() 
{
	if (XMLHttp)
	{
		try
		{

			if (XMLHttp.readyState==XHS_COMPLETE || XMLHttp.readyState==XHS_UNINIT)
			{
				clearTimeout(t);
				XMLHttp.open("GET","../Modules/Boinx/IanseoAwards.php?Tour="+TourCode,true);
				XMLHttp.onreadystatechange=GetFlags_StateChange;
				XMLHttp.send(null);
			}
		}
		catch (e) { }
	}
}

function GetFlags_StateChange()
{
	if (XMLHttp.readyState==XHS_COMPLETE)
	{
		if (XMLHttp.status==200)
		{
			try
			{
				GetFlags_Response();
			}
			catch(e) 
			{ 
				document.getElementById('PopupContent').innerHTML='<div style="width: 100%; height:' + minHeight + 'px; color:#0F0F0F; background-color:#D0D0D0; text-align: center; position: relative;"></div>';
				OldFlags='';
				t = setTimeout("GetFlags()",1000);
			}
		}
	}
}

function GetFlags_Response()
{
	var tbody=document.getElementById('PopupContent');
	var XMLResp=XMLHttp.responseXML;
	if (!XMLResp || !XMLResp.documentElement)
		throw(XMLResp.responseText);
	
	var XMLRoot;
	if ((XMLRoot = XMLResp.documentElement.nodeName)=="parsererror") 
	{
		throw("");
	}

	XMLRoot = XMLResp.documentElement;

	
	var dHeader = XMLRoot.getElementsByTagName('header').item(0).firstChild.data;
	var gName = XMLRoot.getElementsByTagName('gname').item(0).firstChild.data;
	var gFlag = XMLRoot.getElementsByTagName('gflag').item(0).firstChild.data;
	var sName = XMLRoot.getElementsByTagName('sname').item(0).firstChild.data;
	var sFlag = XMLRoot.getElementsByTagName('sflag').item(0).firstChild.data;
	var bName = XMLRoot.getElementsByTagName('bname').item(0).firstChild.data;
	var bFlag = XMLRoot.getElementsByTagName('bflag').item(0).firstChild.data;

	
	if (OldFlags != gFlag+sFlag+bFlag)
	{
		Chunk = '<div style="width: 100%; height:' + minHeight + 'px; color:#0F0F0F; background-color:#D0D0D0; text-align: center; position: relative;">';
		Chunk += '<div style="width: 100%; height:10%; position:absolute; left:0px; top:0px; font-size:50px; font-weight:bold;">' + dHeader + '</div>';
		Chunk += '<div style="width: 33%; position:absolute; left:0%; top:10%; padding-top:10%; vertical-align:top;"><img src="' + sFlag + '" width="90%" border="0"><br>' +  sName + '</div>';
		Chunk += '<div style="width: 34%; position:absolute; left:33%; top:10%; padding-top:0%; vertical-align:top;"><img src="' + gFlag + '" width="90%" border="0"><br>' +  gName + '</div>';
		Chunk += '<div style="width: 33%; position:absolute; left:67%; top:10%; padding-top:20%; vertical-align:top;"><img src="' + bFlag + '" width="90%" border="0"><br>' +  bName + '</div>';
		Chunk += '</div>';
		tbody.innerHTML=Chunk;
		OldFlags = gFlag+sFlag+bFlag;
	}
	t = setTimeout("GetFlags()",1000);
}

