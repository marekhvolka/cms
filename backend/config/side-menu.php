<?php

return [
    ['icon' => 'files-o', 'title' => 'Stránky', 'controller' => 'page', 'action' => 'index'],
    [
        'icon'     => 'globe',
        'title'    => 'Portál',
        'children' => [
            ['title' => 'Hlavička', 'controller' => 'portal', 'action' => 'layout-edit?type=header'],
            ['title' => 'Pätička', 'controller' => 'portal', 'action' => 'layout-edit?type=footer'],
            ['title' => 'Meracie kódy', 'controller' => 'tracking-code', 'action' => 'index'],
            ['title' => 'Presmerovania', 'controller' => 'redirect', 'action' => 'index'],
        ],
    ],
    ['icon' => 'thumbs-o-up', 'title' => 'Ďakovačky', 'controller' => 'thanks', 'action' => 'index'],
    ['icon' => 'book', 'title' => 'Slovník', 'controller' => 'word', 'action' => 'index'],
    ['icon' => 'picture-o', 'title' => 'Multimédiá', 'controller' => 'multimedia', 'action' => 'index'],
    ['icon' => 'puzzle-piece', 'title' => 'Snippety', 'controller' => 'snippet', 'action' => 'index'],
    [
        'icon'     => 'shopping-cart',
        'title'    => 'Produkty',
        'children' => [
            ['title' => 'Zoznam', 'controller' => 'product', 'action' => 'index'],
            ['title' => 'Premenné', 'controller' => 'product-var', 'action' => 'index'],
            ['title' => 'Typy', 'controller' => 'product-type', 'action' => 'index'],
            ['title' => 'Tagy', 'controller' => 'tag', 'action' => 'index'],
        ],
    ],
    ['icon' => 'paint-brush', 'title' => 'Šablóny', 'controller' => 'template', 'action' => 'index'],
    [
        'icon'     => 'cogs',
        'title'    => 'Nastavenia',
        'children' => [
            ['title' => 'Portály', 'controller' => 'portal', 'action' => 'index'],
            ['title' => 'Používatelia', 'controller' => 'user', 'action' => 'index'],
            ['title' => 'Krajiny', 'controller' => 'language', 'action' => 'index'],
            //['title' => 'Administrácia rolí', 'controller' => 'TODO', 'action' => 'index'],
            //['title' => 'Administrácia oprávnení', 'controller' => 'TODO', 'action' => 'index'],
        ],
    ],
    ['icon' => 'exclamation-triangle', 'title' => 'Hlásenia', 'controller' => 'system-exception', 'action' => 'index']
];