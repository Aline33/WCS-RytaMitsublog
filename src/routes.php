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
    'user/show' => ['UserController', 'show'],
    'user/delete' => ['UserController', 'delete'],
    'article/edit' => ['ArticleController', 'edit',['id']],
    'comment/edit' => ['CommentController', 'editComment', ['id']],
    'comment/delete' => ['CommentController', 'delete'],
    'contact' => ['ContactController', 'index',],
    'mentions-legales' => ['LegalNoticeController', 'legalNotice'],
    'politique-de-confidentialite' => ['LegalNoticeController', 'privacyPolicy'],
    'CGU' => ['LegalNoticeController', 'cgu'],
    'RGPD' => ['LegalNoticeController', 'rgpd'],
    'profil' => ['UserController', 'index', ['id']],
];
