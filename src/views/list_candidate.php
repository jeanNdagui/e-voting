<?php if (isset($data)) : ?>
<section class="container mt-5">
  <div class="row">
    <div class="d-flex justify-content-center">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th scope="col" class="text-uppercase">Num</th>
              <th scope="col" class="text-uppercase">ID</th>
              <th scope="col" class="text-uppercase">Nom</th>
              <th scope="col" class="text-uppercase">Partie</th>
            </tr>
          </thead>

          <tbody>


            <?php $i = 1; ?>
            <?php foreach ($data as $el) : ?>

              <tr>
                <th scope="row"><?= $i ?></th>
                <td class="text-uppercase"> <?= $el["candidate_id"] ?> </td>
                <td class="text-uppercase"> <?= $el["candidate_name"] ?></td>
                <td class="text-uppercase"> <?= $el["candidate_party"] ?></td>
              </tr>

              <?php $i++; ?>
            <?php endforeach ?>
          </tbody>
        </table>

    </div>
  </div>
</section>

<?php else : ?>
  <section class="admin__login container pt-5">
    <?php if (!isset($data)) : ?>
      <div class="alert alert-danger text-center" role="alert">
        Aucun candidat n'est inscrit pour le moment.
      </div>
    <?php endif ?>
  <?php endif ?>
  </section>