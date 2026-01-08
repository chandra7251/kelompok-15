<?php

namespace App\Services;

use App\Core\Database;

class ExchangeRateService
{
    private Database $db;
    private ApiClient $apiClient;
    private string $apiKey;
    private string $apiUrl;
    private int $cacheTtl;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->apiClient = new ApiClient();
        $this->apiKey = $_ENV['EXCHANGE_RATE_API_KEY'] ?? '';
        $this->apiUrl = $_ENV['EXCHANGE_RATE_API_URL'] ?? 'https://v6.exchangerate-api.com/v6';
        
        $dbTtl = $this->db->fetch(
            "SELECT setting_value FROM system_settings WHERE setting_key = 'kurs_ttl'"
        );
        $this->cacheTtl = $dbTtl 
            ? (int) $dbTtl['setting_value'] 
            : (int) ($_ENV['EXCHANGE_RATE_CACHE_TTL'] ?? 3600);
    }

    public function getRate(string $from, string $to = 'IDR'): float
    {
        $from = strtoupper($from);
        $to = strtoupper($to);

        if ($from === $to)
            return 1.0;

        $cached = $this->getCachedRate($from, $to);
        if ($cached !== null)
            return $cached;

        $rate = $this->fetchRateFromApi($from, $to);
        if ($rate > 0)
            $this->cacheRate($from, $to, $rate);

        return $rate;
    }

    public function convertToIdr(float $amount, string $from): array
    {
        $rate = $this->getRate($from, 'IDR');
        return [
            'original_amount' => $amount,
            'original_currency' => $from,
            'rate' => $rate,
            'converted_amount' => $amount * $rate
        ];
    }

    public function getAvailableCurrencies(): array
    {
        return [
            'IDR' => 'Indonesian Rupiah',
            'USD' => 'US Dollar',
            'EUR' => 'Euro',
            'GBP' => 'British Pound',
            'SGD' => 'Singapore Dollar',
            'MYR' => 'Malaysian Ringgit',
            'JPY' => 'Japanese Yen',
            'AUD' => 'Australian Dollar',
            'CNY' => 'Chinese Yuan'
        ];
    }

    private function getCachedRate(string $from, string $to): ?float
    {
        $result = $this->db->fetch(
            "SELECT rate FROM exchange_rate_log WHERE base_currency = :from AND target_currency = :to AND expires_at > NOW() ORDER BY fetched_at DESC LIMIT 1",
            ['from' => $from, 'to' => $to]
        );
        return $result ? (float) $result['rate'] : null;
    }

    private function fetchRateFromApi(string $from, string $to): float
    {
        if (empty($this->apiKey)) {
            return $this->getFallbackRate($from, $to);
        }

        $response = $this->apiClient->get("{$this->apiUrl}/{$this->apiKey}/pair/{$from}/{$to}");

        if ($response['success'] && isset($response['data']['conversion_rate'])) {
            return (float) $response['data']['conversion_rate'];
        }

        return $this->getFallbackRate($from, $to);
    }

    private function cacheRate(string $from, string $to, float $rate): void
    {
        $expiresAt = date('Y-m-d H:i:s', time() + $this->cacheTtl);
        $this->db->insert(
            "INSERT INTO exchange_rate_log (base_currency, target_currency, rate, expires_at) VALUES (:from, :to, :rate, :expires_at)",
            ['from' => $from, 'to' => $to, 'rate' => $rate, 'expires_at' => $expiresAt]
        );
    }

    private function getFallbackRate(string $from, string $to): float
    {
        $fallbackRates = [
            'USD' => ['IDR' => 15500],
            'EUR' => ['IDR' => 17000],
            'GBP' => ['IDR' => 19500],
            'SGD' => ['IDR' => 11500],
            'MYR' => ['IDR' => 3500],
            'JPY' => ['IDR' => 105],
            'AUD' => ['IDR' => 10500],
            'CNY' => ['IDR' => 2150]
        ];
        return $fallbackRates[$from][$to] ?? 1.0;
    }
}
