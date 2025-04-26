<?php
class Token {
    public static function generate($userId) {
        return base64_encode($userId . ':' . bin2hex(random_bytes(16)));
    }

    public static function validate($token) {
        $decoded = base64_decode($token);
        if (!$decoded || strpos($decoded, ':') === false) return null;
        return explode(':', $decoded)[0]; // user ID
    }
}
