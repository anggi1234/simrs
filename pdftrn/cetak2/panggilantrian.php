<?php
include('connect.php');
$idxdaftar = $_GET['idxdaftar'];
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
        '') AS alamat,
    LOWER(c.userlevelname) AS unit, c.call_unit
FROM
    simrs2012.m_pasien a
        LEFT JOIN
    simrs.bill_detail_tarif b ON a.nomr = b.nomr
        LEFT JOIN
    simrs.userlevels c ON b.userlevelid = c.userlevelid
WHERE
    b.idxdaftar= $idxdaftar";
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
    "Atas nama <?php echo $DATA_USERNAME['nama']; ?> , dari <?php echo $DATA_USERNAME['alamat']; ?> , silahkan menuju ke <?php echo $DATA_USERNAME['call_unit']; ?>",
    "Indonesian Male",
    {
     pitch: 1, 
     rate: 1, 
     volume: 1
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