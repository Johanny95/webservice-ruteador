Dim oXMLHTTP
Set oXMLHTTP = CreateObject("MSXML2.XMLHTTP.3.0")

call oXMLHTTP.open("POST","http://localhost/webservice_ruteador/eliminar_visitas",False) 'Prod

call oXMLHTTP.send()