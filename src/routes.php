<?php

session_start();

// list of accessible routes of your application, add every new route here
// key : route to match
// values : 1. controller name
//          2. method name
//          3. (optional) array of query string keys to send as parameter to the method
// e.g: route '/item/edit?id=1' will execute $itemController->edit(1)

return [
    '' => ['HomeController', 'index',],

    'items' => ['ItemController', 'index',],
    'items/edit' => ['ItemController', 'edit', ['id']],
    'items/show' => ['ItemController', 'show', ['id']],
    'items/add' => ['ItemController', 'add',],
    'items/delete' => ['ItemController', 'delete',],
    'article/show' => ['ArticleController', 'show', ['id']],
    'article/add' => ['ArticleController', 'add',],
    'article/edit' => ['ArticleController', 'edit',['id']],
    'user/show' => ['UserController', 'show', ['id']],
    'contact' => ['ContactController', 'index',],
    'mentions-legales' => ['LegalNoticeController', 'legalNotice'],
    'politique-de-confidentialite' => ['LegalNoticeController', 'privacyPolicy'],
    'CGU' => ['LegalNoticeController', 'cgu'],
    'RGPD' => ['LegalNoticeController', 'rgpd'],
    'profil' => ['UserController', 'show'],
];
