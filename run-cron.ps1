$request = [System.Net.WebRequest]::Create("http://localhost/cron.php?cron_key=8PXSrniLTWuln4dy9nzmGgAuOYTDuvN1sTVkPDiN_gk")
$response = $request.GetResponse()
$response.Close()