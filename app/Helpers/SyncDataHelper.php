<?php

use Illuminate\Support\Facades\Log;

if (!function_exists('sendOrderData')) {
    /**
     * Send order data to remote API
     *
     * @param array|string $data       Data to send (array will be JSON encoded)
     * @param string       $entry_from Either 'direct_api' or 'manual_api'
     * @return array
     */
    function sendOrderData($data, $entry_from = 'direct_api')
    {
        $endpoints = [
            'direct_api' => 'https://bizfin.indiakarobar.com/api/channel-partners/turnover', // automatic
            'manual_api' => 'https://bizfin.indiakarobar.com/api/channel-partners/syncInvoiceData' // manual
        ];

        $curl_url = $endpoints[$entry_from] ?? $endpoints['direct_api'];

        // Ensure JSON payload
        $payload = is_array($data) ? json_encode($data) : $data;

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL            => $curl_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 5,
            CURLOPT_TIMEOUT        => 60,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => $payload,
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
                'Accept: application/json'
            ],
        ]);

        $response   = curl_exec($curl);
        $http_code  = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($curl);
        curl_close($curl);

        // ✅ Error Handling
        if ($curl_error) {
            Log::error("send_order_data: CURL error ($curl_url) => " . $curl_error);
            return [
                'type'    => 'ERROR',
                'message' => $curl_error
            ];
        }

        if ($http_code >= 400) {
            Log::error("send_order_data: HTTP $http_code ($curl_url) => " . $response);
            return [
                'type'    => 'ERROR',
                'http'    => $http_code,
                'message' => $response
            ];
        }

        // ✅ Decode JSON safely
        $decoded = json_decode($response, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            Log::info("send_order_data: Success ($curl_url)");
            return [
                'type'  => 'SUCCESS',
                'http'  => $http_code,
                'data'  => $decoded
            ];
        } else {
            Log::warning("send_order_data: Non-JSON response ($curl_url) => " . $response);
            return [
                'type'  => 'SUCCESS',
                'http'  => $http_code,
                'data'  => $response
            ];
        }
    }
}
