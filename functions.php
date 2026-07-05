<?php

date_default_timezone_set('Asia/Tokyo');

const OWNER_COOKIE_NAME = 'maniarc_owner_token';

const CATEGORIES = [
    '推し活',
    'スポーツ観戦・応援',
    'コレクティング',
    'ゲーム・eスポーツ',
    '映像作品',
    '食・ワイン',
    'その他',
];

const LOVE_TYPES = [
    '辿る',
    '考察する',
    '体験する',
    '集める・残す',
    '没入する',
    '語る・伝える',
    '支える・応援する',
];

const LOVE_TYPE_LABELS = [
    '推し活' => [
        '辿る' => '活動や歴史を辿る',
        '考察する' => '考察する',
        '体験する' => 'ライブ・イベントに参戦する',
        '集める・残す' => 'グッズや記録を集める',
        '没入する' => '作品や世界観に没入する',
        '語る・伝える' => '魅力を語る・伝える',
        '支える・応援する' => '応援する・支える',
    ],
    'スポーツ観戦・応援' => [
        '辿る' => '戦績や歴史を辿る',
        '考察する' => '戦術やプレーを考察する',
        '体験する' => '現地で観戦する',
        '集める・残す' => 'グッズや記録を集める',
        '没入する' => '試合に没入する',
        '語る・伝える' => 'チームの魅力を語る',
        '支える・応援する' => 'チームや選手を応援する',
    ],
    'コレクティング' => [
        '辿る' => '由来や背景を辿る',
        '考察する' => '価値や違いを研究する',
        '体験する' => '探しに行く・出会う',
        '集める・残す' => '集める・美しく残す',
        '没入する' => '眺める時間に浸る',
        '語る・伝える' => 'コレクションを語る',
        '支える・応援する' => '作り手や文化を支える',
    ],
    'ゲーム・eスポーツ' => [
        '辿る' => '物語やシリーズを辿る',
        '考察する' => '攻略や世界観を考察する',
        '体験する' => 'プレイする・大会に参加する',
        '集める・残す' => '実績や記録を残す',
        '没入する' => 'とことんやり込む',
        '語る・伝える' => '配信する・魅力を語る',
        '支える・応援する' => '作品や選手を応援する',
    ],
    '映像作品' => [
        '辿る' => '作品や制作背景を辿る',
        '考察する' => '物語や演出を考察する',
        '体験する' => '鑑賞する・イベントへ行く',
        '集める・残す' => '作品や記録を残す',
        '没入する' => '世界観に浸る',
        '語る・伝える' => '感想や魅力を語る',
        '支える・応援する' => '作り手や作品を応援する',
    ],
    '食・ワイン' => [
        '辿る' => '産地や造り手を辿る',
        '考察する' => '味わいや背景を考察する',
        '体験する' => '味わう・現地を訪ねる',
        '集める・残す' => 'ボトルや記録を残す',
        '没入する' => '香りや時間に浸る',
        '語る・伝える' => 'おいしさを語る・伝える',
        '支える・応援する' => '造り手や食文化を支える',
    ],
    'その他' => [
        '辿る' => '歴史や背景を辿る',
        '考察する' => '深く考察する',
        '体験する' => '実際に体験する',
        '集める・残す' => '集める・記録に残す',
        '没入する' => '時間を忘れて没入する',
        '語る・伝える' => '魅力を語る・伝える',
        '支える・応援する' => '行動で支える・応援する',
    ],
];

function h($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function get_owner_token()
{
    $token = $_COOKIE[OWNER_COOKIE_NAME] ?? '';

    if (!is_string($token) || !preg_match('/\A[a-f0-9]{64}\z/', $token)) {
        $token = bin2hex(random_bytes(32));
    }

    $path = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/')), '/');
    $path = $path === '' ? '/' : $path . '/';

    setcookie(OWNER_COOKIE_NAME, $token, [
        'expires' => time() + 60 * 60 * 24 * 365,
        'path' => $path,
        'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);

    $_COOKIE[OWNER_COOKIE_NAME] = $token;

    return $token;
}

function text_length($value)
{
    return function_exists('mb_strlen')
        ? mb_strlen($value, 'UTF-8')
        : strlen($value);
}

function love_type_label($category, $loveType)
{
    return LOVE_TYPE_LABELS[$category][$loveType] ?? $loveType;
}

function parse_love_types($value)
{
    if (is_array($value)) {
        return array_values(array_intersect(LOVE_TYPES, $value));
    }

    $items = array_map('trim', explode('/', (string) $value));
    return array_values(array_intersect(LOVE_TYPES, $items));
}

function passport_variant($seed)
{
    return abs(crc32((string) $seed)) % 6 + 1;
}
