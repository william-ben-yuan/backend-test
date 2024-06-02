<?php
function validateBrackets($str)
{
    $pilha = [];
    $mapa = [
        ')' => '(',
        '}' => '{',
        ']' => '['
    ];

    for ($i = 0; $i < strlen($str); $i++) {
        $char = $str[$i];

        if (in_array($char, ['(', '{', '['])) {
            array_push($pilha, $char);
        } else if (in_array($char, [')', '}', ']'])) {
            if (empty($pilha) || $mapa[$char] != array_pop($pilha)) {
                return false;
            }
        }
    }

    return empty($pilha);
}
