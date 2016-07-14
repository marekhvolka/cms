<?php

namespace common\components;

class Icons
{
    public static function fontAwesomeIcons()
    {
        $pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/i';
        $subject = file_get_contents('http://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.css');

        preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

        $icons = array();

        foreach ($matches as $match) {
            $icons['fa ' . $match[1]] = $match[1];
        }

        return $icons;
    }

    public static function glyphicons()
    {
        $icons = array(
            'glyphicon glyphicon-adjust' => 'adjust',
            'glyphicon glyphicon-align-center' => 'align-center',
            'glyphicon glyphicon-align-justify' => 'align-justify',
            'glyphicon glyphicon-align-left' => 'align-left',
            'glyphicon glyphicon-align-right' => 'align-right',
            'glyphicon glyphicon-arrow-down' => 'arrow-down',
            'glyphicon glyphicon-arrow-left' => 'arrow-left',
            'glyphicon glyphicon-arrow-right' => 'arrow-right',
            'glyphicon glyphicon-arrow-up' => 'arrow-up',
            'glyphicon glyphicon-asterisk' => 'asterisk',
            'glyphicon glyphicon-backward' => 'backward',
            'glyphicon glyphicon-ban-circle' => 'ban-circle',
            'glyphicon glyphicon-barcode' => 'barcode',
            'glyphicon glyphicon-bell' => 'bell',
            'glyphicon glyphicon-bold' => 'bold',
            'glyphicon glyphicon-book' => 'book',
            'glyphicon glyphicon-bookmark' => 'bookmark',
            'glyphicon glyphicon-briefcase' => 'briefcase',
            'glyphicon glyphicon-bullhorn' => 'bullhorn',
            'glyphicon glyphicon-calendar' => 'calendar',
            'glyphicon glyphicon-camera' => 'camera',
            'glyphicon glyphicon-certificate' => 'certificate',
            'glyphicon glyphicon-check' => 'check',
            'glyphicon glyphicon-chevron-down' => 'chevron-down',
            'glyphicon glyphicon-chevron-left' => 'chevron-left',
            'glyphicon glyphicon-chevron-right' => 'chevron-right',
            'glyphicon glyphicon-chevron-up' => 'chevron-up',
            'glyphicon glyphicon-circle-arrow-down' => 'circle-arrow-down',
            'glyphicon glyphicon-circle-arrow-left' => 'circle-arrow-left',
            'glyphicon glyphicon-circle-arrow-right' => 'circle-arrow-right',
            'glyphicon glyphicon-circle-arrow-up' => 'circle-arrow-up',
            'glyphicon glyphicon-cloud' => 'cloud',
            'glyphicon glyphicon-cloud-download' => 'cloud-download',
            'glyphicon glyphicon-cloud-upload' => 'cloud-upload',
            'glyphicon glyphicon-cog' => 'cog',
            'glyphicon glyphicon-collapse-down' => 'collapse-down',
            'glyphicon glyphicon-collapse-up' => 'collapse-up',
            'glyphicon glyphicon-comment' => 'comment',
            'glyphicon glyphicon-compressed' => 'compressed',
            'glyphicon glyphicon-copyright-mark' => 'copyright-mark',
            'glyphicon glyphicon-credit-card' => 'credit-card',
            'glyphicon glyphicon-cutlery' => 'cutlery',
            'glyphicon glyphicon-dashboard' => 'dashboard',
            'glyphicon glyphicon-download' => 'download',
            'glyphicon glyphicon-download-alt' => 'download-alt',
            'glyphicon glyphicon-earphone' => 'earphone',
            'glyphicon glyphicon-edit' => 'edit',
            'glyphicon glyphicon-eject' => 'eject',
            'glyphicon glyphicon-envelope' => 'envelope',
            'glyphicon glyphicon-euro' => 'euro',
            'glyphicon glyphicon-exclamation-sign' => 'exclamation-sign',
            'glyphicon glyphicon-expand' => 'expand',
            'glyphicon glyphicon-export' => 'export',
            'glyphicon glyphicon-eye-close' => 'eye-close',
            'glyphicon glyphicon-eye-open' => 'eye-open',
            'glyphicon glyphicon-facetime-video' => 'facetime-video',
            'glyphicon glyphicon-fast-backward' => 'fast-backward',
            'glyphicon glyphicon-fast-forward' => 'fast-forward',
            'glyphicon glyphicon-file' => 'file',
            'glyphicon glyphicon-film' => 'film',
            'glyphicon glyphicon-filter' => 'filter',
            'glyphicon glyphicon-fire' => 'fire',
            'glyphicon glyphicon-flag' => 'flag',
            'glyphicon glyphicon-flash' => 'flash',
            'glyphicon glyphicon-floppy-disk' => 'floppy-disk',
            'glyphicon glyphicon-floppy-open' => 'floppy-open',
            'glyphicon glyphicon-floppy-remove' => 'floppy-remove',
            'glyphicon glyphicon-floppy-save' => 'floppy-save',
            'glyphicon glyphicon-floppy-saved' => 'floppy-saved',
            'glyphicon glyphicon-folder-close' => 'folder-close',
            'glyphicon glyphicon-folder-open' => 'folder-open',
            'glyphicon glyphicon-font' => 'font',
            'glyphicon glyphicon-forward' => 'forward',
            'glyphicon glyphicon-fullscreen' => 'fullscreen',
            'glyphicon glyphicon-gbp' => 'gbp',
            'glyphicon glyphicon-gift' => 'gift',
            'glyphicon glyphicon-glass' => 'glass',
            'glyphicon glyphicon-globe' => 'globe',
            'glyphicon glyphicon-hand-down' => 'hand-down',
            'glyphicon glyphicon-hand-left' => 'hand-left',
            'glyphicon glyphicon-hand-right' => 'hand-right',
            'glyphicon glyphicon-hand-up' => 'hand-up',
            'glyphicon glyphicon-hd-video' => 'hd-video',
            'glyphicon glyphicon-hdd' => 'hdd',
            'glyphicon glyphicon-header' => 'header',
            'glyphicon glyphicon-headphones' => 'headphones',
            'glyphicon glyphicon-heart' => 'heart',
            'glyphicon glyphicon-heart-empty' => 'heart-empty',
            'glyphicon glyphicon-home' => 'home',
            'glyphicon glyphicon-import' => 'import',
            'glyphicon glyphicon-inbox' => 'inbox',
            'glyphicon glyphicon-indent-left' => 'indent-left',
            'glyphicon glyphicon-indent-right' => 'indent-right',
            'glyphicon glyphicon-info-sign' => 'info-sign',
            'glyphicon glyphicon-italic' => 'italic',
            'glyphicon glyphicon-leaf' => 'leaf',
            'glyphicon glyphicon-link' => 'link',
            'glyphicon glyphicon-list' => 'list',
            'glyphicon glyphicon-list-alt' => 'list-alt',
            'glyphicon glyphicon-lock' => 'lock',
            'glyphicon glyphicon-log-in' => 'log-in',
            'glyphicon glyphicon-log-out' => 'log-out',
            'glyphicon glyphicon-magnet' => 'magnet',
            'glyphicon glyphicon-map-marker' => 'map-marker',
            'glyphicon glyphicon-minus' => 'minus',
            'glyphicon glyphicon-minus-sign' => 'minus-sign',
            'glyphicon glyphicon-move' => 'move',
            'glyphicon glyphicon-music' => 'music',
            'glyphicon glyphicon-new-window' => 'new-window',
            'glyphicon glyphicon-off' => 'off',
            'glyphicon glyphicon-ok' => 'ok',
            'glyphicon glyphicon-ok-circle' => 'ok-circle',
            'glyphicon glyphicon-ok-sign' => 'ok-sign',
            'glyphicon glyphicon-open' => 'open',
            'glyphicon glyphicon-paperclip' => 'paperclip',
            'glyphicon glyphicon-pause' => 'pause',
            'glyphicon glyphicon-pencil' => 'pencil',
            'glyphicon glyphicon-phone' => 'phone',
            'glyphicon glyphicon-phone-alt' => 'phone-alt',
            'glyphicon glyphicon-picture' => 'picture',
            'glyphicon glyphicon-plane' => 'plane',
            'glyphicon glyphicon-play' => 'play',
            'glyphicon glyphicon-play-circle' => 'play-circle',
            'glyphicon glyphicon-plus' => 'plus',
            'glyphicon glyphicon-plus-sign' => 'plus-sign',
            'glyphicon glyphicon-print' => 'print',
            'glyphicon glyphicon-pushpin' => 'pushpin',
            'glyphicon glyphicon-qrcode' => 'qrcode',
            'glyphicon glyphicon-question-sign' => 'question-sign',
            'glyphicon glyphicon-random' => 'random',
            'glyphicon glyphicon-record' => 'record',
            'glyphicon glyphicon-refresh' => 'refresh',
            'glyphicon glyphicon-registration-mark' => 'registration-mark',
            'glyphicon glyphicon-remove' => 'remove',
            'glyphicon glyphicon-remove-circle' => 'remove-circle',
            'glyphicon glyphicon-remove-sign' => 'remove-sign',
            'glyphicon glyphicon-repeat' => 'repeat',
            'glyphicon glyphicon-resize-full' => 'resize-full',
            'glyphicon glyphicon-resize-horizontal' => 'resize-horizontal',
            'glyphicon glyphicon-resize-small' => 'resize-small',
            'glyphicon glyphicon-resize-vertical' => 'resize-vertical',
            'glyphicon glyphicon-retweet' => 'retweet',
            'glyphicon glyphicon-road' => 'road',
            'glyphicon glyphicon-save' => 'save',
            'glyphicon glyphicon-saved' => 'saved',
            'glyphicon glyphicon-screenshot' => 'screenshot',
            'glyphicon glyphicon-sd-video' => 'sd-video',
            'glyphicon glyphicon-search' => 'search',
            'glyphicon glyphicon-send' => 'send',
            'glyphicon glyphicon-share' => 'share',
            'glyphicon glyphicon-share-alt' => 'share-alt',
            'glyphicon glyphicon-shopping-cart' => 'shopping-cart',
            'glyphicon glyphicon-signal' => 'signal',
            'glyphicon glyphicon-sort' => 'sort',
            'glyphicon glyphicon-sort-by-alphabet' => 'sort-by-alphabet',
            'glyphicon glyphicon-sort-by-alphabet-alt' => 'sort-by-alphabet-alt',
            'glyphicon glyphicon-sort-by-attributes' => 'sort-by-attributes',
            'glyphicon glyphicon-sort-by-attributes-alt' => 'sort-by-attributes-alt',
            'glyphicon glyphicon-sort-by-order' => 'sort-by-order',
            'glyphicon glyphicon-sort-by-order-alt' => 'sort-by-order-alt',
            'glyphicon glyphicon-sound-5-1' => 'sound-5-1',
            'glyphicon glyphicon-sound-6-1' => 'sound-6-1',
            'glyphicon glyphicon-sound-7-1' => 'sound-7-1',
            'glyphicon glyphicon-sound-dolby' => 'sound-dolby',
            'glyphicon glyphicon-sound-stereo' => 'sound-stereo',
            'glyphicon glyphicon-star' => 'star',
            'glyphicon glyphicon-star-empty' => 'star-empty',
            'glyphicon glyphicon-stats' => 'stats',
            'glyphicon glyphicon-step-backward' => 'step-backward',
            'glyphicon glyphicon-step-forward' => 'step-forward',
            'glyphicon glyphicon-stop' => 'stop',
            'glyphicon glyphicon-subtitles' => 'subtitles',
            'glyphicon glyphicon-tag' => 'tag',
            'glyphicon glyphicon-tags' => 'tags',
            'glyphicon glyphicon-tasks' => 'tasks',
            'glyphicon glyphicon-text-height' => 'text-height',
            'glyphicon glyphicon-text-width' => 'text-width',
            'glyphicon glyphicon-th' => 'th',
            'glyphicon glyphicon-th-large' => 'th-large',
            'glyphicon glyphicon-th-list' => 'th-list',
            'glyphicon glyphicon-thumbs-down' => 'thumbs-down',
            'glyphicon glyphicon-thumbs-up' => 'thumbs-up',
            'glyphicon glyphicon-time' => 'time',
            'glyphicon glyphicon-tint' => 'tint',
            'glyphicon glyphicon-tower' => 'tower',
            'glyphicon glyphicon-transfer' => 'transfer',
            'glyphicon glyphicon-trash' => 'trash',
            'glyphicon glyphicon-tree-conifer' => 'tree-conifer',
            'glyphicon glyphicon-tree-deciduous' => 'tree-deciduous',
            'glyphicon glyphicon-unchecked' => 'unchecked',
            'glyphicon glyphicon-upload' => 'upload',
            'glyphicon glyphicon-usd' => 'usd',
            'glyphicon glyphicon-user' => 'user',
            'glyphicon glyphicon-volume-down' => 'volume-down',
            'glyphicon glyphicon-volume-off' => 'volume-off',
            'glyphicon glyphicon-volume-up' => 'volume-up',
            'glyphicon glyphicon-warning-sign' => 'warning-sign',
            'glyphicon glyphicon-wrench' => 'wrench',
            'glyphicon glyphicon-zoom-in' => 'zoom-in',
            'glyphicon glyphicon-zoom-out' => 'zoom-out',
            'glyphicon glyphicon-eur' => 'eur',
            'glyphicon glyphicon-alert' => 'alert',
            'glyphicon glyphicon-apple' => 'apple',
            'glyphicon glyphicon-baby-formula' => 'baby-formula',
            'glyphicon glyphicon-bed' => 'bed',
            'glyphicon glyphicon-bishop' => 'bishop',
            'glyphicon glyphicon-bitcoin' => 'bitcoin',
            'glyphicon glyphicon-blackboard' => 'blackboard',
            'glyphicon glyphicon-cd' => 'cd',
            'glyphicon glyphicon-console' => 'console',
            'glyphicon glyphicon-copy' => 'copy',
            'glyphicon glyphicon-duplicate' => 'duplicate',
            'glyphicon glyphicon-education' => 'education',
            'glyphicon glyphicon-equalizer' => 'equalizer',
            'glyphicon glyphicon-erase' => 'erase',
            'glyphicon glyphicon-grain' => 'grain',
            'glyphicon glyphicon-hourglass' => 'hourglass',
            'glyphicon glyphicon-ice-lolly' => 'ice-lolly',
            'glyphicon glyphicon-ice-lolly-tasted' => 'ice-lolly-tasted',
            'glyphicon glyphicon-king' => 'king',
            'glyphicon glyphicon-knight' => 'knight',
            'glyphicon glyphicon-lamp' => 'lamp',
            'glyphicon glyphicon-level-up' => 'level-up',
            'glyphicon glyphicon-menu-down' => 'menu-down',
            'glyphicon glyphicon-menu-hamburger' => 'menu-hamburger',
            'glyphicon glyphicon-menu-left' => 'menu-left',
            'glyphicon glyphicon-menu-right' => 'menu-right',
            'glyphicon glyphicon-menu-up' => 'menu-up',
            'glyphicon glyphicon-modal-window' => 'modal-window',
            'glyphicon glyphicon-object-align-bottom' => 'object-align-bottom',
            'glyphicon glyphicon-object-align-horizontal' => 'object-align-horizontal',
            'glyphicon glyphicon-object-align-left' => 'object-align-left',
            'glyphicon glyphicon-object-align-right' => 'object-align-right',
            'glyphicon glyphicon-object-align-top' => 'object-align-top',
            'glyphicon glyphicon-object-align-vertical' => 'object-align-vertical',
            'glyphicon glyphicon-oil' => 'oil',
            'glyphicon glyphicon-open-file' => 'open-file',
            'glyphicon glyphicon-option-horizontal' => 'option-horizontal',
            'glyphicon glyphicon-option-vertical' => 'option-vertical',
            'glyphicon glyphicon-paste' => 'paste',
            'glyphicon glyphicon-pawn' => 'pawn',
            'glyphicon glyphicon-piggy-bank' => 'piggy-bank',
            'glyphicon glyphicon-queen' => 'queen',
            'glyphicon glyphicon-ruble' => 'ruble',
            'glyphicon glyphicon-save-file' => 'save-file',
            'glyphicon glyphicon-scale' => 'scale',
            'glyphicon glyphicon-scissors' => 'scissors',
            'glyphicon glyphicon-subscript' => 'subscript',
            'glyphicon glyphicon-sunglasses' => 'sunglasses',
            'glyphicon glyphicon-superscript' => 'superscript',
            'glyphicon glyphicon-tent' => 'tent',
            'glyphicon glyphicon-text-background' => 'text-background',
            'glyphicon glyphicon-text-color' => 'text-color',
            'glyphicon glyphicon-text-size' => 'text-size',
            'glyphicon glyphicon-triangle-bottom' => 'triangle-bottom',
            'glyphicon glyphicon-triangle-left' => 'triangle-left',
            'glyphicon glyphicon-triangle-right' => 'triangle-right',
            'glyphicon glyphicon-triangle-top' => 'triangle-top',
            'glyphicon glyphicon-yen' => 'yen',
            'glyphicon glyphicon-btc' => 'btc',
            'glyphicon glyphicon-jpy' => 'jpy',
            'glyphicon glyphicon-rub' => 'rub',
            'glyphicon glyphicon-xbt' => 'xbt'
        );

        return $icons;
    }

    public static function all()
    {
        return array_merge(Icons::glyphicons(), Icons::fontAwesomeIcons());
    }
}