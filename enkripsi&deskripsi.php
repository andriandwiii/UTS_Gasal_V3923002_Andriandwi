<?php  
function cipher($char, $key){
    if (ctype_alpha($char)) {
        $base = ord(ctype_upper($char) ? 'A' : 'a');
        $new_char = ord($char);
        $shifted = fmod($new_char + $key - $base, 26);
        return chr($shifted + $base);
    }
    return $char;
} 

function enkripsi_caesar($input, $key){
    $output = "";
    foreach(str_split($input) as $char){
        $output .= cipher($char, $key);
    }
    return $output;
}

function dekripsi_caesar($input, $key){
    return enkripsi_caesar($input, 26 - $key);
}

function vigenere_encrypt($plaintext, $key) {
    $ciphertext = "";
    $key = strtoupper($key);
    $key_len = strlen($key);
    $key_index = 0;

    foreach (str_split($plaintext) as $char) {
        if (ctype_alpha($char)) {
            $shift = ord($key[$key_index % $key_len]) - ord('A');
            if (ctype_lower($char)) {
                $ciphertext .= chr(((ord($char) - ord('a') + $shift) % 26) + ord('a'));
            } else {
                $ciphertext .= chr(((ord($char) - ord('A') + $shift) % 26) + ord('A'));
            }
            $key_index++;
        } else {
            $ciphertext .= $char;
        }
    }
    return $ciphertext;
}

function vigenere_decrypt($ciphertext, $key) {
    $plaintext = "";
    $key = strtoupper($key);
    $key_len = strlen($key);
    $key_index = 0;

    foreach (str_split($ciphertext) as $char) {
        if (ctype_alpha($char)) {
            $shift = ord($key[$key_index % $key_len]) - ord('A');
            if (ctype_lower($char)) {
                $plaintext .= chr(((ord($char) - ord('a') - $shift + 26) % 26) + ord('a'));
            } else {
                $plaintext .= chr(((ord($char) - ord('A') - $shift + 26) % 26) + ord('A'));
            }
            $key_index++;
        } else {
            $plaintext .= $char;
        }
    }
    return $plaintext;
}

function enkripsi_combination($input, $caesar_key, $vigenere_key) {
    $caesar_encrypted = enkripsi_caesar($input, $caesar_key);
    return vigenere_encrypt($caesar_encrypted, $vigenere_key);
}

function dekripsi_combination($input, $caesar_key, $vigenere_key) {
    $vigenere_decrypted = vigenere_decrypt($input, $vigenere_key);
    return dekripsi_caesar($vigenere_decrypted, $caesar_key);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UTS SKD</title>
    <style>
        body {
            background: linear-gradient(135deg, #1a1a1a, #2d2d2d);
            font-family: 'Roboto', sans-serif;
            color: #e0e0e0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            background: rgba(40, 40, 40, 0.95);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            max-width: 450px;
            width: 90%;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        h1 {
            font-size: 1.8em;
            margin-bottom: 30px;
            color: #gold;
            text-transform: uppercase;
            letter-spacing: 2px;
            background: linear-gradient(45deg, #e6b800, #ffdb4d);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-align: center;
        }
        input, textarea {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            color: #fff;
            font-size: 1em;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }
        input:focus, textarea:focus {
            outline: none;
            border-color: #e6b800;
            box-shadow: 0 0 10px rgba(230, 184, 0, 0.3);
        }
        textarea {
            height: 120px;
            resize: none;
        }
        .btn {
            background: linear-gradient(45deg, #e6b800, #ffdb4d);
            border: none;
            padding: 15px 25px;
            color: #1a1a1a;
            cursor: pointer;
            border-radius: 10px;
            font-size: 1em;
            font-weight: bold;
            transition: all 0.3s ease;
            margin: 0 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(230, 184, 0, 0.4);
        }
        .footer {
            margin-top: 30px;
            font-size: 0.9em;
            color: #888;
            text-align: center;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 20px;
        }
        ::placeholder {
            color: #888;
        }
        @keyframes gradient {
            0% {background-position: 0% 50%;}
            50% {background-position: 100% 50%;}
            100% {background-position: 0% 50%;}
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>UJIAN TENGAH SEMESTER</h1>
        <form method="post">
            <input type="text" name="plain" placeholder="Masukkan kalimat" required />
            <input type="number" name="caesar_key" placeholder="Masukkan kunci Caesar (0-25)" min="0" max="25" required />
            <input type="text" name="vigenere_key" placeholder="Masukkan kunci Vigenère" required />
            <button type="submit" name="enkripsi" class="btn">Enkripsi</button>
            <button type="submit" name="dekripsi" class="btn">Dekripsi</button>
            <textarea readonly placeholder="Hasil">
<?php  
    if (isset($_POST["enkripsi"])) { 
        echo enkripsi_combination($_POST["plain"], $_POST["caesar_key"], $_POST["vigenere_key"]);
    } else if (isset($_POST["dekripsi"])) {
        echo dekripsi_combination($_POST["plain"], $_POST["caesar_key"], $_POST["vigenere_key"]);
    }
?>
            </textarea>
        </form>
        <div class="footer">
            <span>andriandwii</span>
        </div>
    </div>
</body>
</html>