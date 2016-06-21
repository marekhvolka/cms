<?php

return [
    ['icon' => 'files-o', 'title' => 'Stránky', 'controller' => 'page', 'action' => 'index'],
    [
        'icon'     => 'globe',
        'title'    => 'Globálne nastavenia',
        'children' => [
            ['title' => 'Globálna hlavička', 'controller' => 'portal', 'action' => 'layout-create?type=header'],
            ['title' => 'Globálna pätička', 'controller' => 'portal', 'action' => 'layout-create?type=footer'],
            ['title' => 'Meracie kódy', 'controller' => 'tracking-code', 'action' => 'index'],
        ],
    ],
    ['icon' => 'thumbs-o-up', 'title' => 'Ďakovačky', 'controller' => 'tracking-code', 'action' => 'index'],
    ['icon' => 'book', 'title' => 'Slovník', 'controller' => 'word', 'action' => 'index'],
    ['icon' => 'picture-o', 'title' => 'Multimédiá', 'controller' => 'multimedia', 'action' => 'index'],
    ['icon' => 'puzzle-piece', 'title' => 'Snippety', 'controller' => 'snippet', 'action' => 'index'],
    [
        'icon'     => 'shopping-cart',
        'title'    => 'Produkty',
        'children' => [
            ['title' => 'Zoznam produktov', 'controller' => 'product', 'action' => 'index'],
            ['title' => 'Zoznam premenných', 'controller' => 'product-var', 'action' => 'index'],
            ['title' => 'Zoznam typov', 'controller' => 'product-type', 'action' => 'index'],
            ['title' => 'Zoznam tagov', 'controller' => 'tag', 'action' => 'index'],
        ],
    ],
    ['icon' => 'paint-brush', 'title' => 'Šablóny', 'controller' => 'template', 'action' => 'index'],
    [
        'icon'     => 'cogs',
        'title'    => 'Nastavenia',
        'children' => [
            ['title' => 'Administrácia portálov', 'controller' => 'portal', 'action' => 'index'],
            ['title' => 'Administrácia používateľov', 'controller' => 'user', 'action' => 'index'],
            ['title' => 'Portálové premenné', 'controller' => 'portal-var', 'action' => 'index'],
            ['title' => 'Administrácia krajín', 'controller' => 'language', 'action' => 'index'],
            ['title' => 'Administrácia rolí', 'controller' => 'TODO', 'action' => 'index'],
            ['title' => 'Administrácia oprávnení', 'controller' => 'TODO', 'action' => 'index'],
        ],
    ],
    ['icon' => 'exclamation-triangle', 'title' => 'Hlásenia', 'controller' => 'system-exception', 'action' => 'index']
];