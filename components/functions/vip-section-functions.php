<?php
function test_input($data){
    $data = trim($data);
    $data = preg_replace("#[^0-9]#i", "", $data);

    return $data;
}

function formatNumber($amount){
    $amountOriginal = "{$amount}";

    if($amountOriginal != ""){
        $sign_left = ($amountOriginal < 0)?"(":"";
        $sign_right = ($amountOriginal < 0)?")":"";
        $amountOriginal = $sign_left . number_format(abs($amountOriginal), 2, '.', ',') . $sign_right;
    }

    return $amountOriginal;
}

// Helper function to format match rows in vip pages
function formatMatchRow($match) {
    return "
        <tr>
            <td>" . substr($match['match_time'], 0, 5) . "</td>
            <td>{$match['league']}</td>
            <td>{$match['match_name']} &nbsp;<span style='font-weight:bold'>vs</span>&nbsp; {$match['away_team']}</td>
            <td>{$match['prediction']}</td>
            <td>{$match['result']}</td>
        </tr>
    ";
}