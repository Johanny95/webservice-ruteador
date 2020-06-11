Dim oXMLHTTP
Set oXMLHTTP = CreateObject("MSXML2.XMLHTTP.3.0")

call oXMLHTTP.open("POST","http://localhost/webservice_ruteador/get_rutas_by_day",False) 'Prod
call oXMLHTTP.open("POST","http://localhost/webservice_ruteador/get_visit_by_day",False) 'Prod

call oXMLHTTP.send()