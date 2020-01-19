<?php 
return array (
  'URL_MODEL' => 0,
  'URL_HTML_SUFFIX' => '.html',
  'URL_PATHINFO_DEPR' => '/',
  'URL_ROUTER_ON' => true,
  'URL_ROUTE_RULES' => 
  array (
    '/^jobfair\/(?!admin)(\w+)$/' => 'jobfair/index/:1',
    '/^mall\/(?!admin)(\w+)$/' => 'mall/index/:1',
  ),
  // 'SESSION_OPTIONS' => 
  // array (
  //   'path' => 'D:\wamp64\web\ygjzhaopin\data\session',
  //   'domain' => '.ygjzhaopin.com',
  // ),
  'COOKIE_PATH' => '/',
  'QSCMS_VERSION' => '1.0.0',
  'QSCMS_RELEASE' => '2017-07-27 15:00',
  // 'COOKIE_DOMAIN' => '.ygjzhaopin.com',
);