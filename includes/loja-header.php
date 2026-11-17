<?php

declare(strict_types=1);

$pageTitle = $pageTitle ?? 'Loja';
$bodyClass = 'loja-body';
require __DIR__ . '/head.php';
?>
<a class="skip-link" href="#conteudo">Ir para os produtos</a>
<header class="loja-topo">
    <a class="brand" href="<?= e(base_url('loja.php')) ?>">
        <img src="<?= e(asset('img/logo-mark.svg')) ?>" width="44" height="44" alt="">
        <span>Toy <strong>Mania</strong></span>
    </a>
    <nav class="loja-nav" aria-label="Loja">
        <a href="<?= e(base_url('loja.php')) ?>">Brinquedos</a>
        <a class="btn btn-ghost btn-small" href="<?= e(base_url('login.php')) ?>">Área da equipe</a>
    </nav>
</header>
<main class="loja-main" id="conteudo">
