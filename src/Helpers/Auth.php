<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\ExpiredException;
use Exception;

/**
 * Final class for handling JWT authentication.
 */
final class Auth
{
    /**
     * @var array|null
     */
    public static ?array $user = null;

    /**
     * Generate a JWT token for the given user ID and username.
     *
     * @param int $userId
     * @param string $username
     * @return string
     */
    public static function generateToken(int $userId, string $username): string
    {
        $issuedAt = time();
        $expirationTime = $issuedAt + (int) $_ENV['JWT_EXPIRY'];
        $payload = [
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'userId' => $userId,
            'userName' => $username
        ];

        return JWT::encode($payload, $_ENV['JWT_SECRET'], $_ENV['JWT_ALGO']);
    }

    /**
     * Validate the provided JWT token and return the decoded payload or false.
     *
     * @param string $token
     * @return array|bool
     */
    public static function validateToken(string $token): array|bool
    {
        try {
            $decoded = JWT::decode($token, new Key($_ENV['JWT_SECRET'], $_ENV['JWT_ALGO']));
            return (array) $decoded;
        } catch (SignatureInvalidException | ExpiredException | Exception $e) {
            return false;
        }
    }

    /**
     * Set the authenticated user based on the provided authorization header.
     *
     * @param string $authHeader
     * @return void
     */
    public static function setUser(string $authHeader): void
    {
        if (!empty($authHeader)) {
            $response = self::validateToken($authHeader);
            if ($response) {
                self::$user = $response;
            }
        }
    }

    /**
     * Get the currently authenticated user.
     *
     * @return array|null
     */
    public static function user(): ?array
    {
        return self::$user;
    }
}