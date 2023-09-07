<?php

function gen_rand_shortlink($len) {
        $to_return = '';
        $possible_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        while (mb_strlen($to_return) < $len) {
                $to_return = $to_return . $possible_chars[rand(0, mb_strlen($possible_chars)-1)];
        }

        return $to_return;

}

function gen_base62_rand_shortlink($len) {
        $rand_bytes = random_bytes(intval(($len * 2) / 3));
        $rand_string = base64_encode($rand_bytes);
        $rand_string = str_replace("+","",$rand_string);
        $rand_string = str_replace("/","",$rand_string);
        $rand_string = str_replace("=","",$rand_string);

        if (mb_strlen($rand_string) < $len) {
                $curlen = mb_strlen($rand_string);
                $rand_string = $rand_string . gen_rand_shortlink($len - $curlen);
        }

        return $rand_string;
}

?>
