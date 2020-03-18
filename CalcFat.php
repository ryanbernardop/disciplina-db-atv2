<?php

/* 
* Padrão de chaves utilizado: A chave será sempre o número a ser calculado
* e o valor será o resultado!
* exemplo: fatorial de 10 -> key = 10 e valor = 3628800!
*/ 

$redis = new Redis(); 
$redis->connect('127.0.0.1', 6379); 
echo "Redis Conectado"."<br>"; 

$valor = $_POST['valor'];

function fatorial ($n) {
    return  $n > 1 ? $n * fatorial($n - 1) : 1;
};

if ($redis->exists($valor)) {
    $ResultCashe = "O fatorial de $valor é: " . $redis->get($valor) . "  Ele foi retirado do redis sem calculo, a chave expira em  " . $redis->ttl($valor) . " segundos!";
   } else {
    
    $resultado = fatorial($valor);
    $redis->set($valor, $resultado);
    $redis->expire($valor, 300);
    $ResultCashe = "O fatorial de $valor é: " . $redis->get($valor) . "  Ele foi calculado agora e incluido no redis!";
};

echo $ResultCashe;

?>

<form method="post" action="CalcFat.php">
<input type="number" name="valor"><br>
<input type="submit" name="aa" value="enviar">

</form>