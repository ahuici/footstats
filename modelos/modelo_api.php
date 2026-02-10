$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://v3.football.api-sports.io/leagues',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'x-apisports-key: XxXxXxXxXxXxXxXxXxXxXxXx',
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

IDosasuna:727
IDbarca:529
IDmadrid:541
IDrealsociedad:548

