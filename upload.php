<?php
header('Access-Control-Allow-Origin:*');
header('Content-type:application/json; charset=utf-8');
error_reporting(0);

if(!empty($_FILES['file'])){
    $type = array_pop(explode('.', $_FILES['file']['name']));
    $name = $_FILES['file']['tmp_name'].'.'.$type;
    if(($_FILES["file"]["size"] < 10*1024*1024) && in_array($type,["gif", "jpeg", "jpg", "png"])){
        rename($_FILES['file']['tmp_name'],$name);
        $url = 'https://kfupload.alibaba.com/mupload';
        $post = [
            'scene' => 'aeMessageCenterV2ImageRule',
            'name' => $_FILES['file']['name'],
        ];
        if(class_exists('CURLFile')){
            $post['file'] = new \CURLFile(realpath($name));
        }else {
            $post['file'] = '@'.realpath($name);
        }
        $result = get_url($url,$post);
        if($result){
            $result = json_decode($result,true);
            exit('{"code":"200","url":"'.$result['url'].'"}');
        }else{
            exit('{"code":"401","url":"上传失败"}');
        }
    }else{
        exit('{"code":"402","url":"文件格式错误或文件过大"}');
    }
}else{
    exit('{"code":"400","url":"参数错误"}');
}

function get_url($url,$post=false){
	$ch = curl_init();
    curl_setopt($ch,CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_USERAGENT, 'iAliexpress/6.22.1 (iPhone; iOS 12.1.2; Scale/2.00)');
	if($post){
		curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
    }
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}
