<?php

namespace SplunkLogger;

use Monolog\Formatter\LineFormatter;

class SplunkFormatter extends LineFormatter
{
    const FORMAT = "[%datetime%]app=%channel%,message=%message%,context=[%context%],extra=[%extra%]\n";

    public function __construct()
    {
        parent::__construct(self::FORMAT);
    }

    protected function convertToString($data, $prefix = '')
    {
        if (null === $data || is_bool($data)) {
            return var_export($data, true);
        }

        if (is_string($data)) {
            return preg_replace('/\s/', '_', $data);
        }

        if (is_scalar($data)) {
            return (string) $data;
        }

        if (is_array($data)) {
            $ret = [];

            foreach ($data as $key => $value) {
                $key = $prefix . preg_replace('/\s/', '_', $key);
                if(is_array($value)) {
                    $value = $this->convertToString($value, $key . '_');
                } else {
                    $value = $this->convertToString($value);
                    $value = "$key=$value";
                }
                array_push($ret, $value);
            }
            return implode(',', $ret);
        }

        return $this->convertToString(json_decode(json_encode($data)));
    }
}
