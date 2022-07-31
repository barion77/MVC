<?php foreach ($posts as $post) : ?>
  <div class="card" style="width: 18rem;">
    <div class="card-body">
      <h5 class="card-title"><?php echo $post['title'] ?></h5>
      <p class="card-text"><?php echo $post['content'] ?></p>
      <a href="#" class="btn btn-primary">Read now...</a>
    </div>
  </div>
<?php endforeach; ?>