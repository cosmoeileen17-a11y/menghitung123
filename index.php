<?php
session_start();

// Inisialisasi riwayat perhitungan
if (!isset($_SESSION['history'])) {$_SESSION['history'] = [];
}

$hasil = '';$error = '';

// Proses kalkulasi jika form dikirimkan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['hitung'])) {
        $angka1 = filter_input(INPUT_POST, 'angka1', FILTER_VALIDATE_FLOAT);$angka2 = filter_input(INPUT_POST, 'angka2', FILTER_VALIDATE_FLOAT);
        $operator =$_POST['operator'] ?? '';

        if ($angka1 === false || $angka2 === false) {$error = 'Harap masukkan angka yang valid!';
        } else {
            switch ($operator) {
                case '+':
                    $hasil = $angka1 +$angka2;
                    break;
                case '-':
                    $hasil = $angka1 -$angka2;
                    break;
                case '*':
                    $hasil = $angka1 * $angka2;
                    break;
                case '/':
                    if ($angka2 == 0) {
                        $error = 'Kesalahan: Tidak dapat membagi dengan angka 0!';                     } else {$hasil = $angka1 / $angka2;
                    }
                    break;
                case '%':
                    $hasil = $angka1 \%$angka2;
                    break;
                case '^':
                    $hasil = pow($angka1,$angka2);
                    break;
                default:
                    $error = 'Operator tidak valid!';
            }

            if ($error === '') {
                // Simpan ke riwayat
                $riwayat_teks = "$angka1$operator $angka2 =$hasil";
                array_unshift($_SESSION['history'],$riwayat_teks);
                // Batasi riwayat maksimal 5 item
                $_SESSION['history'] = array_slice($_SESSION['history'], 0, 5);
            }
        }
    } elseif (isset($_POST['reset_history'])) {$_SESSION['history'] = [];
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Kalkulator PHP</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: #f8fafc;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            margin: 0;
        }
        .container {
            background: #334155;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 420px;
        }
        h2 {
            text-align: center;
            margin-top: 0;
            color: #38bdf8;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
        }
        input, select, button {
            width: 100%;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #475569;
            background: #1e293b;
            color: #fff;
            font-size: 16px;
        }
        input:focus, select:focus {
            outline: none;
            border-color: #38bdf8;
        }
        button {
            background: #0284c7;
            border: none;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 10px;
        }
        button:hover {
            background: #0369a1;
        }
        .btn-reset {
            background: #ef4444;
            font-size: 12px;
            padding: 6px 10px;
            margin-top: 5px;
        }
        .btn-reset:hover {
            background: #dc2626;
        }
        .result-box {
            background: #1e293b;
            padding: 15px;
            border-radius: 6px;
            margin-top: 15px;
            border-left: 4px solid #38bdf8;
        }
        .error-box {
            background: #7f1d1d;
            color: #fca5a5;
            padding: 10px;
            border-radius: 6px;
            margin-top: 15px;
            font-size: 14px;
        }
        .history {
            margin-top: 20px;
            border-top: 1px solid #475569;
            padding-top: 15px;
        }
        .history h4 {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #94a3b8;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .history ul {
            list-style: none;
            padding: 0;
            margin: 0;
            font-size: 13px;
        }
        .history li {
            background: #1e293b;
            padding: 8px;
            border-radius: 4px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>🧮 Kalkulator PHP</h2>
    
    <form method="POST" action="">
        <div class="form-group">
            <label for="angka1">Angka Pertama:</label>
            <input type="number" step="any" name="angka1" id="angka1" required value="<?php echo isset($_POST['angka1']) ? htmlspecialchars($_POST['angka1']) : ''; ?>">
        </div>

        <div class="form-group">
            <label for="operator">Operasi Hitung:</label>
            <select name="operator" id="operator" required>
                <option value="+" <?php echo (isset($_POST['operator']) &&$_POST['operator'] == '+') ? 'selected' : ''; ?>>Penjumlahan (+)</option>
                <option value="-" <?php echo (isset($_POST['operator']) &&$_POST['operator'] == '-') ? 'selected' : ''; ?>>Pengurangan (-)</option>
                <option value="*" <?php echo (isset($_POST['operator']) &&$_POST['operator'] == '*') ? 'selected' : ''; ?>>Perkalian (*)</option>
                <option value="/" <?php echo (isset($_POST['operator']) &&$_POST['operator'] == '/') ? 'selected' : ''; ?>>Pembagian (/)</option>
                <option value="%" <?php echo (isset($_POST['operator']) &&$_POST['operator'] == '%') ? 'selected' : ''; ?>>Modulus / Sisa Bagi (%)</option>
                <option value="^" <?php echo (isset($_POST['operator']) &&$_POST['operator'] == '^') ? 'selected' : ''; ?>>Pangkat (^)</option>
            </select>
        </div>

        <div class="form-group">
            <label for="angka2">Angka Kedua:</label>
            <input type="number" step="any" name="angka2" id="angka2" required value="<?php echo isset($_POST['angka2']) ? htmlspecialchars($_POST['angka2']) : ''; ?>">
        </div>

        <button type="submit" name="hitung">Hitung Sekarang</button>
    </form>

    <?php if ($error !== ''): ?>
        <div class="error-box">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <?php if ($hasil !== '' &&$error === ''): ?>
        <div class="result-box">
            <strong>Hasil:</strong> <span style="font-size: 20px; color: #38bdf8;"><?php echo $hasil; ?></span>
        </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['history'])): ?>
        <div class="history">
            <h4>
                Riwayat Perhitungan
                <form method="POST" action="" style="display:inline;">
                    <button type="submit" name="reset_history" class="btn-reset">Hapus</button>
                </form>
            </h4>
            <ul>
                <?php foreach
