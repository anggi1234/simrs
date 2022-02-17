<?php
include('connect.php');
$id_pendaftaran_online = $_GET['id_pendaftaran_online'];
$sqlusername="SELECT 
    a.nomr,
    LOWER(SUBSTRING(a.nama FROM 1 FOR CHAR_LENGTH(a.nama) - 4)) AS nama,
    REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(LOWER(a.alamat), '00', ''),
                                                '1',
                                                ''),
                                            '2',
                                            ''),
                                        '3',
                                        ''),
                                    '4',
                                    ''),
                                '5',
                                ''),
                            '6',
                            ''),
                        '7',
                        ''),
                    '8',
                    ''),
                '9',
                ''),
            '/',
            ''),
        '0',
        '') AS alamat,b.no_antrian
FROM
    simrs2012.m_pasien a
        LEFT JOIN
    simrs.pendaftaran_online b ON a.nomr = b.nomr
WHERE
    b.id_pendaftaran_online= $id_pendaftaran_online";
$queryusername = mysql_query($sqlusername);
$DATA_USERNAME = mysql_fetch_array($queryusername);
 
?>

<!DOCTYPE html>
<html>
<head>
 <title>speak text to speech with Resvonsive Voice</title>
 <script src='https://code.responsivevoice.org/responsivevoice.js'></script>
 <script type="text/javascript">
  function play (){
   responsiveVoice.speak(
    "atas nama <?php echo $DATA_USERNAME['nama']; ?> , dari <?php echo $DATA_USERNAME['alamat']; ?>      silahkan menuju loket pendaftaran online",
    "Indonesian Male",
    {
     pitch: 1, 
     rate: 1, 
     volume: 7
    }
   );
  }

  function stop (){
   responsiveVoice.cancel();
  }

  function pause (){
   responsiveVoice.pause();
  }

  function resume (){
   responsiveVoice.resume();
  }
 </script>
</head>
<body>
<?php echo $DATA_USERNAME['nama']; ?>
 <button onclick="play();">Panggil Antrian</button>
</body>
</html>