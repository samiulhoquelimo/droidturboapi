<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CryptoController extends BaseController
{
    private string $cipher = "aes-128-cbc";

    function encrypt_iv(): string
    {
        return '971bf36e8ecn83bf';
    }

    function encrypt_key(): string
    {
        return 'c375b81e458b90ff';
    }

    public function encrypt(Request $request): JsonResponse
    {
        $data = json_decode(request()->getContent(), true);

        $key = $this->encrypt_key();
        $iv = $this->encrypt_iv();
        $result = openssl_encrypt($data, $this->cipher, $key, 0, $iv) . '::' . $iv;

        return response()->json(['data' => base64_encode($result)]);
    }

    public function decrypt(Request $request): JsonResponse
    {
        $data = $request->data;

        $key = $this->encrypt_key();
        $iv = $this->encrypt_iv();

        $decode = explode('::', base64_decode($data));
        if (count($decode) != 2 || $decode[1] != $iv) {
            return response()->json(['data' => null]);
        }
        $encrypted = $decode[0];

        return response()->json(['data' => openssl_decrypt($encrypted, $this->cipher, $key, 0, $iv)]);
    }
}
