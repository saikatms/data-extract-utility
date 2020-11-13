<?php

class HTMLTextDataExtract
{
    
    /**
     * Get response of an link in html format
     * @param $url
     *
     */
    
    public static function get_curlResponse($url)
    {
        print "redirecting: " . $url . PHP_EOL;
        
        $curl_options = array(
            CURLOPT_FOLLOWLOCATION => true, // follow redirects
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_TIMEOUT => 2000,
            //             CURLOPT_PROXY => "http://172.16.2.30:8080"
        );
        
        $curl = curl_init(trim($url));
        
        curl_setopt_array($curl, $curl_options);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        // CURLOPT_USERAGENT,
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        
        
        if ($response && $httpcode == "200") {
            return $response;
        } else {
            echo "Bad Response";
            return "";
            // exit;
        }
    }
    
    /**
     * Remove all <script> tags and Java script codes form a HTML response
     * @param string $script_str
     * @return string
     */
    
    public static  function clean_jscode($script_str)
    {
        $script_str = htmlspecialchars_decode($script_str);
        $search_arr = array(
            '<script',
            '</script>'
        );
        $script_str = str_ireplace($search_arr, $search_arr, $script_str);
        $split_arr = explode('<script', $script_str);
        $remove_jscode_arr = array();
        foreach ($split_arr as $key => $val) {
            $newarr = explode('</script>', $split_arr[$key]);
            $remove_jscode_arr[] = ($key == 0) ? $newarr[0] : $newarr[1];
        }
        return implode('', $remove_jscode_arr);
    }
    
    public static function clean_css($script_str)
    {
        $script_str = preg_replace('/<style(.*)<\/style>/s', '', $script_str);
        return $script_str;
        
    }
    public static function remove_html_comments($content) {
        return preg_replace('/<!--(.|\s)*?-->/', '', $content);
    }
    
}


$url="https://futurehuman.medium.com/were-past-the-point-of-no-return-on-global-warming-scientists-warn-6779aaf4ed2b";
$data=new HTMLTextDataExtract();
$response=$data->get_curlResponse($url);

$dom=new DOMDocument();
libxml_use_internal_errors(true);
$dom->loadHTML($response);
libxml_use_internal_errors(false);
$xpath=new DOMXPath($dom);
$body=$xpath->query('//body');
$bodyHTMLdata=$dom->saveHTML($body->item(0));

$bodyRemoveJS=$data->clean_jscode($bodyHTMLdata);
$bodyRemoveCSS=$data->clean_css($bodyRemoveJS);
$bodyRemoveCommants=$data->remove_html_comments($bodyRemoveCSS);
$textContent=strip_tags($bodyRemoveCommants);
print_r($textContent);
