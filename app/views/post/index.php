<?php setValueSection('title', 'Посты'); ?>
<h1>Страница постов</h1>
<?php foreach($posts as $post) : ?>
    <div class="card">
        <h1><? echo $post['title']; ?></h1>
        <div class="mt-3">
            <p><? echo $post['content']; ?></p>
        </div>
    </div>
<?php endforeach; ?>