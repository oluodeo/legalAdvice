<?php

return[
	'img_prefix' => 'http://www.law.com/images/',
	'upload_prefix' => 'http://www.law.com/',
	'token_expire_in' => 7200,
	'token_salt' => 'fgdhsjyjhkk',
	'API_PAGE_SIZE' => 10,
	'ADMIN_PAGE_SIZE' => 5,
	
	//  +---------------------------------
    //  微信相关配置
    //  +---------------------------------

    // 小程序app_id
    'app_id' => 'wxeb99b2efded74889',
    // 小程序app_secret
    'app_secret' => '73bab670d1e48de41162c680e1d7d2d3',

    // 微信使用code换取用户openid及session_key的url地址
    'login_url' => "https://api.weixin.qq.com/sns/jscode2session?" .
        "appid=%s&secret=%s&js_code=%s&grant_type=authorization_code",

    // 微信获取access_token的url地址
    'access_token_url' => "https://api.weixin.qq.com/cgi-bin/token?" .
        "grant_type=client_credential&appid=%s&secret=%s",


];