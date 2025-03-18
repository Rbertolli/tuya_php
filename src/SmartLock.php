<?php

namespace Tuya;

class SmartLock extends TuyaClient
{
    /**
     * Obtém o ticket para smart-lock.
     */
    public function getPasswordTicket($deviceId)
    {
        list($accessToken) = $this->getAccessToken();
        if (!$accessToken) {
            return ["error" => "Failed to get token"];
        }
        $timestamp = round(microtime(true) * 1000);
        $nonce     = $this->generateUUID();
        $urlPath   = "/v1.0/smart-lock/devices/{$deviceId}/password-ticket";
        $sign      = $this->generatePostSignature($timestamp, $nonce, $accessToken, $urlPath, "");
        
        $headers = [
            "client_id: "    . $this->clientId,
            "t: "            . $timestamp,
            "nonce: "        . $nonce,
            "sign: "         . $sign,
            "sign_method: HMAC-SHA256",
            "access_token: " . $accessToken,
            "Content-Type: application/json"
        ];
        
        $ch = curl_init($this->apiUrl . $urlPath);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_POST           => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1
        ]);
        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);
        return $response;
    }
    
    /**
     * Criptografa uma senha numérica usando o ticket_key.
     *
     * @param string $plainPassword Senha em texto plano (ex: "123456")
     * @param string $ticket_key_hex Ticket key em hexadecimal
     * @param array  $debug Array para armazenar mensagens de debug (opcional)
     *
     * @return string|array Retorna a senha criptografada em hexadecimal ou um array de erro com debug
     */
    public function encryptNumericPassword($plainPassword, $ticket_key_hex, &$debug = [])
    {
        $access_secret = $this->clientSecret;
        $debug['access_secret'] = $access_secret;
    
        // Converte o ticket_key de hex para binário
        $ticket_key_bin = hex2bin($ticket_key_hex);
        if ($ticket_key_bin === false) {
            $debug['error_ticket_key'] = "ticket_key em formato inválido";
            return ['error' => 'ticket_key em formato inválido', 'debug' => $debug];
        }
        $debug['ticket_key_hex'] = $ticket_key_hex;
        $debug['ticket_key_bin'] = bin2hex($ticket_key_bin);
    
        // Descriptografa o ticket_key com AES-256-ECB usando a chave completa
        $decrypted_key = openssl_decrypt(
            $ticket_key_bin,
            'AES-256-ECB',
            $access_secret,
            OPENSSL_RAW_DATA
        );
        if ($decrypted_key === false) {
            $debug['decrypted_key'] = "false";
            return ['error' => 'Falha ao descriptografar o ticket_key', 'debug' => $debug];
        }
        $debug['decrypted_key_raw'] = bin2hex($decrypted_key);
    
        // Se a chave resultante não tiver 16 bytes, ajusta para os 16 primeiros bytes
        if (strlen($decrypted_key) !== 16) {
            $debug['decrypted_key_length_before'] = strlen($decrypted_key);
            $decrypted_key = substr($decrypted_key, 0, 16);
            $debug['decrypted_key_length_after'] = strlen($decrypted_key);
        }
        $debug['decrypted_key_final'] = bin2hex($decrypted_key);
    
        // Criptografa o PIN utilizando AES-128-ECB (o OpenSSL aplica padding PKCS#7 automaticamente)
        $encrypted = openssl_encrypt(
            $plainPassword,
            'AES-128-ECB',
            $decrypted_key,
            OPENSSL_RAW_DATA
        );
        if ($encrypted === false) {
            $debug['encrypted'] = "false";
            return ['error' => 'Falha ao criptografar a senha', 'debug' => $debug];
        }
        $debug['encrypted_raw'] = bin2hex($encrypted);
    
        return strtoupper(bin2hex($encrypted));
    }
    
    /**
     * Cria uma senha temporária para smart-lock.
     *
     * @param string $deviceId Identificador do dispositivo
     * @param array  $payload  Dados do payload
     *
     * @return array Resposta da API
     */
    public function createTempPassword($deviceId, $payload)
    {
        list($accessToken) = $this->getAccessToken();
        if (!$accessToken) {
            return ["error" => "Invalid token"];
        }
    
        $urlPath = "/v1.0/devices/{$deviceId}/door-lock/temp-password";
        $bodyData = json_encode($payload);
    
        $timestamp = round(microtime(true) * 1000);
        $nonce     = $this->generateUUID();
        $sign      = $this->generatePostSignature($timestamp, $nonce, $accessToken, $urlPath, $bodyData);
    
        $headers = [
            "client_id: "    . $this->clientId,
            "t: "            . $timestamp,
            "nonce: "        . $nonce,
            "sign: "         . $sign,
            "sign_method: HMAC-SHA256",
            "access_token: " . $accessToken,
            "Content-Type: application/json"
        ];
    
        $ch = curl_init($this->apiUrl . $urlPath);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $bodyData,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1
        ]);
        $rawResponse = curl_exec($ch);
        $curlError   = curl_error($ch);
        curl_close($ch);
    
        return [
            'response'   => json_decode($rawResponse, true),
            'raw'        => $rawResponse,
            'curl_error' => $curlError
        ];
    }
}
