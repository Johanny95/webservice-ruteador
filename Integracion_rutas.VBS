Dim oXMLHTTP
Set oXMLHTTP = CreateObject("MSXML2.XMLHTTP.3.0")

call oXMLHTTP.open("POST","http://localhost/webservice_ruteador/integrar_rutas_det",False) 'Prod

call oXMLHTTP.send()