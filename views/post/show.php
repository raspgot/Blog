<?php
use App\Connexion;
use App\Model\Post;

$id = (int)$params['id'];
$slug = $params['slug'];

$pdo = Connexion::getPDO();
$query = $pdo->prepare('SELECT * FROM post WHERE id = :id');
$query->execute(['id' => $id]);
$post = $query->fetchAll(PDO::FETCH_CLASS, post::class)[0];
dd($post);
die;