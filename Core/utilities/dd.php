 <?php

 function dd($variable) {
    echo '<div class="dd-container">';
    echo '<h2 class="dd-title">' . gettype($variable) . '</h2>';
    app_dump($variable);
    echo '</div>';
    die();
}

function app_dump($variable, $depth = 0) {
    echo '<pre class="dd-content">';

    if (is_array($variable)) {
        echo '<div class="dd-array">';
        foreach ($variable as $key => $value) {
            echo str_repeat(' ', $depth * 4) . '[<span class="dd-number">' . $key . '</span>] => ';
            app_dump($value, $depth + 1);
            echo '<br>';
        }
        echo str_repeat(' ', ($depth + 1) * 4) . '</div>';
    } else {
        var_dump($variable);
    }

    echo '</pre>';
}
