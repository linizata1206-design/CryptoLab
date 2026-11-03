<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StreamCipherController extends Controller
{
    public function proses(Request $request)
    {
        $algo  = $request->input('algo');
        $aksi  = $request->input('aksi');
        $pesan = (string) $request->input('pesan');
        $kunci = (string) $request->input('kunci');

        if ($kunci === '') {
            return response()->json(['error' => 'Kunci tidak boleh kosong.']);
        }

        if ($algo === 'rc4') {
            return $this->rc4($aksi, $pesan, $kunci);
        }
        if ($algo === 'chacha20') {
            return $this->chacha($aksi, $pesan, $kunci);
        }
        return response()->json(['error' => 'Algoritma tidak dikenal.']);
    }

    // RC4 ditulis manual (KSA + PRGA) supaya prosesnya terlihat
    private function rc4Crypt(string $data, string $key): string
    {
        $S = range(0, 255);
        $j = 0;
        $keyLen = strlen($key);
        for ($i = 0; $i < 256; $i++) {
            $j = ($j + $S[$i] + ord($key[$i % $keyLen])) % 256;
            [$S[$i], $S[$j]] = [$S[$j], $S[$i]];
        }
        $i = $j = 0;
        $out = '';
        $len = strlen($data);
        for ($n = 0; $n < $len; $n++) {
            $i = ($i + 1) % 256;
            $j = ($j + $S[$i]) % 256;
            [$S[$i], $S[$j]] = [$S[$j], $S[$i]];
            $k = $S[($S[$i] + $S[$j]) % 256];
            $out .= chr(ord($data[$n]) ^ $k);
        }
        return $out;
    }

    private function rc4(string $aksi, string $pesan, string $kunci)
    {
        if ($aksi === 'enkripsi') {
            return response()->json(['hasil' => base64_encode($this->rc4Crypt($pesan, $kunci))]);
        }
        $data = base64_decode($pesan, true);
        if ($data === false) {
            return response()->json(['error' => 'Ciphertext tidak valid (harus Base64 hasil enkripsi).']);
        }
        return response()->json(['hasil' => $this->rc4Crypt($data, $kunci)]);
    }

    private function chacha(string $aksi, string $pesan, string $kunci)
    {
        // Kunci ChaCha20 harus 32 byte: diturunkan dari kunci input dengan SHA-256
        $key = hash('sha256', $kunci, true);
        $nLen = \SODIUM_CRYPTO_STREAM_XCHACHA20_NONCEBYTES;

        if ($aksi === 'enkripsi') {
            $nonce = random_bytes($nLen);
            $cipher = \sodium_crypto_stream_xchacha20_xor($pesan, $nonce, $key);
            return response()->json(['hasil' => base64_encode($nonce . $cipher)]);
        }

        $data = base64_decode($pesan, true);
        if ($data === false || strlen($data) < $nLen) {
            return response()->json(['error' => 'Ciphertext tidak valid (harus Base64 hasil enkripsi).']);
        }
        $nonce = substr($data, 0, $nLen);
        $plain = \sodium_crypto_stream_xchacha20_xor(substr($data, $nLen), $nonce, $key);
        return response()->json(['hasil' => $plain]);
    }
}