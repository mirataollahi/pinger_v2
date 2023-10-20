<?php

namespace App\Jwt;

class Jwt
{

    /**
     * The jwt private token
     *
     * @var string
     */
    protected string $privateKey;

    /**
     * The jwt encrypt algorithm
     *
     * @var string
     */
    protected string $algorithm = 'HS256';

    /**
     * The jwt token type
     *
     * @var string
     */
    protected string $type = 'JWT';

    /**
     * Create an object of the jwt service
     *
     * @param string $privateKey The jwt private key
     * @param string $algorithm The jwt encrypt algorithm
     * @param string $type The jwt token type
     */
    public function __construct(string $privateKey , string $algorithm = 'HS256' , string $type = 'JWT')
    {
        $this->privateKey = $privateKey;
        $this->algorithm = $algorithm;
        $this->type = $type;
    }

    /**
     * Get header array
     *
     * @return array
     */
    public function getHeader(): array
    {
        return [
            'alg' => $this->algorithm ,
            'typ' => $this->type
        ];
    }

    /**
     * Get encoded jwt header
     *
     * @return array|string
     */
    public function getEncodedHeader(): array|string
    {
        $jsonHeader = json_encode($this->getHeader());
        return $this->base64UrlEncode($jsonHeader);
    }

    /**
     * Decode jwt token header and convert to array
     *
     * @param mixed $encodedHeader
     * @return mixed
     */
    public function getDecodedHeader(mixed $encodedHeader): mixed
    {
        return json_decode($this->base64UrlDecode($encodedHeader), true);
    }

    /**
     * Get encoded payload for jwt service
     *
     * @param mixed $payload
     * @return array|string|string[]
     */
    public function getEncodedPayload(mixed $payload): array|string
    {
        $jsonPayload = json_encode($payload);
        return $this->base64UrlEncode(json_encode($jsonPayload));
    }


    /**
     * Decode jwt token payload
     *
     * @param mixed $encodedPayload
     * @return array|string
     */
    public function getDecodedPayload(mixed $encodedPayload): array|string
    {
        return json_decode($this->base64UrlDecode($encodedPayload), true);
    }

    /**
     * Generate jwt token signature with encoded header and encoded payload
     *
     * @param string|array $encodedHeader
     * @param string|array $encodedPayload
     * @return string
     */
    public function makeSignature(string|array $encodedHeader , string|array $encodedPayload): string
    {
        return hash_hmac('sha256', "$encodedHeader.$encodedPayload", $this->privateKey, true);
    }

    /**
     * Encode jwt token signature with base64
     *
     * @param string|array $encodedHeader
     * @param string|array $encodedPayload
     * @return array|string|string[]
     */
    public function getEncodeSignature(string|array $encodedHeader , string|array $encodedPayload): array|string
    {
        $signature = $this->makeSignature($encodedHeader , $encodedPayload);
        return $this->base64UrlEncode($signature);
    }

    /**
     * Generate jwt token base on header and payload and private key
     *
     * @param array $payload
     * @return string
     */
    public function generateToken(array $payload): string
    {

        $encodedHeader = $this->getEncodedHeader();
        $encodedPayload = $this->getEncodedPayload($payload);
        $encodedSignature = $this->getEncodeSignature($encodedHeader , $encodedPayload);

        return "$encodedHeader.$encodedPayload.$encodedSignature";
    }

    /**
     * Get encoded header of jwt token
     *
     * @param string $token
     * @return array
     */
    public function header(string $token): array
    {
        [$encodedHeader, ,] = explode('.', $token);
        return $this->getEncodedHeader($encodedHeader);
    }

    /**
     * Get encoded payload of jwt token
     *
     * @param string $token
     * @return array
     */
    public function payload(string $token): array
    {
        [, $encodedPayload,] = explode('.', $token);
        return $this->getEncodedPayload($encodedPayload);
    }

    /**
     * Check jwt token is valid or not
     *
     * @param $token
     * @return bool
     */
    public function isValid($token): bool
    {
        [$encodedHeader, $encodedPayload, $encodedSignature] = explode('.', $token);
        $encodedSignatureExpected = $this->getEncodeSignature($encodedHeader , $encodedPayload);
        return $encodedSignature === $encodedSignatureExpected;
    }


    /**
     * Encode base 64 url
     *
     * @param $data
     * @return array|string
     */
    public function base64UrlEncode($data): array|string
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
    }

    /**
     * Decode base 64 url
     *
     * @param $data
     * @return bool|string
     */
    public function base64UrlDecode($data): bool|string
    {
        return base64_decode(str_replace(['-', '_'], ['+', '/'], $data));
    }

}