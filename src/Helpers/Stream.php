<?php

namespace Bavix\Helpers;

use Bavix\Exceptions;
use Bavix\Exceptions\NotFound;
use Curl\Curl;

class Stream
{

    /**
     * @return Curl
     */
    protected static function curl(): Curl
    {
        return new Curl();
    }

    /**
     * @param string $from
     * @param string $to
     *
     * @return bool
     *
     * @throws Exceptions\PermissionDenied
     * @throws NotFound\Path
     */
    public static function download($from, $to): bool
    {
        /**
         * @var bool|resource $fromStream
         */
        $fromStream = File::open($from);

        if (!is_resource($fromStream))
        {
            throw new NotFound\Path('Stream `' . $from . '` not found');
        }

        if (!File::real($to) && !File::touch($to))
        {
            throw new Exceptions\PermissionDenied('File `' . $to . '`');
        }

        File::put($to, $fromStream);

        return File::close($fromStream);
    }

    /**
     * @param string|array $urlOrOptions
     * @param array        $data
     *
     * @return Curl
     *
     * @throws Exceptions\Invalid
     */
    public static function upload($urlOrOptions, array $data = []): Curl
    {

        $options = $urlOrOptions;

        if (is_string($options))
        {
            $options = ['url' => $urlOrOptions];
        }

        if (!isset($options['url']))
        {
            throw new Exceptions\Invalid('Param option `URL` not found!');
        }

        $url    = $options['url'];
        $method = $options['method'] ?? 'post';
        $headers = $options['headers'] ?? [];

        $data = Arr::map($data, function ($value) {

            if (\is_string($value) && Str::sub($value, 0, 1) === '@')
            {
                return curl_file_create(Str::sub($value, 1));
            }

            return $value;

        });

        $curl = static::curl();

        if (!empty($headers))
        {
            foreach ($headers as $key => $value)
            {
                $headers[$key] = $key . ': ' . implode(',', (array)$value);
            }

            $curl->setOpt(CURLOPT_HTTPHEADER, Arr::getValues($headers));
        }

        $curl->$method($url, $data);

        $response = JSON::decode($curl->response);

        if (JSON::errorNone())
        {
            $curl->response = $response;
        }

        return $curl;

    }

}
