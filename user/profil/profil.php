<?php
  if (!(isset($_SESSION['nama_pengguna'])) || $_SESSION['nama_pengguna'] == '') {
    header('Location: index.php');
    exit;
  }

  // Mengupdate data kolom deleted menjadi 1 dari tabel user_pengembalian_buku.
  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['id_hapus'])) {
      $update_sql = "UPDATE user_pengembalian_buku SET deleted = 1 WHERE id_buku = ?";
      $update_stmt = $conn->prepare($update_sql);
      $update_stmt->bind_param('s', $_POST['id_hapus']);
      $update_stmt->execute();
      $update_stmt->close();

      $redirect = isset($_SESSION['page_redirect']) ? $_SESSION['page_redirect'] : 'index.php';

      echo "<script>window.location.href = '$redirect';</script>";
      unset($_SESSION['page_redirect']);
      exit;
    }
  }


?>

<section class="header-profile">
  <div class="head-profile">
    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev/svgjs" width="1440" height="300" preserveAspectRatio="none" viewBox="0 0 1440 300"><g mask="url(&quot;#SvgjsMask1294&quot;)" fill="none"><path d="M75 60C66.7 61.17 64.77 67.81 64.77 75C64.77 81.13 67.7 85.57 75 86.64C110.32 91.82 114.8 92.26 150 87.5C157.84 86.44 161.07 81.2 161.07 75C161.07 68.92 157.7 64.29 150 62.95C114.67 56.79 109.31 55.15 75 60" stroke="#fff" stroke-width="2"></path><path d="M450 70.59C447.03 70.59 443.48 72.86 443.48 75C443.48 77.09 447 79.05 450 79.05C452.18 79.05 453.85 77.07 453.85 75C453.85 72.84 452.21 70.59 450 70.59" stroke="#fff" stroke-width="2"></path><path d="M675 70.95C671.27 70.95 667.5 71.27 667.5 75C667.5 89.96 671.34 108.33 675 108.33C678.66 108.33 682.14 90.06 682.14 75C682.14 71.37 678.59 70.95 675 70.95" stroke="#fff" stroke-width="2"></path><path d="M900 57.53C888.12 57.53 875.94 66.45 875.94 75C875.94 83.36 888.11 91.35 900 91.35C911.33 91.35 922.37 83.35 922.37 75C922.37 66.44 911.34 57.53 900 57.53" stroke="#fff" stroke-width="2"></path><path d="M1125 65.62C1120.06 68.75 1119.04 69.32 1117.86 75C1110.27 111.51 1104.69 115.76 1107.45 150C1108.26 160.02 1115.85 163.52 1125 163.52C1135.77 163.52 1136.58 157.4 1147.3 150C1174.08 131.52 1177.2 134.22 1200 111.76C1215.27 96.72 1223.44 94.23 1223.44 75C1223.44 49.81 1219.6 24.79 1200 22.92C1170.38 20.1 1161.13 42.71 1125 65.62" stroke="#fff" stroke-width="2"></path><path d="M600 129C570.93 129 541.67 137.06 541.67 150C541.67 163.97 571.03 182.81 600 182.81C627.82 182.81 655.26 164.01 655.26 150C655.26 137.11 627.72 129 600 129" stroke="#fff" stroke-width="2"></path><path d="M1425 139.86C1422.34 139.86 1423.16 145.27 1420.13 150C1395.89 187.84 1369 194.61 1370.45 225C1371.43 245.54 1398.76 251.87 1425 251.87C1445.19 251.87 1462.2 243.56 1463.3 225C1465.22 192.62 1447.78 187.19 1431.05 150C1428.63 144.62 1427.8 139.86 1425 139.86" stroke="#fff" stroke-width="2"></path><path d="M225 183.33C211.48 183.33 193.75 209.42 193.75 225C193.75 234.72 209.7 233.93 225 233.93C235.2 233.93 244.74 233.09 244.74 225C244.74 207.79 236.97 183.33 225 183.33" stroke="#fff" stroke-width="2"></path><path d="M450 212.5C444.3 212.5 440.79 219.21 440.79 225C440.79 229.63 444.73 233.33 450 233.33C458.71 233.33 468.75 229.96 468.75 225C468.75 219.55 458.28 212.5 450 212.5" stroke="#fff" stroke-width="2"></path><path d="M750 168.75C733.36 172.72 742.74 198.27 742.74 225C742.74 229.52 746.32 228.18 750 231.25C787.45 262.55 797.63 295.55 825 293.75C845.07 292.43 844.88 256.78 844.88 225C844.88 212.59 836.9 212.42 825 205.36C789.46 184.29 774.49 162.9 750 168.75" stroke="#fff" stroke-width="2"></path><path d="M1200 193.33C1190.28 193.33 1179.35 209.42 1179.35 225C1179.35 239.5 1190.24 253.5 1200 253.5C1209.26 253.5 1217.38 239.45 1217.38 225C1217.38 209.36 1209.29 193.33 1200 193.33" stroke="#fff" stroke-width="2"></path><path d="M0 45.37C11.14 45.37 19.68 58.63 36.36 75C57.18 95.43 50.11 108.63 75 118.97C106.93 132.24 115.39 112.6 150 122.22C171.18 128.11 186.59 134.52 186.59 150C186.59 168.14 167.47 169.04 150 189.47C135.4 206.54 122.45 206.48 122.45 225C122.45 246.74 128.91 258.98 150 270C180.18 285.77 190.85 267.74 225 278.57C238.13 282.74 244.57 293.6 244.57 300C244.57 304.32 234.78 300 225 300C187.5 300 187.5 300 150 300C131.25 300 129.98 304.88 112.5 300C92.48 294.41 88.65 294.53 75 279.07C55.55 257.03 62.71 250.74 46.3 225C25.21 191.93 20.21 194.18 0 161.44C-2.94 156.68 0 155.72 0 150C0 112.5 0 112.5 0 75C0 60.19 -7.04 45.37 0 45.37" stroke="#fff" stroke-width="2"></path><path d="M75 18.33C64.7 14.91 61.25 5.73 61.25 0C61.25 -3.44 68.13 0 75 0C112.5 0 112.5 0 150 0C162.5 0 175 -5.79 175 0C175 8.94 166.88 26.37 150 29.46C116.88 35.53 109.08 29.64 75 18.33" stroke="#fff" stroke-width="2"></path><path d="M191.8 75C191.8 59.12 206.61 58.13 225 46.48C260.71 23.85 266.66 -0.28 300 6.43C337.5 13.98 332.76 41.39 366.67 75C370.26 78.56 370.77 77.99 375 80.77C412.43 105.35 413.33 104.13 450 129.73C462.92 138.75 474.19 140.24 474.19 150C474.19 159.3 459.86 156.7 450 167.86C426.71 194.2 431.09 198.4 407.89 225C393.59 241.4 393 253.85 375 253.85C350.51 253.85 337.77 247.7 322.92 225C303.81 195.77 316.95 186.66 307.08 150C305.49 144.09 305.59 142.1 300 139.86C264.55 125.69 257.1 136.43 225 117.19C203 104 191.8 94.48 191.8 75" stroke="#fff" stroke-width="2"></path><path d="M450 15.44C443.81 8.11 438.59 4.84 438.59 0C438.59 -2.88 444.29 0 450 0C487.5 0 487.5 0 525 0C543.75 0 549.45 -10.34 562.5 0C586.95 19.38 578.75 32.01 600 59.43C607.82 69.51 620.63 67.07 620.63 75C620.63 83.11 612.36 87.98 600 91.5C564.55 101.61 558.33 107.88 525 102.27C509.29 99.63 513.6 88.52 501.92 75C476.1 45.1 475.48 45.61 450 15.44" stroke="#fff" stroke-width="2"></path><path d="M675 45.61C652.29 26.81 636.21 13.84 636.21 0C636.21 -8.97 655.61 0 675 0C712.5 0 712.5 0 750 0C778.85 0 786.16 -11.23 807.69 0C823.66 8.33 816.41 19.54 825 39.13C832.85 57.04 827.35 61.56 840.57 75C864.85 99.69 869.6 96.29 900 115.38C929.31 133.79 936.75 126.96 960 150C974.25 164.12 963.99 171.98 975 189.71C987.28 209.48 1006.58 210.76 1006.58 225C1006.58 235.38 991.28 233.3 975 238.95C937.99 251.79 933.03 266.27 900 261.99C879.26 259.3 884.42 242.85 867.47 225C846.92 203.37 847.65 202.35 825 183.04C803.67 164.85 798.15 170.3 779.51 150C760.65 129.46 766.3 124.54 750 101.35C739.94 87.04 740.7 85.34 726.79 75C703.2 57.47 697.58 64.31 675 45.61" stroke="#fff" stroke-width="2"></path><path d="M900 31.85C874.52 31.85 845.93 8.55 845.93 0C845.93 -7.37 872.96 0 900 0C917.88 0 935.77 -6.81 935.77 0C935.77 9.12 919.44 31.85 900 31.85" stroke="#fff" stroke-width="2"></path><path d="M955.26 75C955.26 61.97 962.47 52.04 975 52.04C999.12 52.04 1004.9 59.4 1028.57 75C1042.4 84.12 1042.25 86.56 1050 101.47C1061.74 124.06 1067.55 126.13 1067.55 150C1067.55 169.15 1062.53 187.5 1050 187.5C1033.13 187.5 1029.72 168.35 1008.75 150C992.22 135.54 987.39 139.26 975 121.88C960.65 101.76 955.26 96.89 955.26 75" stroke="#fff" stroke-width="2"></path><path d="M1050 55.43C1033.82 55.43 1025 19.64 1025 0C1025 -8.07 1037.5 0 1050 0C1072.77 0 1095.54 -10.76 1095.54 0C1095.54 16.95 1069.09 55.43 1050 55.43" stroke="#fff" stroke-width="2"></path><path d="M1246.88 75C1246.88 52.56 1260.48 32.55 1275 32.55C1289.95 32.55 1287.83 56.22 1305.82 75C1325.33 95.36 1328.16 92.62 1350 110.83C1373.14 130.12 1395.78 128.38 1395.78 150C1395.78 175.94 1374.2 179.26 1350 205.95C1340.2 216.76 1327.78 214.35 1327.78 225C1327.78 238.16 1334.79 244.99 1350 253.57C1383.4 272.41 1388.74 264.14 1425 279.85C1442.31 287.35 1457.14 294.55 1457.14 300C1457.14 304.62 1441.07 300 1425 300C1387.5 300 1387.5 300 1350 300C1330.88 300 1328.52 306.65 1311.76 300C1291.02 291.77 1291.21 287.24 1275 270.24C1255.45 249.74 1240.24 249.12 1240.24 225C1240.24 193.36 1256.77 191.3 1275 158.72C1277.76 153.8 1282.21 154.54 1282.21 150C1282.21 144.82 1277.75 145.12 1275 139.29C1260.08 107.62 1246.88 105.93 1246.88 75" stroke="#fff" stroke-width="2"></path><path d="M1414.5 75C1414.5 62.55 1417.67 48.75 1425 48.75C1433.86 48.75 1446.88 63.53 1446.88 75C1446.88 83.75 1434.65 89.19 1425 89.19C1418.46 89.19 1414.5 82.77 1414.5 75" stroke="#fff" stroke-width="2"></path><path d="M1197.97 150C1197.97 149.23 1198.79 148.53 1200 148.53C1206.06 148.53 1212.5 149.22 1212.5 150C1212.5 150.79 1206.01 151.67 1200 151.67C1198.75 151.67 1197.97 150.8 1197.97 150" stroke="#fff" stroke-width="2"></path><path d="M1461.29 150C1461.29 123.89 1489.15 101.02 1500 101.02C1508.51 101.02 1500 125.51 1500 150C1500 185.3 1509.04 220.59 1500 220.59C1489.69 220.59 1461.29 183.67 1461.29 150" stroke="#fff" stroke-width="2"></path><path d="M652.5 225C652.5 220.89 665.06 215.22 675 215.22C679.94 215.22 682.26 220.51 682.26 225C682.26 228.53 679.33 231.25 675 231.25C664.45 231.25 652.5 228.91 652.5 225" stroke="#fff" stroke-width="2"></path><path d="M1072.92 225C1072.92 210.46 1101.39 194.26 1125 194.26C1141.02 194.26 1152.17 210.14 1152.17 225C1152.17 238.72 1140.59 251.41 1125 251.41C1100.97 251.41 1072.92 239.04 1072.92 225" stroke="#fff" stroke-width="2"></path><path d="M0 297.12C4.25 297.12 10.71 299.27 10.71 300C10.71 300.71 4.22 301.13 0 300C-1.13 299.69 -1.1 297.12 0 297.12" stroke="#fff" stroke-width="2"></path><path d="M417.25 300C417.25 288.91 429.65 275.98 450 263.1C483.52 241.89 493.78 222.93 525 231.82C558.55 241.38 579.55 279.02 579.55 300C579.55 313.11 552.28 300 525 300C487.5 300 487.5 300 450 300C433.63 300 417.25 307.36 417.25 300" stroke="#fff" stroke-width="2"></path><path d="M735.37 300C735.37 294.98 742.1 283.33 750 283.33C759.09 283.33 769.35 295.26 769.35 300C769.35 303.59 759.67 300 750 300C742.68 300 735.37 303.31 735.37 300" stroke="#fff" stroke-width="2"></path><path d="M1191.35 300C1191.35 297.34 1195.11 291 1200 291C1206.69 291 1214.52 297.57 1214.52 300C1214.52 302.07 1207.26 300 1200 300C1195.68 300 1191.35 301.84 1191.35 300" stroke="#fff" stroke-width="2"></path><path d="M0 68.52C2.44 68.52 7.95 70.63 7.95 75C7.95 85.29 2.04 97.83 0 97.83C-1.93 97.83 0 86.41 0 75C0 71.76 -1.54 68.52 0 68.52" stroke="#fff" stroke-width="2"></path><path d="M222.54 75C222.54 73.82 223.42 73.2 225 72.89C262.15 65.7 264.87 59.17 300 60C309.66 60.23 314.58 67.6 314.58 75C314.58 82.2 309.48 88.86 300 89.19C264.69 90.42 261.8 84.87 225 78.13C223.07 77.78 222.54 76.44 222.54 75" stroke="#fff" stroke-width="2"></path><path d="M525 42.5C510.71 42.5 488.57 12.87 488.57 0C488.57 -8.38 506.78 0 525 0C532.59 0 540.18 -5.35 540.18 0C540.18 15.9 536.52 42.5 525 42.5" stroke="#fff" stroke-width="2"></path><path d="M675 20.27C663.27 14.97 657.76 6.15 657.76 0C657.76 -3.98 666.38 0 675 0C712.5 0 712.5 0 750 0C760.82 0 771.63 -6.57 771.63 0C771.63 14.26 768.16 37.86 750 41.67C719.84 48 709.39 35.8 675 20.27" stroke="#fff" stroke-width="2"></path><path d="M900 6.16C895.07 6.16 889.53 1.65 889.53 0C889.53 -1.43 894.76 0 900 0C903.46 0 906.92 -1.32 906.92 0C906.92 1.76 903.76 6.16 900 6.16" stroke="#fff" stroke-width="2"></path><path d="M1270.31 75C1270.31 71.26 1272.58 67.92 1275 67.92C1277.49 67.92 1280.14 71.23 1280.14 75C1280.14 80.12 1277.48 85.71 1275 85.71C1272.56 85.71 1270.31 80.15 1270.31 75" stroke="#fff" stroke-width="2"></path><path d="M342.45 150C342.45 130.4 357.36 116.83 375 116.83C396.33 116.83 420.39 128.87 420.39 150C420.39 182.95 395.16 225 375 225C356.19 225 342.45 184.48 342.45 150" stroke="#fff" stroke-width="2"></path><path d="M810.25 150C810.25 134.73 810.49 117.09 825 115.38C855.37 111.8 863.22 125.78 900 139.42C909.88 143.09 915.12 140.66 918.33 150C929.85 183.45 935.93 194.53 929.46 225C926.77 237.68 913.34 236.3 900 236.3C893.64 236.3 895.36 230.34 890.06 225C857.86 192.55 858.27 191.98 825 160.71C818.37 154.48 810.25 157.4 810.25 150" stroke="#fff" stroke-width="2"></path><path d="M1318.27 150C1318.27 139.51 1334.98 131.67 1350 131.67C1361.56 131.67 1371.43 139.88 1371.43 150C1371.43 162.14 1362 176.19 1350 176.19C1335.42 176.19 1318.27 161.77 1318.27 150" stroke="#fff" stroke-width="2"></path><path d="M1491.53 150C1491.53 144.29 1497.63 139.29 1500 139.29C1501.86 139.29 1500 144.64 1500 150C1500 157.72 1501.98 165.44 1500 165.44C1497.74 165.44 1491.53 157.36 1491.53 150" stroke="#fff" stroke-width="2"></path><path d="M69.44 225C69.44 193.42 71.33 160.71 75 160.71C78.7 160.71 84.18 194.22 84.18 225C84.18 231.6 78.98 235.47 75 235.47C71.61 235.47 69.44 230.8 69.44 225" stroke="#fff" stroke-width="2"></path><path d="M1263.11 225C1263.11 214.18 1267.98 202.33 1275 202.33C1282.95 202.33 1293.06 214.52 1293.06 225C1293.06 233.6 1283.23 240.48 1275 240.48C1268.25 240.48 1263.11 233.25 1263.11 225" stroke="#fff" stroke-width="2"></path><path d="M443.66 300C443.66 297.85 445.52 294.27 450 292.86C486.19 281.48 491.48 271.92 525 274.43C539.21 275.49 545.45 292.13 545.45 300C545.45 304.92 535.22 300 525 300C487.5 300 487.5 300 450 300C446.83 300 443.66 301.42 443.66 300" stroke="#fff" stroke-width="2"></path><path d="M1348.53 300C1348.53 299.45 1348.94 298.21 1350 298.21C1354.37 298.21 1359.38 299.55 1359.38 300C1359.38 300.44 1354.69 300 1350 300C1349.26 300 1348.53 300.35 1348.53 300" stroke="#fff" stroke-width="2"></path></g><defs><mask id="SvgjsMask1294"><rect width="1440" height="300" fill="#ffffff"></rect></mask></defs></svg>

    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev/svgjs" width="1440" height="300" preserveAspectRatio="none" viewBox="0 0 1440 300"><g clip-path="url(&quot;#SvgjsClipPath1111&quot;)" fill="none"><circle r="18.12" cx="635.02" cy="65.42" fill="rgba(255, 255, 255, 0.2)"></circle><circle r="24.86" cx="118.31" cy="65.72" fill="rgba(255, 255, 255, 0.2)"></circle><circle r="12.855" cx="1359.01" cy="73.13" fill="rgba(255, 255, 255, 0.2)"></circle><circle r="15.64" cx="1348.84" cy="174.65" fill="rgba(255, 255, 255, 0.2)"></circle><circle r="15.51" cx="915.68" cy="261.48" fill="rgba(255, 255, 255, 0.2)"></circle><circle r="19.1" cx="1236.53" cy="264.46" fill="rgba(255, 255, 255, 0.2)"></circle><circle r="21.85" cx="16.39" cy="187.28" fill="rgba(255, 255, 255, 0.2)"></circle><circle r="19.97" cx="880.62" cy="78.17" fill="rgba(255, 255, 255, 0.2)"></circle><circle r="16.71" cx="269.85" cy="15.63" fill="rgba(255, 255, 255, 0.2)"></circle><circle r="26.85" cx="750.29" cy="146.7" fill="rgba(255, 255, 255, 0.2)"></circle><circle r="18.345" cx="281.81" cy="270.2" fill="rgba(255, 255, 255, 0.2)"></circle><circle r="18.47" cx="1273.65" cy="227.72" fill="rgba(255, 255, 255, 0.2)"></circle><circle r="13.49" cx="215.92" cy="5.64" fill="rgba(255, 255, 255, 0.2)"></circle><circle r="15.535" cx="526.87" cy="145.96" fill="rgba(255, 255, 255, 0.2)"></circle><circle r="26.075" cx="272.71" cy="159.53" fill="rgba(255, 255, 255, 0.2)"></circle></g><defs><clipPath id="SvgjsClipPath1111"><rect width="1440" height="300" x="0" y="0"></rect></clipPath></defs></svg>
  </div>
  <div class="content-header">
    <div class="logo">
      <span class="img-profile"><img src="assets/img/pp.svg" alt=""></span>
      <div>
        <p><?= $_SESSION['nama_pengguna']; ?></p>
        <p><span><?= $_SESSION['id_pengguna']; ?></span> - Anggota Aktif</p>
      </div>
    </div>
  </div>
</section>

<section class="content-profile">
  <div class="data-profile">
      <div class="bio">
        <h3><i class="fa-solid fa-info"></i> Bio</h3>
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eligendi aperiam nemo sequi perspiciatis delectus recusandae blanditiis soluta fugit reiciendis, voluptates..</p>
      </div>
      <div class="data">
        <div class="box">
          <h3><i class="fa-solid fa-user"></i> Nama</h3>
          <p><?= $_SESSION['nama_pengguna']; ?></p>
        </div>
        <div class="box">
          <h3><i class="fa-solid fa-venus-mars"></i> Gender</h3>
          <p><?= $_SESSION['gender']; ?></p>
        </div>
        <div class="box">
          <h3><i class="fa-solid fa-house-user"></i> Alamat</h3>
          <p><?= $_SESSION['alamat']; ?></p>
        </div>
        <div class="box">
          <h3><i class="fa-solid fa-phone"></i> No Telepon</h3>
          <p><?= $_SESSION['no_telp']; ?></p>
        </div>
      </div>
  </div>

  <div class="history">
    <div class="borrowing">
      <h2><i class="fas fa-list-alt"></i>  Riwayat Peminjaman Buku</h2>
      <div class="card-container">

        <?php
        $sql = "SELECT pm.id_pinjam, pm.id_buku, b.judul_buku, b.pengarang 
                FROM peminjaman_buku pm
                INNER JOIN buku b ON pm.id_buku = b.id_buku
                WHERE pm.id_pengguna = ? AND pm.status = 'Dipinjam'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $_SESSION['id_pengguna']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
        ?>

            <div class="card">
              <a href="?page=detail_pinjaman&id_buku=<?= $row['id_buku']; ?>" class="cover-book"><img src="https://picsum.photos/255/400" alt="cover-book-random"></a>
              <div class="card-content">
                <h3 class="title-book"><?= $row['judul_buku']; ?></h3>
                <p class="pengarang"><span><i class="fa-regular fa-pen-to-square"></i> <?= $row['pengarang']; ?></span></p>
                <div>
                  <a href="?page=detail_pinjaman&id_buku=<?= $row['id_buku']; ?>" class="btn-detail">Lihat Detail</a>
                  <form action="?page=kelola_data_buku" method="post" onsubmit="return confirm('Apakah anda benar benar ingin mengembalikan buku ini?');">
                    <input type="hidden" name="id_pengguna" value="<?= $_SESSION['id_pengguna']; ?>" style="display: none;" readonly>
                    <input type="hidden" name="id_buku" value="<?= $row['id_buku']; ?>" style="display: none;" readonly>
                    <input type="hidden" name="id_kembalikan" value="<?= $row['id_pinjam']; ?>" style="display: none;" readonly>
                    <button type="submit">Kembalikan</button>
                  </form>
                </div>
              </div>  
            </div>

        <?php
          }
        } else {
        ?>
          <span class="empty">Riwayat Peminjaman anda kosong...</span>
        <?php
        }
        $stmt->close();
        ?>
      </div>

    </div>
    
    <div class="return" id="historyReturn">
      <h2><i class="fas fa-undo"></i>  Riwayat Pengembalian Buku</h2>
      <div class="card-container">

        <?php
          $sql = "SELECT u.* , b.judul_buku, b.pengarang
                  FROM user_pengembalian_buku u
                  INNER JOIN buku b ON u.id_buku = b.id_buku WHERE u.id_pengguna = ? AND deleted = 0";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param('s', $_SESSION['id_pengguna']);
          $stmt->execute();
          $result = $stmt->get_result();

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
          ?>

            <div class="card"> 
              <form action="" method="post">
                <input type="hidden" name="id_hapus" value="<?= $row['id_buku']; ?>">
                <button typpe="submit" class="close"><i class="fa-solid fa-xmark"></i></button>
              </form>

              <a href="?page=detail_pengembalian&id_buku=<?= $row['id_buku']; ?>" class="cover-book"><img src="https://picsum.photos/255/400" alt="cover-book-random"></a>
              <div class="card-content">
                <h3 class="title-book"><?= $row['judul_buku']; ?></h3>
                <p class="pengarang"><span><i class="fa-regular fa-pen-to-square"></i> <?= $row['pengarang']; ?></span></p>

                <div>
                  <a href="?page=detail_pengembalian&id_buku=<?= $row['id_buku']; ?>" class="btn-detail">Lihat Detail</a>
                  <p class="info"><i class="fa-regular fa-circle-check"></i> Dikembalikan</p>
                </div>
              </div>
            </div>

          <?php
            }
          } else{
          ?>
            <span class="empty">Riwayat Pengembalian anda kosong...</span>
          <?php
          }
          $stmt->close();
          ?>
      </div>

    </div>
  </div>

</section>
<?php $conn->close(); ?>