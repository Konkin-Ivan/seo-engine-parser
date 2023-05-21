# Plan

To parse only internal site URLs and build a graph, you can use the following algorithm in PHP:

1. Create a list of start URLs for parsing. For example, you can add the main page of the site.
```php
$start_urls = [
    'https://example.com/'
];
```

2. Create a list of already processed URLs to avoid repeated requests to process the same address.
```php
$processed_urls = [];
```

3. Create a list of internal site URLs that will be used to build the graph.
```php
$internal_urls = [];
```

4. Write a function that will parse the page and find internal URLs.
```php
function parse_url($url) {
    global $processed_urls, $internal_urls;
    
    // добавляем URL в список обработанных
    $processed_urls[$url] = true;
    
    // получаем содержимое страницы
    $html = file_get_contents($url);
    
    // находим внутренние ссылки
    preg_match_all('/<a\s+href=["\']([^"\']+)["\']/i', $html, $matches);
    
    // перебираем найденные ссылки и добавляем в список внутренних URL-адресов
    foreach ($matches[1] as $link) {
        $link = trim($link);
        
        // проверяем, является ли ссылка внутренней
        if (strpos($link, 'http') !== false) {
            $parsed_link = parse_url($link);
            $link = $parsed_link['scheme'] . '://' . $parsed_link['host'] . $parsed_link['path'];
        } else if (strpos($link, '/') !== 0) {
            $link = '/' . $link;
        }
        
        if (!(strpos($link, 'http') !== false && strpos($link, $_SERVER['HTTP_HOST']) === false)) {
            if (!array_key_exists($link, $processed_urls)) {
                $internal_urls[] = $link;
                parse_url('https://' . $_SERVER['HTTP_HOST'] . $link);
            }
        }
    }
    
    return parse_url($url);
}
```

5. Loop through the start URLs and call a function for each one.
```php
foreach ($start_urls as $url) {
    parse_url($url);
}
```

6. Create an array of vertices for the graph, which will contain a list of internal URLs.
```php
$vertices = array_unique($internal_urls);
```

7. Create an array of edges for the graph, which will contain a list of links between URLs. A link is considered if a link to an address is found on the page of another address.
```php
$edges = [];
foreach ($vertices as $vertex) {
    $edges[$vertex] = [];
    $parsed_vertex = parse_url('https://' . $_SERVER['HTTP_HOST'] . $vertex);
    
    foreach ($vertices as $other_vertex) {
        if ($vertex !== $other_vertex) {
            $parsed_other_vertex = parse_url('https://' . $_SERVER['HTTP_HOST'] . $other_vertex);
            if (strpos($parsed_other_vertex['path'], $parsed_vertex['path']) !== false) {
                $edges[$vertex][] = $other_vertex;
            }
        }
    }
}
```

8. Build a graph using the resulting list of vertices and edges. For example, you can use the Graphviz library to display a graph as an image.
```php
require_once 'vendor/autoload.php';
use Graphp\GraphViz\GraphViz;

$graph = new \Fhaculty\Graph\Graph();
$graph->setAttribute('graphviz.rankdir', 'TB');

foreach ($vertices as $vertex) {
    $graph->createVertex($vertex);
}

foreach ($edges as $vertex => $links) {
    foreach ($links as $link) {
        $graph->getVertex($vertex)->createEdgeTo($graph->getVertex($link));
    }
}