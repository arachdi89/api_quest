<?php
// 1 - api custom error -> contact with api provider to discuss the error
// 2 - response contain javascript tags -> use preg_replace function to remote js script tags, also for the text fields we can use
// strip_tags function to unify text fonts and etc the way that we want.

// 3 - broken img - CASE: 1-> if image is 0 or emty - replace with default img,CASE:2-> I not sure for  http://httpstat.us/503 error handle.

$username = 'hard';
$password = 'hard';
$url = 'https://hiring.rewardgateway.net/list';

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_USERPWD, $username . ":" . $password);
$output = curl_exec($curl);
//$output = strip_tags(html_entity_decode($output));
if($e = curl_error($curl)) {
    echo e;
}else{
    $data = json_decode($output, true);
}
curl_close($curl);
if(isset($data['code'])){
    die('Failed response please refresh page');
}

echo '<!DOCTYPE html>';
echo '<html lang="en">';
echo '<head>';
echo '<meta charset="UTF-8">';
echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>';
echo '<title>Users List</title>';
echo '</head>';
echo '<body>';

foreach($data as $key){
    $key['bio'] = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $key['bio']);
    if(!$key['avatar']){
        $key['avatar'] = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAADsklEQVRYR63XdwincxwH8NeZGWXGnRWZiSJ/kGRlJMqI0+FynSI7skpmnGzJzChd54pkZkUJ2WVE6cqR7BHK3r2v76Pnfvc83+e5zqd+f/z6fcb795nv7xTjZXUciL2xAzbHGvgHP+ADvIln8QR+GuN6ygilzXAOZuIPPIc38CG+L/ZrYgvshD2xHO7BVfi4FqMGYGWcj3PxMm7A4/h9AHTsDsKZBdAcXFHAL2HaB2ATPIB1cHJJ6YhkLaYS3wFyEz7D4fh00kkXgG3wDF7HrFLfLrv0wMblh/fwVQ/CtTAX22NfLGjrTQLIP38JT+IE/DXhNPqn4qxW8Kj8jWtxIX7tALIC7ir9sWs7E20Aqd2L+KSkazJ4/N6Mkyq1+BkX4+oeEA9hbezR9EQbwKU4Bjv2pD0dnu4fIweULE7qJvhbuB2X58cGQEbtfRxSabh08nljouNeHN2jmxjzsWWy3QC4FduW1PTFuL+UZgyG17Bzj2Jips/S5KflSzbcFyX9qVGfPFgyNAbAq9ilojgdd2BqAByJ27D+wJK5E8eNiY78kUMruquUsZ0ZAGmI9QYM4uvsslrHYLikTENNN1t1YQAkXY80XVmx2A9PjYmO/fH0gG6mbq8A+CbNUDq3ZrM0JUhJTxwAcGxuRADkwh1cDk3NJqU6fmQGsv+zMWuSmPMDINcts5ma1CSLKCXIgarJ19gH7wzoJea8AIjB6SNKEH/Ry1muSa7nLSMylUM3JwBeKf8+TTEkOVYLsXyP4p/YtOvsduhfht0DIFtwg9IHQwDy+3U4o0fx+kJExvjJxV0QACEKOZXZBb+NsEwPZHK6JMusjxe09VctpZ8RAKuVVZyahAUNSS7atz1KU/HlkAPMKH0yrTlGGZuc4d0Ky635SI1DSLtk60nG06GUmDlWL6RcDYA0V6jSEXi0Ej3MJmz3qB6d+8pRy27pk5Q8PsKiP28TktCpHJtw/u8mrBM4cxudcLuavIvcglzPSVa1Lt7GjbgyTtoAVsTzpb4JlpHKdISCzca0EbVtq4QB311qnXMf/48hlzCPm/hfDEC+b1jIQuoTo1MQrrgsEpKa5ZXeCUkJKY3vRdJFy7cqr590+7IGb+JkvDO6IaN5wv0nfQ+TZOJhbPc/gPilENHD2v+8loHmt9QsJPSCMporLWUdfix1v6i8GRbVfFLGPE43KkDSiAEVm9otSIzUPZzvmvIs68U+BkBjnO4N08knhDNNlS0ayYPko/KwCRPKp+uFtASQfwFMNb0ytvWaBAAAAABJRU5ErkJggg==";
    }
    if(!$key['bio']){
        $key['bio'] = 'Empty Bio for this persion';
    }

    echo '<div class="card" style="width: 18rem;">';
    echo  '<img class="card-img-top" src="'. $key['avatar'] .'" alt="Card image cap">';
    echo  '<div class="card-body">';
    echo   '<h5 class="card-title">'. $key['name'] .'</h5>';
    echo   '<h5 class="card-title">'. $key['title'] .'</h5>';
    echo   '<h3 class="card-title">'. $key['company'] .'</h3>';
    echo    '<p class="card-text">'. $key['bio'] .'</p>';
    echo    '<div class="border-top my-3"></div>';
    echo  '</div>';
    echo '</div>';

}

// In general, these are the solutions I came up with. I think the http://httpstat.us/503 link has a way of handeling but I'm not sure
// at the moment exactly how. I copied a bootstrap form but I didn't manage it because the frontend is not important for the task.
// In general, I did not use a framework because the task says only for libraries. I had the opportunity to spend about a day on the
// task.
// different libraries and frameworks may have different ways to deal with these issues such as built-in functions, etc. but this is
// quite relative given that there are no specifics about the requirements.





