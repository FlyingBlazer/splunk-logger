<?php

namespace SplunkLogger;

use Monolog\Formatter\LineFormatter;

class SplunkFormatter extends LineFormatter
{
    const FORMAT = "[%datetime%] app=%channel% message=%message% %context%\n";

    public function __construct()
    {
        parent::__construct(self::FORMAT);
    }

    protected function convertToString($data, $prefix = '')
    {
        if (null === $data || is_bool($data)) {
            return var_export($data, true);
        }

        if (is_scalar($data)) {
            return (string) $data;
        }

        if (is_array($data)) {
            $ret = [];

            foreach ($data as $key => $value) {
                if (null === $value || is_bool($value)) {
                    $value = var_export($data, true);
                } else if (is_scalar($value)) {
                    $value = (string) $value;
                } else {
                    $value = json_encode($value);
                }
                array_push($ret, "$key=$value");
            }
            return implode(', ', $ret);
        }

        return json_encode($data);
    }
}
