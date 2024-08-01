<?php

namespace App\Services\AuthServices;

use App\Repositories\UserRepository;
use App\Helpers\Auth;

/**
 * Service class for handling user login functionality.
 */
class LoginService
{
    public string $username;
    public string $password;

    /**
     * Set the username.
     *
     * @param string $username
     * @return $this
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Get the username.
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Set the password.
     *
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Get the password.
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Process the login by validating user credentials and generating a token.
     *
     * @return array
     */
    public function process(): array
    {
        $userRepository = new UserRepository();
        $response = $userRepository->getUserByUsernamePassword($this->getUsername(), md5($this->getPassword()));

        if (empty($response)) {
            return ['success' => false, 'message' => 'Invalid username or password'];
        }

        $response['access_token'] = Auth::generateToken($response['id'], $response['username']);

        return ['success' => true, 'message' => 'Logged in successfully', 'data' => $response];
    }
}