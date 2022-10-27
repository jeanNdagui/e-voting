<?php if (isset($data)) : ?>
  <section class="container mt-5">
    <div class="row">
      <div class="d-flex justify-content-center">

        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th scope="col" class="text-uppercase">Num</th>
              <th scope="col" class="text-uppercase">Électeur ID</th>
              <th scope="col" class="text-uppercase">Nom</th>
              <th scope="col" class="text-uppercase">statut de vote</th>
            </tr>
          </thead>

          <tbody>

            <?php $i = 1; ?>
            <?php foreach ($data as $el) : ?>
              <?php $el["voted"] = ($el["voted"] == "1") ? '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
          <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
        </svg>' : '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z"/>
        <path fill-rule="evenodd" d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z"/>
      </svg>'; ?>

              <tr>
                <th scope="row"> <?= $i ?></th>
                <td class="text-uppercase"> <?= $el["voter_id"] ?></td>
                <td class="text-uppercase"> <?= $el["username"] ?></td>
                <td class="text-uppercase"> <?= $el["voted"] ?></td>
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
        Aucun électeur n'est inscrit pour le moment.
      </div>
    <?php endif ?>
  </section>
<?php endif ?>