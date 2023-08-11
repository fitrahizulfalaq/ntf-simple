<?php
//link akses data api
$req = "https://trends.google.co.id/trends/trendingsearches/daily/rss?geo=ID";
//ambil isi konten
$temp = file_get_contents($req);
//menjadikan format xml string
$xml = simplexml_load_string($temp);
//inisalisasi penomoran untuk tiap list
$no = 1;
$kalimat = "";
//melakukan perluangan, ambil data yang berada di dalam tag channel di dalam item
// foreach ($xml->channel->item as $data) {
//     echo $no++ . " || ";
//     echo $data->title . " || ";
//     $label = explode(', ', $data->description);
//     foreach ($label as $l) {
//         echo $l . " / ";
//     }
//     echo $data->children('ht', true)->approx_traffic . " || " . " <br> <br>";
// }

foreach ($xml->channel->item as $data) {
    $label = explode(', ', $data->description);
    $tag = "";
    foreach ($label as $l) {
        $tag = $tag . $l . " , ";
    }

    if ($tag == " , ") { $tag = "Tidak ada query terkait"; } else { $tag = $tag; }

    $kalimat = $kalimat . $data->title . "\n" . $data->pubDate . "\n" . $tag . "\n" . $data->children('ht', true)->approx_traffic . "\n\n";
}

$kalimat = "*TOPIK POPULER UPDATE DARI GOOGLE TRENDS " . date("d-m-Y H:i:sa") . "*\n\n" . $kalimat ."\n\nby IT JTN";

function kirimWA($hp,$kalimat){
    //API dari Whacenter
    $device_id = 'f75a80b9d2b38921c6134f029d3e8c71'; // Token dari Whacenter
    $no_hp = $hp; // No.HP yang dikirim (No.HP Penerima)
    $pesan = $kalimat; // Pesan yang dikirim
    
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://app.whacenter.com/api/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('device_id' => $device_id, 'number' => $no_hp, 'message' => $kalimat),
    ));
    
    $response = curl_exec($curl);
    curl_close($curl);
    echo $response;
    
    $data = json_decode($response);
    return $data;
}

kirimWA("081231390340",$kalimat);
kirimWA("081234381239",$kalimat);
kirimWA("081333673000", $kalimat); // Mas Heri
kirimWA("082233303178", $kalimat); // Mas Firdaus
kirimWA("081230379610", $kalimat); // Pak Yunan
kirimWA("081334754331", $kalimat); // Pak Yayak
kirimWA("085258927995", $kalimat); // Nyla
kirimWA("081222882015", $kalimat); // Pak Nana
kirimWA("085655525338", $kalimat); // Mbak Nia}