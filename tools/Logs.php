<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Logs
{
    public function info(Request $request, $text, $reference, $params = null): void
    {
        try {
            $log = self::syntax($request, $text, $reference, $params);
            Log::channel('daily')->info($log);
        } catch (Exception $e) {
            Log::channel('error')->emergency('[LOG] Exception->info \n' . $e->getMessage());
        }
    }

    public static function warning(Request $request, $text, $reference, $params = null): void
    {
        try {
            $log = self::syntax($request, $text, $reference, $params);
            Log::channel('daily')->warning($log);
            Log::channel('warning')->error($log);
        } catch (Exception $e) {
            Log::channel('error')->emergency('[LOG] Exception->warning \n' . $e->getMessage());
        }
    }

    public static function warningSimple($text, $reference, $params = null): void
    {
        try {
            $log = '[IP=null] ' . $text . ' | ' . $reference . '\n';
            if ($params != null) {
                $log .= ' [params: ' . count($params) . '] \n';

                $keys = array_keys($params);
                for ($i = 0; $i < count($params); $i++) {
                    $log .= '                      ';
                    $log .= $keys[$i] . '= "' . $params[$keys[$i]] . '" ';
                    if ($i < count($params) - 1) {
                        $log .= '\n';
                    }
                }
            }
            Log::channel('daily')->warning($log);
            Log::channel('warning')->error($log);
        } catch (Exception $e) {
            Log::channel('error')->emergency('[LOG] Exception->warning \n' . $e->getMessage());
        }
    }

    public static function debug(Request $request, $text, $reference, $params = null): void
    {
        if (env('APP_DEBUG')) {
            try {
                $log = self::syntax($request, $text, $reference, $params);
                Log::channel('debug')->debug($log);
            } catch (Exception $e) {
                Log::channel('error')->emergency('[LOG] Exception->debug \n' . $e->getMessage());
            }
        }
    }

    public static function error(Request $request, $text, $reference, $params = null): void
    {
        try {
            $log = self::syntax($request, $text, $reference, $params);
            Log::channel('daily')->error($log);
            Log::channel('error')->error($log);
        } catch (Exception $e) {
            Log::channel('error')->emergency('[LOG] Exception->error \n' . $e->getMessage());
        }
    }

    public static function errorSimple($text, $reference, $params = null): void
    {
        try {
            $log = '[IP=null] ' . $text . ' | ' . $reference . '\n';
            if ($params != null) {
                $log .= ' [params: ' . count($params) . '] \n';

                $keys = array_keys($params);
                for ($i = 0; $i < count($params); $i++) {
                    $log .= '                      ';
                    $log .= $keys[$i] . '= "' . $params[$keys[$i]] . '" ';
                    if ($i < count($params) - 1) {
                        $log .= '\n';
                    }
                }
            }

            Log::channel('daily')->error($log);
            Log::channel('error')->error($log);
        } catch (Exception $e) {
            Log::channel('error')->emergency('[LOG] Exception->error \n' . $e->getMessage());
        }
    }

    private static function syntax(Request $request, $text, $reference, $params = null): string
    {
        $ip = $request->ip();
        $RequestUrl = $request->getRequestUri();
        $RequestMethod = $request->getMethod();

        $log = '[IP=' . $ip . '] ' . $text . ' | ' . $reference . '\n';
        $log .= '                      ' . 'Request is [API] ' . $RequestMethod . ' ' . $RequestUrl;

        if ($params != null) {
            $log .= ' [params: ' . count($params) . '] \n';

            $keys = array_keys($params);
            for ($i = 0; $i < count($params); $i++) {
                $log .= '                      ';
                $log .= $keys[$i] . '= "' . $params[$keys[$i]] . '" ';
                if ($i < count($params) - 1) {
                    $log .= '\n';
                }
            }
        }
        return $log;
    }
}
