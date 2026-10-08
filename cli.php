<?php
// Aplikasi Kalkulator CLI dalam PHP

echo "===================================\n";
echo "    APLIKASI KALKULATOR PHP (CLI)  \n";
echo "===================================\n";

while (true) {
    echo "\nPilih Operasi:\n";
    echo "1. Penjumlahan (+)\n";
    echo "2. Pengurangan (-)\n";
    echo "3. Perkalian (*)\n";
    echo "4. Pembagian (/)\n";
    echo "5. Keluar\n";
    echo "Pilihan (1-5): ";

    $pilihan = trim(fgets(STDIN));

    if ($pilihan === '5') {
        echo "Terima kasih telah menggunakan kalkulator!\n";
        break;
    }

    if (!in_array($pilihan, ['1', '2', '3', '4'])) {
        echo "Pilihan tidak valid, silakan coba lagi.\n";
        continue;
    }

    echo "Masukkan angka pertama: ";
    $n1 = trim(fgets(STDIN));
    echo "Masukkan angka kedua: ";
    $n2 = trim(fgets(STDIN));

    if (!is_numeric($n1) || !is_numeric($n2)) {
        echo "Error: Masukkan harus berupa angka!\n";
        continue;
    }

    $n1 = (float)$n1;
    $n2 = (float)$n2;

    switch ($pilihan) {
        case '1':
            $hasil = $n1 + $n2;
            echo "Hasil: $n1 + $n2 = $hasil\n";
            break;
        case '2':
            $hasil = $n1 - $n2;
            echo "Hasil: $n1 - $n2 = $hasil\n";
            break;
        case '3':
            $hasil = $n1 * $n2;
            echo "Hasil: $n1 * $n2 = $hasil\n";
            break;
        case '4':
            if ($n2 == 0) {
                echo "Error: Tidak dapat membagi dengan 0!\n";
            } else {
                $hasil = $n1 / $n2;
                echo "Hasil: $n1 / $n2 = $hasil\n";
            }
            break;
    }
}
