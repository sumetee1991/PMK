<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( !function_exists('assets_config') && !function_exists('assets_css') && !function_exists('assets_js'))
{
	function assets_config(){
	    $CI =& get_instance();
	    $CI->load->config('assets');

        $config['node_path'] = $CI->config->item('node_path');
	    $config['assets_path'] = $CI->config->item('assets_path');
	    return $config;
	}

    function single_node($file){
        $config = assets_config();
        return "<script src='".$config['node_path'].$file."'></script>\r\n";
    }

    function single_css($file){
        $config = assets_config();
        return "<link rel='stylesheet' href='".$config['assets_path'].$file."'>\r\n";
    }

    function single_js($file){
        $config = assets_config();
        return "<script type='text/javascript' src='".$config['assets_path'].$file."'></script>\r\n";
    }

    function assets_node($file)
    {
        $config = assets_config();
        $data = "";
        foreach($file as $result){
            $data .= "<script src='".$config['node_path'].$result."'></script>\r\n";
        }

        return $data;
    }

    function assets_css($file)
    {
    	$config = assets_config();
        $data = "";
        foreach($file as $result){
            $data .= "<link rel='stylesheet' href='".$config['assets_path'].$result."'>\r\n";
        }

        return $data;
    }
    
    function assets_js($file)
    {
    	$config = assets_config();
        $data = "";
        foreach($file as $result){
            $data .= "<script type='text/javascript' src='".$config['assets_path'].$result."'></script>\r\n";
        }

        return $data;
    }
}