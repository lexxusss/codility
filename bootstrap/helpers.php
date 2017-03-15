<?php

use Symfony\Component\VarDumper\VarDumper;
use Illuminate\Support\Debug\Dumper;

/* dumper */
if (!function_exists('dd')) {
    function dd()
    {
        $callstack = debug_backtrace();
        dd_dumpHeader($callstack);

        $dd = new VarDumper();
//        $dd = new Dumper();

        foreach (func_get_args() as $var) {
            $dd->dump($var);
        }

        dd_dumpHeader($callstack);

        die;
    }
}
if (!function_exists('_d')) {
    function _d()
    {
        $callstack = debug_backtrace();
        dd_dumpHeader($callstack);

        $dd = new VarDumper();
//        $dd = new Dumper();

        foreach (func_get_args() as $var) {
            $dd->dump($var);
        }

        dd_dumpHeader($callstack);
    }
}

function dd_dumpHeader($callstack)
{
    echo "<pre><hr/><div style='clear: both; background-color: rgb(243, 246, 249)'>";
    $calledFromOutput = "\r\n<span style='color:rgb(116, 114, 19); text-decoration: underline dotted darkslategrey;'>called from: "
        . $callstack[0]['file'] . " : " . $callstack[0]['line'] . "</span>";

    echo "\r\n<b><strong>" . $calledFromOutput . "</strong></b>";
    echo "</div><hr/><br/>";
}
/* /dumper */

function getParamFromJson($json, $param)
{
    return @json_decode($json, 1)[$param];
}

/**
 * Append query row with custom params
 *
 * @param array $params
 * @return string
 */
function appendParamsToQuery($params = [])
{
    parse_str(\Illuminate\Support\Facades\Request::getQueryString(), $urlParsed);
    $newUrlParsed = array_merge($urlParsed, $params);
    $newUrl = '?' . http_build_query($newUrlParsed);

    return \Illuminate\Support\Facades\Request::url() . $newUrl;
}

/**
 * Detach params from the query row
 *
 * @param array $params
 * @return string
 */
function popParamsFromQuery($params = [])
{
    parse_str(\Illuminate\Support\Facades\Request::getQueryString(), $urlParsed);
    $urlParsed = array_diff_key($urlParsed, array_flip($params));

    $newUrl = http_build_query($urlParsed);

    return \Illuminate\Support\Facades\Request::url() . ($newUrl ? '?' . $newUrl : null);
}

/**
 * Check whether query row has custom param
 * 
 * @param $param
 * @return bool
 */
function queryHasParam($param)
{
    parse_str(\Illuminate\Support\Facades\Request::getQueryString(), $urlParsed);
    
    return array_key_exists($param, $urlParsed);
}

/*--------- debug page functionality -------------*/
function debugEmailOptions($user)
{
    return [
        'name' => $user->name,
        'intro' => 'We congratulate you on the successful registration on our website ! Please active your account : ',
        'buttonLink' => route('account.activate', str_random(30)),
        'buttonText' => 'Activate account',
    ];
}

function sendDebugEmail()
{
    $user = auth()->user();
    
    try {
        \Illuminate\Support\Facades\Mail::send(
            'email.registration_confirm',
            debugEmailOptions($user),
            function ($m) use ($user) {
                $m->from(env('MAIL_FROM'), env('MAIL_SENDER'));
                $m->to($user->email, $user->name)->subject('Playright registration');
            }
        );
    } catch (Exception $e) {
        flash()->error('Whoops!', sprintf('There was some error during sending email: $s', $e->getMessage()));
        redirect()->route('page.debug');
    }

    flash()->success('Great!', sprintf('Testing email has been successfully sent to %s. Please check your email or log file.', $user->email));
    redirect()->route('page.debug');
}

function getApiTokensRoles(\Illuminate\Http\Request $request)
{
    $apiTokensRoles = [];
    
    if ($request->get('apiTokens')) {
        $users = \App\User::all();
        $apiTokensRoles = [];
        foreach ($users as $user) {
            $apiTokensRoles[$user->role->name][$user->email] = $user->api_token;
        }
    }
    
    return $apiTokensRoles;
}

function getLogFile(\Illuminate\Http\Request $request)
{
    $logFileContent = null;
    
    if ($request->get('logFile')) {
        $fileName = storage_path('/logs/laravel.log');
        $logFileContent = file_get_contents($fileName);
        $logFileContent = substr($logFileContent, strpos($logFileContent, '<!DOCTYPE html>'));
    }
    
    return $logFileContent;
}
/*--------- /debug page functionality -------------*/

/*------- define whether device is mobile -------*/
function isMobileDevice()
{
    $userAgent = $_SERVER['HTTP_USER_AGENT'];

    $matchPartDevice = '/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i';
    $matchPartAgent = '/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i';

    return preg_match($matchPartDevice, $userAgent) || preg_match($matchPartAgent, substr($userAgent, 0, 4));
}
/*------- /define whether device is mobile -------*/



function matrixToPrint($matrix, $title = 'Matrix:') {
    $matrixToPrint = '';

    foreach ($matrix as $items) {
        $matrixToPrint .= join(' ', $items) . "\r\n";
    }

    return $title . "\r\n\r\n" . $matrixToPrint;
}
