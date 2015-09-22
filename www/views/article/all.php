<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8" />
    <title>Статьи</title>
  </head>
  <body>
    <div class="wrap">
      <div class="articles">
        <? if (is_array($items)): ?>
          <?php foreach ($items as $item): ?>
            <div class="article">
              <div class="title">
                <?php echo $item->title; ?>
              </div>
              <div class="text">
                <?php echo $item->text; ?>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          Нет статей.
        <?php endif; ?>
      </div>
    </div>
  </body>
</html>